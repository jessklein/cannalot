<?php
/**
 * Simple File-Based Data Storage (No Database Required)
     file_put_contents('data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    echo "Tasks data created...\n";
    
    echo "\n✅ Internal tools data storage initialized successfully!\n";
    echo "You can now access your internal tools dashboard at: http://cannalot.local/\n";
    echo "Sample login: john@example.com / password\n"; creates JSON files for data storage as a quick alternative
 */

try {
    // Create data directory
    if (!is_dir('data')) {
        mkdir('data', 0755, true);
    }
    
    echo "Creating file-based data storage...\n";
    
    // Sample users data
    $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'admin', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3, 'name' => 'Mike Wilson', 'email' => 'mike@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 4, 'name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 5, 'name' => 'Tom Brown', 'email' => 'tom@example.com', 'password' => password_hash('password', PASSWORD_DEFAULT), 'role' => 'user', 'created_at' => date('Y-m-d H:i:s')],
    ];
    
    file_put_contents('data/users.json', json_encode($users, JSON_PRETTY_PRINT));
    echo "Users data created...\n";
    
    // Sample clients data
    $clients = [
        ['id' => 1, 'name' => 'Acme Corporation', 'contact_person' => 'John Smith', 'email' => 'john@acme.com', 'phone' => '555-0101', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'name' => 'Tech Solutions Inc', 'contact_person' => 'Sarah Johnson', 'email' => 'sarah@techsolutions.com', 'phone' => '555-0102', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3, 'name' => 'Global Industries', 'contact_person' => 'Mike Wilson', 'email' => 'mike@global.com', 'phone' => '555-0103', 'status' => 'inactive', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 4, 'name' => 'Digital Dynamics', 'contact_person' => 'Lisa Chen', 'email' => 'lisa@digitaldynamics.com', 'phone' => '555-0104', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 5, 'name' => 'Future Systems', 'contact_person' => 'David Brown', 'email' => 'david@futuresys.com', 'phone' => '555-0105', 'status' => 'active', 'created_at' => date('Y-m-d H:i:s')],
    ];
    
    file_put_contents('data/clients.json', json_encode($clients, JSON_PRETTY_PRINT));
    echo "Clients data created...\n";
    
    // Sample departments data
    $departments = [
        ['id' => 1, 'name' => 'IT Support', 'description' => 'Technical support and maintenance', 'manager' => 'John Doe', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'name' => 'Development', 'description' => 'Software development and programming', 'manager' => 'Jane Smith', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3, 'name' => 'Customer Service', 'description' => 'Client relations and support', 'manager' => 'Mike Wilson', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 4, 'name' => 'Marketing', 'description' => 'Digital marketing and campaigns', 'manager' => 'Sarah Johnson', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 5, 'name' => 'Sales', 'description' => 'Business development and sales', 'manager' => 'Tom Brown', 'created_at' => date('Y-m-d H:i:s')],
    ];
    
    file_put_contents('data/departments.json', json_encode($departments, JSON_PRETTY_PRINT));
    echo "Departments data created...\n";
    
    // Sample tickets data
    $tickets = [
        ['id' => 1, 'title' => 'Website loading slowly', 'description' => 'Client reports website performance issues', 'client_id' => 1, 'department_id' => 1, 'assigned_to' => 2, 'priority' => 'high', 'status' => 'open', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'title' => 'Email integration needed', 'description' => 'Integrate email system with CRM', 'client_id' => 2, 'department_id' => 2, 'assigned_to' => 3, 'priority' => 'medium', 'status' => 'in_progress', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3, 'title' => 'Database backup failure', 'description' => 'Automated backup system not working', 'client_id' => 4, 'department_id' => 1, 'assigned_to' => 1, 'priority' => 'high', 'status' => 'open', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 4, 'title' => 'New feature request', 'description' => 'Client wants custom reporting feature', 'client_id' => 3, 'department_id' => 2, 'assigned_to' => 4, 'priority' => 'low', 'status' => 'pending', 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 5, 'title' => 'Account access issue', 'description' => 'User cannot login to system', 'client_id' => 5, 'department_id' => 3, 'assigned_to' => 5, 'priority' => 'medium', 'status' => 'resolved', 'created_at' => date('Y-m-d H:i:s')],
    ];
    
    file_put_contents('data/tickets.json', json_encode($tickets, JSON_PRETTY_PRINT));
    echo "Tickets data created...\n";
    
    // Sample tasks data
    $tasks = [
        ['id' => 1, 'title' => 'Update server security patches', 'description' => 'Apply latest security updates to production servers', 'assigned_to' => 1, 'department_id' => 1, 'priority' => 'high', 'status' => 'todo', 'due_date' => date('Y-m-d', strtotime('+3 days')), 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 2, 'title' => 'Code review for new feature', 'description' => 'Review pull request for authentication module', 'assigned_to' => 2, 'department_id' => 2, 'priority' => 'medium', 'status' => 'in_progress', 'due_date' => date('Y-m-d', strtotime('+5 days')), 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 3, 'title' => 'Prepare monthly client report', 'description' => 'Compile and format monthly progress report', 'assigned_to' => 3, 'department_id' => 3, 'priority' => 'medium', 'status' => 'todo', 'due_date' => date('Y-m-d', strtotime('+7 days')), 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 4, 'title' => 'Database optimization', 'description' => 'Optimize slow-running queries in main database', 'assigned_to' => 4, 'department_id' => 1, 'priority' => 'low', 'status' => 'completed', 'due_date' => date('Y-m-d', strtotime('-2 days')), 'created_at' => date('Y-m-d H:i:s')],
        ['id' => 5, 'title' => 'Social media campaign setup', 'description' => 'Set up new campaign for Q3 launch', 'assigned_to' => 5, 'department_id' => 4, 'priority' => 'medium', 'status' => 'in_progress', 'due_date' => date('Y-m-d', strtotime('+10 days')), 'created_at' => date('Y-m-d H:i:s')],
    ];
    
    file_put_contents('data/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    echo "Tasks data created...\n";
    
    echo "\n✅ File-based data storage initialized successfully!\n";
    echo "You can now access your dashboard at: http://cannalot.local/\n";
    echo "Sample login: john@example.com / password\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
