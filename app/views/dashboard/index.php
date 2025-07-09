<!-- Dashboard Stats Cards -->
<div class="grid grid-cols-1 md<!-- Activity Overview -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Tickets -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Tickets</h3>
        <div class="space-y-3">
            <?php foreach (array_slice($recentTickets, 0, 5) as $ticket): ?>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($ticket['title']) ?></p>
                        <p class="text-xs text-gray-500">Priority: 
                            <span class="px-2 py-1 text-xs rounded-full 
                                <?= $ticket['priority'] === 'high' ? 'bg-red-100 text-red-800' : 
                                   ($ticket['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                <?= ucfirst($ticket['priority']) ?>
                            </span>
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?= $ticket['status'] === 'open' ? 'bg-red-100 text-red-800' : 
                               ($ticket['status'] === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                               ($ticket['status'] === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) ?>">
                            <?= ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Recent Tasks -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Tasks</h3>
        <div class="space-y-3">
            <?php foreach (array_slice($recentTasks, 0, 5) as $task): ?>
                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($task['title']) ?></p>
                        <p class="text-xs text-gray-500">Due: <?= date('M j, Y', strtotime($task['due_date'])) ?></p>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?= $task['status'] === 'todo' ? 'bg-gray-100 text-gray-800' : 
                               ($task['status'] === 'in_progress' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') ?>">
                            <?= ucfirst(str_replace('_', ' ', $task['status'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>g:grid-cols-5 gap-6 mb-8">
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

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Sales Overview</h3>
        <canvas id="salesChart" width="400" height="200"></canvas>
    </div>
    
    <!-- User Growth Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">User Growth</h3>
        <canvas id="userChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Recent Users -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700">Recent Users</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <?php foreach ($recentUsers as $user): ?>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium"><?= htmlspecialchars($user['name']) ?></span> 
                            (<?= htmlspecialchars($user['email']) ?>)
                        </p>
                        <p class="text-xs text-gray-400">Role: <?= ucfirst($user['role']) ?> • Joined <?= date('M j, Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


