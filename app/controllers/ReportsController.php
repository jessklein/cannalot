<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Reports Controller
 */
class ReportsController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            // Generate comprehensive reports data
            $reports = $this->generateReportsData();
            
            $this->view('reports/index', [
                'title' => 'Reports & Analytics',
                'reports' => $reports
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Reports error: " . $e->getMessage());
        }
    }
    
    private function generateReportsData()
    {
        // Get all data
        $users = $this->dataManager->getAllUsers();
        $clients = $this->dataManager->getAllClients();
        $tickets = $this->dataManager->getAllTickets();
        $tasks = $this->dataManager->getAllTasks();
        $departments = $this->dataManager->getAllDepartments();
        
        // Calculate various metrics
        $reports = [];
        
        // 1. Client Reports
        $reports['clients'] = [
            'total' => count($clients),
            'active' => count(array_filter($clients, function($c) { return $c['status'] === 'active'; })),
            'inactive' => count(array_filter($clients, function($c) { return $c['status'] === 'inactive'; })),
            'recent' => array_slice(array_reverse($clients), 0, 5)
        ];
        
        // 2. Ticket Reports
        $ticketsByStatus = [];
        $ticketsByPriority = [];
        
        foreach ($tickets as $ticket) {
            $status = $ticket['status'] ?? 'unknown';
            $priority = $ticket['priority'] ?? 'medium';
            
            $ticketsByStatus[$status] = ($ticketsByStatus[$status] ?? 0) + 1;
            $ticketsByPriority[$priority] = ($ticketsByPriority[$priority] ?? 0) + 1;
        }
        
        $reports['tickets'] = [
            'total' => count($tickets),
            'by_status' => $ticketsByStatus,
            'by_priority' => $ticketsByPriority,
            'recent' => array_slice(array_reverse($tickets), 0, 5)
        ];
        
        // 3. Task Reports
        $tasksByStatus = [];
        $tasksByPriority = [];
        
        foreach ($tasks as $task) {
            $status = $task['status'] ?? 'pending';
            $priority = $task['priority'] ?? 'medium';
            
            $tasksByStatus[$status] = ($tasksByStatus[$status] ?? 0) + 1;
            $tasksByPriority[$priority] = ($tasksByPriority[$priority] ?? 0) + 1;
        }
        
        $reports['tasks'] = [
            'total' => count($tasks),
            'by_status' => $tasksByStatus,
            'by_priority' => $tasksByPriority,
            'recent' => array_slice(array_reverse($tasks), 0, 5)
        ];
        
        // 4. Department Reports
        $reports['departments'] = [
            'total' => count($departments),
            'active' => count(array_filter($departments, function($d) { return ($d['status'] ?? 'active') === 'active'; })),
            'list' => $departments
        ];
        
        // 5. User Reports
        $usersByRole = [];
        foreach ($users as $user) {
            $role = $user['role'] ?? 'user';
            $usersByRole[$role] = ($usersByRole[$role] ?? 0) + 1;
        }
        
        $reports['users'] = [
            'total' => count($users),
            'by_role' => $usersByRole,
            'recent' => array_slice(array_reverse($users), 0, 5)
        ];
        
        // 6. Performance Metrics
        $reports['performance'] = [
            'total_entities' => count($users) + count($clients) + count($tickets) + count($tasks) + count($departments),
            'open_tickets' => count(array_filter($tickets, function($t) { return in_array($t['status'] ?? '', ['open', 'in_progress']); })),
            'pending_tasks' => count(array_filter($tasks, function($t) { return $t['status'] === 'pending'; })),
            'completion_rate' => $this->calculateCompletionRate($tickets, $tasks)
        ];
        
        // 7. Time-based Reports
        $reports['timeline'] = [
            'tickets_this_week' => $this->getItemsThisWeek($tickets),
            'tasks_this_week' => $this->getItemsThisWeek($tasks),
            'clients_this_month' => $this->getItemsThisMonth($clients)
        ];
        
        return $reports;
    }
    
    private function calculateCompletionRate($tickets, $tasks)
    {
        $totalItems = count($tickets) + count($tasks);
        
        if ($totalItems === 0) {
            return 0;
        }
        
        $completedTickets = count(array_filter($tickets, function($t) { return $t['status'] === 'closed'; }));
        $completedTasks = count(array_filter($tasks, function($t) { return $t['status'] === 'completed'; }));
        
        return round((($completedTickets + $completedTasks) / $totalItems) * 100, 2);
    }
    
    private function getItemsThisWeek($items)
    {
        $oneWeekAgo = date('Y-m-d', strtotime('-7 days'));
        
        return array_filter($items, function($item) use ($oneWeekAgo) {
            $createdAt = $item['created_at'] ?? '';
            return $createdAt >= $oneWeekAgo;
        });
    }
    
    private function getItemsThisMonth($items)
    {
        $oneMonthAgo = date('Y-m-d', strtotime('-30 days'));
        
        return array_filter($items, function($item) use ($oneMonthAgo) {
            $createdAt = $item['created_at'] ?? '';
            return $createdAt >= $oneMonthAgo;
        });
    }
    
    public function export()
    {
        try {
            // Generate CSV export of all data
            $reports = $this->generateReportsData();
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="cannalot_reports_' . date('Y-m-d') . '.csv"');
            
            $output = fopen('php://output', 'w');
            
            // Write summary data
            fputcsv($output, ['Report Type', 'Metric', 'Value']);
            fputcsv($output, ['Clients', 'Total', $reports['clients']['total']]);
            fputcsv($output, ['Clients', 'Active', $reports['clients']['active']]);
            fputcsv($output, ['Tickets', 'Total', $reports['tickets']['total']]);
            fputcsv($output, ['Tasks', 'Total', $reports['tasks']['total']]);
            fputcsv($output, ['Departments', 'Total', $reports['departments']['total']]);
            fputcsv($output, ['Users', 'Total', $reports['users']['total']]);
            fputcsv($output, ['Performance', 'Completion Rate', $reports['performance']['completion_rate'] . '%']);
            
            fclose($output);
            exit;
            
        } catch (\Exception $e) {
            throw new \Exception("Error exporting reports: " . $e->getMessage());
        }
    }
}
