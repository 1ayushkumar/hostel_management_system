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

        // Delete event registrations
        $stmt = $pdo->prepare("DELETE FROM Event_Registration WHERE EventID = ?");
        $stmt->execute([$data->id]);

        // Delete event resources
        $stmt = $pdo->prepare("DELETE FROM Event_Resources WHERE EventID = ?");
        $stmt->execute([$data->id]);

        // Delete the event
        $stmt = $pdo->prepare("DELETE FROM Community_Events WHERE EventID = ?");
        $result = $stmt->execute([$data->id]);

        if ($result) {
            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to delete event");
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
