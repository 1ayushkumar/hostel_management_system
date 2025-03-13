<?php
session_start();
require_once '../../config/database.php';
header('Content-Type: application/json');

// Check if request is POST and has valid JSON
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data->id)) {
    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Delete student's event registrations
        $stmt = $pdo->prepare("DELETE FROM Event_Registration WHERE StudentID = ?");
        $stmt->execute([$data->id]);

        // Get student's room for updating room status
        $stmt = $pdo->prepare("SELECT RoomID FROM Student WHERE StudentID = ?");
        $stmt->execute([$data->id]);
        $roomId = $stmt->fetchColumn();

        // Delete the student
        $stmt = $pdo->prepare("DELETE FROM Student WHERE StudentID = ?");
        $result = $stmt->execute([$data->id]);

        if ($result) {
            // Update room status if this was the last student in the room
            if ($roomId) {
                $stmt = $pdo->prepare("
                    UPDATE Room r 
                    SET r.Status = 'Vacant'
                    WHERE r.RoomID = ? 
                    AND NOT EXISTS (
                        SELECT 1 FROM Student s 
                        WHERE s.RoomID = r.RoomID
                    )
                ");
                $stmt->execute([$roomId]);
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to delete student");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
