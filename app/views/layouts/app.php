<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Cannalot Dashboard' ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="text-xl font-bold">Cannalot Internal Tools</h1>
            </div>
            
            <nav class="mt-8">
                <ul class="space-y-2">
                    <li>
                        <a href="/dashboard" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/users" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-users mr-3"></i>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="/inbox" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-inbox mr-3"></i>
                            Inbox
                        </a>
                    </li>
                    <li>
                        <a href="/clients" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-building mr-3"></i>
                            Clients
                        </a>
                    </li>
                    <li>
                        <a href="/tickets" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-ticket-alt mr-3"></i>
                            Tickets
                        </a>
                    </li>
                    <li>
                        <a href="/tasks" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-tasks mr-3"></i>
                            Tasks
                        </a>
                    </li>
                    <li>
                        <a href="/departments" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-sitemap mr-3"></i>
                            Departments
                        </a>
                    </li>
                    <li>
                        <a href="/services" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-cogs mr-3"></i>
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="/billing" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-file-invoice-dollar mr-3"></i>
                            Billing
                        </a>
                    </li>
                    <li>
                        <a href="/reports" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Reports
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800"><?= $title ?? 'Dashboard' ?></h2>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="text-sm">Admin User</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (Session::has('success')): ?>
                <div class="mx-6 mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= Session::getFlash('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if (Session::has('error')): ?>
                <div class="mx-6 mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= Session::getFlash('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (Session::has('errors')): ?>
                <div class="mx-6 mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        <?php foreach (Session::getFlash('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 overflow-y-auto">
                <?php require $view ?? '' ?>
            </main>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script src="/assets/js/app.js"></script>
</body>
</html>
