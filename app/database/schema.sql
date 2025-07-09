CREATE DATABASE IF NOT EXISTS cannalot;

USE cannalot;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    sku VARCHAR(100) UNIQUE NOT NULL,
    category_id INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    parent_id INT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT,
    billing_address TEXT,
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Order Items table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Sessions table (for user sessions)
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Settings table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add foreign key for categories
ALTER TABLE products ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL;
ALTER TABLE categories ADD FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL;

-- Insert sample data
INSERT INTO users (name, email, password, status) VALUES
('Admin User', 'admin@cannalot.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active'),
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active');

INSERT INTO categories (name, description) VALUES
('Electronics', 'Electronic devices and accessories'),
('Clothing', 'Apparel and fashion items'),
('Books', 'Physical and digital books');

INSERT INTO products (name, description, price, stock_quantity, sku, category_id) VALUES
('Laptop Computer', 'High-performance laptop for work and gaming', 999.99, 50, 'LAPTOP-001', 1),
('Wireless Headphones', 'Noise-cancelling wireless headphones', 199.99, 100, 'HEADPHONES-001', 1),
('Cotton T-Shirt', 'Comfortable cotton t-shirt', 29.99, 200, 'TSHIRT-001', 2),
('Programming Book', 'Learn advanced programming concepts', 49.99, 75, 'BOOK-001', 3);

INSERT INTO settings (setting_key, setting_value, description) VALUES
('app_name', 'Cannalot Dashboard', 'Application name'),
('timezone', 'UTC', 'Default timezone'),
('currency', 'USD', 'Default currency'),
('items_per_page', '25', 'Default pagination size');
