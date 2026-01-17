<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Panggil fungsi completeOrder
    if (completeOrder($order_id, $user_id)) {
        header("Location: orders.php?status=completed");
        exit;
    } else {
        // Bisa jadi gagal karena status bukan 'shipped'
        header("Location: orders.php?error=complete_failed");
        exit;
    }
} else {
    header("Location: orders.php");
    exit;
}
?>