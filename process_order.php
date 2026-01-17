<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Cek Login
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil Data Input
    $name    = mysqli_real_escape_string($connect, $_POST['name']);
    $phone   = mysqli_real_escape_string($connect, $_POST['phone']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    
    $user_id = $_SESSION['user_id'];
    
    // Hitung Total (Panggil Fungsi)
    $grand_total = getGrandTotal();

    // Validasi keranjang tidak kosong
    if (getCartCount() == 0) {
        header("Location: index.php?error=empty_cart");
        exit;
    }

    // Panggil Fungsi Create Order
    $order_id = createOrder($user_id, $name, $phone, $address, $grand_total);

    if ($order_id) {
        // Sukses -> Redirect ke Orders
        header("Location: orders.php?status=success");
        exit;
    } else {
        // Gagal
        header("Location: checkout.php?error=failed");
        exit;
    }
} else {
    header("Location: checkout.php");
    exit;
}
?>