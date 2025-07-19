# 🏠 Hostel Management System

<div align="center">

![Hostel Management System](https://img.shields.io/badge/Hostel-Management%20System-blue?style=for-the-badge&logo=building&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**A modern, comprehensive web-based hostel management system designed to streamline hostel operations, enhance student experience, and simplify administrative tasks.**

[🚀 Live Demo](#) • [📖 Documentation](#-features) • [🐛 Report Bug](https://github.com/1ayushkumar/hostel_management_system/issues) • [💡 Request Feature](https://github.com/1ayushkumar/hostel_management_system/issues)

</div>

---

## 📋 Table of Contents

- [✨ Features](#-features)
- [🎯 Problem Statement](#-problem-statement)
- [🛠️ Technologies Used](#️-technologies-used)
- [📦 Installation](#-installation)
- [🚀 Quick Start](#-quick-start)
- [👥 User Roles](#-user-roles)
- [📱 Screenshots](#-screenshots)
- [🔧 Configuration](#-configuration)
- [📊 Database Schema](#-database-schema)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)
- [👨‍💻 Authors](#-authors)

---

## 🎯 Problem Statement

Traditional hostel management faces several challenges:
- 📝 **Manual Record Keeping**: Paper-based systems prone to errors and loss
- 📞 **Communication Gaps**: Poor coordination between students, staff, and administration
- ⏰ **Time-Consuming Tasks**: Hours spent on room allocation and student registration
- 📊 **Lack of Analytics**: No insights into occupancy, events, and student satisfaction
- 🔒 **Security Issues**: Unsecured data and unauthorized access

Our system addresses these challenges with a modern, digital approach.

## ✨ Features

<div align="center">

### 🎨 Modern UI/UX Design
![Modern Design](https://img.shields.io/badge/Design-Modern%20Glassmorphism-purple?style=flat-square)
![Responsive](https://img.shields.io/badge/Responsive-Mobile%20First-green?style=flat-square)
![Animations](https://img.shields.io/badge/Animations-Smooth%20Transitions-blue?style=flat-square)

</div>

### 🏠 **Room Management**
- Room allocation and assignment
- Track room occupancy and availability
- Support for different room types (Single, Double, Triple)
- Gender-based block assignments

### 👥 **Student Management**
- Student registration and profile management
- Room assignment tracking
- Event participation history
- Academic information tracking

### 👨‍💼 **Staff Management**
- Staff profiles and role management
- Block assignments for wardens
- Shift timing management
- Secure authentication system

### 🎉 **Event Management**
- Community event creation and management
- Event registration system
- Capacity management and waitlists
- Feedback and rating system
- Resource allocation for events

### 📊 **Dashboard & Analytics**
- Real-time statistics
- Upcoming events display
- Quick action shortcuts
- Responsive design for all devices

---

## 📱 Screenshots

<div align="center">

### 🏠 Dashboard Overview
*Modern glassmorphism design with real-time statistics and smooth animations*

![Dashboard](https://via.placeholder.com/800x400/6366f1/ffffff?text=Dashboard+Screenshot)

### 👥 Student Management
*Comprehensive student profiles with advanced search and filtering*

![Student Management](https://via.placeholder.com/800x400/8b5cf6/ffffff?text=Student+Management)

### 🏠 Room Management
*Intuitive room allocation with real-time occupancy tracking*

![Room Management](https://via.placeholder.com/800x400/06b6d4/ffffff?text=Room+Management)

### 🎉 Event Management
*Event creation and registration with capacity management*

![Event Management](https://via.placeholder.com/800x400/10b981/ffffff?text=Event+Management)

### 📱 Mobile Responsive
*Fully responsive design optimized for all devices*

![Mobile View](https://via.placeholder.com/400x600/f59e0b/ffffff?text=Mobile+Responsive)

</div>

---

## 🚀 Quick Start

### 🔧 Prerequisites
- ![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=flat-square&logo=xampp&logoColor=white) XAMPP/WAMP/LAMP server
- ![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php&logoColor=white) PHP 7.4 or higher
- ![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white) MySQL 5.7 or higher
- ![Browser](https://img.shields.io/badge/Browser-Modern-orange?style=flat-square&logo=googlechrome&logoColor=white) Modern web browser

### ⚡ Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/1ayushkumar/hostel_management_system.git
cd hostel_management_system

# 2. Move to web server directory
# For XAMPP: C:\xampp\htdocs\hostel_management_system
# For WAMP: C:\wamp64\www\hostel_management_system

# 3. Start your web server (XAMPP/WAMP)
# Start Apache and MySQL services

# 4. Create database
# Open phpMyAdmin (http://localhost/phpmyadmin)
# Create database: hostel_management
# Import: hostel_management.sql
# Import sample data: sample_data.sql

# 5. Configure database connection
# Edit config/database.php if needed

# 6. Access the system
# Open: http://localhost/hostel_management_system
```

### 🔑 Default Login Credentials

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| 🛡️ **Warden** | rajesh@hostel.com | password | Full Access |
| 🛡️ **Warden** | priya@hostel.com | password | Full Access |
| 🔒 **Security** | amit@hostel.com | password | Limited Access |

> ⚠️ **Security Note**: Change default passwords in production environment

## 🛠️ Technologies Used

<div align="center">

### Backend Technologies
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

### Frontend Technologies
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

### Libraries & Tools
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![DataTables](https://img.shields.io/badge/DataTables-1F4E79?style=for-the-badge&logo=datatables&logoColor=white)
![Font Awesome](https://img.shields.io/badge/Font%20Awesome-339AF0?style=for-the-badge&logo=fontawesome&logoColor=white)

</div>

### 🏗️ Architecture Overview
- **MVC Pattern**: Organized code structure with separation of concerns
- **RESTful APIs**: Clean API endpoints for data exchange
- **Responsive Design**: Mobile-first approach with Bootstrap framework
- **Security**: Password hashing, SQL injection prevention, session management
- **Performance**: Optimized queries, caching, and efficient data loading

## 👥 User Roles

<div align="center">

| Role | Icon | Access Level | Capabilities |
|------|------|--------------|--------------|
| **👨‍💼 Warden** | 🛡️ | Full Access | Student management, Room allocation, Event creation, Staff oversight |
| **🔒 Security** | 🛡️ | Limited Access | Student verification, Event monitoring, Safety protocols |
| **🧹 Cleaner** | 🧽 | Basic Access | Maintenance requests, Room status updates, Facility management |
| **👨‍🎓 Student** | 📚 | Personal Access | Profile management, Event registration, Room requests |

</div>

---

## 📦 Installation

### Prerequisites
- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Safari, Edge)

### Setup Instructions

1. **Clone/Download the project**
   ```bash
   git clone [repository-url]
   # OR download and extract the ZIP file
   ```

2. **Place in web server directory**
   - For XAMPP: Copy to `C:\xampp\htdocs\hostel_management_system`
   - For WAMP: Copy to `C:\wamp64\www\hostel_management_system`

3. **Database Setup**
   - Start XAMPP: Start Apache and MySQL services from XAMPP Control Panel
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `hostel_management`
   - Click on "Import" tab
   - Choose the file `hostel_management.sql`
   - Click "Go" to import the database
   - Optionally, run `sample_data.sql` for test data

4. **Configuration**
   - Open `config/database.php`
   - Update database credentials if needed:
     ```php
     $host = 'localhost';
     $dbname = 'hostel_management';
     $username = 'root';
     $password = '';
     ```

5. **Access the System**
   - Open browser and navigate to: `http://localhost/hostel_management_system`
   - Login with sample credentials:
     - **Email**: rajesh@hostel.com
     - **Password**: password

## Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Warden | rajesh@hostel.com | password |
| Warden | priya@hostel.com | password |
| Security | amit@hostel.com | password |

*Note: All passwords are hashed using PHP's password_hash() function*

## System Workings & Functionality

### 🔐 **Authentication System**

**Login Process:**
- Staff members log in using email and password
- Passwords are securely hashed using PHP's `password_hash()` function
- Session variables store user information (`user_id`, `user_name`, `user_role`, `user_block`)
- Automatic redirection to dashboard upon successful login
- Session timeout and logout functionality

**Security Features:**
- SQL injection prevention using prepared statements
- Password verification with `password_verify()`
- Session management with secure logout
- Input validation and sanitization

### 🏠 **Room Management Workflow**

**Room Assignment Process:**
1. **View Available Rooms**: System shows rooms with available capacity
2. **Gender Compatibility**: Students can only be assigned to blocks matching their gender
3. **Capacity Checking**: System prevents over-assignment beyond room capacity
4. **Status Updates**: Room status automatically updates (Vacant/Occupied)
5. **Bulk Operations**: Multiple room assignments can be processed

**Room Features:**
- Different room types: Single, Double, Triple
- Monthly rent tracking
- Block-wise organization
- Real-time availability status
- Capacity management (current occupants vs. total capacity)

### 👥 **Student Management System**

**Student Registration:**
1. **Personal Information**: Name, gender, contact details, email
2. **Academic Details**: Course, year of study, joining date
3. **Emergency Contact**: Required for safety purposes
4. **Room Assignment**: Optional during registration, can be assigned later
5. **Validation**: Email uniqueness, required field validation

**Student Operations:**
- **View**: Detailed student profile with accommodation and event history
- **Edit**: Update personal and academic information
- **Delete**: Remove student with cascade deletion of event registrations
- **Room Transfer**: Change room assignments with automatic status updates

### 🎉 **Event Management System**

**Event Creation Process:**
1. **Basic Information**: Event name, type (Cultural/Academic/Sports/Social), date/time
2. **Capacity Management**: Set maximum participants and skill level requirements
3. **Registration Deadline**: Automatic closure of registrations
4. **Resource Allocation**: Assign equipment, rooms, and staff
5. **Block Assignment**: Events can be block-specific or hostel-wide

**Event Registration:**
- **Student Registration**: Students can register for events before deadline
- **Capacity Limits**: System prevents over-registration
- **Attendance Tracking**: Mark attendance and collect feedback
- **Automatic Updates**: Attendance count updates automatically via database triggers

**Event Types & Features:**
- **Cultural Events**: Performances, celebrations, cultural activities
- **Academic Events**: Workshops, seminars, educational programs
- **Sports Events**: Tournaments, competitions, fitness activities
- **Social Events**: Movie nights, social gatherings, community building

### 👨‍💼 **Staff Management**

**Staff Roles:**
- **Warden**: Block management, student oversight, event supervision
- **Security**: Safety monitoring, access control, emergency response
- **Cleaner**: Maintenance, housekeeping, facility management

**Staff Features:**
- **Profile Management**: Personal information, contact details, shift timings
- **Block Assignment**: Wardens assigned to specific blocks
- **Authentication**: Secure login with role-based access
- **Shift Management**: Morning, Afternoon, Night shift tracking

### 📊 **Dashboard & Analytics**

**Real-time Statistics:**
- **Total Students**: Current student count in the hostel
- **Available Rooms**: Rooms with vacant capacity
- **Upcoming Events**: Events scheduled for the future
- **Active Staff**: Current staff members

**Dynamic Updates:**
- Statistics refresh every 5 minutes automatically
- AJAX calls to API endpoints for real-time data
- Error handling for failed API requests
- Graceful degradation when services are unavailable

### 🔄 **Database Operations**

**Automated Triggers:**
- **Attendance Count**: Automatically updates when students register for events
- **Capacity Validation**: Prevents registration when events are full
- **Registration Deadline**: Blocks registration after deadline expires
- **Room Status**: Updates room occupancy status automatically

**Data Integrity:**
- **Foreign Key Constraints**: Maintain referential integrity
- **Cascade Deletions**: Proper cleanup when records are deleted
- **Transaction Management**: Ensure data consistency during complex operations
- **Validation Rules**: Database-level constraints for data quality

### 🌐 **User Interface & Experience**

**Responsive Design:**
- **Mobile-First**: Optimized for mobile devices
- **Bootstrap Framework**: Consistent styling and components
- **Progressive Enhancement**: Works without JavaScript (basic functionality)
- **Cross-Browser**: Compatible with modern browsers

**Navigation:**
- **Dynamic Navbar**: Context-aware navigation based on user session
- **Breadcrumbs**: Clear navigation hierarchy
- **Quick Actions**: Shortcut buttons for common tasks
- **Search & Filter**: DataTables integration for data management

### 🔧 **API Endpoints**

**Dashboard Statistics API** (`/api/dashboard-stats.php`):
- Returns JSON with current system statistics
- Handles database errors gracefully
- Provides fallback values for missing data

**Upcoming Events API** (`/api/upcoming-events.php`):
- Fetches next 5 upcoming events
- Includes organizer and venue information
- Calculates event status (Open/Full/Closed)

### 📱 **Form Handling & Validation**

**Client-Side Validation:**
- HTML5 form validation attributes
- Bootstrap validation classes
- Real-time feedback for user input
- JavaScript validation for complex rules

**Server-Side Processing:**
- PHP validation and sanitization
- Database transaction management
- Error handling with user-friendly messages
- Success/failure feedback to users

### 🔍 **Search & Filtering**

**DataTables Integration:**
- **Sorting**: Click column headers to sort data
- **Searching**: Global search across all columns
- **Pagination**: Handle large datasets efficiently
- **Responsive**: Tables adapt to screen size

**Advanced Features:**
- **Export Options**: Print, PDF, Excel export capabilities
- **Column Visibility**: Show/hide columns as needed
- **State Saving**: Remember user preferences

### 🛡️ **Error Handling & Logging**

**Database Errors:**
- Connection failure handling with user-friendly messages
- Query error logging for debugging
- Graceful degradation when database is unavailable
- Transaction rollback on failures

**Application Errors:**
- PHP error handling and logging
- JavaScript error catching and reporting
- User-friendly error messages
- Development vs. production error display

### 🔄 **System Maintenance**

**Database Maintenance:**
- **Views**: Pre-defined queries for common operations
- **Stored Procedures**: Complex operations encapsulated
- **Indexes**: Optimized for common query patterns
- **Backup**: Regular database backup recommendations

**File Organization:**
- **Modular Structure**: Separated concerns and reusable components
- **Configuration**: Centralized database configuration
- **Assets**: Organized CSS, JavaScript, and image files
- **Documentation**: Inline code comments and external documentation

## File Structure

```
hostel_management_system/
├── api/                    # API endpoints
│   ├── dashboard-stats.php # Real-time statistics API
│   └── upcoming-events.php # Events data API
├── assets/                 # Static assets
│   ├── css/
│   │   └── style.css      # Custom styling
│   └── js/
│       └── main.js        # Dashboard functionality
├── auth/                   # Authentication system
│   ├── login.php          # Staff login page
│   └── logout.php         # Session termination
├── config/                 # Configuration files
│   └── database.php       # Database connection
├── includes/               # Reusable components
│   └── navbar.php         # Navigation bar
├── pages/                  # Main application pages
│   ├── events/            # Event management
│   │   ├── create.php     # Create new events
│   │   ├── delete.php     # Delete events
│   │   └── list.php       # View all events
│   ├── rooms/             # Room management
│   │   ├── assign.php     # Room assignment
│   │   ├── create.php     # Add new rooms
│   │   ├── delete.php     # Remove rooms
│   │   └── list.php       # View all rooms
│   ├── staff/             # Staff management
│   │   ├── create.php     # Add staff members
│   │   ├── delete.php     # Remove staff
│   │   └── list.php       # View all staff
│   ├── students/          # Student management
│   │   ├── create.php     # Student registration
│   │   ├── delete.php     # Remove students
│   │   ├── edit.php       # Update student info
│   │   ├── list.php       # View all students
│   │   └── view.php       # Student details
│   └── profile.php        # User profile management
├── docs/                   # Documentation
├── index.php              # Main dashboard
├── hostel_management.sql  # Database schema
├── sample_data.sql        # Sample data
└── README.md              # This file
```

## Database Schema

### Core Tables

**Staff Table:**
- `StaffID` (Primary Key): Unique staff identifier
- `FirstName`, `LastName`: Staff member names
- `Role`: Warden, Security, or Cleaner
- `ContactNumber`, `EmailID`: Contact information
- `ShiftTiming`: Work schedule
- `Password`: Hashed password for authentication
- `BlockAssigned`: Foreign key to Block table

**Block Table:**
- `BlockID` (Primary Key): Unique block identifier
- `BlockName`: Block designation (A, B, C, etc.)
- `NumberOfFloors`: Building structure info
- `WardenID`: Foreign key to Staff table
- `TotalRooms`: Room capacity
- `Gender`: Male or Female segregation

**Room Table:**
- `RoomID` (Primary Key): Unique room identifier
- `RoomNumber`: Room designation
- `BlockID`: Foreign key to Block table
- `Capacity`: Maximum occupants
- `RoomType`: Single, Double, or Triple
- `Status`: Occupied or Vacant
- `MonthlyRent`: Rental cost

**Student Table:**
- `StudentID` (Primary Key): Unique student identifier
- `FirstName`, `LastName`: Student names
- `Gender`: Male or Female
- `ContactNumber`, `EmailID`: Contact information
- `Course`, `Year`: Academic details
- `RoomID`: Foreign key to Room table
- `EmergencyContact`: Emergency contact number
- `JoiningDate`: Admission date

**Community_Events Table:**
- `EventID` (Primary Key): Unique event identifier
- `EventName`: Event title
- `OrganizerId`: Foreign key to Student table
- `EventType`: Cultural, Academic, Sports, or Social
- `Capacity`: Maximum participants
- `SkillLevel`: Beginner, Intermediate, or Advanced
- `ResourcesNeeded`: Required equipment/facilities
- `BlockID`: Foreign key to Block table (optional)
- `RegistrationDeadline`: Last date for registration
- `AttendanceCount`: Current registered participants
- `EventDateTime`: Event date and time

**Event_Registration Table:**
- `RegistrationID` (Primary Key): Unique registration identifier
- `EventID`: Foreign key to Community_Events table
- `StudentID`: Foreign key to Student table
- `RegistrationDate`: When student registered
- `AttendanceStatus`: Registered, Attended, or Cancelled
- `FeedbackRating`: 1-5 star rating
- `Comments`: Feedback text

**Event_Resources Table:**
- `ResourceID` (Primary Key): Unique resource identifier
- `EventID`: Foreign key to Community_Events table
- `ResourceType`: Equipment, Room, or Technical
- `ResourceName`: Specific resource name
- `Quantity`: Number of items needed
- `Status`: Available, In-Use, or Damaged
- `AssignedStaffID`: Foreign key to Staff table

### Database Views

**UpcomingEvents View:**
- Combines event, organizer, and block information
- Shows only future events
- Ordered by event date/time
- Used for dashboard display

**EventParticipationStats View:**
- Aggregates registration and attendance data
- Calculates participation rates
- Includes average feedback ratings
- Used for reporting and analytics

### Database Triggers

**update_attendance_count:**
- Automatically increments attendance count when student registers
- Maintains data consistency
- Prevents manual count errors

**check_event_capacity:**
- Validates registration against event capacity
- Prevents over-registration
- Throws error if capacity exceeded

**check_registration_deadline:**
- Validates registration timing
- Prevents late registrations
- Maintains event integrity

### Stored Procedures

**RegisterForEvent:**
- Handles complete event registration process
- Includes validation and error handling
- Returns status messages
- Ensures data consistency

## Usage Examples & Common Operations

### 1. Student Management
```php
// Add new student
$stmt = $pdo->prepare("INSERT INTO Student (FirstName, LastName, Gender, ContactNumber, EmailID, Course, Year, EmergencyContact, JoiningDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$firstName, $lastName, $gender, $contact, $email, $course, $year, $emergency, $joinDate]);

// Assign room to student
$stmt = $pdo->prepare("UPDATE Student SET RoomID = ? WHERE StudentID = ?");
$stmt->execute([$roomId, $studentId]);
```

### 2. Event Management
```sql
-- Register student for event
CALL RegisterForEvent(event_id, student_id, @status);
SELECT @status;

-- View upcoming events
SELECT * FROM UpcomingEvents;

-- Check event statistics
SELECT * FROM EventParticipationStats;
```

### 3. Room Operations
```php
// Check room availability
$stmt = $pdo->query("SELECT r.*, b.BlockName, (r.Capacity - COALESCE(student_count.count, 0)) as AvailableSpots FROM Room r JOIN Block b ON r.BlockID = b.BlockID LEFT JOIN (SELECT RoomID, COUNT(*) as count FROM Student WHERE RoomID IS NOT NULL GROUP BY RoomID) student_count ON r.RoomID = student_count.RoomID WHERE (r.Capacity - COALESCE(student_count.count, 0)) > 0");
```

### 4. Dashboard Statistics
```php
// Get real-time statistics
$totalStudents = $pdo->query("SELECT COUNT(*) FROM Student")->fetchColumn();
$availableRooms = $pdo->query("SELECT COUNT(*) FROM Room WHERE Status = 'Vacant'")->fetchColumn();
$upcomingEvents = $pdo->query("SELECT COUNT(*) FROM Community_Events WHERE EventDateTime > NOW()")->fetchColumn();
```

## System Workflows

### Student Registration Workflow
1. **Access Registration Form**: Navigate to Students → Add New Student
2. **Fill Personal Details**: Name, gender, contact information
3. **Add Academic Info**: Course, year, joining date
4. **Emergency Contact**: Required safety information
5. **Room Assignment**: Optional, can be done later
6. **Validation**: System checks email uniqueness and required fields
7. **Database Insert**: Student record created with transaction safety
8. **Confirmation**: Success message and redirect to student list

### Room Assignment Workflow
1. **View Unassigned Students**: System shows students without rooms
2. **Check Available Rooms**: Display rooms with vacant capacity
3. **Gender Compatibility**: Filter rooms by student gender
4. **Capacity Validation**: Ensure room has available spots
5. **Assignment**: Update student record with room ID
6. **Status Update**: Room status changes if at capacity
7. **Confirmation**: Assignment confirmed with updated statistics

### Event Creation Workflow
1. **Event Details**: Name, type, date/time, capacity
2. **Skill Level**: Set appropriate difficulty level
3. **Resource Planning**: List required equipment/facilities
4. **Block Assignment**: Choose specific block or hostel-wide
5. **Registration Deadline**: Set cutoff for registrations
6. **Database Insert**: Event created with validation
7. **Resource Allocation**: Assign staff and equipment
8. **Publication**: Event appears in upcoming events list

### Authentication Workflow
1. **Login Page**: Staff enters email and password
2. **Credential Validation**: Check against hashed passwords
3. **Session Creation**: Store user information in session
4. **Role Assignment**: Set permissions based on staff role
5. **Dashboard Redirect**: Navigate to main dashboard
6. **Session Management**: Maintain login state across pages
7. **Logout**: Clear session and redirect to login

## API Documentation

### Dashboard Statistics API
**Endpoint**: `/api/dashboard-stats.php`
**Method**: GET
**Response Format**: JSON
```json
{
  "totalStudents": 150,
  "availableRooms": 25,
  "upcomingEvents": 8,
  "activeStaff": 12
}
```

### Upcoming Events API
**Endpoint**: `/api/upcoming-events.php`
**Method**: GET
**Response Format**: JSON
```json
[
  {
    "EventID": 1,
    "EventName": "Cultural Night",
    "EventType": "Cultural",
    "Capacity": 100,
    "AttendanceCount": 45,
    "EventDateTime": "2025-02-15 18:00:00",
    "RegistrationDeadline": "2025-02-01 18:00:00",
    "OrganizerName": "John Doe",
    "BlockName": "A Block"
  }
]
```

## Security Implementation

### Password Security
- **Hashing**: PHP `password_hash()` with default algorithm
- **Verification**: `password_verify()` for login validation
- **Salt**: Automatic salt generation for each password
- **Cost Factor**: Configurable computational cost

### SQL Injection Prevention
- **Prepared Statements**: All database queries use prepared statements
- **Parameter Binding**: User input bound as parameters, not concatenated
- **Input Validation**: Server-side validation before database operations
- **Error Handling**: Database errors logged, not exposed to users

### Session Security
- **Session Regeneration**: New session ID on login
- **Timeout**: Automatic logout after inactivity
- **Secure Cookies**: HTTPOnly and Secure flags when available
- **CSRF Protection**: Form tokens for state-changing operations

### Input Validation
- **Client-Side**: HTML5 validation and JavaScript checks
- **Server-Side**: PHP validation and sanitization
- **Data Types**: Strict type checking for all inputs
- **Length Limits**: Maximum length validation for text fields

## Performance Optimization

### Database Optimization
- **Indexes**: Strategic indexing on frequently queried columns
- **Query Optimization**: Efficient JOIN operations and WHERE clauses
- **Connection Pooling**: Reuse database connections
- **Caching**: Query result caching for static data

### Frontend Optimization
- **CDN Usage**: Bootstrap and Font Awesome from CDN
- **Minification**: Compressed CSS and JavaScript files
- **Lazy Loading**: Load content as needed
- **Responsive Images**: Optimized images for different screen sizes

### Caching Strategy
- **Browser Caching**: Static assets cached by browser
- **Database Caching**: Frequently accessed data cached
- **Session Caching**: User session data optimized
- **API Caching**: Dashboard statistics cached for performance

## Troubleshooting Guide

### Common Issues

**Database Connection Failed:**
- Check XAMPP MySQL service is running
- Verify database credentials in `config/database.php`
- Ensure `hostel_management` database exists
- Check MySQL port (default 3306)

**Login Not Working:**
- Verify sample data is imported
- Check password hashing in database
- Clear browser cache and cookies
- Ensure session directory is writable

**Dashboard Not Loading:**
- Check API endpoints are accessible
- Verify JavaScript console for errors
- Ensure database has sample data
- Check file permissions

**Room Assignment Fails:**
- Verify gender compatibility
- Check room capacity limits
- Ensure student exists and is unassigned
- Check database constraints

### Debug Mode
Enable PHP error reporting for development:
```php
// Add to config/database.php for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## Maintenance & Updates

### Regular Maintenance
- **Database Backup**: Weekly automated backups
- **Log Rotation**: Clear old log files monthly
- **Session Cleanup**: Remove expired sessions
- **Performance Monitoring**: Track query performance

### Update Procedures
- **Code Updates**: Version control with Git
- **Database Migrations**: Structured schema updates
- **Dependency Updates**: Keep libraries current
- **Security Patches**: Regular security updates

### Monitoring
- **Error Logs**: Monitor PHP and MySQL error logs
- **Performance Metrics**: Track page load times
- **User Activity**: Monitor login patterns
- **System Resources**: CPU, memory, disk usage

---

## 🤝 Contributing

We welcome contributions to improve the Hostel Management System! Here's how you can help:

### 🚀 Getting Started
1. **Fork** the repository
2. **Clone** your fork: `git clone https://github.com/1ayushkumar/hostel_management_system.git`
3. **Create** a feature branch: `git checkout -b feature/amazing-feature`
4. **Make** your changes
5. **Test** thoroughly
6. **Commit** your changes: `git commit -m 'Add amazing feature'`
7. **Push** to the branch: `git push origin feature/amazing-feature`
8. **Open** a Pull Request

### 📋 Contribution Guidelines
- Follow existing code style and conventions
- Write clear, descriptive commit messages
- Add comments for complex logic
- Test your changes thoroughly
- Update documentation if needed

### 🐛 Bug Reports
- Use the issue tracker to report bugs
- Include detailed steps to reproduce
- Provide system information (PHP version, browser, etc.)
- Add screenshots if applicable

### 💡 Feature Requests
- Check existing issues before creating new ones
- Clearly describe the proposed feature
- Explain the use case and benefits
- Consider implementation complexity

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2024 Hostel Management System

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 👨‍💻 Authors

<div align="center">

### 🎯 Development Team

| Role | Contributor | GitHub | LinkedIn |
|------|-------------|--------|----------|
| **Lead Developer** | Ayush Kumar | [@1ayushkumar](https://github.com/1ayushkumar) | [LinkedIn](https://linkedin.com/in/ayushkumar) |
| **Full Stack Developer** | Ayush Kumar | [@1ayushkumar](https://github.com/1ayushkumar) | [LinkedIn](https://linkedin.com/in/ayushkumar) |
| **System Architect** | Ayush Kumar | [@1ayushkumar](https://github.com/1ayushkumar) | [LinkedIn](https://linkedin.com/in/ayushkumar) |

</div>

---

## 🙏 Acknowledgments

- **Bootstrap Team** for the amazing CSS framework
- **Font Awesome** for the beautiful icons
- **DataTables** for the powerful table functionality
- **PHP Community** for excellent documentation and support
- **MySQL Team** for the robust database system

---

## 📞 Support

<div align="center">

### Need Help?

[![GitHub Issues](https://img.shields.io/badge/GitHub-Issues-red?style=for-the-badge&logo=github&logoColor=white)](https://github.com/1ayushkumar/hostel_management_system/issues)
[![Email Support](https://img.shields.io/badge/Email-Support-blue?style=for-the-badge&logo=gmail&logoColor=white)](mailto:support@hostelms.com)
[![Documentation](https://img.shields.io/badge/Read-Documentation-green?style=for-the-badge&logo=gitbook&logoColor=white)](#-features)

**⭐ If you found this project helpful, please give it a star!**

</div>

---

<div align="center">

**Made with ❤️ for the hostel management community**

[![GitHub stars](https://img.shields.io/github/stars/1ayushkumar/hostel_management_system?style=social)](https://github.com/1ayushkumar/hostel_management_system/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/1ayushkumar/hostel_management_system?style=social)](https://github.com/1ayushkumar/hostel_management_system/network/members)
[![GitHub watchers](https://img.shields.io/github/watchers/1ayushkumar/hostel_management_system?style=social)](https://github.com/1ayushkumar/hostel_management_system/watchers)

</div>
