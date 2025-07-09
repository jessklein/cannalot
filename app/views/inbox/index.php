<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">My Inbox</h1>
    <p class="text-gray-600 mt-2">Your assigned tickets and tasks</p>
    <?php if ($currentUser): ?>
        <p class="text-sm text-gray-500 mt-1">Welcome back, <?= htmlspecialchars($currentUser['name']) ?>!</p>
    <?php endif; ?>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500 rounded-full">
                <i class="fas fa-ticket-alt text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">My Tickets</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_tickets']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-500 rounded-full">
                <i class="fas fa-exclamation-triangle text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Urgent Tickets</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['urgent_tickets']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full">
                <i class="fas fa-tasks text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">My Tasks</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_tasks']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-orange-500 rounded-full">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Overdue Tasks</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['overdue_tasks']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Assigned Tickets -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">My Tickets</h2>
                <a href="/tickets" class="text-blue-500 hover:text-blue-700 text-sm">View All Tickets</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <?php if (!empty($assignedTickets)): ?>
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ticket
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priority
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
                        <?php foreach (array_slice($assignedTickets, 0, 5) as $ticket): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($ticket['title'] ?? 'Untitled') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= isset($ticket['client_name']) ? 'Client: ' . htmlspecialchars($ticket['client_name']) : 'No client assigned' ?>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        <?= isset($ticket['created_at']) ? date('M j, Y', strtotime($ticket['created_at'])) : 'Unknown date' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $priorityColors = [
                                        'low' => 'bg-gray-100 text-gray-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        'high' => 'bg-orange-100 text-orange-800',
                                        'urgent' => 'bg-red-100 text-red-800'
                                    ];
                                    $priority = $ticket['priority'] ?? 'medium';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityColors[$priority] ?? $priorityColors['medium'] ?>">
                                        <?= ucfirst($priority) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusColors = [
                                        'open' => 'bg-blue-100 text-blue-800',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $status = $ticket['status'] ?? 'open';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['open'] ?>">
                                        <?= str_replace('_', ' ', ucfirst($status)) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/tickets/<?= $ticket['id'] ?>" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (count($assignedTickets) > 5): ?>
                    <div class="px-6 py-3 bg-gray-50 text-center">
                        <a href="/tickets" class="text-blue-500 hover:text-blue-700 text-sm">
                            View all <?= count($assignedTickets) ?> assigned tickets
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-ticket-alt text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No tickets assigned</h3>
                    <p class="text-gray-500">You don't have any tickets assigned to you at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Assigned Tasks -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">My Tasks</h2>
                <a href="/tasks" class="text-blue-500 hover:text-blue-700 text-sm">View All Tasks</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <?php if (!empty($assignedTasks)): ?>
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Task
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priority
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach (array_slice($assignedTasks, 0, 5) as $task): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($task['title'] ?? 'Untitled') ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= isset($task['department_name']) ? 'Dept: ' . htmlspecialchars($task['department_name']) : 'No department' ?>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Status: <?= ucfirst(str_replace('_', ' ', $task['status'] ?? 'pending')) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $priorityColors = [
                                        'low' => 'bg-gray-100 text-gray-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        'high' => 'bg-orange-100 text-orange-800',
                                        'urgent' => 'bg-red-100 text-red-800'
                                    ];
                                    $priority = $task['priority'] ?? 'medium';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityColors[$priority] ?? $priorityColors['medium'] ?>">
                                        <?= ucfirst($priority) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if (isset($task['due_date'])): ?>
                                        <?php
                                        $dueDate = strtotime($task['due_date']);
                                        $isOverdue = $dueDate < time() && ($task['status'] ?? '') !== 'completed';
                                        ?>
                                        <span class="<?= $isOverdue ? 'text-red-600 font-medium' : 'text-gray-900' ?>">
                                            <?= date('M j, Y', $dueDate) ?>
                                        </span>
                                        <?php if ($isOverdue): ?>
                                            <div class="text-xs text-red-500">Overdue</div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400">No due date</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/tasks/<?= $task['id'] ?>" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (count($assignedTasks) > 5): ?>
                    <div class="px-6 py-3 bg-gray-50 text-center">
                        <a href="/tasks" class="text-blue-500 hover:text-blue-700 text-sm">
                            View all <?= count($assignedTasks) ?> assigned tasks
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-tasks text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks assigned</h3>
                    <p class="text-gray-500">You don't have any tasks assigned to you at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<?php if (!empty($assignedTickets) || !empty($assignedTasks)): ?>
<div class="mt-8 bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
    <div class="flex flex-wrap gap-4">
        <a href="/tickets/create" class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-md text-blue-700 hover:bg-blue-50">
            <i class="fas fa-plus mr-2"></i>Create New Ticket
        </a>
        <a href="/tasks/create" class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md text-green-700 hover:bg-green-50">
            <i class="fas fa-plus mr-2"></i>Create New Task
        </a>
        <a href="/tickets" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            <i class="fas fa-ticket-alt mr-2"></i>All Tickets
        </a>
        <a href="/tasks" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            <i class="fas fa-tasks mr-2"></i>All Tasks
        </a>
    </div>
</div>
<?php endif; ?>
