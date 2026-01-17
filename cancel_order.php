<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Cek Login
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $order_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    if (cancelOrder($order_id, $user_id)) {
        header("Location: orders.php?status=cancelled");
        exit;
    } else {
        header("Location: orders.php?error=cancel_failed");
        exit;
    }
} else {
    header("Location: orders.php");
    exit;
}
?>