<?php 

require_once __DIR__ . '../../../Config/config.php';
try {
// Create a connection to the database using mysqli
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL queries to create tables
$queries = [
    "Users" => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );
    ",
    "Tasks" => "
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

foreach ($queries as $name => $query) {
    if ($conn->query($query) === TRUE) {
        echo "Table '$name' created successfully.\n";
    } else {
        echo "Error creating table '$name': " . $conn->error . "\n";
    }
}

// Close the database connection
$conn->close();
}
catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit;
}
?>
