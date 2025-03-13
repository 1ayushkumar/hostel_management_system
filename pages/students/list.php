<?php
session_start();
require_once '../../config/database.php';

// Fetch students with room information
$stmt = $pdo->query("
    SELECT 
        s.*,
        r.RoomNumber,
        b.BlockName
    FROM Student s
    LEFT JOIN Room r ON s.RoomID = r.RoomID
    LEFT JOIN Block b ON r.BlockID = b.BlockID
    ORDER BY s.StudentID DESC
");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Student Management</h2>
            <a href="create.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Student
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="studentsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Room</th>
                            <th>Block</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['StudentID']; ?></td>
                            <td><?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($student['Course']); ?></td>
                            <td><?php echo $student['Year']; ?></td>
                            <td><?php echo $student['RoomNumber'] ?? 'Not Assigned'; ?></td>
                            <td><?php echo $student['BlockName'] ?? 'Not Assigned'; ?></td>
                            <td><?php echo htmlspecialchars($student['ContactNumber']); ?></td>
                            <td>
                                <a href="view.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteStudent(<?php echo $student['StudentID']; ?>)">
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
            $('#studentsTable').DataTable({
                order: [[0, 'desc']]
            });
        });

        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student? This will also remove all event registrations.')) {
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
                        alert('Error deleting student: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
