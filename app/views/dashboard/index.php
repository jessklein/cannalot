<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900"></h1>Dashboard</h1>
    <p class="text-gray-600 mt-2">Welcome to your internal tools dashboard</p>
</div>

<!-- Dashboard Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-500 rounded-full">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_users']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-500 rounded-full">
                <i class="fas fa-building text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Active Clients</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_clients']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-500 rounded-full">
                <i class="fas fa-ticket-alt text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Open Tickets</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['open_tickets']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-500 rounded-full">
                <i class="fas fa-tasks text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Pending Tasks</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['pending_tasks']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-500 rounded-full">
                <i class="fas fa-sitemap text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Departments</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_departments']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Activity Overview -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Tickets -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Recent Tickets</h3>
            <a href="/tickets" class="text-blue-500 hover:text-blue-700 text-sm">View All</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($recentTickets)): ?>
                <?php foreach (array_slice($recentTickets, 0, 5) as $ticket): ?>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($ticket['title'] ?? 'Untitled') ?></p>
                            <p class="text-xs text-gray-500">Priority: 
                                <span class="px-2 py-1 text-xs rounded-full 
                                    <?= ($ticket['priority'] ?? 'medium') === 'high' ? 'bg-red-100 text-red-800' : 
                                       (($ticket['priority'] ?? 'medium') === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                    <?= ucfirst($ticket['priority'] ?? 'medium') ?>
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs rounded-full 
                                <?= ($ticket['status'] ?? 'open') === 'open' ? 'bg-red-100 text-red-800' : 
                                   (($ticket['status'] ?? 'open') === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                   (($ticket['status'] ?? 'open') === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) ?>">
                                <?= ucfirst(str_replace('_', ' ', $ticket['status'] ?? 'open')) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-sm">No recent tickets</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Tasks -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Recent Tasks</h3>
            <a href="/tasks" class="text-blue-500 hover:text-blue-700 text-sm">View All</a>
        </div>
        <div class="space-y-3">
            <?php if (!empty($recentTasks)): ?>
                <?php foreach (array_slice($recentTasks, 0, 5) as $task): ?>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($task['title'] ?? 'Untitled') ?></p>
                            <p class="text-xs text-gray-500">
                                <?php if (isset($task['due_date']) && $task['due_date']): ?>
                                    Due: <?= date('M j, Y', strtotime($task['due_date'])) ?>
                                <?php else: ?>
                                    No due date
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs rounded-full 
                                <?= ($task['status'] ?? 'pending') === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   (($task['status'] ?? 'pending') === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                   (($task['status'] ?? 'pending') === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) ?>">
                                <?= ucfirst(str_replace('_', ' ', $task['status'] ?? 'pending')) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 text-sm">No recent tasks</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Recent Users and Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Users -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-700">Recent Users</h3>
                <a href="/users" class="text-blue-500 hover:text-blue-700 text-sm">View All</a>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <?php if (!empty($recentUsers)): ?>
                    <?php foreach (array_slice($recentUsers, 0, 5) as $user): ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium"><?= htmlspecialchars($user['name'] ?? 'Unknown') ?></span> 
                                    (<?= htmlspecialchars($user['email'] ?? 'No email') ?>)
                                </p>
                                <p class="text-xs text-gray-400">
                                    Role: <?= ucfirst($user['role'] ?? 'user') ?> • 
                                    Joined <?= isset($user['created_at']) ? date('M j, Y', strtotime($user['created_at'])) : 'Unknown' ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">No recent users</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="/clients/create" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded text-center transition-colors">
                <i class="fas fa-building mr-2"></i>New Client
            </a>
            <a href="/tickets/create" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded text-center transition-colors">
                <i class="fas fa-ticket-alt mr-2"></i>New Ticket
            </a>
            <a href="/tasks/create" class="block w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded text-center transition-colors">
                <i class="fas fa-tasks mr-2"></i>New Task
            </a>
            <a href="/departments/create" class="block w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-2 px-4 rounded text-center transition-colors">
                <i class="fas fa-sitemap mr-2"></i>New Department
            </a>
            <a href="/reports" class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded text-center transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>View Reports
            </a>
        </div>
    </div>
</div>