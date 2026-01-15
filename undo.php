<?php
require_once '../config/db.php';
require_once '../includes/security.php';
header('Content-Type: application/json');

session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'POST') {
    $action_type = $input['actionType'];
    $data = json_encode($input['data']);
    
    $stmt = $pdo->prepare("INSERT INTO undo_history (user_id, action_type, data, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $action_type, $data]);
    echo json_encode(['status' => 'success']);
} elseif ($method === 'GET') {
    $limit = (int)($_GET['limit'] ?? 10);
    $stmt = $pdo->prepare("SELECT action_type, data, timestamp FROM undo_history WHERE user_id = ? ORDER BY timestamp DESC LIMIT ?");
    $stmt->execute([$user_id, $limit]);
    $history = $stmt->fetchAll();
    
    echo json_encode($history);
}
?>