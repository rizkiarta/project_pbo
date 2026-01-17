<?php
// pay_order.php - UBAH STATUS JADI SIAP DIANTAR
session_start();
require_once 'includes/functions.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek ID Order
if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $user_id  = $_SESSION['user_id'];
    
    // Pastikan order ini milik user yang sedang login (Keamanan)
    $check = mysqli_query($conn, "SELECT id FROM orders WHERE id='$order_id' AND user_id='$user_id'");
    
    if (mysqli_num_rows($check) > 0) {
        // UBAH STATUS JADI 'shipped' (Artinya: Siap Diantar)
        $query = "UPDATE orders SET status = 'shipped' WHERE id = '$order_id'";
        
        if (mysqli_query($conn, $query)) {
            // Balik ke halaman orders dengan pesan sukses
            header("Location: orders.php?msg=paid");
        } else {
            echo "Gagal update status.";
        }
    } else {
        echo "Pesanan tidak ditemukan.";
    }
} else {
    header("Location: orders.php");
}
?>