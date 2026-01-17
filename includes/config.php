<?php
// includes/config.php - VERSI FINAL
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');

// 1. Buka koneksi ke database
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 2. [SOLUSI SAKTI] Kita buat kembarannya!
// Jadi kalau ada file minta $conn dikasih, minta $connect juga dikasih.
$conn = $connect; 

// Cek jika koneksi gagal
if (!$connect) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Setting tambahan (opsional)
mysqli_set_charset($connect, 'utf8mb4');
date_default_timezone_set('Asia/Jakarta');
?>