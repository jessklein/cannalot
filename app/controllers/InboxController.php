<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Inbox Controller - Shows tickets and tasks assigned to the current user
 */
class InboxController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            // Get current user (for now, we'll use user ID 1 as default)
            // In a real app, this would come from session/authentication
            $currentUserId = 1;
            
            // Get all tickets and tasks
            $allTickets = $this->dataManager->getAllTickets();
            $allTasks = $this->dataManager->getAllTasks();
            $users = $this->dataManager->getAllUsers();
            $clients = $this->dataManager->getAllClients();
            $departments = $this->dataManager->getAllDepartments();
            
            // Filter tickets assigned to current user
            $assignedTickets = array_filter($allTickets, function($ticket) use ($currentUserId) {
                return isset($ticket['assigned_to']) && $ticket['assigned_to'] == $currentUserId;
            });
            
            // Filter tasks assigned to current user
            $assignedTasks = array_filter($allTasks, function($task) use ($currentUserId) {
                return isset($task['assigned_to']) && $task['assigned_to'] == $currentUserId;
            });
            
            // Add user, client, and department names to tickets
            foreach ($assignedTickets as &$ticket) {
                // Find client name
                foreach ($clients as $client) {
                    if ($client['id'] == ($ticket['client_id'] ?? null)) {
                        $ticket['client_name'] = $client['name'];
                        break;
                    }
                }
                
                // Find department name
                foreach ($departments as $dept) {
                    if ($dept['id'] == ($ticket['department_id'] ?? null)) {
                        $ticket['department_name'] = $dept['name'];
                        break;
                    }
                }
                
                // Find assigned user name
                foreach ($users as $user) {
                    if ($user['id'] == ($ticket['assigned_to'] ?? null)) {
                        $ticket['assigned_user_name'] = $user['name'];
                        break;
                    }
                }
            }
            
            // Add user and department names to tasks
            foreach ($assignedTasks as &$task) {
                // Find department name
                foreach ($departments as $dept) {
                    if ($dept['id'] == ($task['department_id'] ?? null)) {
                        $task['department_name'] = $dept['name'];
                        break;
                    }
                }
                
                // Find assigned user name
                foreach ($users as $user) {
                    if ($user['id'] == ($task['assigned_to'] ?? null)) {
                        $task['assigned_user_name'] = $user['name'];
                        break;
                    }
                }
            }
            
            // Sort by priority and due date
            usort($assignedTickets, function($a, $b) {
                $priorityOrder = ['low' => 1, 'medium' => 2, 'high' => 3, 'urgent' => 4];
                $aPriority = $priorityOrder[$a['priority'] ?? 'medium'];
                $bPriority = $priorityOrder[$b['priority'] ?? 'medium'];
                
                if ($aPriority == $bPriority) {
                    // If same priority, sort by created date (newest first)
                    return strtotime($b['created_at'] ?? '1970-01-01') - strtotime($a['created_at'] ?? '1970-01-01');
                }
                return $bPriority - $aPriority; // Higher priority first
            });
            
            usort($assignedTasks, function($a, $b) {
                $priorityOrder = ['low' => 1, 'medium' => 2, 'high' => 3, 'urgent' => 4];
                $aPriority = $priorityOrder[$a['priority'] ?? 'medium'];
                $bPriority = $priorityOrder[$b['priority'] ?? 'medium'];
                
                if ($aPriority == $bPriority) {
                    // If same priority, sort by due date
                    $aDue = strtotime($a['due_date'] ?? '2099-12-31');
                    $bDue = strtotime($b['due_date'] ?? '2099-12-31');
                    return $aDue - $bDue; // Earlier due date first
                }
                return $bPriority - $aPriority; // Higher priority first
            });
            
            // Get current user info
            $currentUser = null;
            foreach ($users as $user) {
                if ($user['id'] == $currentUserId) {
                    $currentUser = $user;
                    break;
                }
            }
            
            // Calculate stats
            $stats = [
                'total_tickets' => count($assignedTickets),
                'urgent_tickets' => count(array_filter($assignedTickets, function($t) { return ($t['priority'] ?? '') === 'urgent'; })),
                'total_tasks' => count($assignedTasks),
                'overdue_tasks' => count(array_filter($assignedTasks, function($t) { 
                    return isset($t['due_date']) && strtotime($t['due_date']) < time() && ($t['status'] ?? '') !== 'completed'; 
                })),
            ];
            
            $this->view('inbox/index', [
                'title' => 'My Inbox',
                'assignedTickets' => $assignedTickets,
                'assignedTasks' => $assignedTasks,
                'currentUser' => $currentUser,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Inbox error: " . $e->getMessage());
        }
    }
}
