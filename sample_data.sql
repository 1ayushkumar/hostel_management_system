-- Insert sample Staff data
INSERT INTO Staff (
        FirstName,
        LastName,
        Role,
        ContactNumber,
        EmailID,
        ShiftTiming,
        Password
    )
VALUES (
        'Rajesh',
        'Kumar',
        'Warden',
        '9876543210',
        'rajesh@hostel.com',
        'Morning (6 AM - 2 PM)',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ),
    (
        'Priya',
        'Singh',
        'Warden',
        '9876543211',
        'priya@hostel.com',
        'Afternoon (2 PM - 10 PM)',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ),
    (
        'Amit',
        'Sharma',
        'Security',
        '9876543212',
        'amit@hostel.com',
        'Night (10 PM - 6 AM)',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ),
    (
        'Sunita',
        'Verma',
        'Cleaner',
        '9876543213',
        'sunita@hostel.com',
        'Morning (6 AM - 2 PM)',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ),
    (
        'Mohan',
        'Patel',
        'Security',
        '9876543214',
        'mohan@hostel.com',
        'Afternoon (2 PM - 10 PM)',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    );
-- Insert sample Block data
INSERT INTO Block (
        BlockName,
        NumberOfFloors,
        WardenID,
        TotalRooms,
        Gender
    )
VALUES ('A Block', 3, 1, 30, 'Male'),
    ('B Block', 3, 2, 30, 'Female'),
    ('C Block', 2, NULL, 20, 'Male'),
    ('D Block', 2, NULL, 20, 'Female'),
    ('E Block', 2, NULL, 20, 'Male');
-- Update Staff with BlockAssigned
UPDATE Staff
SET BlockAssigned = 1
WHERE StaffID = 1;
UPDATE Staff
SET BlockAssigned = 2
WHERE StaffID = 2;
-- Insert sample Room data
INSERT INTO Room (
        RoomNumber,
        BlockID,
        Capacity,
        RoomType,
        Status,
        MonthlyRent
    )
VALUES ('A101', 1, 2, 'Double', 'Occupied', 4000),
    ('B101', 2, 1, 'Single', 'Vacant', 5000),
    ('C101', 3, 3, 'Triple', 'Occupied', 3000),
    ('D101', 4, 2, 'Double', 'Vacant', 4000),
    ('E101', 5, 1, 'Single', 'Occupied', 5000);
-- Insert sample Student data
INSERT INTO Student (
        FirstName,
        LastName,
        Gender,
        ContactNumber,
        EmailID,
        Course,
        Year,
        RoomID,
        EmergencyContact,
        JoiningDate
    )
VALUES (
        'Rahul',
        'Gupta',
        'Male',
        '9876543215',
        'rahul@student.com',
        'B.Tech',
        2,
        1,
        '9876543220',
        '2024-01-01'
    ),
    (
        'Sneha',
        'Patel',
        'Female',
        '9876543216',
        'sneha@student.com',
        'M.Tech',
        1,
        2,
        '9876543221',
        '2024-01-02'
    ),
    (
        'Vikram',
        'Singh',
        'Male',
        '9876543217',
        'vikram@student.com',
        'BCA',
        3,
        3,
        '9876543222',
        '2024-01-03'
    ),
    (
        'Neha',
        'Sharma',
        'Female',
        '9876543218',
        'neha@student.com',
        'MCA',
        2,
        4,
        '9876543223',
        '2024-01-04'
    ),
    (
        'Arun',
        'Kumar',
        'Male',
        '9876543219',
        'arun@student.com',
        'B.Tech',
        1,
        5,
        '9876543224',
        '2024-01-05'
    );
-- Insert sample Community_Events data (with future dates to avoid trigger issues)
INSERT INTO Community_Events (
        EventName,
        OrganizerId,
        EventType,
        Capacity,
        SkillLevel,
        ResourcesNeeded,
        BlockID,
        RegistrationDeadline,
        EventDateTime,
        AttendanceCount
    )
VALUES (
        'Cultural Night',
        1,
        'Cultural',
        100,
        'Beginner',
        'Sound system, Lights, Stage',
        1,
        '2025-08-01 18:00:00',
        '2025-08-15 18:00:00',
        0
    ),
    (
        'Tech Workshop',
        2,
        'Academic',
        50,
        'Intermediate',
        'Projector, Laptops',
        2,
        '2025-08-05 18:00:00',
        '2025-08-20 10:00:00',
        0
    ),
    (
        'Sports Tournament',
        3,
        'Sports',
        60,
        'Advanced',
        'Sports equipment, First aid kit',
        3,
        '2025-08-10 18:00:00',
        '2025-08-25 09:00:00',
        0
    ),
    (
        'Movie Night',
        4,
        'Social',
        80,
        'Beginner',
        'Projector, Sound system',
        4,
        '2025-08-15 18:00:00',
        '2025-09-01 19:00:00',
        0
    ),
    (
        'Coding Competition',
        5,
        'Academic',
        40,
        'Advanced',
        'Computers, Internet',
        5,
        '2025-08-20 18:00:00',
        '2025-09-05 14:00:00',
        0
    );
-- Insert sample Event_Registration data
INSERT INTO Event_Registration (
        EventID,
        StudentID,
        AttendanceStatus,
        FeedbackRating,
        Comments
    )
VALUES (1, 1, 'Registered', NULL, NULL),
    (1, 2, 'Registered', NULL, NULL),
    (2, 3, 'Registered', NULL, NULL),
    (2, 4, 'Registered', NULL, NULL),
    (3, 5, 'Registered', NULL, NULL);
-- Insert sample Event_Resources data
INSERT INTO Event_Resources (
        EventID,
        ResourceType,
        ResourceName,
        Quantity,
        Status,
        AssignedStaffID
    )
VALUES (
        1,
        'Equipment',
        'Sound System',
        1,
        'Available',
        1
    ),
    (
        1,
        'Equipment',
        'Stage Lights',
        4,
        'Available',
        1
    ),
    (2, 'Technical', 'Projector', 1, 'Available', 2),
    (3, 'Equipment', 'Sports Kit', 5, 'Available', 3),
    (
        4,
        'Technical',
        'Movie Screen',
        1,
        'Available',
        4
    );