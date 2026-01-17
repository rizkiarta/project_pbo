<?php
// add_to_cart.php - VERSI MANUAL (TANPA POP-UP JS)
session_start();
require_once 'includes/functions.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Login dulu yuk!'); window.location.href='login.php';</script>";
    exit;
}

// Tangkap Data
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        // SUKSES: Balik ke halaman sebelumnya (Home)
        echo "<script>alert('Berhasil masuk keranjang! 🛒'); window.history.back();</script>";
    } else {
        echo "<script>alert('Gagal masuk keranjang.'); window.history.back();</script>";
    }
} else {
    header("Location: index.php");
}
?>