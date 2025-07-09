<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Service</h1>
    <a href="/services" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i>Back to Services
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="/services">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Service Name -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Service Name *</label>
                <input type="text" id="name" name="name" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter service name">
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select id="category" name="category" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Category</option>
                    <option value="development">Development</option>
                    <option value="marketing">Marketing</option>
                    <option value="content">Content</option>
                    <option value="infrastructure">Infrastructure</option>
                    <option value="general">General</option>
                </select>
            </div>

            <!-- Hourly Rate -->
            <div>
                <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate *</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-gray-500">$</span>
                    <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" required 
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                </div>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="status" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter service description..."></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
            <a href="/services" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-save mr-2"></i>Create Service
            </button>
        </div>
    </form>
</div>
