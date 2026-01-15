<?php
// Authentication check middleware
function require_auth() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    return [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? 'User'
    ];
}

// Check if user is authenticated (returns boolean)
function is_authenticated() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

// Get current user info (renamed to avoid conflict with PHP's built-in get_current_user)
function get_current_user_info() {
    if (!is_authenticated()) {
        return null;
    }

    return [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'] ?? 'User'
    ];
}
?>