<?php
// Simple test to debug routing issue

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing routing...\n";

// Load environment variables
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Load autoloader
spl_autoload_register(function ($class) {
    // Handle App\Controllers namespace
    if (strpos($class, 'App\\Controllers\\') === 0) {
        $className = str_replace('App\\Controllers\\', '', $class);
        $file = __DIR__ . '/app/controllers/' . $className . '.php';
        echo "Trying to load controller: $file\n";
    } else {
        // Default handling for other classes
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = __DIR__ . '/app/' . $class . '.php';
        echo "Trying to load class: $file\n";
    }
    
    if (file_exists($file)) {
        require $file;
        echo "Loaded: $file\n";
    } else {
        echo "Could not find: $file\n";
    }
});

// Load core
require_once 'app/Core.php';

echo "Creating router...\n";
$router = new Router;

echo "Adding routes...\n";
$router->get('', 'DashboardController@index');

echo "Getting routes...\n";
$routes = $router->getRoutes();
print_r($routes);

echo "Testing route lookup for ''...\n";
if (array_key_exists('', $routes['GET'])) {
    echo "Route found: " . $routes['GET'][''] . "\n";
} else {
    echo "Route NOT found!\n";
}

echo "Checking if DashboardController class exists...\n";
$class = "App\\Controllers\\DashboardController";
if (class_exists($class)) {
    echo "✅ $class exists\n";
} else {
    echo "❌ $class does not exist\n";
    
    // Try to load it manually
    echo "Trying to load manually...\n";
    $file = __DIR__ . '/app/controllers/DashboardController.php';
    if (file_exists($file)) {
        require_once $file;
        if (class_exists($class)) {
            echo "✅ Loaded successfully\n";
        } else {
            echo "❌ File exists but class not found\n";
        }
    } else {
        echo "❌ File does not exist: $file\n";
    }
}
