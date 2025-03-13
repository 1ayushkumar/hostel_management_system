// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Update dashboard stats
    updateDashboardStats();
    
    // Load upcoming events
    loadUpcomingEvents();
    
    // Refresh data every 5 minutes
    setInterval(function() {
        updateDashboardStats();
        loadUpcomingEvents();
    }, 300000);
});

// Function to update dashboard statistics
function updateDashboardStats() {
    fetch('api/dashboard-stats.php')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.bg-primary .display-6').textContent = data.totalStudents;
            document.querySelector('.bg-success .display-6').textContent = data.availableRooms;
            document.querySelector('.bg-info .display-6').textContent = data.upcomingEvents;
            document.querySelector('.bg-warning .display-6').textContent = data.activeStaff;
        })
        .catch(error => console.error('Error:', error));
}

// Function to load upcoming events
function loadUpcomingEvents() {
    fetch('api/upcoming-events.php')
        .then(response => response.json())
        .then(events => {
            const tbody = document.querySelector('.table tbody');
            tbody.innerHTML = '';
            
            events.forEach(event => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${event.EventName}</td>
                    <td>${formatDate(event.EventDateTime)}</td>
                    <td><span class="badge bg-${getEventTypeColor(event.EventType)}">${event.EventType}</span></td>
                    <td>${getEventStatus(event)}</td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Error:', error));
}

// Helper function to format date
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
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
    const now = new Date();
    const eventDate = new Date(event.EventDateTime);
    const registrationDeadline = new Date(event.RegistrationDeadline);
    
    if (event.AttendanceCount >= event.Capacity) {
        return '<span class="badge bg-danger">Full</span>';
    } else if (now > registrationDeadline) {
        return '<span class="badge bg-warning">Registration Closed</span>';
    } else {
        return '<span class="badge bg-success">Open</span>';
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
