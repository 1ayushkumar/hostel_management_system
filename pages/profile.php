<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$success = $error = '';

// Fetch staff details
$stmt = $pdo->prepare("
    SELECT s.*, b.BlockName 
    FROM Staff s 
    LEFT JOIN Block b ON s.BlockAssigned = b.BlockID 
    WHERE s.StaffID = ?
");
$stmt->execute([$_SESSION['user_id']]);
$staff = $stmt->fetch();

if (!$staff) {
    session_destroy();
    header('Location: ../auth/login.php');
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $pdo->prepare("
            UPDATE Staff 
            SET FirstName = ?, LastName = ?, ContactNumber = ?, 
                EmailID = ?, ShiftTiming = ?
            WHERE StaffID = ?
        ");
        
        $result = $stmt->execute([
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['contactNumber'],
            $_POST['email'],
            $_POST['shiftTiming'],
            $_SESSION['user_id']
        ]);

        if ($result) {
            $success = 'Profile updated successfully!';
            // Update session name
            $_SESSION['user_name'] = $_POST['firstName'] . ' ' . $_POST['lastName'];
            
            // Refresh staff data
            $stmt = $pdo->prepare("
                SELECT s.*, b.BlockName 
                FROM Staff s 
                LEFT JOIN Block b ON s.BlockAssigned = b.BlockID 
                WHERE s.StaffID = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $staff = $stmt->fetch();
        }
    } catch (PDOException $e) {
        $error = 'Error updating profile: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-circle"></i> My Profile
                        </h3>
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
                                           value="<?php echo htmlspecialchars($staff['FirstName']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" 
                                           value="<?php echo htmlspecialchars($staff['LastName']); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" class="form-control" id="role" 
                                           value="<?php echo htmlspecialchars($staff['Role']); ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="blockAssigned" class="form-label">Block Assigned</label>
                                    <input type="text" class="form-control" id="blockAssigned" 
                                           value="<?php echo htmlspecialchars($staff['BlockName'] ?? 'Not Assigned'); ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($staff['EmailID']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" 
                                       value="<?php echo htmlspecialchars($staff['ContactNumber']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="shiftTiming" class="form-label">Shift Timing</label>
                                <select class="form-select" id="shiftTiming" name="shiftTiming" required>
                                    <option value="Morning (6 AM - 2 PM)" <?php echo $staff['ShiftTiming'] === 'Morning (6 AM - 2 PM)' ? 'selected' : ''; ?>>Morning (6 AM - 2 PM)</option>
                                    <option value="Afternoon (2 PM - 10 PM)" <?php echo $staff['ShiftTiming'] === 'Afternoon (2 PM - 10 PM)' ? 'selected' : ''; ?>>Afternoon (2 PM - 10 PM)</option>
                                    <option value="Night (10 PM - 6 AM)" <?php echo $staff['ShiftTiming'] === 'Night (10 PM - 6 AM)' ? 'selected' : ''; ?>>Night (10 PM - 6 AM)</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                                <a href="../index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-key"></i> Change Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">For security reasons, password changes require administrator assistance.</p>
                        <p>Please contact your system administrator to change your password.</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Security Note:</strong> Passwords are encrypted and cannot be viewed by administrators.
                        </div>
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
