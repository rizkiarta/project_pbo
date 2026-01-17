<?php
session_start();
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

 $order_id = (int)$_GET['id'];
 $user_id  = $_SESSION['user_id'];

// Update status jadi 'completed'
 $query = "UPDATE orders SET status = 'completed' 
          WHERE id = '$order_id' AND user_id = '$user_id'";
          
// Jalankan Query (gunakan koneksi global atau fungsi)
global $conn;
if (mysqli_query($conn, $query)) {
    $_SESSION['success_msg'] = "Terima kasih! Pesanan telah selesai.";
} else {
    $_SESSION['error_msg'] = "Gagal mengubah status pesanan.";
}

header("Location: orders.php");
exit;
?>