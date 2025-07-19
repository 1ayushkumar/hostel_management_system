-- Hostel Management System Database Schema Only
-- This file contains only the table structure without sample data

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: hostel_management

-- Table structure for table Staff
CREATE TABLE Staff (
    StaffID int(11) NOT NULL AUTO_INCREMENT,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    Role enum('Warden','Security','Cleaner') NOT NULL,
    ContactNumber varchar(15) NOT NULL,
    EmailID varchar(100) NOT NULL,
    ShiftTiming varchar(50) NOT NULL,
    Password varchar(255) NOT NULL,
    BlockAssigned int(11) DEFAULT NULL,
    PRIMARY KEY (StaffID),
    UNIQUE KEY EmailID (EmailID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Block
CREATE TABLE Block (
    BlockID int(11) NOT NULL AUTO_INCREMENT,
    BlockName varchar(10) NOT NULL,
    NumberOfFloors int(11) NOT NULL,
    WardenID int(11) DEFAULT NULL,
    TotalRooms int(11) NOT NULL,
    Gender enum('Male','Female') NOT NULL,
    PRIMARY KEY (BlockID),
    KEY WardenID (WardenID),
    CONSTRAINT Block_ibfk_1 FOREIGN KEY (WardenID) REFERENCES Staff (StaffID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Room
CREATE TABLE Room (
    RoomID int(11) NOT NULL AUTO_INCREMENT,
    RoomNumber varchar(10) NOT NULL,
    BlockID int(11) NOT NULL,
    Capacity int(11) NOT NULL,
    RoomType enum('Single','Double','Triple') NOT NULL,
    Status enum('Occupied','Vacant') DEFAULT 'Vacant',
    MonthlyRent decimal(10,2) NOT NULL,
    PRIMARY KEY (RoomID),
    KEY BlockID (BlockID),
    CONSTRAINT Room_ibfk_1 FOREIGN KEY (BlockID) REFERENCES Block (BlockID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Student
CREATE TABLE Student (
    StudentID int(11) NOT NULL AUTO_INCREMENT,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    Gender enum('Male','Female') NOT NULL,
    ContactNumber varchar(15) NOT NULL,
    EmailID varchar(100) NOT NULL,
    Course varchar(50) NOT NULL,
    Year int(11) NOT NULL,
    RoomID int(11) DEFAULT NULL,
    EmergencyContact varchar(15) NOT NULL,
    JoiningDate date NOT NULL,
    PRIMARY KEY (StudentID),
    UNIQUE KEY EmailID (EmailID),
    KEY RoomID (RoomID),
    CONSTRAINT Student_ibfk_1 FOREIGN KEY (RoomID) REFERENCES Room (RoomID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Community_Events
CREATE TABLE Community_Events (
    EventID int(11) NOT NULL AUTO_INCREMENT,
    EventName varchar(100) NOT NULL,
    OrganizerId int(11) NOT NULL,
    EventType enum('Cultural','Academic','Sports','Social') NOT NULL,
    Capacity int(11) NOT NULL,
    SkillLevel enum('Beginner','Intermediate','Advanced') NOT NULL,
    ResourcesNeeded text DEFAULT NULL,
    BlockID int(11) DEFAULT NULL,
    RegistrationDeadline datetime NOT NULL,
    EventDateTime datetime NOT NULL,
    AttendanceCount int(11) DEFAULT 0,
    PRIMARY KEY (EventID),
    KEY OrganizerId (OrganizerId),
    KEY BlockID (BlockID),
    CONSTRAINT Community_Events_ibfk_1 FOREIGN KEY (OrganizerId) REFERENCES Student (StudentID),
    CONSTRAINT Community_Events_ibfk_2 FOREIGN KEY (BlockID) REFERENCES Block (BlockID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Event_Registration
CREATE TABLE Event_Registration (
    RegistrationID int(11) NOT NULL AUTO_INCREMENT,
    EventID int(11) NOT NULL,
    StudentID int(11) NOT NULL,
    RegistrationDate timestamp NOT NULL DEFAULT current_timestamp(),
    AttendanceStatus enum('Registered','Attended','Cancelled') DEFAULT 'Registered',
    FeedbackRating int(11) DEFAULT NULL CHECK (FeedbackRating >= 1 AND FeedbackRating <= 5),
    Comments text DEFAULT NULL,
    PRIMARY KEY (RegistrationID),
    UNIQUE KEY EventID (EventID,StudentID),
    KEY StudentID (StudentID),
    CONSTRAINT Event_Registration_ibfk_1 FOREIGN KEY (EventID) REFERENCES Community_Events (EventID) ON DELETE CASCADE,
    CONSTRAINT Event_Registration_ibfk_2 FOREIGN KEY (StudentID) REFERENCES Student (StudentID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table Event_Resources
CREATE TABLE Event_Resources (
    ResourceID int(11) NOT NULL AUTO_INCREMENT,
    EventID int(11) NOT NULL,
    ResourceType enum('Equipment','Room','Technical') NOT NULL,
    ResourceName varchar(100) NOT NULL,
    Quantity int(11) NOT NULL,
    Status enum('Available','In-Use','Damaged') DEFAULT 'Available',
    AssignedStaffID int(11) DEFAULT NULL,
    PRIMARY KEY (ResourceID),
    KEY EventID (EventID),
    KEY AssignedStaffID (AssignedStaffID),
    CONSTRAINT Event_Resources_ibfk_1 FOREIGN KEY (EventID) REFERENCES Community_Events (EventID) ON DELETE CASCADE,
    CONSTRAINT Event_Resources_ibfk_2 FOREIGN KEY (AssignedStaffID) REFERENCES Staff (StaffID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add foreign key constraint for Staff.BlockAssigned
ALTER TABLE Staff ADD CONSTRAINT Staff_ibfk_1 FOREIGN KEY (BlockAssigned) REFERENCES Block (BlockID);

-- View for upcoming events
CREATE VIEW UpcomingEvents AS
SELECT 
    ce.EventID,
    ce.EventName,
    ce.EventType,
    ce.Capacity,
    ce.AttendanceCount,
    ce.EventDateTime,
    ce.RegistrationDeadline,
    CONCAT(s.FirstName, ' ', s.LastName) AS OrganizerName,
    b.BlockName
FROM Community_Events ce
JOIN Student s ON ce.OrganizerId = s.StudentID
LEFT JOIN Block b ON ce.BlockID = b.BlockID
WHERE ce.EventDateTime > NOW()
ORDER BY ce.EventDateTime ASC;

-- View for event participation statistics
CREATE VIEW EventParticipationStats AS
SELECT 
    ce.EventID,
    ce.EventName,
    ce.EventType,
    ce.Capacity,
    ce.AttendanceCount,
    ROUND((ce.AttendanceCount / ce.Capacity) * 100, 2) AS ParticipationRate,
    AVG(er.FeedbackRating) AS AverageRating,
    COUNT(er.RegistrationID) AS TotalRegistrations
FROM Community_Events ce
LEFT JOIN Event_Registration er ON ce.EventID = er.EventID
GROUP BY ce.EventID, ce.EventName, ce.EventType, ce.Capacity, ce.AttendanceCount;

-- Triggers
DELIMITER $$

-- Trigger to update attendance count when a student registers
CREATE TRIGGER update_attendance_count
AFTER INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    UPDATE Community_Events 
    SET AttendanceCount = AttendanceCount + 1 
    WHERE EventID = NEW.EventID;
END$$

-- Trigger to check event capacity before registration
CREATE TRIGGER check_event_capacity
BEFORE INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    DECLARE current_count INT;
    DECLARE max_capacity INT;
    
    SELECT AttendanceCount, Capacity INTO current_count, max_capacity
    FROM Community_Events 
    WHERE EventID = NEW.EventID;
    
    IF current_count >= max_capacity THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Event is at full capacity';
    END IF;
END$$

-- Trigger to check registration deadline
CREATE TRIGGER check_registration_deadline
BEFORE INSERT ON Event_Registration
FOR EACH ROW
BEGIN
    DECLARE deadline DATETIME;
    SELECT RegistrationDeadline INTO deadline 
    FROM Community_Events 
    WHERE EventID = NEW.EventID;
    
    IF NOW() > deadline THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Registration deadline has passed';
    END IF;
END$$

DELIMITER ;

COMMIT;

-- Success message
SELECT 'Database schema created successfully! Now import sample_data_fixed.sql for sample data.' as 'Status';
