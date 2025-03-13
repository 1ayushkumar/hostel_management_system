# Hostel Management System Database

This is a MySQL database design for a Hostel Management System with a focus on Community Events management.

## Setup Instructions

1. Start XAMPP:
   - Start Apache and MySQL services from XAMPP Control Panel

2. Import Database:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click on "Import" tab
   - Choose the file `hostel_management.sql`
   - Click "Go" to import the database

## Database Structure

### Main Tables:
- `Student`: Stores student information
- `Staff`: Manages staff details
- `Block`: Hostel block information
- `Room`: Room details and status
- `Community_Events`: Event management
- `Event_Registration`: Event participation tracking
- `Event_Resources`: Resource management for events

### Views:
- `UpcomingEvents`: Shows all future events
- `EventParticipationStats`: Provides event participation statistics

### Key Features:
1. **Event Management**
   - Event creation and registration
   - Capacity management
   - Resource allocation
   - Attendance tracking

2. **Automated Checks**
   - Registration deadline validation
   - Capacity limit enforcement
   - Duplicate registration prevention

3. **Statistics and Reporting**
   - Event participation tracking
   - Feedback collection
   - Resource utilization monitoring

## Usage Examples

1. Register a student for an event:
```sql
CALL RegisterForEvent(event_id, student_id, @status);
SELECT @status;
```

2. View upcoming events:
```sql
SELECT * FROM UpcomingEvents;
```

3. Check event statistics:
```sql
SELECT * FROM EventParticipationStats;
```

## Notes
- All tables include timestamps for creation and updates
- Foreign key constraints ensure data integrity
- Triggers automate attendance counting and validation
- Views provide easy access to common queries
