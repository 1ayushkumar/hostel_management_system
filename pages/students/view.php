<?php
session_start();
require_once '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit();
}

// Fetch student details with room and block information
$stmt = $pdo->prepare("
    SELECT 
        s.*,
        r.RoomNumber,
        r.RoomType,
        r.MonthlyRent,
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

// Fetch student's event registrations
$stmt = $pdo->prepare("
    SELECT 
        e.EventName,
        e.EventType,
        e.EventDateTime,
        er.AttendanceStatus,
        er.FeedbackRating,
        er.Comments
    FROM Event_Registration er
    JOIN Community_Events e ON er.EventID = e.EventID
    WHERE er.StudentID = ?
    ORDER BY e.EventDateTime DESC
");
$stmt->execute([$_GET['id']]);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student - Hostel Management System</title>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Student Details</h3>
                        <div>
                            <a href="edit.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="list.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td><?php echo htmlspecialchars($student['Gender']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact</th>
                                        <td><?php echo htmlspecialchars($student['ContactNumber']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo htmlspecialchars($student['EmailID']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Emergency Contact</th>
                                        <td><?php echo htmlspecialchars($student['EmergencyContact']); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Academic Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Course</th>
                                        <td><?php echo htmlspecialchars($student['Course']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Year</th>
                                        <td><?php echo htmlspecialchars($student['Year']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td><?php echo date('d M, Y', strtotime($student['JoiningDate'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>Accommodation Details</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Block</th>
                                    <td>
                                        <?php echo htmlspecialchars($student['BlockName']); ?>
                                        <span class="badge bg-info"><?php echo $student['BlockGender']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Room Number</th>
                                    <td><?php echo htmlspecialchars($student['RoomNumber']); ?></td>
                                </tr>
                                <tr>
                                    <th>Room Type</th>
                                    <td><?php echo htmlspecialchars($student['RoomType']); ?></td>
                                </tr>
                                <tr>
                                    <th>Monthly Rent</th>
                                    <td>₹<?php echo number_format($student['MonthlyRent'], 2); ?></td>
                                </tr>
                            </table>
                        </div>

                        <?php if ($events): ?>
                        <div class="mt-4">
                            <h5>Event Participation</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($events as $event): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($event['EventName']); ?></td>
                                        <td><?php echo htmlspecialchars($event['EventType']); ?></td>
                                        <td><?php echo date('d M, Y h:i A', strtotime($event['EventDateTime'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $event['AttendanceStatus'] === 'Attended' ? 'success' : 
                                                    ($event['AttendanceStatus'] === 'Registered' ? 'info' : 'warning'); 
                                            ?>">
                                                <?php echo $event['AttendanceStatus']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($event['FeedbackRating']): ?>
                                                <?php echo str_repeat('★', $event['FeedbackRating']) . str_repeat('☆', 5 - $event['FeedbackRating']); ?>
                                                <?php if ($event['Comments']): ?>
                                                    <i class="fas fa-comment-dots" title="<?php echo htmlspecialchars($event['Comments']); ?>"></i>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">No feedback</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Additional Information or Quick Actions can be added here -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="edit.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Details
                            </a>
                            <button class="btn btn-danger" onclick="deleteStudent(<?php echo $student['StudentID']; ?>)">
                                <i class="fas fa-trash"></i> Delete Student
                            </button>
                            <a href="list.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
                        window.location.href = 'list.php';
                    } else {
                        alert('Error deleting student: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
