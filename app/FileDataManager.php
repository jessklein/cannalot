<?php
/**
 * File-Based Data Manager (Alternative to Database)
 */

class FileDataManager 
{
    private $dataPath;
    
    public function __construct()
    {
        $this->dataPath = __DIR__ . '/../data/';
        if (!is_dir($this->dataPath)) {
            mkdir($this->dataPath, 0755, true);
        }
    }
    
    public function getUsers($page = 1, $perPage = 25)
    {
        $users = $this->loadData('users');
        $total = count($users);
        $offset = ($page - 1) * $perPage;
        $data = array_slice($users, $offset, $perPage);
        
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    public function getUserById($id)
    {
        $users = $this->loadData('users');
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    public function getUserByEmail($email)
    {
        $users = $this->loadData('users');
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
        return null;
    }
    
    public function createUser($data)
    {
        $users = $this->loadData('users');
        $data['id'] = $this->getNextId($users);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $users[] = $data;
        $this->saveData('users', $users);
        
        return $data['id'];
    }
    
    public function updateUser($id, $data)
    {
        $users = $this->loadData('users');
        foreach ($users as &$user) {
            if ($user['id'] == $id) {
                if (isset($data['password']) && !empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                } else {
                    unset($data['password']);
                }
                
                $data['updated_at'] = date('Y-m-d H:i:s');
                $user = array_merge($user, $data);
                break;
            }
        }
        $this->saveData('users', $users);
        return true;
    }
    
    public function deleteUser($id)
    {
        $users = $this->loadData('users');
        $users = array_filter($users, function($user) use ($id) {
            return $user['id'] != $id;
        });
        $this->saveData('users', array_values($users));
        return true;
    }
    
    public function getStats()
    {
        $users = $this->loadData('users');
        $clients = $this->loadData('clients');
        $tickets = $this->loadData('tickets');
        $tasks = $this->loadData('tasks');
        $departments = $this->loadData('departments');
        
        $openTickets = array_filter($tickets, function($ticket) {
            return in_array($ticket['status'], ['open', 'in_progress']);
        });
        
        $pendingTasks = array_filter($tasks, function($task) {
            return in_array($task['status'], ['todo', 'in_progress']);
        });
        
        $activeClients = array_filter($clients, function($client) {
            return $client['status'] === 'active';
        });
        
        return [
            'total_users' => count($users),
            'total_clients' => count($activeClients),
            'open_tickets' => count($openTickets),
            'pending_tasks' => count($pendingTasks),
            'total_departments' => count($departments)
        ];
    }
    
    public function getRecentUsers($limit = 5)
    {
        $users = $this->loadData('users');
        usort($users, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($users, 0, $limit);
    }
    
    public function getRecentTickets($limit = 5)
    {
        $tickets = $this->loadData('tickets');
        usort($tickets, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($tickets, 0, $limit);
    }
    
    public function getRecentTasks($limit = 5)
    {
        $tasks = $this->loadData('tasks');
        usort($tasks, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        return array_slice($tasks, 0, $limit);
    }
    
    // Generic methods for all data types
    public function getAllClients()
    {
        return $this->loadData('clients');
    }
    
    public function getAllTickets()
    {
        return $this->loadData('tickets');
    }
    
    public function getAllTasks()
    {
        return $this->loadData('tasks');
    }
    
    public function getAllDepartments()
    {
        return $this->loadData('departments');
    }
    
    public function getAllUsers()
    {
        return $this->loadData('users');
    }
    
    private function loadData($type)
    {
        $file = $this->dataPath . $type . '.json';
        if (!file_exists($file)) {
            return [];
        }
        
        $json = file_get_contents($file);
        return json_decode($json, true) ?: [];
    }
    
    private function saveData($type, $data)
    {
        $file = $this->dataPath . $type . '.json';
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
    
    private function getNextId($data)
    {
        if (empty($data)) {
            return 1;
        }
        
        $ids = array_column($data, 'id');
        return max($ids) + 1;
    }
}
