<?php
// Ensure secure session settings
session_start([
    'cookie_lifetime' => 86400, // 1 day
    'cookie_secure' => isset($_SERVER['HTTPS']), // Only send over HTTPS
    'cookie_httponly' => true, // Prevent JavaScript access
    'use_strict_mode' => true // Enhanced session security
]);

// Database configuration
$host = 'localhost';
$dbname = 'lms_system';
$username = 'root';
$password = '';
$port = '3307';

// Error reporting (only in development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Create PDO instance with persistent connection
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true
        ]
    );
} catch (PDOException $e) {
    // Log error securely (in production, don't show detailed errors to users)
    error_log("Database connection failed: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

/**
 * Sanitize user input
 * @param string $data The input to sanitize
 * @return string Sanitized output
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Set default timezone
date_default_timezone_set('UTC');

// CSRF protection function
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>