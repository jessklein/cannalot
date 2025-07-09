<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Services Management</h1>
    <a href="/services/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Add New Service
    </a>
</div>

<!-- Services Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Service Name
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Category
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Hourly Rate
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
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
            <?php foreach ($services as $service): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <i class="fas fa-cogs text-white"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($service['name'] ?? 'Unnamed Service') ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= htmlspecialchars(substr($service['description'] ?? '', 0, 50)) ?><?= strlen($service['description'] ?? '') > 50 ? '...' : '' ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $categoryColors = [
                            'development' => 'bg-blue-100 text-blue-800',
                            'marketing' => 'bg-green-100 text-green-800',
                            'content' => 'bg-purple-100 text-purple-800',
                            'infrastructure' => 'bg-red-100 text-red-800',
                            'general' => 'bg-gray-100 text-gray-800'
                        ];
                        $category = $service['category'] ?? 'general';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $categoryColors[$category] ?? $categoryColors['general'] ?>">
                            <?= ucfirst($category) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        $<?= number_format($service['hourly_rate'] ?? 0, 2) ?>/hr
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-red-100 text-red-800'
                        ];
                        $status = $service['status'] ?? 'active';
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['active'] ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= isset($service['created_at']) ? date('M j, Y', strtotime($service['created_at'])) : 'Unknown' ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/services/<?= $service['id'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        <a href="/services/<?= $service['id'] ?>/edit" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form method="POST" action="/services/<?= $service['id'] ?>/delete" style="display: inline;">
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this service?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if (empty($services)): ?>
        <div class="text-center py-12">
            <i class="fas fa-cogs text-gray-300 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No services found</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first service.</p>
            <a href="/services/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i>Add New Service
            </a>
        </div>
    <?php endif; ?>
</div>
