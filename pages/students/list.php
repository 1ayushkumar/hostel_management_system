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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Students - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/css/jquery.dataTables.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
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

        .action-buttons .btn {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Modern table styling */
        .table {
            background: transparent;
            color: rgba(255, 255, 255, 0.9);
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
        }

        .btn-group .btn {
            margin: 0 2px;
            border-radius: var(--border-radius-sm);
        }

        .badge {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-group .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.9);
        }

        .input-group .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        /* Animated loading states */
        .table tbody tr.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .table tbody tr.loading td {
            position: relative;
        }

        .table tbody tr.loading td::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Hide DataTables default search box to avoid duplicates */
        .dataTables_filter {
            display: none !important;
        }

        /* Enhance our custom search box */
        #quickSearch {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(17, 24, 39, 0.3) !important;
            color: #111827 !important;
            font-weight: 600;
        }

        #quickSearch:focus {
            background: rgba(255, 255, 255, 1) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(17, 24, 39, 0.3) !important;
            color: #111827 !important;
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
                        <i class="fas fa-users me-3"></i>
                        Student Management
                    </h2>
                    <p class="page-subtitle mb-0">Manage student registrations and room assignments</p>
                </div>
                <div class="action-buttons d-flex gap-2">
                    <a href="create.php" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add New Student
                    </a>
                    <button class="btn btn-success" onclick="exportData()">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                </div>
            </div>
        </div>

        <div class="card glass">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-table me-3 text-primary"></i>
                        <h5 class="card-title mb-0">All Students</h5>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search students..." id="quickSearch">
                        </div>
                        <span class="badge bg-primary" id="studentCount"><?php echo count($students); ?> Students</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="studentsTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-user me-2"></i>Name</th>
                                <th><i class="fas fa-graduation-cap me-2"></i>Course</th>
                                <th><i class="fas fa-calendar me-2"></i>Year</th>
                                <th><i class="fas fa-bed me-2"></i>Room</th>
                                <th><i class="fas fa-building me-2"></i>Block</th>
                                <th><i class="fas fa-phone me-2"></i>Contact</th>
                                <th><i class="fas fa-cogs me-2"></i>Actions</th>
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
                                        <div class="btn-group" role="group">
                                            <a href="view.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit.php?id=<?php echo $student['StudentID']; ?>" class="btn btn-sm btn-warning" title="Edit Student">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteStudent(<?php echo $student['StudentID']; ?>)" title="Delete Student">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
                // Initialize DataTable with custom search only
                const table = $('#studentsTable').DataTable({
                    order: [
                        [0, 'desc']
                    ],
                    pageLength: window.innerWidth <= 576 ? 5 : 10,
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    columnDefs: [{
                            targets: [3, 5, 6], // Year, Block, Contact columns
                            visible: window.innerWidth > 768
                        },
                        {
                            targets: [2, 4], // Course, Room columns
                            visible: window.innerWidth > 576
                        }
                    ],
                    language: {
                        lengthMenu: "Show _MENU_ students",
                        info: window.innerWidth <= 576 ? "_TOTAL_ students" : "Showing _START_ to _END_ of _TOTAL_ students",
                        paginate: {
                            previous: window.innerWidth <= 576 ? "‹" : "Previous",
                            next: window.innerWidth <= 576 ? "›" : "Next"
                        }
                    },
                    dom: window.innerWidth <= 576 ? 'rtip' : 'lrtip', // Remove 'f' to hide default search
                    searching: true // Keep search functionality but hide the default search box
                });

                // Single search functionality using our custom search box
                $('#quickSearch').on('keyup', function() {
                    table.search(this.value).draw();
                });
            });

            function deleteStudent(id) {
                if (confirm('⚠️ Are you sure you want to delete this student?\n\nThis action will remove the student permanently and cannot be undone.')) {
                    const deleteBtn = event.target.closest('button');
                    const originalContent = deleteBtn.innerHTML;
                    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    deleteBtn.disabled = true;

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
                                const row = deleteBtn.closest('tr');
                                row.style.background = 'linear-gradient(45deg, #4facfe, #00f2fe)';
                                row.style.color = 'white';

                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                deleteBtn.innerHTML = originalContent;
                                deleteBtn.disabled = false;
                                alert('Error deleting student: ' + data.message);
                            }
                        })
                        .catch(error => {
                            deleteBtn.innerHTML = originalContent;
                            deleteBtn.disabled = false;
                            console.error('Error:', error);
                        });
                }
            }

            function exportData() {
                // Add loading state to export button
                const exportBtn = event.target;
                const originalContent = exportBtn.innerHTML;
                exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
                exportBtn.disabled = true;

                setTimeout(() => {
                    window.print();
                    exportBtn.innerHTML = originalContent;
                    exportBtn.disabled = false;
                }, 1000);
            }

            // Modern page enhancements
            document.addEventListener('DOMContentLoaded', function() {
                // Animate table rows on load
                const rows = document.querySelectorAll('.table tbody tr');
                rows.forEach((row, index) => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(20px)';
                    row.style.transition = 'all 0.3s ease';

                    setTimeout(() => {
                        row.style.opacity = '1';
                        row.style.transform = 'translateY(0)';
                    }, index * 50);
                });

                // Enhanced search with DataTable integration (no duplicate functionality)
                const searchInput = document.getElementById('quickSearch');
                if (searchInput) {
                    // Remove the duplicate event listener since DataTable handles the search
                    // Just update the count badge based on DataTable's filtered results
                    searchInput.addEventListener('input', function() {
                        setTimeout(() => {
                            const visibleRows = table.rows({
                                search: 'applied'
                            }).count();
                            const countBadge = document.getElementById('studentCount');
                            if (countBadge) {
                                countBadge.textContent = `${visibleRows} Students`;
                            }
                        }, 100);
                    });
                }

                // Add hover effects to action buttons
                const actionButtons = document.querySelectorAll('.btn-group .btn');
                actionButtons.forEach(btn => {
                    btn.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.1) translateY(-2px)';
                    });

                    btn.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1) translateY(0)';
                    });
                });

                // Page header animation
                const pageHeader = document.querySelector('.page-header');
                if (pageHeader) {
                    pageHeader.style.opacity = '0';
                    pageHeader.style.transform = 'translateY(-30px)';
                    pageHeader.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

                    setTimeout(() => {
                        pageHeader.style.opacity = '1';
                        pageHeader.style.transform = 'translateY(0)';
                    }, 200);
                }

                // Card entrance animation
                const card = document.querySelector('.card.glass');
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px) scale(0.95)';
                    card.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0) scale(1)';
                    }, 400);
                }
            });
        </script>

        <!-- Floating Action Button -->
        <div class="fab-container">
            <button class="fab" id="fabMain" onclick="toggleFabMenu()">
                <i class="fas fa-plus"></i>
            </button>
            <div class="fab-menu" id="fabMenu">
                <a href="create.php" class="fab-item" title="Add Student">
                    <i class="fas fa-user-plus"></i>
                </a>
                <a href="../../index.php" class="fab-item" title="Dashboard">
                    <i class="fas fa-home"></i>
                </a>
                <button class="fab-item" onclick="exportData()" title="Export Data">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>

        <script>
            function toggleFabMenu() {
                const fabMenu = document.getElementById('fabMenu');
                const fabMain = document.getElementById('fabMain');

                fabMenu.classList.toggle('active');
                fabMain.classList.toggle('active');

                if (fabMenu.classList.contains('active')) {
                    fabMain.innerHTML = '<i class="fas fa-times"></i>';
                } else {
                    fabMain.innerHTML = '<i class="fas fa-plus"></i>';
                }
            }
        </script>
</body>

</html>