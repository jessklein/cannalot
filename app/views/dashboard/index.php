<?php $view = __FILE__; require __DIR__ . '/../layouts/app.php'; ?>

<!-- Dashboard Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                <i class="fas fa-shopping-cart text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['total_orders']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-500 rounded-full">
                <i class="fas fa-dollar-sign text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Revenue</h3>
                <p class="text-3xl font-bold text-gray-900">$<?= number_format($stats['total_revenue']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-500 rounded-full">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Pending Orders</h3>
                <p class="text-3xl font-bold text-gray-900"><?= number_format($stats['pending_orders']) ?></p>
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

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-700">Recent Activity</h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-600">New user registered: John Doe</p>
                    <p class="text-xs text-gray-400">2 minutes ago</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-600">New order placed: Order #1234</p>
                    <p class="text-xs text-gray-400">5 minutes ago</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-600">Low stock alert: Product SKU-123</p>
                    <p class="text-xs text-gray-400">10 minutes ago</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Sales',
            data: [12000, 19000, 15000, 25000, 22000, 30000],
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// User Growth Chart
const userCtx = document.getElementById('userChart').getContext('2d');
new Chart(userCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'New Users',
            data: [25, 45, 35, 60, 55, 75],
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
