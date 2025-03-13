-- Drop database if exists and create new one
DROP DATABASE IF EXISTS hostel_management;
CREATE DATABASE hostel_management;
USE hostel_management;

-- Create Staff table
CREATE TABLE Staff (
    StaffID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Role ENUM('Warden', 'Cleaner', 'Security') NOT NULL,
    ContactNumber VARCHAR(15) NOT NULL,
    EmailID VARCHAR(100) UNIQUE NOT NULL,
    ShiftTiming VARCHAR(50) NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Block table
CREATE TABLE Block (
    BlockID INT PRIMARY KEY AUTO_INCREMENT,
    BlockName VARCHAR(50) UNIQUE NOT NULL,
    NumberOfFloors INT NOT NULL,
    WardenID INT,
    TotalRooms INT NOT NULL,
    Gender ENUM('Male', 'Female') NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (WardenID) REFERENCES Staff(StaffID) ON DELETE SET NULL,
    CHECK (NumberOfFloors > 0),
    CHECK (TotalRooms > 0)
);

-- Add BlockAssigned to Staff after Block table creation
ALTER TABLE Staff
ADD BlockAssigned INT,
ADD FOREIGN KEY (BlockAssigned) REFERENCES Block(BlockID) ON DELETE SET NULL;

-- Create Room table
CREATE TABLE Room (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    RoomNumber VARCHAR(10) NOT NULL,
    BlockID INT NOT NULL,
    Capacity INT NOT NULL,
    RoomType ENUM('Single', 'Double', 'Triple') NOT NULL,
    Status ENUM('Occupied', 'Vacant') DEFAULT 'Vacant',
    MonthlyRent DECIMAL(10,2) NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BlockID) REFERENCES Block(BlockID) ON DELETE CASCADE,
    UNIQUE KEY unique_room_block (RoomNumber, BlockID),
    CHECK (Capacity > 0),
    CHECK (MonthlyRent > 0)
);

-- Create Student table
CREATE TABLE Student (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Gender ENUM('Male', 'Female') NOT NULL,
    ContactNumber VARCHAR(15) NOT NULL,
    EmailID VARCHAR(100) UNIQUE NOT NULL,
    Course VARCHAR(100) NOT NULL,
    Year INT NOT NULL,
    RoomID INT,
    EmergencyContact VARCHAR(15) NOT NULL,
    JoiningDate DATE NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RoomID) REFERENCES Room(RoomID) ON DELETE SET NULL,
    CHECK (Year > 0 AND Year <= 5)
);

-- Create Community_Events table
CREATE TABLE Community_Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    EventName VARCHAR(100) NOT NULL,
    OrganizerId INT NOT NULL,
    EventType ENUM('Cultural', 'Academic', 'Sports', 'Social') NOT NULL,
    Capacity INT NOT NULL,
    SkillLevel ENUM('Beginner', 'Intermediate', 'Advanced') NOT NULL,
    ResourcesNeeded TEXT,
    BlockID INT,
    RegistrationDeadline DATETIME NOT NULL,
    AttendanceCount INT DEFAULT 0,
    EventDateTime DATETIME NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (OrganizerId) REFERENCES Student(StudentID) ON DELETE CASCADE,
    FOREIGN KEY (BlockID) REFERENCES Block(BlockID) ON DELETE SET NULL,
    CHECK (Capacity > 0),
    CHECK (AttendanceCount >= 0),
    CHECK (AttendanceCount <= Capacity),
    CHECK (EventDateTime > RegistrationDeadline)
);

-- Create Event_Registration table
CREATE TABLE Event_Registration (
    RegistrationID INT PRIMARY KEY AUTO_INCREMENT,
    EventID INT NOT NULL,
    StudentID INT NOT NULL,
    RegistrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AttendanceStatus ENUM('Registered', 'Attended', 'Cancelled') DEFAULT 'Registered',
    FeedbackRating DECIMAL(3,2),
    Comments TEXT,
    FOREIGN KEY (EventID) REFERENCES Community_Events(EventID) ON DELETE CASCADE,
    FOREIGN KEY (StudentID) REFERENCES Student(StudentID) ON DELETE CASCADE,
    UNIQUE KEY unique_event_student (EventID, StudentID),
    CHECK (FeedbackRating >= 1 AND FeedbackRating <= 5)
);

-- Create Event_Resources table
CREATE TABLE Event_Resources (
    ResourceID INT PRIMARY KEY AUTO_INCREMENT,
    EventID INT NOT NULL,
    ResourceType ENUM('Equipment', 'Room', 'Technical') NOT NULL,
    ResourceName VARCHAR(100) NOT NULL,
    Quantity INT NOT NULL,
    Status ENUM('Available', 'In-Use', 'Damaged') DEFAULT 'Available',
    AssignedStaffID INT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (EventID) REFERENCES Community_Events(EventID) ON DELETE CASCADE,
    FOREIGN KEY (AssignedStaffID) REFERENCES Staff(StaffID) ON DELETE SET NULL,
    CHECK (Quantity > 0)
);

-- Create view for upcoming events
CREATE VIEW UpcomingEvents AS
SELECT 
    e.EventID,
    e.EventName,
    e.EventType,
    e.SkillLevel,
    e.Capacity,
    e.AttendanceCount,
    e.EventDateTime,
    e.RegistrationDeadline,
    CONCAT(s.FirstName, ' ', s.LastName) AS OrganizerName,
    b.BlockName
FROM Community_Events e
JOIN Student s ON e.OrganizerId = s.StudentID
LEFT JOIN Block b ON e.BlockID = b.BlockID
WHERE e.EventDateTime > NOW()
ORDER BY e.EventDateTime;

-- Create view for event participation statistics
CREATE VIEW EventParticipationStats AS
SELECT 
    e.EventID,
    e.EventName,
    e.EventType,
    COUNT(er.RegistrationID) as TotalRegistrations,
    SUM(CASE WHEN er.AttendanceStatus = 'Attended' THEN 1 ELSE 0 END) as ActualAttendance,
    AVG(er.FeedbackRating) as AverageRating
FROM Community_Events e
LEFT JOIN Event_Registration er ON e.EventID = er.EventID
GROUP BY e.EventID, e.EventName, e.EventType;

-- Trigger to update attendance count
DELIMITER //
CREATE TRIGGER update_attendance_count
AFTER INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    UPDATE Community_Events 
    SET AttendanceCount = AttendanceCount + 1
    WHERE EventID = NEW.EventID;
END//

-- Trigger to check capacity before registration
CREATE TRIGGER check_event_capacity
BEFORE INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    DECLARE current_count INT;
    DECLARE max_capacity INT;
    
    SELECT AttendanceCount, Capacity 
    INTO current_count, max_capacity
    FROM Community_Events 
    WHERE EventID = NEW.EventID;
    
    IF current_count >= max_capacity THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Event has reached maximum capacity';
    END IF;
END//

-- Trigger to validate registration deadline
CREATE TRIGGER check_registration_deadline
BEFORE INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    DECLARE deadline DATETIME;
    
    SELECT RegistrationDeadline 
    INTO deadline
    FROM Community_Events 
    WHERE EventID = NEW.EventID;
    
    IF NOW() > deadline THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Registration deadline has passed';
    END IF;
END//

DELIMITER ;

-- Add Password column to Staff table if not exists
ALTER TABLE Staff ADD COLUMN IF NOT EXISTS Password VARCHAR(255);

-- Insert sample Staff data with proper password hashes
INSERT INTO Staff (FirstName, LastName, Role, ContactNumber, EmailID, ShiftTiming, Password) VALUES
('Rajesh', 'Kumar', 'Warden', '9876543210', 'rajesh@hostel.com', 'Morning (6 AM - 2 PM)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Priya', 'Singh', 'Warden', '9876543211', 'priya@hostel.com', 'Afternoon (2 PM - 10 PM)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Amit', 'Sharma', 'Security', '9876543212', 'amit@hostel.com', 'Night (10 PM - 6 AM)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Sunita', 'Verma', 'Cleaner', '9876543213', 'sunita@hostel.com', 'Morning (6 AM - 2 PM)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Mohan', 'Patel', 'Security', '9876543214', 'mohan@hostel.com', 'Afternoon (2 PM - 10 PM)', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample Block data
INSERT INTO Block (BlockName, NumberOfFloors, WardenID, TotalRooms, Gender) VALUES
('A Block', 3, 1, 30, 'Male'),
('B Block', 3, 2, 30, 'Female'),
('C Block', 2, NULL, 20, 'Male'),
('D Block', 2, NULL, 20, 'Female'),
('E Block', 2, NULL, 20, 'Male');

-- Update Staff with BlockAssigned
UPDATE Staff SET BlockAssigned = 1 WHERE StaffID = 1;
UPDATE Staff SET BlockAssigned = 2 WHERE StaffID = 2;

-- Insert sample Room data
INSERT INTO Room (RoomNumber, BlockID, Capacity, RoomType, Status, MonthlyRent) VALUES
('A101', 1, 2, 'Double', 'Occupied', 4000),
('B101', 2, 1, 'Single', 'Vacant', 5000),
('C101', 3, 3, 'Triple', 'Occupied', 3000),
('D101', 4, 2, 'Double', 'Vacant', 4000),
('E101', 5, 1, 'Single', 'Occupied', 5000);

-- Insert sample Student data
INSERT INTO Student (FirstName, LastName, Gender, ContactNumber, EmailID, Course, Year, RoomID, EmergencyContact, JoiningDate) VALUES
('Rahul', 'Gupta', 'Male', '9876543215', 'rahul@student.com', 'B.Tech', 2, 1, '9876543220', '2024-01-01'),
('Sneha', 'Patel', 'Female', '9876543216', 'sneha@student.com', 'M.Tech', 1, 2, '9876543221', '2024-01-02'),
('Vikram', 'Singh', 'Male', '9876543217', 'vikram@student.com', 'BCA', 3, 3, '9876543222', '2024-01-03'),
('Neha', 'Sharma', 'Female', '9876543218', 'neha@student.com', 'MCA', 2, 4, '9876543223', '2024-01-04'),
('Arun', 'Kumar', 'Male', '9876543219', 'arun@student.com', 'B.Tech', 1, 5, '9876543224', '2024-01-05');

-- Insert sample Community_Events data
INSERT INTO Community_Events (EventName, OrganizerId, EventType, Capacity, SkillLevel, ResourcesNeeded, BlockID, RegistrationDeadline, EventDateTime, AttendanceCount) VALUES
('Cultural Night', 1, 'Cultural', 100, 'Beginner', 'Sound system, Lights, Stage', 1, '2025-02-01 18:00:00', '2025-02-15 18:00:00', 0),
('Tech Workshop', 2, 'Academic', 50, 'Intermediate', 'Projector, Laptops', 2, '2025-02-05 18:00:00', '2025-02-20 10:00:00', 0),
('Sports Tournament', 3, 'Sports', 60, 'Advanced', 'Sports equipment, First aid kit', 3, '2025-02-10 18:00:00', '2025-02-25 09:00:00', 0),
('Movie Night', 4, 'Social', 80, 'Beginner', 'Projector, Sound system', 4, '2025-02-15 18:00:00', '2025-03-01 19:00:00', 0),
('Coding Competition', 5, 'Academic', 40, 'Advanced', 'Computers, Internet', 5, '2025-02-20 18:00:00', '2025-03-05 14:00:00', 0);

-- Insert sample Event_Registration data
INSERT INTO Event_Registration (EventID, StudentID, AttendanceStatus, FeedbackRating, Comments) VALUES
(1, 1, 'Registered', NULL, NULL),
(1, 2, 'Registered', NULL, NULL),
(2, 3, 'Registered', NULL, NULL),
(2, 4, 'Registered', NULL, NULL),
(3, 5, 'Registered', NULL, NULL);

-- Insert sample Event_Resources data
INSERT INTO Event_Resources (EventID, ResourceType, ResourceName, Quantity, Status, AssignedStaffID) VALUES
(1, 'Equipment', 'Sound System', 1, 'Available', 1),
(1, 'Equipment', 'Stage Lights', 4, 'Available', 1),
(2, 'Technical', 'Projector', 1, 'Available', 2),
(3, 'Equipment', 'Sports Kit', 5, 'Available', 3),
(4, 'Technical', 'Movie Screen', 1, 'Available', 4);

-- Stored procedure to register for an event
DELIMITER //
CREATE PROCEDURE RegisterForEvent(
    IN p_EventID INT,
    IN p_StudentID INT,
    OUT p_Status VARCHAR(100)
)
BEGIN
    DECLARE event_exists INT;
    DECLARE already_registered INT;
    
    -- Check if event exists
    SELECT COUNT(*) INTO event_exists 
    FROM Community_Events 
    WHERE EventID = p_EventID;
    
    IF event_exists = 0 THEN
        SET p_Status = 'Event does not exist';
    ELSE
        -- Check if already registered
        SELECT COUNT(*) INTO already_registered 
        FROM Event_Registration 
        WHERE EventID = p_EventID AND StudentID = p_StudentID;
        
        IF already_registered > 0 THEN
            SET p_Status = 'Already registered for this event';
        ELSE
            -- Attempt to register
            INSERT INTO Event_Registration (EventID, StudentID)
            VALUES (p_EventID, p_StudentID);
            SET p_Status = 'Successfully registered';
        END IF;
    END IF;
END//

DELIMITER ;
