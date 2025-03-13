<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

// Fetch blocks for room assignment
$stmt = $pdo->query("SELECT BlockID, BlockName, Gender FROM Block ORDER BY BlockName");
$blocks = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Check if room number already exists in the selected block
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM Room 
            WHERE RoomNumber = ? AND BlockID = ?
        ");
        $stmt->execute([$_POST['roomNumber'], $_POST['blockId']]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('Room number already exists in this block');
        }

        // Insert new room
        $stmt = $pdo->prepare("
            INSERT INTO Room (
                RoomNumber, BlockID, Capacity,
                RoomType, Status, MonthlyRent
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $_POST['roomNumber'],
            $_POST['blockId'],
            $_POST['capacity'],
            $_POST['roomType'],
            'Vacant', // Default status for new room
            $_POST['monthlyRent']
        ]);

        if ($result) {
            $success = 'Room added successfully!';
            header('Location: list.php');
            exit();
        }
    } catch (Exception $e) {
        $error = 'Error adding room: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Room - Hostel Management System</title>
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
                        <h3 class="card-title">Add New Room</h3>
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
                                    <label for="blockId" class="form-label">Block</label>
                                    <select class="form-select" id="blockId" name="blockId" required>
                                        <option value="">Select Block</option>
                                        <?php foreach ($blocks as $block): ?>
                                            <option value="<?php echo $block['BlockID']; ?>" 
                                                    data-gender="<?php echo $block['Gender']; ?>">
                                                <?php echo htmlspecialchars($block['BlockName']); ?> 
                                                (<?php echo $block['Gender']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="roomNumber" class="form-label">Room Number</label>
                                    <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
                                    <div class="form-text">Example: 101, A101, etc.</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="roomType" class="form-label">Room Type</label>
                                    <select class="form-select" id="roomType" name="roomType" required>
                                        <option value="">Select Type</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Triple">Triple</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" 
                                           min="1" max="3" required readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="monthlyRent" class="form-label">Monthly Rent (₹)</label>
                                <input type="number" class="form-control" id="monthlyRent" name="monthlyRent" 
                                       min="1000" step="100" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Add Room</button>
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

        // Set capacity based on room type
        document.getElementById('roomType').addEventListener('change', function() {
            const capacity = document.getElementById('capacity')
            switch(this.value) {
                case 'Single':
                    capacity.value = 1
                    break
                case 'Double':
                    capacity.value = 2
                    break
                case 'Triple':
                    capacity.value = 3
                    break
                default:
                    capacity.value = ''
            }
        })

        // Validate room number format
        document.getElementById('roomNumber').addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z0-9]/g, '')
        })

        // Set default monthly rent based on room type
        document.getElementById('roomType').addEventListener('change', function() {
            const monthlyRent = document.getElementById('monthlyRent')
            switch(this.value) {
                case 'Single':
                    monthlyRent.value = 5000
                    break
                case 'Double':
                    monthlyRent.value = 4000
                    break
                case 'Triple':
                    monthlyRent.value = 3000
                    break
                default:
                    monthlyRent.value = ''
            }
        })
    </script>
</body>
</html>
