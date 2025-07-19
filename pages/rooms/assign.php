<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

// Fetch students without rooms
$stmt = $pdo->query("
    SELECT StudentID, FirstName, LastName, Gender, Course, Year 
    FROM Student 
    WHERE RoomID IS NULL 
    ORDER BY FirstName, LastName
");
$unassigned_students = $stmt->fetchAll();

// Fetch available rooms
$stmt = $pdo->query("
    SELECT r.*, b.BlockName, b.Gender as BlockGender,
           (r.Capacity - COALESCE(student_count.count, 0)) as AvailableSpots
    FROM Room r 
    JOIN Block b ON r.BlockID = b.BlockID 
    LEFT JOIN (
        SELECT RoomID, COUNT(*) as count 
        FROM Student 
        WHERE RoomID IS NOT NULL 
        GROUP BY RoomID
    ) student_count ON r.RoomID = student_count.RoomID
    WHERE (r.Capacity - COALESCE(student_count.count, 0)) > 0
    ORDER BY b.BlockName, r.RoomNumber
");
$available_rooms = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();

        $studentId = $_POST['studentId'];
        $roomId = $_POST['roomId'];

        // Verify student and room compatibility
        $stmt = $pdo->prepare("
            SELECT s.Gender, r.Capacity, b.Gender as BlockGender,
                   COALESCE(student_count.count, 0) as CurrentOccupancy
            FROM Student s
            CROSS JOIN Room r
            JOIN Block b ON r.BlockID = b.BlockID
            LEFT JOIN (
                SELECT RoomID, COUNT(*) as count 
                FROM Student 
                WHERE RoomID IS NOT NULL 
                GROUP BY RoomID
            ) student_count ON r.RoomID = student_count.RoomID
            WHERE s.StudentID = ? AND r.RoomID = ?
        ");
        $stmt->execute([$studentId, $roomId]);
        $compatibility = $stmt->fetch();

        if (!$compatibility) {
            throw new Exception("Invalid student or room selection");
        }

        if ($compatibility['Gender'] !== $compatibility['BlockGender']) {
            throw new Exception("Student gender does not match block gender requirements");
        }

        if ($compatibility['CurrentOccupancy'] >= $compatibility['Capacity']) {
            throw new Exception("Room is already at full capacity");
        }

        // Assign room to student
        $stmt = $pdo->prepare("UPDATE Student SET RoomID = ? WHERE StudentID = ?");
        $stmt->execute([$roomId, $studentId]);

        // Update room status if it becomes occupied
        $stmt = $pdo->prepare("
            UPDATE Room 
            SET Status = CASE 
                WHEN (SELECT COUNT(*) FROM Student WHERE RoomID = ?) >= Capacity 
                THEN 'Occupied' 
                ELSE 'Occupied' 
            END 
            WHERE RoomID = ?
        ");
        $stmt->execute([$roomId, $roomId]);

        $pdo->commit();
        $success = 'Room assigned successfully!';
        
        // Refresh data
        $stmt = $pdo->query("
            SELECT StudentID, FirstName, LastName, Gender, Course, Year 
            FROM Student 
            WHERE RoomID IS NULL 
            ORDER BY FirstName, LastName
        ");
        $unassigned_students = $stmt->fetchAll();

        $stmt = $pdo->query("
            SELECT r.*, b.BlockName, b.Gender as BlockGender,
                   (r.Capacity - COALESCE(student_count.count, 0)) as AvailableSpots
            FROM Room r 
            JOIN Block b ON r.BlockID = b.BlockID 
            LEFT JOIN (
                SELECT RoomID, COUNT(*) as count 
                FROM Student 
                WHERE RoomID IS NOT NULL 
                GROUP BY RoomID
            ) student_count ON r.RoomID = student_count.RoomID
            WHERE (r.Capacity - COALESCE(student_count.count, 0)) > 0
            ORDER BY b.BlockName, r.RoomNumber
        ");
        $available_rooms = $stmt->fetchAll();

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = 'Error assigning room: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Room - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bed"></i> Assign Room to Student
                        </h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <?php if (empty($unassigned_students)): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                All students have been assigned rooms.
                            </div>
                        <?php elseif (empty($available_rooms)): ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                No rooms available for assignment.
                            </div>
                        <?php else: ?>
                            <form method="POST" action="" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="studentId" class="form-label">Select Student</label>
                                    <select class="form-select" id="studentId" name="studentId" required onchange="filterRooms()">
                                        <option value="">Choose a student...</option>
                                        <?php foreach ($unassigned_students as $student): ?>
                                            <option value="<?php echo $student['StudentID']; ?>" 
                                                    data-gender="<?php echo $student['Gender']; ?>">
                                                <?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?>
                                                (<?php echo $student['Gender']; ?> - <?php echo $student['Course']; ?> Year <?php echo $student['Year']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="roomId" class="form-label">Select Room</label>
                                    <select class="form-select" id="roomId" name="roomId" required>
                                        <option value="">Choose a room...</option>
                                        <?php foreach ($available_rooms as $room): ?>
                                            <option value="<?php echo $room['RoomID']; ?>" 
                                                    data-gender="<?php echo $room['BlockGender']; ?>"
                                                    data-block="<?php echo $room['BlockName']; ?>"
                                                    data-spots="<?php echo $room['AvailableSpots']; ?>">
                                                Room <?php echo $room['RoomNumber']; ?> - <?php echo $room['BlockName']; ?> Block
                                                (<?php echo $room['BlockGender']; ?>, <?php echo $room['AvailableSpots']; ?> spot<?php echo $room['AvailableSpots'] > 1 ? 's' : ''; ?> available)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check"></i> Assign Room
                                    </button>
                                    <a href="list.php" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Rooms
                                    </a>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle"></i> Assignment Rules
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> Students can only be assigned to blocks matching their gender</li>
                            <li><i class="fas fa-check text-success"></i> Rooms must have available capacity</li>
                            <li><i class="fas fa-check text-success"></i> Only unassigned students are shown</li>
                        </ul>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-bar"></i> Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Unassigned Students:</strong> <?php echo count($unassigned_students); ?></p>
                        <p><strong>Available Rooms:</strong> <?php echo count($available_rooms); ?></p>
                        <p><strong>Total Available Spots:</strong> 
                            <?php echo array_sum(array_column($available_rooms, 'AvailableSpots')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterRooms() {
            const studentSelect = document.getElementById('studentId');
            const roomSelect = document.getElementById('roomId');
            const selectedOption = studentSelect.options[studentSelect.selectedIndex];
            
            if (selectedOption.value) {
                const studentGender = selectedOption.getAttribute('data-gender');
                
                // Show/hide room options based on gender compatibility
                for (let i = 0; i < roomSelect.options.length; i++) {
                    const option = roomSelect.options[i];
                    if (option.value) {
                        const roomGender = option.getAttribute('data-gender');
                        option.style.display = (roomGender === studentGender) ? 'block' : 'none';
                    }
                }
                
                // Reset room selection
                roomSelect.value = '';
            } else {
                // Show all rooms if no student selected
                for (let i = 0; i < roomSelect.options.length; i++) {
                    roomSelect.options[i].style.display = 'block';
                }
            }
        }

        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
