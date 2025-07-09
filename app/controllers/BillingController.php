<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Billing Controller
 */
class BillingController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $billing = $this->dataManager->getAllBilling();
            $clients = $this->dataManager->getAllClients();
            $services = $this->dataManager->getAllServices();
            
            // Add client and service names to billing records
            foreach ($billing as &$bill) {
                // Find client name
                foreach ($clients as $client) {
                    if ($client['id'] == $bill['client_id']) {
                        $bill['client_name'] = $client['name'];
                        break;
                    }
                }
                
                // Find service name
                foreach ($services as $service) {
                    if ($service['id'] == $bill['service_id']) {
                        $bill['service_name'] = $service['name'];
                        break;
                    }
                }
            }
            
            $this->view('billing/index', [
                'title' => 'Billing Management',
                'billing' => $billing
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Billing error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $billing = $this->dataManager->getAllBilling();
            $clients = $this->dataManager->getAllClients();
            $services = $this->dataManager->getAllServices();
            $bill = null;
            
            foreach ($billing as $b) {
                if ($b['id'] == $id) {
                    $bill = $b;
                    break;
                }
            }
            
            if (!$bill) {
                throw new \Exception("Invoice not found");
            }
            
            // Add client and service details
            foreach ($clients as $client) {
                if ($client['id'] == $bill['client_id']) {
                    $bill['client'] = $client;
                    break;
                }
            }
            
            foreach ($services as $service) {
                if ($service['id'] == $bill['service_id']) {
                    $bill['service'] = $service;
                    break;
                }
            }
            
            $this->view('billing/show', [
                'title' => 'Invoice Details',
                'bill' => $bill
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Billing error: " . $e->getMessage());
        }
    }
    
    public function create()
    {
        $clients = $this->dataManager->getAllClients();
        $services = $this->dataManager->getAllServices();
        
        $this->view('billing/create', [
            'title' => 'Create New Invoice',
            'clients' => $clients,
            'services' => $services
        ]);
    }
    
    public function store()
    {
        try {
            // Get form data
            $client_id = intval($_POST['client_id'] ?? 0);
            $service_id = intval($_POST['service_id'] ?? 0);
            $hours = floatval($_POST['hours'] ?? 0);
            $billing_date = $_POST['billing_date'] ?? date('Y-m-d');
            $due_date = $_POST['due_date'] ?? date('Y-m-d', strtotime('+30 days'));
            $status = $_POST['status'] ?? 'draft';
            
            // Basic validation
            if ($client_id <= 0) {
                throw new \Exception("Please select a client");
            }
            
            if ($service_id <= 0) {
                throw new \Exception("Please select a service");
            }
            
            if ($hours <= 0) {
                throw new \Exception("Hours must be greater than 0");
            }
            
            // Get service to calculate amount
            $services = $this->dataManager->getAllServices();
            $service = null;
            foreach ($services as $s) {
                if ($s['id'] == $service_id) {
                    $service = $s;
                    break;
                }
            }
            
            if (!$service) {
                throw new \Exception("Service not found");
            }
            
            $amount = $hours * $service['hourly_rate'];
            
            // Get existing billing to determine next ID and invoice number
            $billing = $this->dataManager->getAllBilling();
            $nextId = count($billing) > 0 ? max(array_column($billing, 'id')) + 1 : 1;
            $invoiceNumber = 'INV-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
            
            // Create new billing record
            $newBill = [
                'id' => $nextId,
                'client_id' => $client_id,
                'service_id' => $service_id,
                'hours' => $hours,
                'amount' => round($amount, 2),
                'billing_date' => $billing_date,
                'due_date' => $due_date,
                'status' => $status,
                'invoice_number' => $invoiceNumber,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Add to billing array and save
            $billing[] = $newBill;
            $this->dataManager->saveData('billing', $billing);
            
            $this->redirect('billing');
            
        } catch (\Exception $e) {
            throw new \Exception("Error creating invoice: " . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $billing = $this->dataManager->getAllBilling();
            $clients = $this->dataManager->getAllClients();
            $services = $this->dataManager->getAllServices();
            $bill = null;
            
            foreach ($billing as $b) {
                if ($b['id'] == $id) {
                    $bill = $b;
                    break;
                }
            }
            
            if (!$bill) {
                throw new \Exception("Invoice not found");
            }
            
            $this->view('billing/edit', [
                'title' => 'Edit Invoice',
                'bill' => $bill,
                'clients' => $clients,
                'services' => $services
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Billing error: " . $e->getMessage());
        }
    }
    
    public function update($id)
    {
        try {
            $billing = $this->dataManager->getAllBilling();
            $billIndex = null;
            
            foreach ($billing as $index => $bill) {
                if ($bill['id'] == $id) {
                    $billIndex = $index;
                    break;
                }
            }
            
            if ($billIndex === null) {
                throw new \Exception("Invoice not found");
            }
            
            // Get service to recalculate amount if needed
            $service_id = intval($_POST['service_id'] ?? $billing[$billIndex]['service_id']);
            $hours = floatval($_POST['hours'] ?? $billing[$billIndex]['hours']);
            
            $services = $this->dataManager->getAllServices();
            $service = null;
            foreach ($services as $s) {
                if ($s['id'] == $service_id) {
                    $service = $s;
                    break;
                }
            }
            
            $amount = $service ? $hours * $service['hourly_rate'] : $billing[$billIndex]['amount'];
            
            // Update billing data
            $billing[$billIndex]['client_id'] = intval($_POST['client_id'] ?? $billing[$billIndex]['client_id']);
            $billing[$billIndex]['service_id'] = $service_id;
            $billing[$billIndex]['hours'] = $hours;
            $billing[$billIndex]['amount'] = round($amount, 2);
            $billing[$billIndex]['billing_date'] = $_POST['billing_date'] ?? $billing[$billIndex]['billing_date'];
            $billing[$billIndex]['due_date'] = $_POST['due_date'] ?? $billing[$billIndex]['due_date'];
            $billing[$billIndex]['status'] = $_POST['status'] ?? $billing[$billIndex]['status'];
            $billing[$billIndex]['updated_at'] = date('Y-m-d H:i:s');
            
            $this->dataManager->saveData('billing', $billing);
            $this->redirect('billing');
            
        } catch (\Exception $e) {
            throw new \Exception("Error updating invoice: " . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $billing = $this->dataManager->getAllBilling();
            $billIndex = null;
            
            foreach ($billing as $index => $bill) {
                if ($bill['id'] == $id) {
                    $billIndex = $index;
                    break;
                }
            }
            
            if ($billIndex === null) {
                throw new \Exception("Invoice not found");
            }
            
            // Remove billing record
            unset($billing[$billIndex]);
            $billing = array_values($billing); // Re-index array
            
            $this->dataManager->saveData('billing', $billing);
            $this->redirect('billing');
            
        } catch (\Exception $e) {
            throw new \Exception("Error deleting invoice: " . $e->getMessage());
        }
    }
}
