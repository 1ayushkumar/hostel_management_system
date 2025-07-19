<?php
$host = 'localhost';
$dbname = 'hostel_management';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // Log the error for debugging (in production, log to file instead of displaying)
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
