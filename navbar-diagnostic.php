<?php
session_start();

// Set test session if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = 'Test User';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Diagnostic - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .diagnostic-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .status-good { color: #28a745; }
        .status-bad { color: #dc3545; }
        .status-warning { color: #ffc107; }
    </style>
</head>
<body>
    <!-- Use the actual navbar from index.php -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-home me-2"></i>Hostel Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/students/list.php">
                            <i class="fas fa-users me-2"></i>Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/rooms/list.php">
                            <i class="fas fa-bed me-2"></i>Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/events/list.php">
                            <i class="fas fa-calendar-alt me-2"></i>Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/staff/list.php">
                            <i class="fas fa-user-tie me-2"></i>Staff
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="pages/profile.php">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="auth/logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="diagnostic-card card">
                    <div class="card-header">
                        <h3><i class="fas fa-stethoscope me-2"></i>Navbar Diagnostic Tool</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Instructions:</strong> Click the navbar buttons above and watch the console (F12) for detailed debugging information.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>🔗 Link Status Check</h5>
                                <div id="linkStatus">
                                    <button class="btn btn-primary" onclick="checkAllLinks()">
                                        <i class="fas fa-search me-2"></i>Check All Links
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>📁 File Existence Check</h5>
                                <div id="fileStatus">
                                    <button class="btn btn-secondary" onclick="checkFiles()">
                                        <i class="fas fa-folder-open me-2"></i>Check Files
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>🖱️ Click Event Log</h5>
                            <div id="clickLog" class="border rounded p-3" style="height: 200px; overflow-y: auto; background: rgba(0,0,0,0.1);">
                                <small class="text-muted">Click navbar buttons to see events logged here...</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>🔧 Quick Actions</h5>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" onclick="testDirectNavigation()">
                                    <i class="fas fa-rocket me-2"></i>Test Direct Navigation
                                </button>
                                <button class="btn btn-warning" onclick="clearConsole()">
                                    <i class="fas fa-broom me-2"></i>Clear Console
                                </button>
                                <button class="btn btn-info" onclick="showNavbarInfo()">
                                    <i class="fas fa-info me-2"></i>Show Navbar Info
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        // Override console.log to also show in the click log
        const originalLog = console.log;
        const clickLogDiv = document.getElementById('clickLog');
        
        console.log = function(...args) {
            originalLog.apply(console, args);
            
            // Add to click log if it contains navbar-related info
            const message = args.join(' ');
            if (message.includes('NAVBAR') || message.includes('🖱️') || message.includes('🔗')) {
                const timestamp = new Date().toLocaleTimeString();
                clickLogDiv.innerHTML += `<div><small class="text-muted">[${timestamp}]</small> ${message}</div>`;
                clickLogDiv.scrollTop = clickLogDiv.scrollHeight;
            }
        };

        function checkAllLinks() {
            const linkStatus = document.getElementById('linkStatus');
            linkStatus.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Checking links...';
            
            const links = [
                'pages/students/list.php',
                'pages/rooms/list.php', 
                'pages/events/list.php',
                'pages/staff/list.php',
                'pages/profile.php'
            ];
            
            let results = '';
            let completed = 0;
            
            links.forEach(link => {
                fetch(link, { method: 'HEAD' })
                    .then(response => {
                        const status = response.ok ? 'good' : 'bad';
                        const icon = response.ok ? 'check' : 'times';
                        results += `<div class="status-${status}"><i class="fas fa-${icon} me-2"></i>${link}: ${response.status}</div>`;
                    })
                    .catch(error => {
                        results += `<div class="status-bad"><i class="fas fa-times me-2"></i>${link}: ERROR</div>`;
                    })
                    .finally(() => {
                        completed++;
                        if (completed === links.length) {
                            linkStatus.innerHTML = results;
                        }
                    });
            });
        }

        function checkFiles() {
            const fileStatus = document.getElementById('fileStatus');
            fileStatus.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Checking files...';
            
            fetch('debug.php')
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    if (data.file_checks) {
                        Object.entries(data.file_checks).forEach(([file, exists]) => {
                            const status = exists ? 'good' : 'bad';
                            const icon = exists ? 'check' : 'times';
                            html += `<div class="status-${status}"><i class="fas fa-${icon} me-2"></i>${file}</div>`;
                        });
                    }
                    fileStatus.innerHTML = html || '<div class="status-warning">No file check data available</div>';
                })
                .catch(error => {
                    fileStatus.innerHTML = `<div class="status-bad">Error: ${error.message}</div>`;
                });
        }

        function testDirectNavigation() {
            console.log('🚀 Testing direct navigation...');
            const testUrl = 'pages/students/list.php';
            console.log(`Attempting to navigate to: ${testUrl}`);
            
            // Test with a simple window.location change
            if (confirm(`Navigate to ${testUrl}?`)) {
                window.location.href = testUrl;
            }
        }

        function clearConsole() {
            console.clear();
            clickLogDiv.innerHTML = '<small class="text-muted">Console cleared. Click navbar buttons to see new events...</small>';
        }

        function showNavbarInfo() {
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            console.log('📊 Navbar Information:');
            console.log(`Total nav links found: ${navLinks.length}`);
            
            navLinks.forEach((link, index) => {
                console.log(`${index + 1}. "${link.textContent.trim()}" -> "${link.href}"`);
            });
        }

        // Auto-run diagnostics on page load
        setTimeout(() => {
            console.log('🔍 Auto-running navbar diagnostics...');
            showNavbarInfo();
            checkAllLinks();
        }, 1000);
    </script>
</body>
</html>
