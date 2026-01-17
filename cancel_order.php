<?php
session_start();
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek ID Order
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

 $order_id = (int)$_GET['id'];
 $user_id  = $_SESSION['user_id'];

// 3. Proses Pembatalan
if (cancelOrder($order_id, $user_id)) {
    $_SESSION['success_msg'] = "Pesanan berhasil dibatalkan.";
} else {
    $_SESSION['error_msg'] = "Gagal membatalkan pesanan.";
}

// 4. Kembali ke halaman pesanan
header("Location: orders.php");
exit;
?>