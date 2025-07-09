<?php
/**
 * Application Bootstrap
 */

class App 
{
    private static $container = [];
    
    public static function bind($key, $value)
    {
        static::$container[$key] = $value;
    }
    
    public static function get($key)
    {
        if (!array_key_exists($key, static::$container)) {
            throw new Exception("No {$key} is bound in the container.");
        }
        
        return static::$container[$key];
    }
    
    public static function config($key = null)
    {
        $config = static::get('config');
        
        if ($key === null) {
            return $config;
        }
        
        return $config[$key] ?? null;
    }
}

/**
 * Database Connection Manager
 */
class Database 
{
    private static $connection;
    
    public static function connect($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        
        static::$connection = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        
        return static::$connection;
    }
    
    public static function connection()
    {
        return static::$connection;
    }
    
    public static function query($sql, $params = [])
    {
        $statement = static::$connection->prepare($sql);
        $statement->execute($params);
        
        return $statement;
    }
}

/**
 * Router Class
 */
class Router 
{
    private $routes = [];
    
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
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        
        // Try to match dynamic routes
        foreach ($this->routes[$requestType] as $route => $controller) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            
            if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                array_shift($matches); // Remove full match
                return $this->callAction(
                    ...explode('@', $controller), $matches
                );
            }
        }
        
        // Default routing
        $segments = explode('/', trim($uri, '/'));
        $controller = !empty($segments[0]) ? ucfirst($segments[0]) : App::config('default_controller');
        $method = !empty($segments[1]) ? $segments[1] : App::config('default_method');
        
        return $this->callAction($controller, $method);
    }
    
    protected function callAction($controller, $method, $params = [])
    {
        $controller = "App\\Controllers\\{$controller}Controller";
        
        if (!class_exists($controller)) {
            throw new Exception("Controller {$controller} does not exist.");
        }
        
        $controllerInstance = new $controller;
        
        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method {$method} does not exist on controller {$controller}.");
        }
        
        return call_user_func_array([$controllerInstance, $method], $params);
    }
}

/**
 * Request Helper
 */
class Request 
{
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }
    
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public static function all()
    {
        return $_REQUEST;
    }
    
    public static function get($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }
    
    public static function has($key)
    {
        return isset($_REQUEST[$key]);
    }
}

/**
 * Session Manager
 */
class Session 
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
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
    
    public static function getFlash($key, $default = null)
    {
        $value = $_SESSION['flash'][$key] ?? $default;
        unset($_SESSION['flash'][$key]);
        return $value;
    }
}
