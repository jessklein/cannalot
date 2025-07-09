<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Service</h1>
    <div class="flex space-x-2">
        <a href="/services/<?= $service['id'] ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-eye mr-2"></i>View Service
        </a>
        <a href="/services" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i>Back to Services
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="/services/<?= $service['id'] ?>">
        <input type="hidden" name="_method" value="PUT">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Service Name -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Service Name *</label>
                <input type="text" id="name" name="name" required 
                       value="<?= htmlspecialchars($service['name'] ?? '') ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter service name">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="category" name="category" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Category</option>
                    <option value="development" <?= ($service['category'] ?? '') === 'development' ? 'selected' : '' ?>>Development</option>
                    <option value="marketing" <?= ($service['category'] ?? '') === 'marketing' ? 'selected' : '' ?>>Marketing</option>
                    <option value="content" <?= ($service['category'] ?? '') === 'content' ? 'selected' : '' ?>>Content</option>
                    <option value="infrastructure" <?= ($service['category'] ?? '') === 'infrastructure' ? 'selected' : '' ?>>Infrastructure</option>
                    <option value="general" <?= ($service['category'] ?? '') === 'general' ? 'selected' : '' ?>>General</option>
                </select>
            </div>

            <!-- Hourly Rate -->
            <div>
                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate *</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                    <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" required 
                           value="<?= htmlspecialchars($service['hourly_rate'] ?? '') ?>"
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="active" <?= ($service['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($service['status'] ?? 'active') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter service description..."><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
            <a href="/services/<?= $service['id'] ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i>Update Service
            </button>
        </div>
    </form>
</div>

<!-- Danger Zone -->
<div class="bg-white rounded-lg shadow p-6 mt-6 border-l-4 border-red-500">
    <h3 class="text-lg font-medium text-red-600 mb-4">Danger Zone</h3>
    <p class="text-sm text-gray-600 mb-4">
        Once you delete a service, there is no going back. Please be certain.
    </p>
    <form method="POST" action="/services/<?= $service['id'] ?>/delete" class="inline">
        <button type="submit" 
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
            <i class="fas fa-trash mr-2"></i>Delete Service
        </button>
    </form>
</div>
