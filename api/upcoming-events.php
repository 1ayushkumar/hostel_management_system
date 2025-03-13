<?php
require_once '../config/database.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            e.EventID,
            e.EventName,
            e.EventType,
            e.Capacity,
            e.AttendanceCount,
            e.EventDateTime,
            e.RegistrationDeadline,
            CONCAT(s.FirstName, ' ', s.LastName) as OrganizerName,
            b.BlockName
        FROM Community_Events e
        JOIN Student s ON e.OrganizerId = s.StudentID
        LEFT JOIN Block b ON e.BlockID = b.BlockID
        WHERE e.EventDateTime > NOW()
        ORDER BY e.EventDateTime
        LIMIT 5
    ");
    
    $events = $stmt->fetchAll();
    echo json_encode($events);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
