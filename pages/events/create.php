<?php
session_start();
require_once '../../config/database.php';

$success = $error = '';

// Fetch blocks for location selection
$stmt = $pdo->query("SELECT BlockID, BlockName FROM Block");
$blocks = $stmt->fetchAll();

// Fetch students for organizer selection
$stmt = $pdo->query("SELECT StudentID, FirstName, LastName FROM Student");
$students = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();

        // Validate dates
        $eventDateTime = new DateTime($_POST['eventDateTime']);
        $registrationDeadline = new DateTime($_POST['registrationDeadline']);
        
        if ($registrationDeadline >= $eventDateTime) {
            throw new Exception('Registration deadline must be before event date');
        }

        $stmt = $pdo->prepare("
            INSERT INTO Community_Events (
                EventName, OrganizerId, EventType, 
                Capacity, SkillLevel, ResourcesNeeded,
                BlockID, RegistrationDeadline, EventDateTime
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $result = $stmt->execute([
            $_POST['eventName'],
            $_POST['organizerId'],
            $_POST['eventType'],
            $_POST['capacity'],
            $_POST['skillLevel'],
            $_POST['resourcesNeeded'],
            $_POST['blockId'] ?: null,
            $_POST['registrationDeadline'],
            $_POST['eventDateTime']
        ]);

        // Get the new event ID
        $eventId = $pdo->lastInsertId();

        // Insert resources if provided
        if (!empty($_POST['resources'])) {
            $stmt = $pdo->prepare("
                INSERT INTO Event_Resources (
                    EventID, ResourceType, ResourceName,
                    Quantity, Status
                ) VALUES (?, ?, ?, ?, 'Available')
            ");

            foreach ($_POST['resources'] as $resource) {
                $stmt->execute([
                    $eventId,
                    $resource['type'],
                    $resource['name'],
                    $resource['quantity']
                ]);
            }
        }

        $pdo->commit();
        $success = 'Event created successfully!';
        
        // Redirect after successful creation
        header('Location: list.php');
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = 'Error creating event: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - Hostel Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Event</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="eventName" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="eventName" name="eventName" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="organizerId" class="form-label">Organizer</label>
                                    <select class="form-select" id="organizerId" name="organizerId" required>
                                        <option value="">Select Organizer</option>
                                        <?php foreach ($students as $student): ?>
                                            <option value="<?php echo $student['StudentID']; ?>">
                                                <?php echo htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="eventType" class="form-label">Event Type</label>
                                    <select class="form-select" id="eventType" name="eventType" required>
                                        <option value="">Select Type</option>
                                        <option value="Cultural">Cultural</option>
                                        <option value="Academic">Academic</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Social">Social</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="skillLevel" class="form-label">Skill Level</label>
                                    <select class="form-select" id="skillLevel" name="skillLevel" required>
                                        <option value="">Select Level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="blockId" class="form-label">Location</label>
                                <select class="form-select" id="blockId" name="blockId">
                                    <option value="">Select Location</option>
                                    <?php foreach ($blocks as $block): ?>
                                        <option value="<?php echo $block['BlockID']; ?>">
                                            <?php echo htmlspecialchars($block['BlockName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="eventDateTime" class="form-label">Event Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="eventDateTime" name="eventDateTime" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="registrationDeadline" class="form-label">Registration Deadline</label>
                                    <input type="datetime-local" class="form-control" id="registrationDeadline" name="registrationDeadline" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="resourcesNeeded" class="form-label">Resources Needed</label>
                                <textarea class="form-control" id="resourcesNeeded" name="resourcesNeeded" rows="3"></textarea>
                            </div>

                            <div id="resourcesContainer">
                                <h5>Additional Resources</h5>
                                <div id="resourcesList"></div>
                                <button type="button" class="btn btn-secondary mb-3" onclick="addResource()">
                                    Add Resource
                                </button>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Create Event</button>
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

        // Dynamic resource fields
        let resourceCount = 0;
        
        function addResource() {
            const resourcesList = document.getElementById('resourcesList');
            const resourceDiv = document.createElement('div');
            resourceDiv.className = 'resource-item border p-3 mb-3';
            resourceDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="resources[${resourceCount}][type]" required>
                            <option value="Equipment">Equipment</option>
                            <option value="Room">Room</option>
                            <option value="Technical">Technical</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="resources[${resourceCount}][name]" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="resources[${resourceCount}][quantity]" min="1" required>
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            resourcesList.appendChild(resourceDiv);
            resourceCount++;
        }

        // Date validation
        document.getElementById('eventDateTime').addEventListener('change', validateDates);
        document.getElementById('registrationDeadline').addEventListener('change', validateDates);

        function validateDates() {
            const eventDateTime = new Date(document.getElementById('eventDateTime').value);
            const registrationDeadline = new Date(document.getElementById('registrationDeadline').value);
            
            if (registrationDeadline >= eventDateTime) {
                alert('Registration deadline must be before event date');
                document.getElementById('registrationDeadline').value = '';
            }
        }
    </script>
</body>
</html>
