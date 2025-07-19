// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Initialize modern UI enhancements
        initializeModernUI();

        // Update dashboard stats
        updateDashboardStats();

        // Load upcoming events
        loadUpcomingEvents();

        // Refresh data every 5 minutes
        setInterval(function() {
            updateDashboardStats();
            loadUpcomingEvents();
        }, 300000);
    } catch (error) {
        console.warn('Non-critical error in main.js:', error);
    }
});

// Global error handler to prevent external script conflicts
window.addEventListener('error', function(e) {
    // Ignore errors from browser extensions or external scripts
    if (e.filename && (e.filename.includes('extension') || e.filename.includes('enable_copy'))) {
        e.preventDefault();
        return false;
    }
});

// Debug function to check system status
function debugSystemStatus() {
    console.log('🔍 Hostel Management System Debug Info:');
    console.log('📍 Current URL:', window.location.href);
    console.log('📁 Base Path:', window.location.pathname);

    // Check if required elements exist
    const elements = {
        'Stats Cards': document.querySelectorAll('.stats-card').length,
        'Events Table': document.querySelector('.table tbody') ? 'Found' : 'Not Found',
        'Navigation': document.querySelector('.navbar') ? 'Found' : 'Not Found',
        'Main Container': document.querySelector('.container') ? 'Found' : 'Not Found'
    };

    console.table(elements);

    // Test API endpoints
    fetch('debug.php')
        .then(response => response.json())
        .then(data => {
            console.log('🔧 System Status:', data);
        })
        .catch(error => {
            console.warn('⚠️ Debug endpoint not available:', error);
        });
}

// Add debug command to console
window.debugHMS = debugSystemStatus;

// Test navbar functionality
function testNavbarButtons() {
    console.log('🧪 Testing Navbar Buttons:');

    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const results = {};

    navLinks.forEach((link, index) => {
        const href = link.getAttribute('href');
        const text = link.textContent.trim();
        const isWorking = href && href !== '#' && !href.startsWith('javascript:');

        results[text] = {
            href: href,
            working: isWorking,
            element: link
        };

        // Just log the link info, don't add click handlers
        console.log(`📋 Found link: "${text}" -> "${href}" (${isWorking ? 'Valid' : 'Invalid'})`);

        // Store link info for testing
        results[text] = {
            href: href,
            working: isWorking,
            element: link
        };
    });

    console.table(results);
    return results;
}

// Add navbar test to debug function
window.testNavbar = testNavbarButtons;

// Ensure table content visibility
function enhanceTableVisibility() {
    document.addEventListener('DOMContentLoaded', function() {
        // Find all tables and ensure content is visible
        const tables = document.querySelectorAll('.table');

        tables.forEach(table => {
            // Ensure all text in tables is visible with enhanced black color
            const cells = table.querySelectorAll('td, th');
            cells.forEach(cell => {
                // Add explicit styling to ensure maximum visibility
                cell.style.color = '#111827';
                cell.style.textShadow = 'none';
                cell.style.fontWeight = '600';

                // Ensure background is visible
                if (cell.tagName === 'TH') {
                    cell.style.background = 'rgba(255, 255, 255, 0.95)';
                    cell.style.fontWeight = '700';
                } else {
                    cell.style.background = 'rgba(255, 255, 255, 0.85)';
                }
            });

            // Enhance table rows with enhanced black text
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.background = 'rgba(255, 255, 255, 0.85)';

                row.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.95)';
                    this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
                    const cells = this.querySelectorAll('td');
                    cells.forEach(cell => {
                        cell.style.color = '#000000';
                        cell.style.fontWeight = '700';
                    });
                });

                row.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.85)';
                    this.style.boxShadow = 'none';
                    const cells = this.querySelectorAll('td');
                    cells.forEach(cell => {
                        cell.style.color = '#111827';
                        cell.style.fontWeight = '600';
                    });
                });
            });
        });

        console.log(`✅ Enhanced visibility for ${tables.length} tables`);
    });
}

// Initialize table visibility enhancement
enhanceTableVisibility();

// Simple navbar click logging (non-intrusive)
function logNavbarClicks() {
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            const text = link.textContent.trim();

            // Only add logging, don't interfere with navigation
            link.addEventListener('click', function(e) {
                console.log(`🔗 Navbar click: "${text}" -> "${href}"`);
                // Let the browser handle navigation normally
            });
        });

        console.log(`✅ Added non-intrusive logging to ${navLinks.length} navbar links`);
    });
}

// Initialize simple logging only
logNavbarClicks();

// Modern UI Enhancements
function initializeModernUI() {
    // Add entrance animations to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add hover effects to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add ripple effect to buttons
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });
    });

    // Initialize Floating Action Button
    initializeFAB();
}

// Floating Action Button functionality
function initializeFAB() {
    const fabMain = document.getElementById('fabMain');
    const fabMenu = document.getElementById('fabMenu');

    if (fabMain && fabMenu) {
        fabMain.addEventListener('click', function() {
            const isActive = fabMain.classList.contains('active');

            if (isActive) {
                fabMain.classList.remove('active');
                fabMenu.classList.remove('active');
            } else {
                fabMain.classList.add('active');
                fabMenu.classList.add('active');
            }
        });

        // Close FAB menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.fab-container')) {
                fabMain.classList.remove('active');
                fabMenu.classList.remove('active');
            }
        });

        // Close FAB menu when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                fabMain.classList.remove('active');
                fabMenu.classList.remove('active');
            }
        });
    }
}

// Function to update dashboard statistics
function updateDashboardStats() {
    // Check if we're on the dashboard page
    if (!document.querySelector('.stats-card')) {
        return;
    }

    fetch('api/dashboard-stats.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('API Error:', data.error);
                return;
            }

            // Use the new stats-card selectors
            const totalStudentsEl = document.querySelector('.stats-card.primary .display-6');
            const availableRoomsEl = document.querySelector('.stats-card.success .display-6');
            const upcomingEventsEl = document.querySelector('.stats-card.info .display-6');
            const activeStaffEl = document.querySelector('.stats-card.warning .display-6');

            if (totalStudentsEl) {
                animateNumber(totalStudentsEl, data.totalStudents || 0);
            }
            if (availableRoomsEl) {
                animateNumber(availableRoomsEl, data.availableRooms || 0);
            }
            if (upcomingEventsEl) {
                animateNumber(upcomingEventsEl, data.upcomingEvents || 0);
            }
            if (activeStaffEl) {
                animateNumber(activeStaffEl, data.activeStaff || 0);
            }
        })
        .catch(error => {
            console.error('Error updating dashboard stats:', error);
            // Show fallback values
            const statsCards = document.querySelectorAll('.stats-card .display-6');
            statsCards.forEach(card => {
                if (card.textContent === '0' || card.textContent === '') {
                    card.textContent = '--';
                }
            });
        });
}

// Function to animate numbers
function animateNumber(element, targetNumber) {
    const startNumber = parseInt(element.textContent) || 0;
    const duration = 1000;
    const startTime = performance.now();

    function updateNumber(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        const currentNumber = Math.floor(startNumber + (targetNumber - startNumber) * progress);
        element.textContent = currentNumber;

        if (progress < 1) {
            requestAnimationFrame(updateNumber);
        }
    }

    requestAnimationFrame(updateNumber);
}

// Function to load upcoming events
function loadUpcomingEvents() {
    // Check if we're on a page with events table
    const tbody = document.querySelector('.table tbody');
    if (!tbody) return;

    fetch('api/upcoming-events.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(events => {
            tbody.innerHTML = '';

            if (events.error) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error loading events: ${events.error}
                        </td>
                    </tr>`;
                return;
            }

            if (!Array.isArray(events) || events.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            <i class="fas fa-calendar-times me-2"></i>
                            No upcoming events scheduled
                        </td>
                    </tr>`;
                return;
            }

            events.forEach((event, index) => {
                const row = document.createElement('tr');
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.innerHTML = `
                    <td>
                        <i class="fas fa-star me-2 text-warning"></i>
                        ${escapeHtml(event.EventName || 'N/A')}
                    </td>
                    <td>
                        <i class="fas fa-clock me-2 text-info"></i>
                        ${formatDate(event.EventDateTime)}
                    </td>
                    <td>
                        <span class="badge bg-${getEventTypeColor(event.EventType)}">
                            ${escapeHtml(event.EventType || 'N/A')}
                        </span>
                    </td>
                    <td>${getEventStatus(event)}</td>
                `;
                tbody.appendChild(row);

                // Animate row appearance
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        })
        .catch(error => {
            console.error('Error loading upcoming events:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Failed to load events. Please check your connection.
                    </td>
                </tr>`;
        });
}

// Helper function to escape HTML
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Helper function to format date
function formatDate(dateString) {
    if (!dateString) return 'N/A';

    try {
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('en-US', options);
    } catch (error) {
        console.error('Error formatting date:', error);
        return 'Invalid Date';
    }
}

// Helper function to get event type color
function getEventTypeColor(type) {
    const colors = {
        'Cultural': 'primary',
        'Academic': 'success',
        'Sports': 'warning',
        'Social': 'info'
    };
    return colors[type] || 'secondary';
}

// Helper function to get event status
function getEventStatus(event) {
    if (!event) return '<span class="badge bg-secondary">Unknown</span>';

    try {
        const now = new Date();
        const eventDate = new Date(event.EventDateTime);
        const registrationDeadline = new Date(event.RegistrationDeadline);

        const attendanceCount = parseInt(event.AttendanceCount) || 0;
        const capacity = parseInt(event.Capacity) || 0;

        if (capacity > 0 && attendanceCount >= capacity) {
            return '<span class="badge bg-danger">Full</span>';
        } else if (event.RegistrationDeadline && now > registrationDeadline) {
            return '<span class="badge bg-warning">Registration Closed</span>';
        } else {
            return '<span class="badge bg-success">Open</span>';
        }
    } catch (error) {
        console.error('Error determining event status:', error);
        return '<span class="badge bg-secondary">Unknown</span>';
    }
}

// Form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
