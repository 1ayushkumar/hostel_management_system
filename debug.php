<?php
// Debug script to check system status
header('Content-Type: application/json');

$debug_info = [
    'timestamp' => date('Y-m-d H:i:s'),
    'server_info' => [
        'php_version' => phpversion(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
        'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'Unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Unknown'
    ],
    'file_checks' => [
        'config_database' => file_exists(__DIR__ . '/config/database.php'),
        'api_dashboard_stats' => file_exists(__DIR__ . '/api/dashboard-stats.php'),
        'api_upcoming_events' => file_exists(__DIR__ . '/api/upcoming-events.php'),
        'pages_students_list' => file_exists(__DIR__ . '/pages/students/list.php'),
        'assets_js_main' => file_exists(__DIR__ . '/assets/js/main.js'),
        'assets_css_style' => file_exists(__DIR__ . '/assets/css/style.css')
    ],
    'directory_structure' => []
];

// Check directory structure
$directories = ['api', 'assets', 'auth', 'config', 'includes', 'pages'];
foreach ($directories as $dir) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        $debug_info['directory_structure'][$dir] = scandir(__DIR__ . '/' . $dir);
    } else {
        $debug_info['directory_structure'][$dir] = 'Directory not found';
    }
}

// Database connection test
try {
    require_once __DIR__ . '/config/database.php';
    $debug_info['database'] = [
        'connection' => 'Success',
        'tables' => []
    ];
    
    // Check if tables exist
    $tables = ['Staff', 'Student', 'Block', 'Room', 'Community_Events'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            $debug_info['database']['tables'][$table] = $count . ' records';
        } catch (Exception $e) {
            $debug_info['database']['tables'][$table] = 'Error: ' . $e->getMessage();
        }
    }
} catch (Exception $e) {
    $debug_info['database'] = [
        'connection' => 'Failed',
        'error' => $e->getMessage()
    ];
}

echo json_encode($debug_info, JSON_PRETTY_PRINT);
?>
