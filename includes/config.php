<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$conn = $connect; 

if (!$connect) {
    die("Gagal Koneksi Database: " . mysqli_connect_error());
}

// Setting Waktu & Bahasa
mysqli_set_charset($connect, 'utf8mb4');
date_default_timezone_set('Asia/Jakarta');
?>