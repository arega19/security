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
        $topic = encrypt_data($input['topic']);
        $category = $input['category'] ?? '';
        $priority = $input['priority'] ?? 'medium';
        $deadline = $input['deadline'];
        
        $stmt = $pdo->prepare("INSERT INTO study_plans (user_id, topic_aes, category, priority, deadline, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $topic, $category, $priority, $deadline]);
        echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
    } elseif ($action === 'update') {
        $id = (int)$input['id'];
        $updates = [];
        $params = [];
        
        if (isset($input['topic'])) {
            $updates[] = 'topic_aes = ?';
            $params[] = encrypt_data($input['topic']);
        }
        if (isset($input['category'])) {
            $updates[] = 'category = ?';
            $params[] = $input['category'];
        }
        if (isset($input['priority'])) {
            $updates[] = 'priority = ?';
            $params[] = $input['priority'];
        }
        if (isset($input['deadline'])) {
            $updates[] = 'deadline = ?';
            $params[] = $input['deadline'];
        }
        
        if (!empty($updates)) {
            $params[] = $id;
            $params[] = $user_id;
            $stmt = $pdo->prepare("UPDATE study_plans SET " . implode(', ', $updates) . " WHERE id = ? AND user_id = ?");
            $stmt->execute($params);
            echo json_encode(['status' => 'success']);
        }
    } elseif ($action === 'delete') {
        $id = (int)$input['id'];
        $stmt = $pdo->prepare("DELETE FROM study_plans WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        echo json_encode(['status' => 'success']);
    }
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT id, topic_aes, category, priority, deadline, created_at FROM study_plans WHERE user_id = ? ORDER BY deadline ASC");
    $stmt->execute([$user_id]);
    $plans = $stmt->fetchAll();
    
    // Decrypt topics
    foreach ($plans as &$plan) {
        $plan['topic'] = decrypt_data($plan['topic_aes']);
        $plan['createdAt'] = $plan['created_at'];
        unset($plan['topic_aes'], $plan['created_at']);
    }
    
    echo json_encode($plans);
}
?>