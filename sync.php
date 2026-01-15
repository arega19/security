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
    $sync_data = json_encode($input['syncData']);
    
    $stmt = $pdo->prepare("INSERT INTO sync_state (user_id, last_sync, sync_data) 
                          VALUES (?, NOW(), ?) 
                          ON DUPLICATE KEY UPDATE 
                          last_sync = NOW(),
                          sync_data = VALUES(sync_data)");
    
    $stmt->execute([$user_id, $sync_data]);
    echo json_encode(['status' => 'success']);
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT last_sync, sync_data FROM sync_state WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $sync = $stmt->fetch();
    
    if ($sync) {
        $sync['syncData'] = json_decode($sync['sync_data'], true);
        unset($sync['sync_data']);
    } else {
        $sync = ['lastSync' => null, 'syncData' => null];
    }
    
    echo json_encode($sync);
}
?>