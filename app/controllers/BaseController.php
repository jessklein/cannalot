<?php

namespace App\Controllers;

/**
 * Base Controller Class
 */
class BaseController 
{
    protected function view($view, $data = [])
    {
        extract($data);
        
        $viewFile = \App::config('base_path') . "/views/{$view}.php";
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View {$view} not found.");
        }
        
        require $viewFile;
    }
    
    protected function redirect($path)
    {
        header("Location: /{$path}");
        exit;
    }
    
    protected function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function validateRequired($fields)
    {
        $errors = [];
        
        foreach ($fields as $field) {
            if (!\Request::has($field) || empty(trim(\Request::get($field)))) {
                $errors[] = ucfirst($field) . ' is required.';
            }
        }
        
        return $errors;
    }
}
