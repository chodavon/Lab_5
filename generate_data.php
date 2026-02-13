<?php
require_once 'db_connect.php';

echo "Warning: This will RESET the database 'security_demo' and LOSE all existing data.\n";
echo "Starting data generation...\n";

// A. DEFINE SCHEMA AND INITIAL DATA
$commands = [
    // 1. Reset Database
    "DROP DATABASE IF EXISTS security_demo",
    "CREATE DATABASE security_demo",
    "USE security_demo",
    
    // 2. Create Tables
    "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user'
    )",
    
    "CREATE TABLE login_attempts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        time DATETIME NOT NULL
    )",
    
    "CREATE TABLE inventory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        owner_id INT NOT NULL,
        item_name VARCHAR(100) NOT NULL,
        category VARCHAR(50),
        quantity INT DEFAULT 10,
        price DECIMAL(10, 2),
        FOREIGN KEY (owner_id) REFERENCES users(id)
    )",
    
    // 3. Insert Users (Password: password123)
    "INSERT INTO users (username, password, role) VALUES 
    ('admin', '\$2y\$10\$LTZ58YecmK4lxkTDvLwtw.K4azrI4wDC/5/koHy1SbZWcsSddZ3zi', 'admin'),
    ('alice', '\$2y\$10\$LTZ58YecmK4lxkTDvLwtw.K4azrI4wDC/5/koHy1SbZWcsSddZ3zi', 'user'),
    ('bob', '\$2y\$10\$LTZ58YecmK4lxkTDvLwtw.K4azrI4wDC/5/koHy1SbZWcsSddZ3zi', 'user')",

    // 4. Insert Inventory
    // ID 2 = Alice (Electronics)
    "INSERT INTO inventory (owner_id, item_name, category, price) VALUES 
    (2, 'Pro Laptop X1', 'Electronics', 1299.99),
    (2, 'Wireless Mouse', 'Electronics', 29.99),
    (2, '4K Monitor', 'Electronics', 349.50)",
    
    // ID 3 = Bob (Furniture)
    "INSERT INTO inventory (owner_id, item_name, category, price) VALUES 
    (3, 'Ergonomic Chair', 'Furniture', 199.00),
    (3, 'Standing Desk', 'Furniture', 450.00),
    (3, 'Office Lamp', 'Furniture', 45.00)"
];

// B. EXECUTE SCHEMA COMMANDS
foreach ($commands as $command) {
    try {
        $pdo->exec($command);
    } catch (PDOException $e) {
        echo "SQL Error during setup: " . $e->getMessage() . "\n";
        echo "Command: $command\n";
        exit(1);
    }
}
echo "Database schema created and initial data inserted.\n";

echo "Success! Database reset.\n";
?>
