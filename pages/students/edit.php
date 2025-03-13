<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

// Fetch available rooms
$stmt = $pdo->query("
    SELECT 
        r.RoomID,
        r.RoomNumber,
        r.Capacity,
        r.RoomType,
        b.BlockName,
        b.Gender as BlockGender,
        (SELECT COUNT(*) FROM Student s WHERE s.RoomID = r.RoomID) as CurrentOccupants
    FROM Room r
    JOIN Block b ON r.BlockID = b.BlockID
    WHERE r.Status != 'Maintenance'
    ORDER BY b.BlockName, r.RoomNumber
");
$rooms = $stmt->fetchAll();

// Fetch student details
$stmt = $pdo->prepare("
    SELECT 
        s.*,
        r.RoomNumber,
        b.BlockName,
        b.Gender as BlockGender
    FROM Student s
    LEFT JOIN Room r ON s.RoomID = r.RoomID
    LEFT JOIN Block b ON r.BlockID = b.BlockID
    WHERE s.StudentID = ?
");
$stmt->execute([$_GET['id']]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: list.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // If room is being changed
        if ($_POST['roomId'] != $student['RoomID']) {
            // Check if new room has space
            $stmt = $pdo->prepare("
                SELECT 
                    r.Capacity,
                    (SELECT COUNT(*) FROM Student s WHERE s.RoomID = r.RoomID) as CurrentOccupants,
                    b.Gender as BlockGender
                FROM Room r
                JOIN Block b ON r.BlockID = b.BlockID
                WHERE r.RoomID = ?
            ");
            $stmt->execute([$_POST['roomId']]);
            $newRoom = $stmt->fetch();

            if ($newRoom['CurrentOccupants'] >= $newRoom['Capacity']) {
                throw new Exception('Selected room is already at full capacity');
            }

            if ($newRoom['BlockGender'] != $_POST['gender']) {
                throw new Exception('Selected room is in a ' . $newRoom['BlockGender'] . ' block');
            }

            // Update old room status if it becomes empty
            $stmt = $pdo->prepare("
                UPDATE Room 
                SET Status = CASE 
                    WHEN (SELECT COUNT(*) FROM Student WHERE RoomID = ? AND StudentID != ?) = 0 
                    THEN 'Vacant' 
                    ELSE Status 
                END
                WHERE RoomID = ?
            ");
            $stmt->execute([$student['RoomID'], $student['StudentID'], $student['RoomID']]);

            // Update new room status
            $stmt = $pdo->prepare("UPDATE Room SET Status = 'Occupied' WHERE RoomID = ?");
            $stmt->execute([$_POST['roomId']]);
        }

        // Update student
        $stmt = $pdo->prepare("
            UPDATE Student SET
                FirstName = ?,
                LastName = ?,
                Gender = ?,
                ContactNumber = ?,
                EmailID = ?,
                Course = ?,
                Year = ?,
                RoomID = ?,
                EmergencyContact = ?,
                JoiningDate = ?
            WHERE StudentID = ?
        ");

        $result = $stmt->execute([
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['gender'],
            $_POST['contactNumber'],
            $_POST['email'],
            $_POST['course'],
            $_POST['year'],
            $_POST['roomId'],
            $_POST['emergencyContact'],
            $_POST['joiningDate'],
            $_GET['id']
        ]);

        if ($result) {
            $pdo->commit();
            $success = 'Student updated successfully!';
            header('Location: list.php');
            exit();
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = 'Error updating student: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Student</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" 
                                           value="<?php echo htmlspecialchars($student['FirstName']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" 
                                           value="<?php echo htmlspecialchars($student['LastName']); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?php echo $student['Gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo $student['Gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactNumber" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contactNumber" name="contactNumber" 
                                           value="<?php echo htmlspecialchars($student['ContactNumber']); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($student['EmailID']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="course" class="form-label">Course</label>
                                    <input type="text" class="form-control" id="course" name="course" 
                                           value="<?php echo htmlspecialchars($student['Course']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" class="form-control" id="year" name="year" 
                                           value="<?php echo htmlspecialchars($student['Year']); ?>" min="1" max="5" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="roomId" class="form-label">Room</label>
                                <select class="form-select" id="roomId" name="roomId" required>
                                    <option value="">Select Room</option>
                                    <?php foreach ($rooms as $room): ?>
                                        <?php
                                        $isCurrentRoom = $room['RoomID'] == $student['RoomID'];
                                        $hasSpace = $room['CurrentOccupants'] < $room['Capacity'] || $isCurrentRoom;
                                        $matchesGender = $room['BlockGender'] == $student['Gender'];
                                        ?>
                                        <?php if ($hasSpace && ($matchesGender || $isCurrentRoom)): ?>
                                            <option value="<?php echo $room['RoomID']; ?>" 
                                                    <?php echo $isCurrentRoom ? 'selected' : ''; ?>>
                                                Room <?php echo htmlspecialchars($room['RoomNumber']); ?> - 
                                                <?php echo htmlspecialchars($room['BlockName']); ?> Block
                                                (<?php echo $room['CurrentOccupants']; ?>/<?php echo $room['Capacity']; ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emergencyContact" class="form-label">Emergency Contact</label>
                                    <input type="tel" class="form-control" id="emergencyContact" name="emergencyContact" 
                                           value="<?php echo htmlspecialchars($student['EmergencyContact']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="joiningDate" class="form-label">Joining Date</label>
                                    <input type="date" class="form-control" id="joiningDate" name="joiningDate" 
                                           value="<?php echo date('Y-m-d', strtotime($student['JoiningDate'])); ?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Update Student</button>
                                <a href="list.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Update available rooms based on gender
        document.getElementById('gender').addEventListener('change', function() {
            const roomSelect = document.getElementById('roomId')
            const selectedGender = this.value
            const currentRoomId = '<?php echo $student['RoomID']; ?>'
            
            Array.from(roomSelect.options).forEach(option => {
                if (option.value === '') return // Skip placeholder option
                
                const blockGender = option.getAttribute('data-gender')
                const isCurrentRoom = option.value === currentRoomId
                
                if (!blockGender || blockGender === selectedGender || isCurrentRoom) {
                    option.style.display = ''
                } else {
                    option.style.display = 'none'
                    if (option.selected) roomSelect.value = ''
                }
            })
        })
    </script>
</body>
</html>
