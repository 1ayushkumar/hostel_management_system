-- Hostel Management System Database Schema for PostgreSQL (Render)
-- This is a PostgreSQL version of the MySQL schema

-- Create database (this will be done automatically by Render)
-- CREATE DATABASE hostel_management;

-- Block table
CREATE TABLE IF NOT EXISTS Block (
    BlockID SERIAL PRIMARY KEY,
    BlockName VARCHAR(10) NOT NULL UNIQUE,
    NumberOfFloors INTEGER NOT NULL,
    WardenID INTEGER,
    TotalRooms INTEGER NOT NULL,
    Gender VARCHAR(10) NOT NULL CHECK (Gender IN ('Male', 'Female')),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Staff table
CREATE TABLE IF NOT EXISTS Staff (
    StaffID SERIAL PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Role VARCHAR(20) NOT NULL CHECK (Role IN ('Warden', 'Security', 'Cleaner')),
    ContactNumber VARCHAR(15) NOT NULL,
    EmailID VARCHAR(100) NOT NULL UNIQUE,
    ShiftTiming VARCHAR(50),
    Password VARCHAR(255) NOT NULL,
    BlockAssigned INTEGER,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BlockAssigned) REFERENCES Block(BlockID) ON DELETE SET NULL
);

-- Room table
CREATE TABLE IF NOT EXISTS Room (
    RoomID SERIAL PRIMARY KEY,
    RoomNumber VARCHAR(10) NOT NULL,
    BlockID INTEGER NOT NULL,
    Capacity INTEGER NOT NULL,
    CurrentOccupants INTEGER DEFAULT 0,
    RoomType VARCHAR(20) NOT NULL CHECK (RoomType IN ('Single', 'Double', 'Triple')),
    Status VARCHAR(20) DEFAULT 'Vacant' CHECK (Status IN ('Occupied', 'Vacant')),
    MonthlyRent DECIMAL(10,2) NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BlockID) REFERENCES Block(BlockID) ON DELETE CASCADE,
    UNIQUE(RoomNumber, BlockID)
);

-- Student table
CREATE TABLE IF NOT EXISTS Student (
    StudentID SERIAL PRIMARY KEY,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Gender VARCHAR(10) NOT NULL CHECK (Gender IN ('Male', 'Female')),
    ContactNumber VARCHAR(15) NOT NULL,
    EmailID VARCHAR(100) NOT NULL UNIQUE,
    Course VARCHAR(100) NOT NULL,
    Year INTEGER NOT NULL,
    RoomID INTEGER,
    EmergencyContact VARCHAR(15) NOT NULL,
    JoiningDate DATE NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RoomID) REFERENCES Room(RoomID) ON DELETE SET NULL
);

-- Community_Events table
CREATE TABLE IF NOT EXISTS Community_Events (
    EventID SERIAL PRIMARY KEY,
    EventName VARCHAR(200) NOT NULL,
    OrganizerId INTEGER,
    EventType VARCHAR(50) NOT NULL CHECK (EventType IN ('Cultural', 'Academic', 'Sports', 'Social')),
    Capacity INTEGER NOT NULL,
    SkillLevel VARCHAR(20) CHECK (SkillLevel IN ('Beginner', 'Intermediate', 'Advanced')),
    ResourcesNeeded TEXT,
    BlockID INTEGER,
    RegistrationDeadline TIMESTAMP NOT NULL,
    AttendanceCount INTEGER DEFAULT 0,
    EventDateTime TIMESTAMP NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (OrganizerId) REFERENCES Student(StudentID) ON DELETE SET NULL,
    FOREIGN KEY (BlockID) REFERENCES Block(BlockID) ON DELETE SET NULL
);

-- Event_Registration table
CREATE TABLE IF NOT EXISTS Event_Registration (
    RegistrationID SERIAL PRIMARY KEY,
    EventID INTEGER NOT NULL,
    StudentID INTEGER NOT NULL,
    RegistrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AttendanceStatus VARCHAR(20) DEFAULT 'Registered' CHECK (AttendanceStatus IN ('Registered', 'Attended', 'Cancelled')),
    FeedbackRating INTEGER CHECK (FeedbackRating BETWEEN 1 AND 5),
    Comments TEXT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (EventID) REFERENCES Community_Events(EventID) ON DELETE CASCADE,
    FOREIGN KEY (StudentID) REFERENCES Student(StudentID) ON DELETE CASCADE,
    UNIQUE(EventID, StudentID)
);

-- Event_Resources table
CREATE TABLE IF NOT EXISTS Event_Resources (
    ResourceID SERIAL PRIMARY KEY,
    EventID INTEGER NOT NULL,
    ResourceType VARCHAR(50) NOT NULL CHECK (ResourceType IN ('Equipment', 'Room', 'Technical')),
    ResourceName VARCHAR(100) NOT NULL,
    Quantity INTEGER NOT NULL,
    Status VARCHAR(20) DEFAULT 'Available' CHECK (Status IN ('Available', 'In-Use', 'Damaged')),
    AssignedStaffID INTEGER,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (EventID) REFERENCES Community_Events(EventID) ON DELETE CASCADE,
    FOREIGN KEY (AssignedStaffID) REFERENCES Staff(StaffID) ON DELETE SET NULL
);

-- Add foreign key constraint for Block.WardenID after Staff table is created
ALTER TABLE Block ADD CONSTRAINT fk_block_warden 
    FOREIGN KEY (WardenID) REFERENCES Staff(StaffID) ON DELETE SET NULL;

-- Create indexes for better performance
CREATE INDEX idx_student_room ON Student(RoomID);
CREATE INDEX idx_student_email ON Student(EmailID);
CREATE INDEX idx_staff_email ON Staff(EmailID);
CREATE INDEX idx_event_datetime ON Community_Events(EventDateTime);
CREATE INDEX idx_event_registration_event ON Event_Registration(EventID);
CREATE INDEX idx_event_registration_student ON Event_Registration(StudentID);

-- Create views
CREATE OR REPLACE VIEW UpcomingEvents AS
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
LEFT JOIN Student s ON ce.OrganizerId = s.StudentID
LEFT JOIN Block b ON ce.BlockID = b.BlockID
WHERE ce.EventDateTime > CURRENT_TIMESTAMP
ORDER BY ce.EventDateTime ASC;

-- Insert sample data
INSERT INTO Block (BlockName, NumberOfFloors, TotalRooms, Gender) VALUES
('A', 3, 30, 'Male'),
('B', 3, 30, 'Female'),
('C', 4, 40, 'Male');

INSERT INTO Staff (FirstName, LastName, Role, ContactNumber, EmailID, ShiftTiming, Password, BlockAssigned) VALUES
('Rajesh', 'Kumar', 'Warden', '9876543210', 'rajesh@hostel.com', 'Morning', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
('Priya', 'Sharma', 'Warden', '9876543211', 'priya@hostel.com', 'Evening', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),
('Amit', 'Singh', 'Security', '9876543212', 'amit@hostel.com', 'Night', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL);

-- Update Block table with WardenID
UPDATE Block SET WardenID = 1 WHERE BlockID = 1;
UPDATE Block SET WardenID = 2 WHERE BlockID = 2;

-- Insert sample rooms
INSERT INTO Room (RoomNumber, BlockID, Capacity, RoomType, MonthlyRent) VALUES
('101', 1, 2, 'Double', 5000.00),
('102', 1, 2, 'Double', 5000.00),
('103', 1, 3, 'Triple', 4000.00),
('201', 2, 1, 'Single', 8000.00),
('202', 2, 2, 'Double', 5000.00);

-- Insert sample students
INSERT INTO Student (FirstName, LastName, Gender, ContactNumber, EmailID, Course, Year, RoomID, EmergencyContact, JoiningDate) VALUES
('John', 'Doe', 'Male', '9876543213', 'john@student.com', 'Computer Science', 2, 1, '9876543214', '2024-08-01'),
('Jane', 'Smith', 'Female', '9876543215', 'jane@student.com', 'Electronics', 3, 4, '9876543216', '2024-08-01'),
('Mike', 'Johnson', 'Male', '9876543217', 'mike@student.com', 'Mechanical', 1, 1, '9876543218', '2024-08-15');

-- Insert sample events
INSERT INTO Community_Events (EventName, OrganizerId, EventType, Capacity, SkillLevel, ResourcesNeeded, BlockID, RegistrationDeadline, EventDateTime) VALUES
('Cultural Night 2024', 1, 'Cultural', 100, 'Beginner', 'Sound System, Stage', 1, '2025-02-01 18:00:00', '2025-02-15 18:00:00'),
('Tech Workshop', 2, 'Academic', 50, 'Intermediate', 'Projector, Laptops', 2, '2025-01-25 17:00:00', '2025-02-10 14:00:00'),
('Football Tournament', 3, 'Sports', 32, 'Advanced', 'Football, Ground', NULL, '2025-01-30 20:00:00', '2025-02-20 16:00:00');

-- Update room occupancy
UPDATE Room SET CurrentOccupants = 2, Status = 'Occupied' WHERE RoomID = 1;
UPDATE Room SET CurrentOccupants = 1, Status = 'Occupied' WHERE RoomID = 4;
