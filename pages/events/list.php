<?php
session_start();
require_once '../../config/database.php';

// Fetch all events with organizer and block information
$stmt = $pdo->query("
    SELECT 
        e.*,
        CONCAT(s.FirstName, ' ', s.LastName) as OrganizerName,
        b.BlockName,
        (SELECT COUNT(*) FROM Event_Registration er WHERE er.EventID = e.EventID) as RegisteredCount
    FROM Community_Events e
    LEFT JOIN Student s ON e.OrganizerId = s.StudentID
    LEFT JOIN Block b ON e.BlockID = b.BlockID
    ORDER BY e.EventDateTime DESC
");
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Events - Hostel Management System</title>
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
            background: linear-gradient(135deg, #8b5cf6, #06b6d4);
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

        .event-card {
            transition: var(--transition);
            cursor: pointer;
        }

        .event-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-hover);
        }

        .event-type-cultural {
            border-left: 4px solid #8b5cf6;
        }

        .event-type-academic {
            border-left: 4px solid #3b82f6;
        }

        .event-type-sports {
            border-left: 4px solid #10b981;
        }

        .event-type-social {
            border-left: 4px solid #f59e0b;
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
                        <i class="fas fa-calendar-alt me-3"></i>
                        Event Management
                    </h2>
                    <p class="page-subtitle mb-0">Organize and manage community events</p>
                </div>
                <div class="action-buttons d-flex gap-2">
                    <a href="create.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Create New Event
                    </a>
                    <button class="btn btn-success" onclick="exportData()">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="eventsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Type</th>
                            <th>Date & Time</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <?php
                            $status = 'Open';
                            if (new DateTime($event['EventDateTime']) < new DateTime()) {
                                $status = 'Completed';
                            } elseif (new DateTime($event['RegistrationDeadline']) < new DateTime()) {
                                $status = 'Registration Closed';
                            } elseif ($event['RegisteredCount'] >= $event['Capacity']) {
                                $status = 'Full';
                            }

                            $statusClass = [
                                'Open' => 'success',
                                'Completed' => 'secondary',
                                'Registration Closed' => 'warning',
                                'Full' => 'danger'
                            ][$status];
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['EventName']); ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo $event['EventType']; ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y h:i A', strtotime($event['EventDateTime'])); ?></td>
                                <td><?php echo $event['BlockName'] ?? 'TBD'; ?></td>
                                <td><?php echo $event['Capacity']; ?></td>
                                <td><?php echo $event['RegisteredCount']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $statusClass; ?>">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view.php?id=<?php echo $event['EventID']; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit.php?id=<?php echo $event['EventID']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger" onclick="deleteEvent(<?php echo $event['EventID']; ?>)">
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
            $('#eventsTable').DataTable({
                order: [
                    [2, 'desc']
                ]
            });
        });

        function deleteEvent(id) {
            if (confirm('Are you sure you want to delete this event? This will also remove all registrations and resources.')) {
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
                            alert('Error deleting event: ' + data.message);
                        }
                    });
            }
        }
    </script>
</body>

</html>