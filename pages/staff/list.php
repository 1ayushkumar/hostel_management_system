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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Staff Management - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <style>
        /* Page-specific modern enhancements */
        .page-header {
            background: var(--glass-bg-strong);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border-strong);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        .page-title {
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .role-warden {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }

        .role-security {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .role-cleaner {
            background: linear-gradient(135deg, #10b981, #059669);
        }
    </style>
</head>

<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="page-title mb-2">
                        <i class="fas fa-user-tie me-3"></i>
                        Staff Management
                    </h2>
                    <p class="page-subtitle mb-0">Manage staff members and their assignments</p>
                </div>
                <div class="action-buttons d-flex gap-2">
                    <a href="create.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add New Staff
                    </a>
                    <button class="btn btn-success" onclick="exportData()">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                </div>
            </div>
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
                order: [
                    [0, 'desc']
                ]
            });
        });

        function deleteStaff(id) {
            if (confirm('Are you sure you want to delete this staff member?')) {
                fetch('delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: id
                        })
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