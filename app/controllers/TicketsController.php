<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Tickets Controller
 */
class TicketsController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $tickets = $this->dataManager->getAllTickets();
            $clients = $this->dataManager->getAllClients();
            $departments = $this->dataManager->getAllDepartments();
            $users = $this->dataManager->getAllUsers();
            
            // Add client and department names to tickets
            foreach ($tickets as &$ticket) {
                // Find client name
                foreach ($clients as $client) {
                    if ($client['id'] == $ticket['client_id']) {
                        $ticket['client_name'] = $client['name'];
                        break;
                    }
                }
                
                // Find department name
                foreach ($departments as $department) {
                    if ($department['id'] == $ticket['department_id']) {
                        $ticket['department_name'] = $department['name'];
                        break;
                    }
                }
                
                // Find assigned user name
                foreach ($users as $user) {
                    if ($user['id'] == $ticket['assigned_to']) {
                        $ticket['assigned_user'] = $user['name'];
                        break;
                    }
                }
            }
            
            $this->view('tickets/index', [
                'title' => 'Tickets Management',
                'tickets' => $tickets
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Tickets error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        // Implementation for showing ticket details
        $this->view('tickets/show', [
            'title' => 'Ticket Details'
        ]);
    }
    
    public function create()
    {
        $this->view('tickets/create', [
            'title' => 'Create New Ticket'
        ]);
    }
    
    public function store()
    {
        // Implementation for creating new ticket
        $this->redirect('tickets');
    }
    
    public function edit($id)
    {
        // Implementation for editing ticket
        $this->view('tickets/edit', [
            'title' => 'Edit Ticket'
        ]);
    }
    
    public function update($id)
    {
        // Implementation for updating ticket
        $this->redirect('tickets');
    }
    
    public function destroy($id)
    {
        // Implementation for deleting ticket
        $this->redirect('tickets');
    }
}
