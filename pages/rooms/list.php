<?php
session_start();
require_once '../../config/database.php';

// Fetch rooms with block information and current occupants
$stmt = $pdo->query("
    SELECT 
        r.*,
        b.BlockName,
        b.Gender as BlockGender,
        COUNT(s.StudentID) as CurrentOccupants,
        GROUP_CONCAT(CONCAT(s.FirstName, ' ', s.LastName) SEPARATOR ', ') as OccupantNames
    FROM Room r
    LEFT JOIN Block b ON r.BlockID = b.BlockID
    LEFT JOIN Student s ON r.RoomID = s.RoomID
    GROUP BY r.RoomID
    ORDER BY b.BlockName, r.RoomNumber
");
$rooms = $stmt->fetchAll();

// Calculate statistics
$totalRooms = count($rooms);
$occupiedRooms = 0;
$vacantRooms = 0;
$maintenanceRooms = 0;

foreach ($rooms as $room) {
    if ($room['Status'] === 'Occupied') $occupiedRooms++;
    elseif ($room['Status'] === 'Vacant') $vacantRooms++;
    else $maintenanceRooms++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Room Management</h2>
            <a href="create.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Room
            </a>
        </div>

        <!-- Room Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Rooms</h5>
                        <p class="card-text display-6"><?php echo $totalRooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Vacant Rooms</h5>
                        <p class="card-text display-6"><?php echo $vacantRooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Occupied Rooms</h5>
                        <p class="card-text display-6"><?php echo $occupiedRooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Under Maintenance</h5>
                        <p class="card-text display-6"><?php echo $maintenanceRooms; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="roomsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Block</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Occupants</th>
                            <th>Status</th>
                            <th>Monthly Rent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($room['RoomNumber']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($room['BlockName']); ?>
                                <span class="badge bg-info"><?php echo $room['BlockGender']; ?></span>
                            </td>
                            <td><?php echo $room['RoomType']; ?></td>
                            <td>
                                <?php echo $room['CurrentOccupants']; ?>/<?php echo $room['Capacity']; ?>
                            </td>
                            <td>
                                <?php if ($room['OccupantNames']): ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" 
                                          title="<?php echo htmlspecialchars($room['OccupantNames']); ?>">
                                        <?php echo htmlspecialchars($room['OccupantNames']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">No occupants</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $room['Status'] === 'Vacant' ? 'success' : 
                                        ($room['Status'] === 'Occupied' ? 'danger' : 'warning'); 
                                ?>">
                                    <?php echo $room['Status']; ?>
                                </span>
                            </td>
                            <td>₹<?php echo number_format($room['MonthlyRent'], 2); ?></td>
                            <td>
                                <a href="view.php?id=<?php echo $room['RoomID']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit.php?id=<?php echo $room['RoomID']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($room['CurrentOccupants'] == 0): ?>
                                    <button class="btn btn-sm btn-danger" onclick="deleteRoom(<?php echo $room['RoomID']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
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
            $('#roomsTable').DataTable({
                order: [[1, 'asc'], [0, 'asc']]
            });
        });

        function deleteRoom(id) {
            if (confirm('Are you sure you want to delete this room?')) {
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
                        alert('Error deleting room: ' + data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>
