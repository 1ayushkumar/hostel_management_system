<?php
// Database configuration for Render deployment
try {
    // Check if we're on Render (has DATABASE_URL environment variable)
    if (isset($_ENV['DATABASE_URL'])) {
        // Parse Render's DATABASE_URL
        $databaseUrl = parse_url($_ENV['DATABASE_URL']);
        
        $host = $databaseUrl['host'];
        $port = $databaseUrl['port'] ?? 5432;
        $dbname = ltrim($databaseUrl['path'], '/');
        $username = $databaseUrl['user'];
        $password = $databaseUrl['pass'];
        
        // Create PDO connection for PostgreSQL on Render
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } else {
        // Local development with MySQL
        $host = 'localhost';
        $dbname = 'hostel_management';
        $username = 'root';
        $password = '';
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    
    // Test the connection
    $pdo->query("SELECT 1");
    
} catch (PDOException $e) {
    // Log error and show user-friendly message
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please check your configuration.");
}
?>
