<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Users Controller
 */
class UsersController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        $page = \Request::get('page', 1);
        $users = $this->dataManager->getUsers($page);
        
        $this->view('users/index', [
            'title' => 'Users Management',
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        $user = $this->dataManager->getUserById($id);
        
        if (!$user) {
            \Session::flash('error', 'User not found.');
            $this->redirect('users');
        }
        
        $this->view('users/show', [
            'title' => 'User Details',
            'user' => $user
        ]);
    }
    
    public function create()
    {
        $this->view('users/create', [
            'title' => 'Create User'
        ]);
    }
    
    public function store()
    {
        $errors = $this->validateRequired(['name', 'email', 'password']);
        
        if (!empty($errors)) {
            \Session::flash('errors', $errors);
            $this->redirect('users/create');
        }
        
        // Check if email already exists
        if ($this->dataManager->getUserByEmail(\Request::get('email'))) {
            \Session::flash('error', 'Email already exists.');
            $this->redirect('users/create');
        }
        
        $data = [
            'name' => \Request::get('name'),
            'email' => \Request::get('email'),
            'password' => \Request::get('password'),
            'role' => \Request::get('role', 'user')
        ];
        
        $userId = $this->dataManager->createUser($data);
        
        \Session::flash('success', 'User created successfully.');
        $this->redirect('users/' . $userId);
    }
    
    public function edit($id)
    {
        $user = $this->dataManager->getUserById($id);
        
        if (!$user) {
            \Session::flash('error', 'User not found.');
            $this->redirect('users');
        }
        
        $this->view('users/edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }
    
    public function update($id)
    {
        $errors = $this->validateRequired(['name', 'email']);
        
        if (!empty($errors)) {
            \Session::flash('errors', $errors);
            $this->redirect('users/' . $id . '/edit');
        }
        
        $data = [
            'name' => \Request::get('name'),
            'email' => \Request::get('email'),
            'role' => \Request::get('role', 'user')
        ];
        
        // Update password if provided
        if (\Request::get('password')) {
            $data['password'] = \Request::get('password');
        }
        
        $this->dataManager->updateUser($id, $data);
        
        \Session::flash('success', 'User updated successfully.');
        $this->redirect('users/' . $id);
    }
    
    public function destroy($id)
    {
        $this->dataManager->deleteUser($id);
        
        \Session::flash('success', 'User deleted successfully.');
        $this->redirect('users');
    }
}
