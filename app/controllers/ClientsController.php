<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Clients Controller
 */
class ClientsController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $clients = $this->dataManager->getAllClients();
            
            $this->view('clients/index', [
                'title' => 'Clients Management',
                'clients' => $clients
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Clients error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $clients = $this->dataManager->getAllClients();
            $client = null;
            
            foreach ($clients as $c) {
                if ($c['id'] == $id) {
                    $client = $c;
                    break;
                }
            }
            
            if (!$client) {
                throw new \Exception("Client not found");
            }
            
            $this->view('clients/show', [
                'title' => 'Client Details',
                'client' => $client
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Client error: " . $e->getMessage());
        }
    }
    
    public function create()
    {
        $this->view('clients/create', [
            'title' => 'Create New Client'
        ]);
    }
    
    public function store()
    {
        // Implementation for creating new client
        $this->view('clients/index', [
            'title' => 'Clients Management',
            'clients' => $this->dataManager->getAllClients()
        ]);
    }
    
    public function edit($id)
    {
        // Implementation for editing client
        $this->view('clients/edit', [
            'title' => 'Edit Client'
        ]);
    }
    
    public function update($id)
    {
        // Implementation for updating client
        $this->redirect('clients');
    }
    
    public function destroy($id)
    {
        // Implementation for deleting client
        $this->redirect('clients');
    }
}
