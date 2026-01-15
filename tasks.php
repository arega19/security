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
        $priority = $input['priority'] ?? 'medium';
        $difficulty = $input['difficulty'] ?? 'medium';
        $due_date = $input['due_date'];
        
        $due_date_value = $due_date && validate_date($due_date) ? $due_date : null;
        
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, priority, difficulty, due_date, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $title, $priority, $difficulty, $due_date_value]);
        echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
    } elseif ($action === 'update') {
        $id = (int)$input['id'];
        $updates = [];
        $params = [];
        
        if (isset($input['completed'])) {
            $updates[] = 'completed = ?';
            $params[] = $input['completed'] ? 1 : 0;
            if ($input['completed']) {
                $updates[] = 'completed_at = NOW()';
            }
        }
        if (isset($input['title'])) {
            $updates[] = 'title = ?';
            $params[] = clean($input['title']);
        }
        if (isset($input['priority'])) {
            $updates[] = 'priority = ?';
            $params[] = $input['priority'];
        }
        if (isset($input['difficulty'])) {
            $updates[] = 'difficulty = ?';
            $params[] = $input['difficulty'];
        }
        if (isset($input['due_date'])) {
            $updates[] = 'due_date = ?';
            $params[] = $input['due_date'];
        }
        
        if (!empty($updates)) {
            $params[] = $id;
            $params[] = $user_id;
            $stmt = $pdo->prepare("UPDATE tasks SET " . implode(', ', $updates) . " WHERE id = ? AND user_id = ?");
            $stmt->execute($params);
            echo json_encode(['status' => 'success']);
        }
    } elseif ($action === 'delete') {
        $id = (int)$input['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['status' => 'success']);
    }
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT id, title, priority, difficulty, due_date, completed, created_at, completed_at FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
    $stmt->execute([$user_id]);
    $tasks = $stmt->fetchAll();
    
    // Format for frontend
    foreach ($tasks as &$task) {
        $task['createdAt'] = $task['created_at'];
        $task['completedAt'] = $task['completed_at'];
        unset($task['created_at'], $task['completed_at']);
    }
    
    echo json_encode($tasks);
}
?>