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
    $action = $input['action'] ?? 'update';
    
    if ($action === 'update') {
        $total_time = (int)($input['totalTime'] ?? 0);
        $sessions_completed = (int)($input['sessionsCompleted'] ?? 0);
        
        $stmt = $pdo->prepare("INSERT INTO pomodoro_stats (user_id, total_time, sessions_completed, last_updated) 
                              VALUES (?, ?, ?, NOW()) 
                              ON DUPLICATE KEY UPDATE 
                              total_time = VALUES(total_time),
                              sessions_completed = VALUES(sessions_completed),
                              last_updated = NOW()");
        
        $stmt->execute([$user_id, $total_time, $sessions_completed]);
        echo json_encode(['status' => 'success']);
    }
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM pomodoro_stats WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $stats = $stmt->fetch();
    
    if (!$stats) {
        $stats = ['total_time' => 0, 'sessions_completed' => 0];
    }
    
    echo json_encode($stats);
}
?>