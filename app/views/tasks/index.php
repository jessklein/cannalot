<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tasks Management</h1>
    <a href="/tasks/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Add New Task
    </a>
</div>

<!-- Tasks Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Task Title
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Priority
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Assigned To
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Due Date
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Created
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($tasks as $task): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($task['title']) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= htmlspecialchars(substr($task['description'] ?? '', 0, 50)) ?><?= strlen($task['description'] ?? '') > 50 ? '...' : '' ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $priorityColors = [
                            'low' => 'bg-gray-100 text-gray-800',
                            'medium' => 'bg-yellow-100 text-yellow-800',
                            'high' => 'bg-red-100 text-red-800',
                            'urgent' => 'bg-red-100 text-red-800'
                        ];
                        $priority = $task['priority'] ?? 'medium';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityColors[$priority] ?? $priorityColors['medium'] ?>">
                            <?= ucfirst($priority) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800'
                        ];
                        $status = $task['status'] ?? 'pending';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['pending'] ?>">
                            <?= ucfirst(str_replace('_', ' ', $status)) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= htmlspecialchars($task['assigned_to'] ?? 'Unassigned') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= $task['due_date'] ? date('M j, Y', strtotime($task['due_date'])) : 'No due date' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= date('M j, Y', strtotime($task['created_at'])) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/tasks/<?= $task['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        <a href="/tasks/<?= $task['id'] ?>/edit" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form method="POST" action="/tasks/<?= $task['id'] ?>/delete" style="display: inline;">
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if (empty($tasks)): ?>
        <div class="text-center py-12">
            <i class="fas fa-tasks text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first task.</p>
            <a href="/tasks/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i>Add New Task
            </a>
        </div>
    <?php endif; ?>
</div>
