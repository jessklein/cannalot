<?php
/**
 * Database Initialization Script
 * Run this once to create the SQLite database and sample data
 */

try {
    // Create SQLite database
    $pdo = new PDO('sqlite:database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Creating database...\n";
    
    // Enable foreign keys
    $pdo->exec('PRAGMA foreign_keys = ON');
    
    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT 'user',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    echo "Users table created...\n";
    
    // Create products table (for dashboard stats)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            stock INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    echo "Products table created...\n";
    
    // Create orders table (for dashboard stats)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            total DECIMAL(10,2) NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");
    
    echo "Orders table created...\n";
    
    // Insert sample users
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $users = [
        ['John Doe', 'john@example.com', password_hash('password', PASSWORD_DEFAULT), 'admin'],
        ['Jane Smith', 'jane@example.com', password_hash('password', PASSWORD_DEFAULT), 'user'],
        ['Mike Wilson', 'mike@example.com', password_hash('password', PASSWORD_DEFAULT), 'user'],
        ['Sarah Johnson', 'sarah@example.com', password_hash('password', PASSWORD_DEFAULT), 'user'],
        ['Tom Brown', 'tom@example.com', password_hash('password', PASSWORD_DEFAULT), 'user'],
    ];
    
    foreach ($users as $user) {
        $stmt->execute($user);
    }
    
    echo "Sample users inserted...\n";
    
    // Insert sample products
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO products (name, price, stock) VALUES (?, ?, ?)");
    $products = [
        ['Cannabis Strain A', 25.99, 50],
        ['Cannabis Strain B', 30.99, 35],
        ['CBD Oil 500mg', 45.99, 20],
        ['Edibles Pack', 15.99, 100],
        ['Vape Cartridge', 35.99, 25],
    ];
    
    foreach ($products as $product) {
        $stmt->execute($product);
    }
    
    echo "Sample products inserted...\n";
    
    // Insert sample orders
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO orders (user_id, total, status) VALUES (?, ?, ?)");
    $orders = [
        [2, 25.99, 'completed'],
        [3, 61.98, 'completed'],
        [4, 15.99, 'pending'],
        [5, 71.98, 'completed'],
        [2, 45.99, 'processing'],
    ];
    
    foreach ($orders as $order) {
        $stmt->execute($order);
    }
    
    echo "Sample orders inserted...\n";
    
    echo "\n✅ Database initialized successfully!\n";
    echo "You can now access your dashboard at: http://localhost/\n";
    echo "Sample login: john@example.com / password\n";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}