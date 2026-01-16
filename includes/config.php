<?php
// config.php - versi sedikit ditingkatkan

session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connect) {
    // Log error tanpa tampilkan detail ke user (lebih aman di production)
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Maaf, saat ini sistem sedang maintenance. Silakan coba lagi nanti.");
}

mysqli_set_charset($connect, 'utf8mb4');

// Optional: Set timezone Indonesia
date_default_timezone_set('Asia/Jakarta');
?>