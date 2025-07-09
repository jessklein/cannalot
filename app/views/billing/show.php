<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Invoice Details</h1>
    <div class="flex space-x-2">
        <a href="/billing/<?= $invoice['id'] ?>/edit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-edit mr-2"></i>Edit Invoice
        </a>
        <button onclick="window.print()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-print mr-2"></i>Print
        </button>
        <a href="/billing" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i>Back to Billing
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Invoice Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Invoice Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($invoice['invoice_number']) ?></h2>
                    <p class="text-gray-600 mt-1">Invoice</p>
                </div>
                <div class="text-right">
                    <?php
                    $statusColors = [
                        'draft' => 'bg-gray-100 text-gray-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'sent' => 'bg-blue-100 text-blue-800',
                        'paid' => 'bg-green-100 text-green-800',
                        'overdue' => 'bg-red-100 text-red-800'
                    ];
                    $status = $invoice['status'] ?? 'pending';
                    ?>
                    <span class="px-3 py-1 text-lg font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['pending'] ?>">
                        <?= ucfirst($status) ?>
                    </span>
                </div>
            </div>

            <!-- Client Information -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Bill To</h3>
                    <?php
                    $dataManager = new FileDataManager();
                    $client = null;
                    if (!empty($invoice['client_id'])) {
                        $clients = $dataManager->getAllClients();
                        foreach ($clients as $c) {
                            if ($c['id'] == $invoice['client_id']) {
                                $client = $c;
                                break;
                            }
                        }
                    }
                    ?>
                    <?php if ($client): ?>
                        <div class="text-gray-700">
                            <p class="font-medium"><?= htmlspecialchars($client['name']) ?></p>
                            <?php if (!empty($client['email'])): ?>
                                <p><?= htmlspecialchars($client['email']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($client['phone'])): ?>
                                <p><?= htmlspecialchars($client['phone']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">Client not found</p>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Invoice Details</h3>
                    <dl class="text-sm">
                        <div class="flex justify-between py-1">
                            <dt class="text-gray-500">Invoice Date:</dt>
                            <dd class="text-gray-900"><?= isset($invoice['created_at']) ? date('M j, Y', strtotime($invoice['created_at'])) : date('M j, Y') ?></dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-gray-500">Due Date:</dt>
                            <dd class="text-gray-900"><?= isset($invoice['due_date']) ? date('M j, Y', strtotime($invoice['due_date'])) : 'Not set' ?></dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt class="text-gray-500">Hours:</dt>
                            <dd class="text-gray-900"><?= number_format($invoice['hours'] ?? 0, 2) ?></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Service Details -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Service Details</h3>
                <?php
                $service = null;
                if (!empty($invoice['service_id'])) {
                    $services = $dataManager->getAllServices();
                    foreach ($services as $s) {
                        if ($s['id'] == $invoice['service_id']) {
                            $service = $s;
                            break;
                        }
                    }
                }
                ?>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm font-medium text-gray-500">
                                <th class="pb-2">Service</th>
                                <th class="pb-2 text-right">Hours</th>
                                <th class="pb-2 text-right">Rate</th>
                                <th class="pb-2 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-sm">
                                <td class="py-2">
                                    <div class="font-medium"><?= $service ? htmlspecialchars($service['name']) : 'Service not found' ?></div>
                                    <?php if ($service && !empty($service['description'])): ?>
                                        <div class="text-gray-500"><?= htmlspecialchars(substr($service['description'], 0, 100)) ?><?= strlen($service['description']) > 100 ? '...' : '' ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-2 text-right"><?= number_format($invoice['hours'] ?? 0, 2) ?></td>
                                <td class="py-2 text-right">$<?= number_format($invoice['hourly_rate'] ?? 0, 2) ?></td>
                                <td class="py-2 text-right font-medium">$<?= number_format($invoice['amount'] ?? 0, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2 text-lg font-bold">
                            <span>Total:</span>
                            <span>$<?= number_format($invoice['amount'] ?? 0, 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($invoice['description'])): ?>
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Notes</h3>
                <p class="text-gray-700"><?= nl2br(htmlspecialchars($invoice['description'])) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Actions Panel -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="space-y-3">
                <a href="/billing/<?= $invoice['id'] ?>/edit" 
                   class="w-full flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md text-blue-700 hover:bg-blue-50">
                    <i class="fas fa-edit mr-2"></i>Edit Invoice
                </a>
                <button onclick="window.print()" 
                        class="w-full flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-green-700 hover:bg-green-50">
                    <i class="fas fa-print mr-2"></i>Print Invoice
                </button>
                <form method="POST" action="/billing/<?= $invoice['id'] ?>/delete" class="w-full">
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-red-700 hover:bg-red-50"
                            onclick="return confirm('Are you sure you want to delete this invoice? This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>Delete Invoice
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Summary</h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Status</dt>
                    <dd class="text-sm font-medium text-gray-900"><?= ucfirst($invoice['status'] ?? 'Pending') ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Hours</dt>
                    <dd class="text-sm font-medium text-gray-900"><?= number_format($invoice['hours'] ?? 0, 2) ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Rate</dt>
                    <dd class="text-sm font-medium text-gray-900">$<?= number_format($invoice['hourly_rate'] ?? 0, 2) ?>/hr</dd>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <dt class="text-sm font-medium text-gray-900">Total</dt>
                    <dd class="text-sm font-bold text-gray-900">$<?= number_format($invoice['amount'] ?? 0, 2) ?></dd>
                </div>
            </dl>
        </div>
    </div>
</div>
