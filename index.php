<?php
session_start();
include 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Dashboard - Hostel Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
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
                    <?php if (isset($_SESSION['user_id'])): ?>
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
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="auth/logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="auth/login.php">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Dashboard Stats -->
            <div class="col-md-12 mb-5">
                <div class="row g-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="card stats-card primary">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-2">Total Students</h5>
                                        <p class="display-6 mb-0">0</p>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-users fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card stats-card success">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-2">Available Rooms</h5>
                                        <p class="display-6 mb-0">0</p>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-bed fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card stats-card info">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-2">Upcoming Events</h5>
                                        <p class="display-6 mb-0">0</p>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card stats-card warning">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-2">Active Staff</h5>
                                        <p class="display-6 mb-0">0</p>
                                    </div>
                                    <div class="stats-icon">
                                        <i class="fas fa-user-tie fa-2x opacity-75"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="col-md-8">
                <div class="card glass">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-check me-3 text-primary"></i>
                            <h5 class="card-title mb-0">Upcoming Events</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-star me-2"></i>Event</th>
                                        <th><i class="fas fa-clock me-2"></i>Date</th>
                                        <th><i class="fas fa-tag me-2"></i>Type</th>
                                        <th><i class="fas fa-info-circle me-2"></i>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Events will be loaded dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card glass">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bolt me-3 text-warning"></i>
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="pages/events/create.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="action-icon me-3">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Create New Event</h6>
                                    <small class="text-muted">Organize community activities</small>
                                </div>
                            </a>
                            <a href="pages/students/create.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="action-icon me-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Add New Student</h6>
                                    <small class="text-muted">Register new residents</small>
                                </div>
                            </a>
                            <a href="pages/rooms/assign.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="action-icon me-3">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Assign Room</h6>
                                    <small class="text-muted">Allocate accommodation</small>
                                </div>
                            </a>
                            <a href="pages/staff/create.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                <div class="action-icon me-3">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Add Staff Member</h6>
                                    <small class="text-muted">Expand the team</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fab-container">
        <button class="fab" id="fabMain" title="Quick Actions">
            <i class="fas fa-plus"></i>
        </button>
        <div class="fab-menu" id="fabMenu">
            <a href="pages/students/create.php" class="fab-item" title="Add Student">
                <i class="fas fa-user-plus"></i>
            </a>
            <a href="pages/events/create.php" class="fab-item" title="Create Event">
                <i class="fas fa-calendar-plus"></i>
            </a>
            <a href="pages/rooms/assign.php" class="fab-item" title="Assign Room">
                <i class="fas fa-bed"></i>
            </a>
            <a href="pages/staff/create.php" class="fab-item" title="Add Staff">
                <i class="fas fa-user-tie"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5>Hostel Management System</h5>
                    <p>A comprehensive solution for managing hostel operations and community events.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="pages/about.php" class="text-white text-decoration-none">
                                <i class="fas fa-info-circle me-2"></i>About
                            </a></li>
                        <li><a href="pages/contact.php" class="text-white text-decoration-none">
                                <i class="fas fa-envelope me-2"></i>Contact
                            </a></li>
                        <li><a href="pages/help.php" class="text-white text-decoration-none">
                                <i class="fas fa-question-circle me-2"></i>Help
                            </a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> +1234567890</li>
                        <li><i class="fas fa-envelope me-2"></i> info@hostel.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
    <script>
        // Initialize debug mode in development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.log('🏠 Hostel Management System - Debug Mode');
            console.log('Type debugHMS() in console for system status');

            // Auto-run debug after page load
            setTimeout(() => {
                if (typeof debugHMS === 'function') {
                    debugHMS();
                }
            }, 2000);
        }
    </script>
</body>

</html>