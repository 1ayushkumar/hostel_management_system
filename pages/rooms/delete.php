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

        // Check if room has any occupants
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Student WHERE RoomID = ?");
        $stmt->execute([$data->id]);
        $hasOccupants = $stmt->fetchColumn() > 0;

        if ($hasOccupants) {
            throw new Exception("Cannot delete room as it currently has occupants");
        }

        // Delete the room
        $stmt = $pdo->prepare("DELETE FROM Room WHERE RoomID = ?");
        $result = $stmt->execute([$data->id]);

        if ($result) {
            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to delete room");
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
