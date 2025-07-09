<?php

namespace App\Controllers;

/**
 * Dashboard Controller
 */
class DashboardController extends BaseController 
{
    public function index()
    {
        // Get some basic stats for the dashboard
        $stats = $this->getDashboardStats();
        
        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'stats' => $stats
        ]);
    }
    
    private function getDashboardStats()
    {
        // This would typically fetch real data from your models
        return [
            'total_users' => 150,
            'total_orders' => 1250,
            'total_revenue' => 25000,
            'pending_orders' => 45
        ];
    }
}
