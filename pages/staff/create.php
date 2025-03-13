<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

// Fetch blocks for assignment
$stmt = $pdo->query("SELECT BlockID, BlockName FROM Block");
$blocks = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Hash the password
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO Staff (
                FirstName, LastName, Role, ContactNumber,
                EmailID, BlockAssigned, ShiftTiming, Password
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['role'],
            $_POST['contactNumber'],
            $_POST['email'],
            $_POST['blockAssigned'] ?: null,
            $_POST['shiftTiming'],
            $hashedPassword
        ]);

        if ($result) {
            $success = 'Staff member added successfully!';
            header('Location: list.php');
            exit();
        }
    } catch (PDOException $e) {
        $error = 'Error adding staff member: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff - Hostel Management System</title>
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
                        <h3 class="card-title">Add New Staff Member</h3>
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
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="Warden">Warden</option>
                                        <option value="Security">Security</option>
                                        <option value="Cleaner">Cleaner</option>
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
                                    <label for="blockAssigned" class="form-label">Block Assignment</label>
                                    <select class="form-select" id="blockAssigned" name="blockAssigned">
                                        <option value="">Select Block</option>
                                        <?php foreach ($blocks as $block): ?>
                                            <option value="<?php echo $block['BlockID']; ?>">
                                                <?php echo htmlspecialchars($block['BlockName']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="shiftTiming" class="form-label">Shift Timing</label>
                                    <select class="form-select" id="shiftTiming" name="shiftTiming" required>
                                        <option value="">Select Shift</option>
                                        <option value="Morning (6 AM - 2 PM)">Morning (6 AM - 2 PM)</option>
                                        <option value="Afternoon (2 PM - 10 PM)">Afternoon (2 PM - 10 PM)</option>
                                        <option value="Night (10 PM - 6 AM)">Night (10 PM - 6 AM)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Staff Member</button>
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

                        // Check if passwords match
                        const password = document.getElementById('password')
                        const confirmPassword = document.getElementById('confirmPassword')
                        if (password.value !== confirmPassword.value) {
                            event.preventDefault()
                            alert('Passwords do not match!')
                            return
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        // Role-based block assignment
        document.getElementById('role').addEventListener('change', function() {
            const blockAssigned = document.getElementById('blockAssigned')
            if (this.value === 'Warden') {
                blockAssigned.required = true
                blockAssigned.parentElement.style.display = 'block'
            } else {
                blockAssigned.required = false
                blockAssigned.parentElement.style.display = this.value === 'Security' ? 'block' : 'none'
            }
        })
    </script>
</body>
</html>
