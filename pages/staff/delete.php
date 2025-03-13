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

        // Check if staff member is a warden assigned to any blocks
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Block WHERE WardenID = ?");
        $stmt->execute([$data->id]);
        $hasBlocks = $stmt->fetchColumn() > 0;

        if ($hasBlocks) {
            throw new Exception("Cannot delete staff member as they are assigned as warden to one or more blocks");
        }

        // Delete the staff member
        $stmt = $pdo->prepare("DELETE FROM Staff WHERE StaffID = ?");
        $result = $stmt->execute([$data->id]);

        if ($result) {
            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to delete staff member");
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
