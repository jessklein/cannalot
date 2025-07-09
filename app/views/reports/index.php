<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
    <a href="/reports/export" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-download mr-2"></i>Export CSV
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-building text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Clients</dt>
                        <dd class="text-lg font-medium text-gray-900"><?= $reports['clients']['total'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-ticket-alt text-purple-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Tickets</dt>
                        <dd class="text-lg font-medium text-gray-900"><?= $reports['tickets']['total'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-tasks text-green-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Tasks</dt>
                        <dd class="text-lg font-medium text-gray-900"><?= $reports['tasks']['total'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-percentage text-indigo-500 text-2xl"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Completion Rate</dt>
                        <dd class="text-lg font-medium text-gray-900"><?= $reports['performance']['completion_rate'] ?>%</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Details -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Ticket Status Chart -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tickets by Status</h3>
            <div class="space-y-3">
                <?php foreach ($reports['tickets']['by_status'] as $status => $count): ?>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $reports['tickets']['total'] > 0 ? ($count / $reports['tickets']['total']) * 100 : 0 ?>%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900"><?= $count ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Task Status Chart -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tasks by Status</h3>
            <div class="space-y-3">
                <?php foreach ($reports['tasks']['by_status'] as $status => $count): ?>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                        <div class="flex items-center">
                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                <div class="bg-green-600 h-2 rounded-full" style="width: <?= $reports['tasks']['total'] > 0 ? ($count / $reports['tasks']['total']) * 100 : 0 ?>%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900"><?= $count ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Department Overview -->
<div class="bg-white overflow-hidden shadow rounded-lg mb-8">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Department Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600"><?= $reports['departments']['total'] ?></div>
                <div class="text-sm text-gray-500">Total Departments</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600"><?= $reports['departments']['active'] ?></div>
                <div class="text-sm text-gray-500">Active Departments</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600"><?= $reports['users']['total'] ?></div>
                <div class="text-sm text-gray-500">Total Users</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Tickets -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Tickets</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    <?php foreach (array_slice($reports['tickets']['recent'], 0, 5) as $index => $ticket): ?>
                        <li>
                            <div class="relative pb-8">
                                <?php if ($index < 4): ?>
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <?php endif; ?>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-ticket-alt text-white text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Ticket: <span class="font-medium text-gray-900"><?= htmlspecialchars($ticket['title']) ?></span>
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time><?= date('M j', strtotime($ticket['created_at'])) ?></time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Tasks -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Tasks</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    <?php foreach (array_slice($reports['tasks']['recent'], 0, 5) as $index => $task): ?>
                        <li>
                            <div class="relative pb-8">
                                <?php if ($index < 4): ?>
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <?php endif; ?>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-tasks text-white text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Task: <span class="font-medium text-gray-900"><?= htmlspecialchars($task['title']) ?></span>
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time><?= date('M j', strtotime($task['created_at'])) ?></time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
