<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <style>
        .help-hero {
            background: var(--glass-bg-strong);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border-strong);
            border-radius: var(--border-radius-lg);
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .help-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669, #047857);
            animation: shimmer 2s ease-in-out infinite;
        }
        
        .help-category {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            height: 100%;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .help-category:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            background: var(--glass-bg-strong);
        }
        
        .help-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }
        
        .search-box {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 3rem;
        }
        
        .search-input {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(17, 24, 39, 0.3) !important;
            color: #111827 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
        }
        
        .search-input:focus {
            background: rgba(255, 255, 255, 1) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .page-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #10b981, #059669);
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
        
        .help-article {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .help-article:hover {
            background: var(--glass-bg-strong);
            transform: translateX(10px);
        }
        
        .help-article h5 {
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0.5rem;
        }
        
        .help-article p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
        }
        
        @keyframes shimmer {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .video-tutorial {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
        }
        
        .video-tutorial:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .video-thumbnail {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .play-button {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #10b981;
            transition: var(--transition);
        }
        
        .play-button:hover {
            transform: scale(1.1);
            background: white;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    
    <div class="container mt-4">
        <!-- Hero Section -->
        <div class="help-hero">
            <h1 class="page-title">Help Center</h1>
            <p class="page-subtitle">Find answers to your questions and learn how to use our system effectively</p>
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="../index.php" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="contact.php" class="btn btn-outline-light">
                    <i class="fas fa-envelope me-2"></i>Contact Support
                </a>
            </div>
        </div>
        
        <!-- Search Box -->
        <div class="search-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-0">
                            <i class="fas fa-search text-success"></i>
                        </span>
                        <input type="text" class="search-input border-start-0" placeholder="Search for help articles, tutorials, or FAQs..." id="helpSearch">
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-success btn-lg" onclick="searchHelp()">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Help Categories -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="display-5 fw-bold">Browse by Category</h2>
                <p class="lead">Choose a category to find relevant help articles</p>
            </div>
            <div class="col-md-3 mb-4">
                <div class="help-category" onclick="showCategory('getting-started')">
                    <div class="help-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h4>Getting Started</h4>
                    <p>Learn the basics of using our hostel management system</p>
                    <small class="text-success">12 articles</small>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="help-category" onclick="showCategory('student-guide')">
                    <div class="help-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>Student Guide</h4>
                    <p>Everything students need to know about the system</p>
                    <small class="text-success">18 articles</small>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="help-category" onclick="showCategory('admin-guide')">
                    <div class="help-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>Admin Guide</h4>
                    <p>Administrative functions and system management</p>
                    <small class="text-success">25 articles</small>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="help-category" onclick="showCategory('troubleshooting')">
                    <div class="help-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>Troubleshooting</h4>
                    <p>Solutions to common problems and issues</p>
                    <small class="text-success">15 articles</small>
                </div>
            </div>
        </div>
        
        <!-- Popular Articles -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h2 class="mb-4">Popular Help Articles</h2>
                <div id="helpArticles">
                    <div class="help-article" onclick="openArticle('login-help')">
                        <h5><i class="fas fa-sign-in-alt me-2 text-success"></i>How to Login to the System</h5>
                        <p>Step-by-step guide to accessing your account and troubleshooting login issues.</p>
                    </div>
                    <div class="help-article" onclick="openArticle('room-booking')">
                        <h5><i class="fas fa-bed me-2 text-success"></i>Room Booking and Management</h5>
                        <p>Learn how to book rooms, change assignments, and manage your accommodation.</p>
                    </div>
                    <div class="help-article" onclick="openArticle('event-registration')">
                        <h5><i class="fas fa-calendar me-2 text-success"></i>Event Registration Process</h5>
                        <p>How to register for hostel events and manage your event participation.</p>
                    </div>
                    <div class="help-article" onclick="openArticle('profile-update')">
                        <h5><i class="fas fa-user-edit me-2 text-success"></i>Updating Your Profile</h5>
                        <p>Guide to updating personal information, contact details, and preferences.</p>
                    </div>
                    <div class="help-article" onclick="openArticle('maintenance-request')">
                        <h5><i class="fas fa-wrench me-2 text-success"></i>Submitting Maintenance Requests</h5>
                        <p>How to report maintenance issues and track repair progress.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="mb-4">Video Tutorials</h2>
                <div class="video-tutorial mb-3" onclick="playVideo('system-overview')">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <h5>System Overview</h5>
                    <p class="small">5:30 minutes</p>
                </div>
                <div class="video-tutorial mb-3" onclick="playVideo('student-dashboard')">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <h5>Student Dashboard Tour</h5>
                    <p class="small">3:45 minutes</p>
                </div>
                <div class="video-tutorial" onclick="playVideo('admin-features')">
                    <div class="video-thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <h5>Admin Features</h5>
                    <p class="small">8:20 minutes</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="help-category text-center">
                    <h3 class="mb-4">Still Need Help?</h3>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="contact.php" class="btn btn-success btn-lg">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                        <button class="btn btn-outline-success btn-lg" onclick="startLiveChat()">
                            <i class="fas fa-comments me-2"></i>Live Chat
                        </button>
                        <button class="btn btn-outline-success btn-lg" onclick="scheduleCall()">
                            <i class="fas fa-phone me-2"></i>Schedule Call
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js?v=<?php echo time(); ?>"></script>
    <script>
        // Help search functionality
        function searchHelp() {
            const query = document.getElementById('helpSearch').value;
            if (query.trim()) {
                alert(`Searching for: "${query}"\n\nThis would normally search through help articles and display relevant results.`);
            } else {
                alert('Please enter a search term.');
            }
        }
        
        // Category navigation
        function showCategory(category) {
            alert(`Showing ${category} articles.\n\nThis would normally display all articles in the selected category.`);
        }
        
        // Article opening
        function openArticle(articleId) {
            alert(`Opening article: ${articleId}\n\nThis would normally display the full article content.`);
        }
        
        // Video player
        function playVideo(videoId) {
            alert(`Playing video: ${videoId}\n\nThis would normally open a video player with the tutorial.`);
        }
        
        // Live chat
        function startLiveChat() {
            alert('Starting live chat...\n\nThis would normally open a chat widget to connect with support staff.');
        }
        
        // Schedule call
        function scheduleCall() {
            alert('Schedule a call...\n\nThis would normally open a calendar to book a support call.');
        }
        
        // Search on Enter key
        document.getElementById('helpSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchHelp();
            }
        });
        
        // Page entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.help-category, .help-article, .video-tutorial');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
