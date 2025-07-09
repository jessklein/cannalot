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
    // Handle App\Controllers namespace
    if (strpos($class, 'App\\Controllers\\') === 0) {
        $className = str_replace('App\\Controllers\\', '', $class);
        $file = __DIR__ . '/app/controllers/' . $className . '.php';
    } else {
        // Default handling for other classes
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $file = __DIR__ . '/app/' . $class . '.php';
    }
    
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
    
    // Bind configurations
    App::bind('config', $appConfig);
    
    // Initialize router
    $router = new Router;
    
    // Define routes
    $router->get('', 'DashboardController@index');
    $router->get('dashboard', 'DashboardController@index');
    
    // User routes
    $router->get('users', 'UsersController@index');
    $router->get('users/create', 'UsersController@create');
    $router->post('users', 'UsersController@store');
    $router->get('users/{id}', 'UsersController@show');
    $router->get('users/{id}/edit', 'UsersController@edit');
    $router->post('users/{id}', 'UsersController@update');
    $router->post('users/{id}/delete', 'UsersController@destroy');
    
    // Client routes
    $router->get('clients', 'ClientsController@index');
    $router->get('clients/create', 'ClientsController@create');
    $router->post('clients', 'ClientsController@store');
    $router->get('clients/{id}', 'ClientsController@show');
    $router->get('clients/{id}/edit', 'ClientsController@edit');
    $router->post('clients/{id}', 'ClientsController@update');
    $router->post('clients/{id}/delete', 'ClientsController@destroy');
    
    // Ticket routes
    $router->get('tickets', 'TicketsController@index');
    $router->get('tickets/create', 'TicketsController@create');
    $router->post('tickets', 'TicketsController@store');
    $router->get('tickets/{id}', 'TicketsController@show');
    $router->get('tickets/{id}/edit', 'TicketsController@edit');
    $router->post('tickets/{id}', 'TicketsController@update');
    $router->post('tickets/{id}/delete', 'TicketsController@destroy');
    
    // Task routes
    $router->get('tasks', 'TasksController@index');
    $router->get('tasks/create', 'TasksController@create');
    $router->post('tasks', 'TasksController@store');
    $router->get('tasks/{id}', 'TasksController@show');
    $router->get('tasks/{id}/edit', 'TasksController@edit');
    $router->post('tasks/{id}', 'TasksController@update');
    $router->post('tasks/{id}/delete', 'TasksController@destroy');
    
    // Department routes
    $router->get('departments', 'DepartmentsController@index');
    $router->get('departments/create', 'DepartmentsController@create');
    $router->post('departments', 'DepartmentsController@store');
    $router->get('departments/{id}', 'DepartmentsController@show');
    $router->get('departments/{id}/edit', 'DepartmentsController@edit');
    $router->post('departments/{id}', 'DepartmentsController@update');
    $router->post('departments/{id}/delete', 'DepartmentsController@destroy');
    
    // Reports route
    $router->get('reports', 'ReportsController@index');
    $router->get('reports/export', 'ReportsController@export');
    
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