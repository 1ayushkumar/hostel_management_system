<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

// Fetch available rooms
$stmt = $pdo->query("
    SELECT r.*, b.BlockName 
    FROM Room r 
    JOIN Block b ON r.BlockID = b.BlockID 
    WHERE r.Status = 'Vacant'
");
$available_rooms = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO Student (
                FirstName, LastName, Gender, ContactNumber, 
                EmailID, Course, Year, RoomID, 
                EmergencyContact, JoiningDate
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['gender'],
            $_POST['contactNumber'],
            $_POST['email'],
            $_POST['course'],
            $_POST['year'],
            $_POST['roomId'] ?: null,
            $_POST['emergencyContact'],
            $_POST['joiningDate']
        ]);

        if ($_POST['roomId']) {
            // Update room status
            $stmt = $pdo->prepare("
                UPDATE Room 
                SET Status = 'Occupied'
                WHERE RoomID = ?
            ");
            $stmt->execute([$_POST['roomId']]);
        }

        $pdo->commit();
        $success = 'Student added successfully!';
        
        // Redirect after successful addition
        header('Location: list.php');
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = 'Error adding student: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add New Student</h3>
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
                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactNumber" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contactNumber" name="contactNumber" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="course" class="form-label">Course</label>
                                    <input type="text" class="form-control" id="course" name="course" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" class="form-control" id="year" name="year" min="1" max="5" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="roomId" class="form-label">Room</label>
                                <select class="form-select" id="roomId" name="roomId">
                                    <option value="">Select Room</option>
                                    <?php foreach ($available_rooms as $room): ?>
                                        <option value="<?php echo $room['RoomID']; ?>">
                                            <?php echo "Room {$room['RoomNumber']} - {$room['BlockName']} Block"; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="emergencyContact" class="form-label">Emergency Contact</label>
                                <input type="tel" class="form-control" id="emergencyContact" name="emergencyContact" required>
                            </div>

                            <div class="mb-3">
                                <label for="joiningDate" class="form-label">Joining Date</label>
                                <input type="date" class="form-control" id="joiningDate" name="joiningDate" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Student</button>
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
    </script>
</body>
</html>
