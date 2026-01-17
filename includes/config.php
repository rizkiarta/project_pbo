<?php
// includes/config.php - VERSI FINAL ANTI-LEMOT
// Hapus session_start() jika di file lain sudah ada, tapi untuk aman biarkan di sini
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ganti localhost jadi 127.0.0.1 supaya INSTANT (tidak loading lama)
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Buat Alias: File yang minta $conn dikasih, minta $connect juga dikasih
$conn = $connect; 

if (!$connect) {
    die("Gagal Koneksi Database: " . mysqli_connect_error());
}

// Setting Waktu & Bahasa
mysqli_set_charset($connect, 'utf8mb4');
date_default_timezone_set('Asia/Jakarta');
?>