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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'upload';
    
    if ($action === 'upload') {
        $name = clean($_POST['name']);
        $type = clean($_POST['type']);
        $topic = clean($_POST['topic']);
        $file_path = clean($_POST['file_path']);
        
        $stmt = $pdo->prepare("INSERT INTO resources (user_id, name, type, topic, file_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $type, $topic, $file_path]);
        echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
    } elseif ($action === 'time') {
        $resource_id = (int)$_POST['resource_id'];
        $time_spent = (int)$_POST['time_spent'];
        $date = date('Y-m-d');
        
        $stmt = $pdo->prepare("INSERT INTO resource_time (user_id, resource_id, time_spent, date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE time_spent = time_spent + VALUES(time_spent)");
        $stmt->execute([$user_id, $resource_id, $time_spent, $date]);
        echo json_encode(['status' => 'success']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE user_id = ? ORDER BY uploaded_at DESC");
    $stmt->execute([$user_id]);
    $resources = $stmt->fetchAll();
    
    // Get time data
    $timeStmt = $pdo->prepare("SELECT resource_id, SUM(time_spent) as total_time FROM resource_time WHERE user_id = ? GROUP BY resource_id");
    $timeStmt->execute([$user_id]);
    $timeData = $timeStmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    foreach ($resources as &$resource) {
        $resource['time_spent'] = $timeData[$resource['id']] ?? 0;
    }
    
    echo json_encode($resources);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    echo json_encode(['status' => 'success']);
}
?>