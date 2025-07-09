<?php $view = __FILE__; require __DIR__ . '/../layouts/app.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Users Management</h1>
    <a href="/users/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Add New User
    </a>
</div>

<!-- Users Table -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">All Users</h3>
            <div class="flex items-center space-x-2">
                <input type="text" placeholder="Search users..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($users['data'])): ?>
                    <?php foreach ($users['data'] as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $user['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($user['name']) ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y', strtotime($user['created_at'] ?? 'now')) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="/users/<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/users/<?= $user['id'] ?>/edit" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteUser(<?= $user['id'] ?>)" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if (isset($users['last_page']) && $users['last_page'] > 1): ?>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-700">
                    Showing <?= (($users['current_page'] - 1) * $users['per_page']) + 1 ?> to 
                    <?= min($users['current_page'] * $users['per_page'], $users['total']) ?> 
                    of <?= $users['total'] ?> results
                </p>
                <div class="flex space-x-1">
                    <?php for ($i = 1; $i <= $users['last_page']; $i++): ?>
                        <a href="?page=<?= $i ?>" 
                           class="px-3 py-1 text-sm <?= $i == $users['current_page'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?> rounded">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Error deleting user');
            }
        });
    }
}
</script>
