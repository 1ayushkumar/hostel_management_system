<?php
// Database configuration - works for both local and Render deployment
try {
    // Check if we're on Render (has DATABASE_URL environment variable)
    if (isset($_ENV['DATABASE_URL']) || getenv('DATABASE_URL')) {
        // Parse Render's DATABASE_URL
        $databaseUrl = parse_url($_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL'));

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
    // Log the error for debugging
    error_log("Database connection failed: " . $e->getMessage());

    // Display user-friendly error message
    die("
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Database Connection Error</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='row justify-content-center'>
                <div class='col-md-6'>
                    <div class='alert alert-danger text-center'>
                        <h4>Database Connection Error</h4>
                        <p>Unable to connect to the database. Please try again later or contact the administrator.</p>
                        <small class='text-muted'>Error details have been logged for review.</small>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ");
}
