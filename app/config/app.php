<?php
/**
 * Application Configuration
 */

return [
    'app_name' => 'Cannalot Dashboard',
    'app_url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'app_env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => $_ENV['APP_DEBUG'] ?? true,
    
    // Security
    'app_key' => $_ENV['APP_KEY'] ?? 'your-secret-key-here',
    'session_lifetime' => 120, // minutes
    
    // Paths
    'base_path' => __DIR__ . '/..',
    'public_path' => __DIR__ . '/../..',
    
    // Default controller and method
    'default_controller' => 'DashboardController',
    'default_method' => 'index',
    
    // Pagination
    'items_per_page' => 25,
    
    // File uploads
    'max_file_size' => 5 * 1024 * 1024, // 5MB
    'allowed_file_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']
];
