<?php
// Secure Error Handling: Log errors to file, don't show to users
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/logs/error.log');

define('DB_HOST', 'localhost');
define('DB_NAME', 'study_planner');
define('DB_USER', 'root'); // Use a restricted user in production
define('DB_PASS', '');
define('AES_KEY', '4361ee7209b74cc9f0f72585f8961e'); // Change this!

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("A secure system error occurred.");
}
?>