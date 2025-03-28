<?php 

require_once __DIR__ . '/Config/config.php';

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $queries = [
        "users" => "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ",
        "tasks" => "
            CREATE TABLE IF NOT EXISTS tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT NULL,
                start_time DATETIME NULL,
                end_time DATETIME NULL,
                start_date DATE NULL,
                end_date DATE NULL,
                status VARCHAR(20) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );
        "
    ];

    echo "Are you sure you want to drop and recreate the tables? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $confirmation = trim(fgets($handle));
    while (!in_array(strtolower($confirmation), ['y', 'n'])) {
        echo "Invalid input. Please enter 'y' to confirm or 'n' to cancel: ";
        $confirmation = trim(fgets($handle));
    }

    if (strtolower($confirmation) !== 'y') {
        echo "Operation cancelled.\n";
        exit;
    }
    // Kiểm tra database có tồn tại không
    $result = $conn->query("SHOW DATABASES LIKE '". DB_NAME ."'");
    if ($result->num_rows !== 0) {
    $dropDatabaseQuery = "DROP DATABASE IF EXISTS " . DB_NAME;
    if ($conn->query($dropDatabaseQuery) === TRUE) {
        echo "Database '" . DB_NAME . "' dropped successfully.\n";
    } else {
        echo "Error dropping database '" . DB_NAME . "': " . $conn->error . "\n";
        exit;
    }
    }
    $createDatabaseQuery = "CREATE DATABASE " . DB_NAME;
    if ($conn->query($createDatabaseQuery) === TRUE) {
        echo "Database '" . DB_NAME . "' created successfully.\n";
    } else {
        echo "Error creating database '" . DB_NAME . "': " . $conn->error . "\n";
        exit;
    }
    $conn->select_db(DB_NAME);
    foreach ($queries as $name => $query) {
        if ($conn->query($query) === TRUE) {
            echo "Table '$name' created successfully.\n";
        } else {
            echo "Error creating table '$name': " . $conn->error . "\n";
        }
    }
    
  
// password_hash
    $defaultAdminPassword = password_hash('admin123', PASSWORD_DEFAULT); 
    $insertAdminQuery = "INSERT INTO users (name, email, password) 
                         VALUES ('Admin', 'admin@example.com', '$defaultAdminPassword')";

    if ($conn->query($insertAdminQuery) === TRUE) {
        echo "Default admin account created successfully.\n";
    } else {
        echo "Error creating admin account: " . $conn->error . "\n";
    }
    $conn->close();
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit;
}
?>
