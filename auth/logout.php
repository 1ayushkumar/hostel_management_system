<?php
session_start();
session_destroy();

// Get the base URL dynamically
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = dirname(dirname($script_name));
if ($base_path === '/' || $base_path === '\\') {
    $base_path = '';
}
$base_url = $protocol . '://' . $host . $base_path;

header('Location: ' . $base_url . '/auth/login.php');
exit();
