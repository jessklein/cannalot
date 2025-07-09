<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Departments Controller
 */
class DepartmentsController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $departments = $this->dataManager->getAllDepartments();
            
            $this->view('departments/index', [
                'title' => 'Departments Management',
                'departments' => $departments
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Departments error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $departments = $this->dataManager->getAllDepartments();
            $department = null;
            
            foreach ($departments as $d) {
                if ($d['id'] == $id) {
                    $department = $d;
                    break;
                }
            }
            
            if (!$department) {
                throw new \Exception("Department not found");
            }
            
            // Get related tickets and tasks for this department
            $tickets = $this->dataManager->getAllTickets();
            $tasks = $this->dataManager->getAllTasks();
            
            $departmentTickets = array_filter($tickets, function($ticket) use ($id) {
                return isset($ticket['department_id']) && $ticket['department_id'] == $id;
            });
            
            $departmentTasks = array_filter($tasks, function($task) use ($id) {
                return isset($task['department_id']) && $task['department_id'] == $id;
            });
            
            $this->view('departments/show', [
                'title' => 'Department Details',
                'department' => $department,
                'tickets' => $departmentTickets,
                'tasks' => $departmentTasks
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Department error: " . $e->getMessage());
        }
    }
    
    public function create()
    {
        $this->view('departments/create', [
            'title' => 'Create New Department'
        ]);
    }
    
    public function store()
    {
        try {
            // Get form data
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $manager = $_POST['manager'] ?? '';
            $status = $_POST['status'] ?? 'active';
            
            // Basic validation
            if (empty($name)) {
                throw new \Exception("Department name is required");
            }
            
            // Get existing departments to determine next ID
            $departments = $this->dataManager->getAllDepartments();
            $nextId = count($departments) > 0 ? max(array_column($departments, 'id')) + 1 : 1;
            
            // Create new department
            $newDepartment = [
                'id' => $nextId,
                'name' => $name,
                'description' => $description,
                'manager' => $manager,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Add to departments array and save
            $departments[] = $newDepartment;
            $this->dataManager->saveData('departments', $departments);
            
            $this->redirect('departments');
            
        } catch (\Exception $e) {
            throw new \Exception("Error creating department: " . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $departments = $this->dataManager->getAllDepartments();
            $department = null;
            
            foreach ($departments as $d) {
                if ($d['id'] == $id) {
                    $department = $d;
                    break;
                }
            }
            
            if (!$department) {
                throw new \Exception("Department not found");
            }
            
            $this->view('departments/edit', [
                'title' => 'Edit Department',
                'department' => $department
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Department error: " . $e->getMessage());
        }
    }
    
    public function update($id)
    {
        try {
            $departments = $this->dataManager->getAllDepartments();
            $departmentIndex = null;
            
            foreach ($departments as $index => $department) {
                if ($department['id'] == $id) {
                    $departmentIndex = $index;
                    break;
                }
            }
            
            if ($departmentIndex === null) {
                throw new \Exception("Department not found");
            }
            
            // Update department data
            $departments[$departmentIndex]['name'] = $_POST['name'] ?? $departments[$departmentIndex]['name'];
            $departments[$departmentIndex]['description'] = $_POST['description'] ?? $departments[$departmentIndex]['description'];
            $departments[$departmentIndex]['manager'] = $_POST['manager'] ?? $departments[$departmentIndex]['manager'];
            $departments[$departmentIndex]['status'] = $_POST['status'] ?? $departments[$departmentIndex]['status'];
            $departments[$departmentIndex]['updated_at'] = date('Y-m-d H:i:s');
            
            $this->dataManager->saveData('departments', $departments);
            $this->redirect('departments');
            
        } catch (\Exception $e) {
            throw new \Exception("Error updating department: " . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $departments = $this->dataManager->getAllDepartments();
            $departmentIndex = null;
            
            foreach ($departments as $index => $department) {
                if ($department['id'] == $id) {
                    $departmentIndex = $index;
                    break;
                }
            }
            
            if ($departmentIndex === null) {
                throw new \Exception("Department not found");
            }
            
            // Remove department
            unset($departments[$departmentIndex]);
            $departments = array_values($departments); // Re-index array
            
            $this->dataManager->saveData('departments', $departments);
            $this->redirect('departments');
            
        } catch (\Exception $e) {
            throw new \Exception("Error deleting department: " . $e->getMessage());
        }
    }
}
