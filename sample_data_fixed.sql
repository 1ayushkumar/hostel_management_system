-- Fixed Sample Data for Hostel Management System
-- This version temporarily disables triggers to avoid registration deadline issues

-- Temporarily disable triggers
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- Insert sample Staff data
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
('A102', 1, 2, 'Double', 'Vacant', 4000),
('A103', 1, 1, 'Single', 'Vacant', 5000),
('B101', 2, 1, 'Single', 'Occupied', 5000),
('B102', 2, 2, 'Double', 'Vacant', 4000),
('B103', 2, 3, 'Triple', 'Vacant', 3000),
('C101', 3, 3, 'Triple', 'Occupied', 3000),
('C102', 3, 2, 'Double', 'Vacant', 4000),
('D101', 4, 2, 'Double', 'Vacant', 4000),
('D102', 4, 1, 'Single', 'Vacant', 5000),
('E101', 5, 1, 'Single', 'Occupied', 5000),
('E102', 5, 2, 'Double', 'Vacant', 4000);

-- Insert sample Student data
INSERT INTO Student (FirstName, LastName, Gender, ContactNumber, EmailID, Course, Year, RoomID, EmergencyContact, JoiningDate) VALUES
('Rahul', 'Gupta', 'Male', '9876543215', 'rahul@student.com', 'B.Tech', 2, 1, '9876543220', '2024-01-01'),
('Arjun', 'Patel', 'Male', '9876543225', 'arjun@student.com', 'B.Tech', 1, 1, '9876543230', '2024-01-02'),
('Sneha', 'Singh', 'Female', '9876543216', 'sneha@student.com', 'M.Tech', 1, 4, '9876543221', '2024-01-03'),
('Vikram', 'Kumar', 'Male', '9876543217', 'vikram@student.com', 'BCA', 3, 7, '9876543222', '2024-01-04'),
('Neha', 'Sharma', 'Female', '9876543218', 'neha@student.com', 'MCA', 2, NULL, '9876543223', '2024-01-05'),
('Arun', 'Verma', 'Male', '9876543219', 'arun@student.com', 'B.Tech', 1, 11, '9876543224', '2024-01-06'),
('Priyanka', 'Joshi', 'Female', '9876543226', 'priyanka@student.com', 'MBA', 1, NULL, '9876543231', '2024-01-07'),
('Rohit', 'Agarwal', 'Male', '9876543227', 'rohit@student.com', 'B.Tech', 3, NULL, '9876543232', '2024-01-08');

-- Insert sample Community_Events data with future dates
INSERT INTO Community_Events (EventName, OrganizerId, EventType, Capacity, SkillLevel, ResourcesNeeded, BlockID, RegistrationDeadline, EventDateTime, AttendanceCount) VALUES
('Cultural Night 2025', 1, 'Cultural', 100, 'Beginner', 'Sound system, Lights, Stage', 1, '2025-08-01 18:00:00', '2025-08-15 18:00:00', 0),
('Tech Workshop: AI & ML', 2, 'Academic', 50, 'Intermediate', 'Projector, Laptops', 2, '2025-08-05 18:00:00', '2025-08-20 10:00:00', 0),
('Inter-Block Sports Tournament', 3, 'Sports', 80, 'Beginner', 'Sports equipment, First aid kit', NULL, '2025-08-10 18:00:00', '2025-08-25 09:00:00', 0),
('Movie Night: Bollywood Special', 4, 'Social', 120, 'Beginner', 'Projector, Sound system, Snacks', 1, '2025-08-15 18:00:00', '2025-09-01 19:00:00', 0),
('Coding Competition', 5, 'Academic', 40, 'Advanced', 'Computers, Internet', NULL, '2025-08-20 18:00:00', '2025-09-05 14:00:00', 0),
('Fresher Welcome Party', 1, 'Social', 150, 'Beginner', 'Decorations, Music system', NULL, '2025-09-01 18:00:00', '2025-09-15 18:00:00', 0);

-- Temporarily drop the trigger to insert registration data
DROP TRIGGER IF EXISTS check_registration_deadline;

-- Insert sample Event_Registration data
INSERT INTO Event_Registration (EventID, StudentID, AttendanceStatus, FeedbackRating, Comments) VALUES
(1, 1, 'Registered', NULL, NULL),
(1, 2, 'Registered', NULL, NULL),
(1, 3, 'Registered', NULL, NULL),
(2, 4, 'Registered', NULL, NULL),
(2, 5, 'Registered', NULL, NULL),
(3, 6, 'Registered', NULL, NULL),
(3, 7, 'Registered', NULL, NULL),
(3, 8, 'Registered', NULL, NULL),
(4, 1, 'Registered', NULL, NULL),
(4, 3, 'Registered', NULL, NULL),
(5, 2, 'Registered', NULL, NULL),
(5, 4, 'Registered', NULL, NULL);

-- Recreate the trigger
DELIMITER $$
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

-- Insert sample Event_Resources data
INSERT INTO Event_Resources (EventID, ResourceType, ResourceName, Quantity, Status, AssignedStaffID) VALUES
(1, 'Equipment', 'Sound System', 1, 'Available', 1),
(1, 'Equipment', 'Stage Lights', 4, 'Available', 1),
(1, 'Equipment', 'Microphones', 3, 'Available', 1),
(2, 'Technical', 'Projector', 1, 'Available', 2),
(2, 'Technical', 'Laptops', 10, 'Available', 2),
(3, 'Equipment', 'Sports Kit', 5, 'Available', 3),
(3, 'Equipment', 'First Aid Kit', 2, 'Available', 3),
(4, 'Technical', 'Movie Screen', 1, 'Available', 1),
(4, 'Equipment', 'Popcorn Machine', 1, 'Available', 4),
(5, 'Technical', 'Computers', 20, 'Available', 2),
(6, 'Equipment', 'Decoration Items', 50, 'Available', 1);

-- Update attendance counts based on registrations
UPDATE Community_Events SET AttendanceCount = (
    SELECT COUNT(*) FROM Event_Registration 
    WHERE Event_Registration.EventID = Community_Events.EventID
);

-- Restore settings
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;

-- Success message
SELECT 'Sample data imported successfully! You can now login with rajesh@hostel.com / password' as 'Status';
