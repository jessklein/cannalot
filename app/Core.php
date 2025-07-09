<?php
/**
 * Core Application Classes
 */

class App
{
    protected static $registry = [];

    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, static::$registry)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }

    public static function config($key)
    {
        $config = static::get('config');
        return $config[$key] ?? null;
    }
}

class Database
{
    public static function connect($config)
    {
        try {
            // Check if this is SQLite configuration
            if (isset($config['database']) && !isset($config['host'])) {
                // SQLite connection
                $dbPath = $config['database'];
                
                // If it's a relative path, make it relative to the public directory
                if (!file_exists($dbPath)) {
                    $dbPath = __DIR__ . '/../' . $config['database'];
                }
                
                $dsn = "sqlite:{$dbPath}";
                $pdo = new PDO($dsn, null, null, $config['options'] ?? [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                
                // Enable foreign keys for SQLite
                $pdo->exec('PRAGMA foreign_keys = ON');
                
                return $pdo;
            } else {
                // MySQL connection
                $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
                $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
                return $pdo;
            }
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }
}

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Remove leading slash
        $uri = ltrim($uri, '/');
        
        // Check for exact match first
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction($this->routes[$requestType][$uri]);
        }
        
        // Check for dynamic routes
        foreach ($this->routes[$requestType] as $route => $controller) {
            if ($this->matchRoute($route, $uri)) {
                return $this->callAction($controller, $this->getRouteParams($route, $uri));
            }
        }
        
        throw new Exception('No route defined for this URI.');
    }

    protected function matchRoute($route, $uri)
    {
        $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
        return preg_match("#^{$routePattern}$#", $uri);
    }

    protected function getRouteParams($route, $uri)
    {
        $routePattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $route);
        preg_match("#^{$routePattern}$#", $uri, $matches);
        
        $params = [];
        foreach ($matches as $key => $value) {
            if (!is_numeric($key)) {
                $params[$key] = $value;
            }
        }
        
        return $params;
    }

    protected function callAction($controller, $params = [])
    {
        list($class, $method) = explode('@', $controller);
        
        $class = "App\\Controllers\\{$class}";
        
        if (!class_exists($class)) {
            throw new Exception("Controller {$class} does not exist.");
        }
        
        $controllerInstance = new $class;
        
        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method {$method} does not exist on controller {$class}.");
        }
        
        // Fixed: Use call_user_func_array instead of argument unpacking
        return call_user_func_array([$controllerInstance, $method], array_values($params));
    }
}

class Request
{
    public static function uri()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public static function post($key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    public static function all()
    {
        return array_merge($_GET, $_POST);
    }
}

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    public static function getFlash($key)
    {
        $value = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    public static function destroy()
    {
        session_destroy();
    }
}
