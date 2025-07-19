<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <style>
        .hero-section {
            background: var(--glass-bg-strong);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border-strong);
            border-radius: var(--border-radius-lg);
            padding: 4rem 2rem;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4);
            animation: shimmer 2s ease-in-out infinite;
        }

        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            height: 100%;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-hover);
            background: var(--glass-bg-strong);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .stats-section {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 3rem 2rem;
            margin: 3rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .team-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 3rem;
            color: white;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-4">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="page-title">About Our Hostel Management System</h1>
            <p class="page-subtitle">A comprehensive digital solution designed to streamline hostel operations, enhance student experience, and simplify administrative tasks</p>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="../index.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="contact.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-envelope me-2"></i>Contact Us
                </a>
            </div>
        </div>

        <!-- What This Website Is About -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">What Is This Website?</h2>
                <p class="lead">Understanding our Hostel Management System</p>
            </div>
            <div class="col-lg-10 mx-auto">
                <div class="feature-card">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="feature-icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">Complete Hostel Management Solution</h3>
                            <p class="lead mb-4">This website is a comprehensive digital platform designed specifically for managing hostel operations efficiently and effectively.</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5><i class="fas fa-check-circle text-success me-2"></i>For Students</h5>
                                    <p>Easy room booking, profile management, event registration, and community interaction.</p>
                                </div>
                                <div class="col-sm-6">
                                    <h5><i class="fas fa-check-circle text-success me-2"></i>For Administrators</h5>
                                    <p>Complete control over student records, room allocation, staff management, and facility operations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purpose Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="feature-card text-center">
                    <div class="feature-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="mb-3">Our Purpose & Mission</h3>
                    <p class="lead">To revolutionize hostel management by providing a modern, intuitive, and comprehensive digital solution that bridges the gap between students, staff, and administrators while promoting community building and operational efficiency.</p>
                </div>
            </div>
        </div>

        <!-- Problems We Solve -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">Problems We Solve</h2>
                <p class="lead">Traditional hostel management challenges that our system addresses</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h4>Manual Record Keeping</h4>
                    <p><strong>Problem:</strong> Paper-based records, lost files, and time-consuming manual processes.</p>
                    <p><strong>Solution:</strong> Digital records with instant access, backup, and search capabilities.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4>Communication Gaps</h4>
                    <p><strong>Problem:</strong> Poor communication between students, staff, and administration.</p>
                    <p><strong>Solution:</strong> Centralized platform for announcements, requests, and updates.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Time-Consuming Tasks</h4>
                    <p><strong>Problem:</strong> Hours spent on room allocation, student registration, and report generation.</p>
                    <p><strong>Solution:</strong> Automated processes that complete tasks in minutes, not hours.</p>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold mb-3">Core Features & Capabilities</h2>
                <p class="lead">Comprehensive tools designed for modern hostel management</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Student Management</h4>
                    <p><strong>What it does:</strong> Maintains detailed student profiles including personal information, academic details, contact information, and hostel history.</p>
                    <ul class="text-start mt-3">
                        <li>Student registration and profile management</li>
                        <li>Academic year and course tracking</li>
                        <li>Emergency contact information</li>
                        <li>Student search and filtering</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h4>Room Management</h4>
                    <p><strong>What it does:</strong> Handles all aspects of room allocation, occupancy tracking, and facility management with real-time status updates.</p>
                    <ul class="text-start mt-3">
                        <li>Room allocation and assignment</li>
                        <li>Occupancy status tracking</li>
                        <li>Maintenance request management</li>
                        <li>Room capacity and availability</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4>Event Management</h4>
                    <p><strong>What it does:</strong> Organizes and manages all hostel events, activities, and community programs with registration and attendance tracking.</p>
                    <ul class="text-start mt-3">
                        <li>Event creation and scheduling</li>
                        <li>Student registration for events</li>
                        <li>Event categories and types</li>
                        <li>Attendance and participation tracking</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h4>Staff Management</h4>
                    <p><strong>What it does:</strong> Manages hostel staff information, roles, responsibilities, and work schedules for efficient operations.</p>
                    <ul class="text-start mt-3">
                        <li>Staff profiles and role assignment</li>
                        <li>Work shift scheduling</li>
                        <li>Contact information management</li>
                        <li>Performance and duty tracking</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Analytics & Reports</h4>
                    <p><strong>What it does:</strong> Generates comprehensive reports and analytics for informed decision-making and operational insights.</p>
                    <ul class="text-start mt-3">
                        <li>Occupancy and utilization reports</li>
                        <li>Student demographics analysis</li>
                        <li>Event participation statistics</li>
                        <li>Financial and operational metrics</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Security & Access Control</h4>
                    <p><strong>What it does:</strong> Ensures secure access to the system with role-based permissions and data protection.</p>
                    <ul class="text-start mt-3">
                        <li>User authentication and authorization</li>
                        <li>Role-based access control</li>
                        <li>Data encryption and security</li>
                        <li>Activity logging and monitoring</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Who Can Use This Website -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">Who Can Use This Website?</h2>
                <p class="lead">Different user roles and their access levels</p>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>Students</h4>
                    <p><strong>Access Level:</strong> Personal dashboard and student-specific features</p>
                    <h6 class="mt-3 mb-2">What Students Can Do:</h6>
                    <ul class="text-start">
                        <li>View and update personal profile</li>
                        <li>Check room assignment and details</li>
                        <li>Register for hostel events</li>
                        <li>Submit maintenance requests</li>
                        <li>View announcements and notices</li>
                        <li>Access hostel community features</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #10b981, #047857);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h4>Administrators</h4>
                    <p><strong>Access Level:</strong> Full system access and management capabilities</p>
                    <h6 class="mt-3 mb-2">What Administrators Can Do:</h6>
                    <ul class="text-start">
                        <li>Manage all student records and profiles</li>
                        <li>Allocate and manage room assignments</li>
                        <li>Create and manage events</li>
                        <li>Oversee staff management</li>
                        <li>Generate reports and analytics</li>
                        <li>System configuration and settings</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">How Does It Work?</h2>
                <p class="lead">Simple steps to get started with our system</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                        <span style="font-size: 2rem; font-weight: bold;">1</span>
                    </div>
                    <h5>Login</h5>
                    <p>Access the system using your credentials provided by the hostel administration.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                        <span style="font-size: 2rem; font-weight: bold;">2</span>
                    </div>
                    <h5>Navigate</h5>
                    <p>Use the intuitive dashboard to access different sections based on your role and permissions.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                        <span style="font-size: 2rem; font-weight: bold;">3</span>
                    </div>
                    <h5>Manage</h5>
                    <p>Perform your tasks - whether it's updating profiles, booking rooms, or managing events.</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="feature-card text-center">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <span style="font-size: 2rem; font-weight: bold;">4</span>
                    </div>
                    <h5>Track</h5>
                    <p>Monitor progress, view reports, and stay updated with real-time information and notifications.</p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h2 class="display-5 fw-bold">System Statistics</h2>
                    <p class="lead">Numbers that showcase our system's capabilities and impact</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <h5>Students Managed</h5>
                        <p>Active student profiles with complete records and room assignments</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <h5>Rooms Available</h5>
                        <p>Accommodation units with real-time occupancy tracking</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <h5>Events Organized</h5>
                        <p>Community events with automated registration and tracking</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">95%</div>
                        <h5>Efficiency Improvement</h5>
                        <p>Reduction in manual administrative tasks and paperwork</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">Why This Website Matters</h2>
                <p class="lead">The positive impact of digital hostel management</p>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <h4><i class="fas fa-clock text-success me-2"></i>Time Savings</h4>
                    <p>Reduces administrative workload by 95%, allowing staff to focus on student welfare and community building rather than paperwork.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <h4><i class="fas fa-accuracy text-success me-2"></i>Improved Accuracy</h4>
                    <p>Eliminates human errors in record keeping, room allocation, and student information management through automated processes.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <h4><i class="fas fa-users text-success me-2"></i>Better Student Experience</h4>
                    <p>Students can easily access their information, register for events, and communicate with administration through a single platform.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-card">
                    <h4><i class="fas fa-chart-line text-success me-2"></i>Data-Driven Decisions</h4>
                    <p>Provides valuable insights through analytics and reports, enabling better resource allocation and strategic planning.</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">Our Development Team</h2>
                <p class="lead">The dedicated professionals who built and maintain this system</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h4>System Administrator</h4>
                    <p class="text-muted">Managing system operations and user support</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-code"></i>
                    </div>
                    <h4>Lead Developer</h4>
                    <p class="text-muted">Building and maintaining the system architecture</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-github"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Support Manager</h4>
                    <p class="text-muted">Providing excellent customer support and assistance</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js?v=<?php echo time(); ?>"></script>
    <script>
        // Page entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.feature-card, .team-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>