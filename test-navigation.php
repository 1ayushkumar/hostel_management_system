<?php
session_start();

// Set a test session for navigation testing
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = 'Test User';
    $_SESSION['user_role'] = 'Warden';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Test - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card glass">
                    <div class="card-header">
                        <h3><i class="fas fa-vial me-2"></i>Navigation Test Page</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Testing Navigation:</strong> This page tests all navigation links in the navbar.
                        </div>

                        <h5>Navigation Links Status:</h5>
                        <div id="linkStatus" class="mb-4">
                            <p>Click the button below to test all navigation links:</p>
                            <button class="btn btn-primary" onclick="testAllLinks()">
                                <i class="fas fa-play me-2"></i>Test All Navigation Links
                            </button>
                        </div>

                        <h5>Manual Link Testing:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <strong>Main Navigation:</strong>
                                    </div>
                                    <a href="index.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-home me-2"></i>Dashboard
                                    </a>
                                    <a href="pages/students/list.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-users me-2"></i>Students
                                    </a>
                                    <a href="pages/rooms/list.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-bed me-2"></i>Rooms
                                    </a>
                                    <a href="pages/events/list.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-calendar-alt me-2"></i>Events
                                    </a>
                                    <a href="pages/staff/list.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-user-tie me-2"></i>Staff
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <strong>User Actions:</strong>
                                    </div>
                                    <a href="pages/profile.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-user-circle me-2"></i>Profile
                                    </a>
                                    <a href="auth/logout.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <a href="auth/login.php" class="list-group-item list-group-item-action">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>File Existence Check:</h5>
                            <div id="fileCheck" class="alert alert-secondary">
                                <p>Click the button to check if all navigation target files exist:</p>
                                <button class="btn btn-secondary" onclick="checkFiles()">
                                    <i class="fas fa-search me-2"></i>Check File Existence
                                </button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> This is a test page. In production, remove this file for security.
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
        function testAllLinks() {
            const linkStatus = document.getElementById('linkStatus');
            linkStatus.innerHTML = '<div class="spinner-border me-2" role="status"></div>Testing navigation links...';
            
            const links = [
                { name: 'Dashboard', url: 'index.php' },
                { name: 'Students', url: 'pages/students/list.php' },
                { name: 'Rooms', url: 'pages/rooms/list.php' },
                { name: 'Events', url: 'pages/events/list.php' },
                { name: 'Staff', url: 'pages/staff/list.php' },
                { name: 'Profile', url: 'pages/profile.php' }
            ];
            
            let results = '<h6>Link Test Results:</h6><div class="row">';
            let promises = [];
            
            links.forEach(link => {
                const promise = fetch(link.url, { method: 'HEAD' })
                    .then(response => ({
                        name: link.name,
                        url: link.url,
                        status: response.status,
                        ok: response.ok
                    }))
                    .catch(error => ({
                        name: link.name,
                        url: link.url,
                        status: 'Error',
                        ok: false,
                        error: error.message
                    }));
                promises.push(promise);
            });
            
            Promise.all(promises).then(results => {
                let html = '<h6>Link Test Results:</h6><div class="row">';
                results.forEach(result => {
                    const statusClass = result.ok ? 'success' : 'danger';
                    const icon = result.ok ? 'check-circle' : 'times-circle';
                    html += `
                        <div class="col-md-6 mb-2">
                            <div class="alert alert-${statusClass} py-2">
                                <i class="fas fa-${icon} me-2"></i>
                                <strong>${result.name}:</strong> ${result.status}
                                <br><small>${result.url}</small>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                linkStatus.innerHTML = html;
            });
        }
        
        function checkFiles() {
            const fileCheck = document.getElementById('fileCheck');
            fileCheck.innerHTML = '<div class="spinner-border me-2" role="status"></div>Checking file existence...';
            
            fetch('debug.php')
                .then(response => response.json())
                .then(data => {
                    let html = '<h6>File Existence Check:</h6>';
                    if (data.file_checks) {
                        html += '<div class="row">';
                        Object.entries(data.file_checks).forEach(([file, exists]) => {
                            const statusClass = exists ? 'success' : 'danger';
                            const icon = exists ? 'check' : 'times';
                            html += `
                                <div class="col-md-6 mb-1">
                                    <span class="badge bg-${statusClass}">
                                        <i class="fas fa-${icon} me-1"></i>${file}: ${exists ? 'EXISTS' : 'MISSING'}
                                    </span>
                                </div>
                            `;
                        });
                        html += '</div>';
                    } else {
                        html += '<div class="alert alert-warning">Debug endpoint not available</div>';
                    }
                    fileCheck.innerHTML = html;
                })
                .catch(error => {
                    fileCheck.innerHTML = `<div class="alert alert-danger">Error checking files: ${error.message}</div>`;
                });
        }
        
        // Auto-test on page load
        setTimeout(() => {
            if (typeof testNavbar === 'function') {
                console.log('🧪 Auto-testing navbar buttons...');
                testNavbar();
            }
        }, 1000);
    </script>
</body>
</html>
