<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Dashboard Controller
 */
class DashboardController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            // Get statistics from file-based data
            $stats = $this->dataManager->getStats();
            $recentUsers = $this->dataManager->getRecentUsers();
            $recentTickets = $this->dataManager->getRecentTickets();
            $recentTasks = $this->dataManager->getRecentTasks();
            
            $this->view('dashboard/index', [
                'title' => 'Internal Tools Dashboard',
                'stats' => $stats,
                'recentUsers' => $recentUsers,
                'recentTickets' => $recentTickets,
                'recentTasks' => $recentTasks
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Dashboard error: " . $e->getMessage());
        }
    }
}
