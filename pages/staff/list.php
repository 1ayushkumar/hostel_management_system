<?php
session_start();
require_once '../../config/database.php';

// Fetch staff with block information
$stmt = $pdo->query("
    SELECT 
        s.*,
        b.BlockName
    FROM Staff s
    LEFT JOIN Block b ON s.BlockAssigned = b.BlockID
    ORDER BY s.StaffID DESC
");
$staff_members = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Staff Management</h2>
            <a href="create.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Staff
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="staffTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Block Assigned</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Shift</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staff_members as $staff): ?>
                        <tr>
                            <td><?php echo $staff['StaffID']; ?></td>
                            <td><?php echo htmlspecialchars($staff['FirstName'] . ' ' . $staff['LastName']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $staff['Role'] === 'Warden' ? 'primary' : ($staff['Role'] === 'Security' ? 'danger' : 'success'); ?>">
                                    <?php echo $staff['Role']; ?>
                                </span>
                            </td>
                            <td><?php echo $staff['BlockName'] ?? 'Not Assigned'; ?></td>
                            <td><?php echo htmlspecialchars($staff['ContactNumber']); ?></td>
                            <td><?php echo htmlspecialchars($staff['EmailID']); ?></td>
                            <td><?php echo htmlspecialchars($staff['ShiftTiming']); ?></td>
                            <td>
                                <a href="view.php?id=<?php echo $staff['StaffID']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit.php?id=<?php echo $staff['StaffID']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteStaff(<?php echo $staff['StaffID']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#staffTable').DataTable({
                order: [[0, 'desc']]
            });
        });

        function deleteStaff(id) {
            if (confirm('Are you sure you want to delete this staff member?')) {
                fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting staff member: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
