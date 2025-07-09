<?php
/**
 * Cannalot Dashboard - Entry Point
 */

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables (you can use vlucas/phpdotenv in production)
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Autoloader (simple implementation - use Composer in production)
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/app/' . $class . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Include core classes
require_once 'app/Core.php';

// Start session
Session::start();

try {
    // Load configuration
    $appConfig = require 'app/config/app.php';
    $dbConfig = require 'app/config/database.php';
    
    // Bind configurations
    App::bind('config', $appConfig);
    App::bind('database', $dbConfig);
    
    // Connect to database
    $connection = Database::connect($dbConfig['connections'][$dbConfig['default']]);
    App::bind('database_connection', $connection);
    
    // Initialize router
    $router = new Router;
    
    // Define routes
    $router->get('', 'Dashboard@index');
    $router->get('dashboard', 'Dashboard@index');
    
    // User routes
    $router->get('users', 'Users@index');
    $router->get('users/create', 'Users@create');
    $router->post('users', 'Users@store');
    $router->get('users/{id}', 'Users@show');
    $router->get('users/{id}/edit', 'Users@edit');
    $router->post('users/{id}', 'Users@update');
    $router->post('users/{id}/delete', 'Users@destroy');
    
    // Handle the request
    $router->direct(Request::uri(), Request::method());
    
} catch (Exception $e) {
    // Error handling
    http_response_code(500);
    
    if (App::config('debug')) {
        echo "<h1>Application Error</h1>";
        echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
        echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        echo "<h1>Something went wrong</h1>";
        echo "<p>We're sorry, but something went wrong. Please try again later.</p>";
    }
}