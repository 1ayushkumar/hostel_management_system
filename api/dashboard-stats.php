<?php
require_once '../config/database.php';
header('Content-Type: application/json');

try {
    // Get total students
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM Student");
    $totalStudents = $stmt->fetch()['count'];

    // Get available rooms
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM Room WHERE Status = 'Vacant'");
    $availableRooms = $stmt->fetch()['count'];

    // Get upcoming events
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM Community_Events WHERE EventDateTime > NOW()");
    $upcomingEvents = $stmt->fetch()['count'];

    // Get active staff
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM Staff");
    $activeStaff = $stmt->fetch()['count'];

    echo json_encode([
        'totalStudents' => $totalStudents,
        'availableRooms' => $availableRooms,
        'upcomingEvents' => $upcomingEvents,
        'activeStaff' => $activeStaff
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
