<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Users Controller
 */
class UsersController extends BaseController 
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    public function index()
    {
        $page = \Request::get('page', 1);
        $users = $this->userModel->paginate($page);
        
        $this->view('users/index', [
            'title' => 'Users Management',
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        $user = $this->userModel->find($id);
        
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
        
        $data = [
            'name' => \Request::get('name'),
            'email' => \Request::get('email'),
            'password' => password_hash(\Request::get('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $userId = $this->userModel->create($data);
        
        \Session::flash('success', 'User created successfully.');
        $this->redirect('users/' . $userId);
    }
    
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
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
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Update password if provided
        if (\Request::get('password')) {
            $data['password'] = password_hash(\Request::get('password'), PASSWORD_DEFAULT);
        }
        
        $this->userModel->update($id, $data);
        
        \Session::flash('success', 'User updated successfully.');
        $this->redirect('users/' . $id);
    }
    
    public function destroy($id)
    {
        $this->userModel->delete($id);
        
        \Session::flash('success', 'User deleted successfully.');
        $this->redirect('users');
    }
}
