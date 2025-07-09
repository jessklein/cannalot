<?php

namespace App\Models;

/**
 * User Model
 */
class User extends BaseModel 
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'created_at', 'updated_at'];
    
    public function findByEmail($email)
    {
        return $this->where('email', $email);
    }
    
    public function getActiveUsers()
    {
        return $this->where('status', 'active');
    }
}
