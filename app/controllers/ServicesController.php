<?php

namespace App\Controllers;

require_once __DIR__ . '/../FileDataManager.php';

/**
 * Services Controller
 */
class ServicesController extends BaseController 
{
    private $dataManager;
    
    public function __construct()
    {
        $this->dataManager = new \FileDataManager();
    }
    
    public function index()
    {
        try {
            $services = $this->dataManager->getAllServices();
            
            $this->view('services/index', [
                'title' => 'Services Management',
                'services' => $services
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Services error: " . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $services = $this->dataManager->getAllServices();
            $service = null;
            
            foreach ($services as $s) {
                if ($s['id'] == $id) {
                    $service = $s;
                    break;
                }
            }
            
            if (!$service) {
                throw new \Exception("Service not found");
            }
            
            // Get billing records for this service
            $billing = $this->dataManager->getAllBilling();
            $serviceBilling = array_filter($billing, function($bill) use ($id) {
                return isset($bill['service_id']) && $bill['service_id'] == $id;
            });
            
            $this->view('services/show', [
                'title' => 'Service Details',
                'service' => $service,
                'billing' => $serviceBilling
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Service error: " . $e->getMessage());
        }
    }
    
    public function create()
    {
        $this->view('services/create', [
            'title' => 'Create New Service'
        ]);
    }
    
    public function store()
    {
        try {
            // Get form data
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $hourly_rate = floatval($_POST['hourly_rate'] ?? 0);
            $category = $_POST['category'] ?? 'general';
            $status = $_POST['status'] ?? 'active';
            
            // Basic validation
            if (empty($name)) {
                throw new \Exception("Service name is required");
            }
            
            if ($hourly_rate <= 0) {
                throw new \Exception("Hourly rate must be greater than 0");
            }
            
            // Get existing services to determine next ID
            $services = $this->dataManager->getAllServices();
            $nextId = count($services) > 0 ? max(array_column($services, 'id')) + 1 : 1;
            
            // Create new service
            $newService = [
                'id' => $nextId,
                'name' => $name,
                'description' => $description,
                'hourly_rate' => $hourly_rate,
                'category' => $category,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Add to services array and save
            $services[] = $newService;
            $this->dataManager->saveData('services', $services);
            
            $this->redirect('services');
            
        } catch (\Exception $e) {
            throw new \Exception("Error creating service: " . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        try {
            $services = $this->dataManager->getAllServices();
            $service = null;
            
            foreach ($services as $s) {
                if ($s['id'] == $id) {
                    $service = $s;
                    break;
                }
            }
            
            if (!$service) {
                throw new \Exception("Service not found");
            }
            
            $this->view('services/edit', [
                'title' => 'Edit Service',
                'service' => $service
            ]);
            
        } catch (\Exception $e) {
            throw new \Exception("Service error: " . $e->getMessage());
        }
    }
    
    public function update($id)
    {
        try {
            $services = $this->dataManager->getAllServices();
            $serviceIndex = null;
            
            foreach ($services as $index => $service) {
                if ($service['id'] == $id) {
                    $serviceIndex = $index;
                    break;
                }
            }
            
            if ($serviceIndex === null) {
                throw new \Exception("Service not found");
            }
            
            // Update service data
            $services[$serviceIndex]['name'] = $_POST['name'] ?? $services[$serviceIndex]['name'];
            $services[$serviceIndex]['description'] = $_POST['description'] ?? $services[$serviceIndex]['description'];
            $services[$serviceIndex]['hourly_rate'] = floatval($_POST['hourly_rate'] ?? $services[$serviceIndex]['hourly_rate']);
            $services[$serviceIndex]['category'] = $_POST['category'] ?? $services[$serviceIndex]['category'];
            $services[$serviceIndex]['status'] = $_POST['status'] ?? $services[$serviceIndex]['status'];
            $services[$serviceIndex]['updated_at'] = date('Y-m-d H:i:s');
            
            $this->dataManager->saveData('services', $services);
            $this->redirect('services');
            
        } catch (\Exception $e) {
            throw new \Exception("Error updating service: " . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $services = $this->dataManager->getAllServices();
            $serviceIndex = null;
            
            foreach ($services as $index => $service) {
                if ($service['id'] == $id) {
                    $serviceIndex = $index;
                    break;
                }
            }
            
            if ($serviceIndex === null) {
                throw new \Exception("Service not found");
            }
            
            // Remove service
            unset($services[$serviceIndex]);
            $services = array_values($services); // Re-index array
            
            $this->dataManager->saveData('services', $services);
            $this->redirect('services');
            
        } catch (\Exception $e) {
            throw new \Exception("Error deleting service: " . $e->getMessage());
        }
    }
}
