<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Tasks Controller
 */
class TasksController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $tasks = $this->dataManager->getAllTasks();
            
            $this->view('tasks/index', [
                'title' => 'Tasks Management',
                'tasks' => $tasks
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Tasks error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $tasks = $this->dataManager->getAllTasks();
            $task = null;
            
            foreach ($tasks as $t) {
                if ($t['id'] == $id) {
                    $task = $t;
                    break;
                }
            }
            
            if (!$task) {
                throw new \Exception("Task not found");
            }
            
            $this->view('tasks/show', [
                'title' => 'Task Details',
                'task' => $task
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Task error: " . $e->getMessage());
        }
    }
    
    public function create()
    {
        // Get clients and tickets for assignment dropdowns
        $clients = $this->dataManager->getAllClients();
        $tickets = $this->dataManager->getAllTickets();
        
        $this->view('tasks/create', [
            'title' => 'Create New Task',
            'clients' => $clients,
            'tickets' => $tickets
        ]);
    }
    
    public function store()
    {
        try {
            // Get form data
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $priority = $_POST['priority'] ?? 'medium';
            $status = $_POST['status'] ?? 'pending';
            $client_id = $_POST['client_id'] ?? null;
            $ticket_id = $_POST['ticket_id'] ?? null;
            $assigned_to = $_POST['assigned_to'] ?? null;
            $due_date = $_POST['due_date'] ?? null;
            
            // Basic validation
            if (empty($title)) {
                throw new \Exception("Task title is required");
            }
            
            // Get existing tasks to determine next ID
            $tasks = $this->dataManager->getAllTasks();
            $nextId = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;
            
            // Create new task
            $newTask = [
                'id' => $nextId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'client_id' => $client_id,
                'ticket_id' => $ticket_id,
                'assigned_to' => $assigned_to,
                'due_date' => $due_date,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Add to tasks array and save
            $tasks[] = $newTask;
            $this->dataManager->saveData('tasks', $tasks);
            
            $this->redirect('tasks');
            
        } catch (\Exception $e) {
            // In a real app, you'd want to show this error to the user
            throw new \Exception("Error creating task: " . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $tasks = $this->dataManager->getAllTasks();
            $task = null;
            
            foreach ($tasks as $t) {
                if ($t['id'] == $id) {
                    $task = $t;
                    break;
                }
            }
            
            if (!$task) {
                throw new \Exception("Task not found");
            }
            
            // Get clients and tickets for assignment dropdowns
            $clients = $this->dataManager->getAllClients();
            $tickets = $this->dataManager->getAllTickets();
            
            $this->view('tasks/edit', [
                'title' => 'Edit Task',
                'task' => $task,
                'clients' => $clients,
                'tickets' => $tickets
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Task error: " . $e->getMessage());
        }
    }
    
    public function update($id)
    {
        try {
            $tasks = $this->dataManager->getAllTasks();
            $taskIndex = null;
            
            foreach ($tasks as $index => $task) {
                if ($task['id'] == $id) {
                    $taskIndex = $index;
                    break;
                }
            }
            
            if ($taskIndex === null) {
                throw new \Exception("Task not found");
            }
            
            // Update task data
            $tasks[$taskIndex]['title'] = $_POST['title'] ?? $tasks[$taskIndex]['title'];
            $tasks[$taskIndex]['description'] = $_POST['description'] ?? $tasks[$taskIndex]['description'];
            $tasks[$taskIndex]['priority'] = $_POST['priority'] ?? $tasks[$taskIndex]['priority'];
            $tasks[$taskIndex]['status'] = $_POST['status'] ?? $tasks[$taskIndex]['status'];
            $tasks[$taskIndex]['client_id'] = $_POST['client_id'] ?? $tasks[$taskIndex]['client_id'];
            $tasks[$taskIndex]['ticket_id'] = $_POST['ticket_id'] ?? $tasks[$taskIndex]['ticket_id'];
            $tasks[$taskIndex]['assigned_to'] = $_POST['assigned_to'] ?? $tasks[$taskIndex]['assigned_to'];
            $tasks[$taskIndex]['due_date'] = $_POST['due_date'] ?? $tasks[$taskIndex]['due_date'];
            $tasks[$taskIndex]['updated_at'] = date('Y-m-d H:i:s');
            
            $this->dataManager->saveData('tasks', $tasks);
            $this->redirect('tasks');
            
        } catch (\Exception $e) {
            throw new \Exception("Error updating task: " . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $tasks = $this->dataManager->getAllTasks();
            $taskIndex = null;
            
            foreach ($tasks as $index => $task) {
                if ($task['id'] == $id) {
                    $taskIndex = $index;
                    break;
                }
            }
            
            if ($taskIndex === null) {
                throw new \Exception("Task not found");
            }
            
            // Remove task
            unset($tasks[$taskIndex]);
            $tasks = array_values($tasks); // Re-index array
            
            $this->dataManager->saveData('tasks', $tasks);
            $this->redirect('tasks');
            
        } catch (\Exception $e) {
            throw new \Exception("Error deleting task: " . $e->getMessage());
        }
    }
}
