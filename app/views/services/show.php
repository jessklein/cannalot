<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Service Details</h1>
    <div class="flex space-x-2">
        <a href="/services/<?= $service['id'] ?>/edit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-edit mr-2"></i>Edit Service
        </a>
        <a href="/services" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i>Back to Services
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Service Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0 h-16 w-16">
                    <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center">
                        <i class="fas fa-cogs text-white text-2xl"></i>
                    </div>
                </div>
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($service['name']) ?></h2>
                    <div class="flex items-center mt-2">
                        <?php
                        $categoryColors = [
                            'development' => 'bg-blue-100 text-blue-800',
                            'marketing' => 'bg-green-100 text-green-800',
                            'content' => 'bg-purple-100 text-purple-800',
                            'infrastructure' => 'bg-red-100 text-red-800',
                            'general' => 'bg-gray-100 text-gray-800'
                        ];
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-red-100 text-red-800'
                        ];
                        $category = $service['category'] ?? 'general';
                        $status = $service['status'] ?? 'active';
                        ?>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full mr-3 <?= $categoryColors[$category] ?? $categoryColors['general'] ?>">
                            <?= ucfirst($category) ?>
                        </span>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full <?= $statusColors[$status] ?? $statusColors['active'] ?>">
                            <?= ucfirst($status) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Service Information</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Hourly Rate</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">$<?= number_format($service['hourly_rate'] ?? 0, 2) ?>/hr</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= ucfirst($service['category'] ?? 'General') ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= ucfirst($service['status'] ?? 'Active') ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= isset($service['created_at']) ? date('F j, Y g:i A', strtotime($service['created_at'])) : 'Unknown' ?></dd>
                    </div>
                </dl>
            </div>

            <?php if (!empty($service['description'])): ?>
            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                <p class="text-gray-700"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Actions Panel -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="space-y-3">
                <a href="/services/<?= $service['id'] ?>/edit" 
                   class="w-full flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md text-blue-700 hover:bg-blue-50">
                    <i class="fas fa-edit mr-2"></i>Edit Service
                </a>
                <form method="POST" action="/services/<?= $service['id'] ?>/delete" class="w-full">
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-red-700 hover:bg-red-50"
                            onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>Delete Service
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
            <dl class="space-y-3">
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Monthly Rate</dt>
                    <dd class="text-sm font-medium text-gray-900">$<?= number_format(($service['hourly_rate'] ?? 0) * 160, 2) ?></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Daily Rate</dt>
                    <dd class="text-sm font-medium text-gray-900">$<?= number_format(($service['hourly_rate'] ?? 0) * 8, 2) ?></dd>
                </div>
            </dl>
        </div>
    </div>
</div>
