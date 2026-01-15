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
    $preferences = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $pdo->prepare("INSERT INTO user_preferences (user_id, session_length, study_time_preference, break_length, sync_frequency, offline_mode, last_updated) 
                          VALUES (?, ?, ?, ?, ?, ?, NOW()) 
                          ON DUPLICATE KEY UPDATE 
                          session_length = VALUES(session_length),
                          study_time_preference = VALUES(study_time_preference),
                          break_length = VALUES(break_length),
                          sync_frequency = VALUES(sync_frequency),
                          offline_mode = VALUES(offline_mode),
                          last_updated = NOW()");
    
    $stmt->execute([
        $user_id,
        $preferences['sessionLength'] ?? 25,
        $preferences['studyTimePreference'] ?? 'afternoon',
        $preferences['breakLength'] ?? 5,
        $preferences['syncFrequency'] ?? 15,
        $preferences['offlineMode'] ? 1 : 0
    ]);
    
    echo json_encode(['status' => 'success']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM user_preferences WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $prefs = $stmt->fetch();
    
    if (!$prefs) {
        $prefs = [
            'session_length' => 25,
            'study_time_preference' => 'afternoon',
            'break_length' => 5,
            'sync_frequency' => 15,
            'offline_mode' => 1
        ];
    }
    
    echo json_encode($prefs);
}
?>