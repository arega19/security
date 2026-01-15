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
    $analytics = $input['analytics'];
    
    $stmt = $pdo->prepare("INSERT INTO analytics (user_id, daily_time, subject_time, completion_rates, productivity, focus_ratings_data, last_updated) 
                          VALUES (?, ?, ?, ?, ?, ?, NOW()) 
                          ON DUPLICATE KEY UPDATE 
                          daily_time = VALUES(daily_time),
                          subject_time = VALUES(subject_time),
                          completion_rates = VALUES(completion_rates),
                          productivity = VALUES(productivity),
                          focus_ratings_data = VALUES(focus_ratings_data),
                          last_updated = NOW()");
    
    $stmt->execute([
        $user_id,
        json_encode($analytics['dailyTime'] ?? []),
        json_encode($analytics['subjectTime'] ?? []),
        json_encode($analytics['completionRates'] ?? []),
        json_encode($analytics['productivity'] ?? []),
        json_encode($analytics['focusRatings'] ?? [])
    ]);
    
    echo json_encode(['status' => 'success']);
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM analytics WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $data = $stmt->fetch();
    
    if ($data) {
        $analytics = [
            'dailyTime' => json_decode($data['daily_time'], true) ?? [],
            'subjectTime' => json_decode($data['subject_time'], true) ?? [],
            'completionRates' => json_decode($data['completion_rates'], true) ?? [],
            'productivity' => json_decode($data['productivity'], true) ?? [],
            'focusRatings' => json_decode($data['focus_ratings_data'], true) ?? []
        ];
    } else {
        $analytics = [
            'dailyTime' => [],
            'subjectTime' => [],
            'completionRates' => [],
            'productivity' => [],
            'focusRatings' => []
        ];
    }
    
    echo json_encode($analytics);
}
?>