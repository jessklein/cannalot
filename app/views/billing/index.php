<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Billing Management</h1>
    <a href="/billing/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Create New Invoice
    </a>
</div>

<!-- Billing Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <?php
    $totalAmount = array_sum(array_column($billing, 'amount'));
    $paidAmount = array_sum(array_column(array_filter($billing, function($b) { return $b['status'] === 'paid'; }), 'amount'));
    $pendingAmount = array_sum(array_column(array_filter($billing, function($b) { return in_array($b['status'], ['pending', 'sent']); }), 'amount'));
    $overdueAmount = array_sum(array_column(array_filter($billing, function($b) { return $b['status'] === 'overdue'; }), 'amount'));
    ?>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500 rounded-full">
                <i class="fas fa-dollar-sign text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                <p class="text-2xl font-bold text-gray-900">$<?= number_format($totalAmount, 2) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Paid</h3>
                <p class="text-2xl font-bold text-gray-900">$<?= number_format($paidAmount, 2) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-500 rounded-full">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                <p class="text-2xl font-bold text-gray-900">$<?= number_format($pendingAmount, 2) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-500 rounded-full">
                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Overdue</h3>
                <p class="text-2xl font-bold text-gray-900">$<?= number_format($overdueAmount, 2) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Billing Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Invoice #
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Client
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Service
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Hours
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Amount
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Due Date
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($billing as $bill): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($bill['invoice_number'] ?? 'N/A') ?>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($bill['client_name'] ?? 'Unknown Client') ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= htmlspecialchars($bill['service_name'] ?? 'Unknown Service') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= number_format($bill['hours'] ?? 0, 1) ?>h
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        $<?= number_format($bill['amount'] ?? 0, 2) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= isset($bill['due_date']) ? date('M j, Y', strtotime($bill['due_date'])) : 'No due date' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $statusColors = [
                            'draft' => 'bg-gray-100 text-gray-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'sent' => 'bg-blue-100 text-blue-800',
                            'paid' => 'bg-green-100 text-green-800',
                            'overdue' => 'bg-red-100 text-red-800'
                        ];
                        $status = $bill['status'] ?? 'draft';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['draft'] ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/billing/<?= $bill['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        <a href="/billing/<?= $bill['id'] ?>/edit" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form method="POST" action="/billing/<?= $bill['id'] ?>/delete" style="display: inline;">
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this invoice?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if (empty($billing)): ?>
        <div class="text-center py-12">
            <i class="fas fa-file-invoice-dollar text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No invoices found</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first invoice.</p>
            <a href="/billing/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i>Create New Invoice
            </a>
        </div>
    <?php endif; ?>
</div>
