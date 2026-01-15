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
    $action = $input['action'] ?? 'create';
    
    if ($action === 'create') {
        $title = clean($input['title']);
        $date = $input['date'];
        $start_time = $input['startTime'];
        $end_time = $input['endTime'];
        $type = $input['type'] ?? 'study';
        
        $stmt = $pdo->prepare("INSERT INTO schedule (user_id, title, date, start_time, end_time, type, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $title, $date, $start_time, $end_time, $type]);
        echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
    } elseif ($action === 'update') {
        $id = (int)$input['id'];
        $updates = [];
        $params = [];
        
        if (isset($input['title'])) {
            $updates[] = 'title = ?';
            $params[] = clean($input['title']);
        }
        if (isset($input['date'])) {
            $updates[] = 'date = ?';
            $params[] = $input['date'];
        }
        if (isset($input['startTime'])) {
            $updates[] = 'start_time = ?';
            $params[] = $input['startTime'];
        }
        if (isset($input['endTime'])) {
            $updates[] = 'end_time = ?';
            $params[] = $input['endTime'];
        }
        if (isset($input['type'])) {
            $updates[] = 'type = ?';
            $params[] = $input['type'];
        }
        
        if (!empty($updates)) {
            $params[] = $id;
            $params[] = $user_id;
            $stmt = $pdo->prepare("UPDATE schedule SET " . implode(', ', $updates) . " WHERE id = ? AND user_id = ?");
            $stmt->execute($params);
            echo json_encode(['status' => 'success']);
        }
    } elseif ($action === 'delete') {
        $id = (int)$input['id'];
        $stmt = $pdo->prepare("DELETE FROM schedule WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['status' => 'success']);
    }
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT id, title, date, start_time, end_time, type, created_at FROM schedule WHERE user_id = ? ORDER BY date ASC, start_time ASC");
    $stmt->execute([$user_id]);
    $schedule = $stmt->fetchAll();
    
    echo json_encode($schedule);
}
?>