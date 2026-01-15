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
    $rating = (int)$input['rating'];
    $session_length = (int)$input['sessionLength'];
    
    $stmt = $pdo->prepare("INSERT INTO focus_ratings (user_id, rating, session_length, date) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$user_id, $rating, $session_length]);
    echo json_encode(['status' => 'success']);
} elseif ($method === 'GET') {
    $stmt = $pdo->prepare("SELECT rating, date, session_length FROM focus_ratings WHERE user_id = ? ORDER BY date DESC");
    $stmt->execute([$user_id]);
    $ratings = $stmt->fetchAll();
    
    echo json_encode($ratings);
}
?>