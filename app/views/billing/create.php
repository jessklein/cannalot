<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Create New Invoice</h1>
    <a href="/billing" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i>Back to Billing
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="/billing">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Invoice Number -->
            <div>
                <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Invoice Number *</label>
                <input type="text" id="invoice_number" name="invoice_number" required 
                       value="INV-<?= date('Y') ?>-<?= str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter invoice number">
            </div>

            <!-- Client -->
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client *</label>
                <select id="client_id" name="client_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Client</option>
                    <?php
                    // Get clients from data manager
                    $dataManager = new FileDataManager();
                    $clients = $dataManager->getAllClients();
                    foreach ($clients as $client):
                    ?>
                        <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Service -->
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Service *</label>
                <select id="service_id" name="service_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        onchange="updateHourlyRate()">
                    <option value="">Select Service</option>
                    <?php
                    $services = $dataManager->getAllServices();
                    foreach ($services as $service):
                    ?>
                        <option value="<?= $service['id'] ?>" data-rate="<?= $service['hourly_rate'] ?>"><?= htmlspecialchars($service['name']) ?> ($<?= number_format($service['hourly_rate'], 2) ?>/hr)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Hours -->
            <div>
                <label for="hours" class="block text-sm font-medium text-gray-700 mb-2">Hours Worked *</label>
                <input type="number" id="hours" name="hours" step="0.25" min="0" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="0.00" onchange="calculateAmount()">
            </div>

            <!-- Hourly Rate -->
            <div>
                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                    <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" readonly
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md bg-gray-50"
                           placeholder="0.00">
                </div>
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Total Amount *</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required 
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                </div>
            </div>

            <!-- Due Date -->
            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date *</label>
                <input type="date" id="due_date" name="due_date" required 
                       value="<?= date('Y-m-d', strtotime('+30 days')) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="draft">Draft</option>
                    <option value="pending" selected>Pending</option>
                    <option value="sent">Sent</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter invoice description or additional notes..."></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
            <a href="/billing" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i>Create Invoice
            </button>
        </div>
    </form>
</div>

<script>
function updateHourlyRate() {
    const serviceSelect = document.getElementById('service_id');
    const hourlyRateInput = document.getElementById('hourly_rate');
    const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    
    if (selectedOption.dataset.rate) {
        hourlyRateInput.value = selectedOption.dataset.rate;
        calculateAmount();
    } else {
        hourlyRateInput.value = '';
    }
}

function calculateAmount() {
    const hours = parseFloat(document.getElementById('hours').value) || 0;
    const hourlyRate = parseFloat(document.getElementById('hourly_rate').value) || 0;
    const amount = hours * hourlyRate;
    
    document.getElementById('amount').value = amount.toFixed(2);
}
</script>
