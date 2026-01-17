<?php
// add_to_cart.php - SIMPLE & STABIL
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    // Balikkan kode error biar JS tau user belum login
    echo "login_required"; 
    exit;
}

// 2. Tangkap Data
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

// 3. Eksekusi
if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        echo "success"; // Jangan ubah kata ini, JS membacanya
    } else {
        echo "failed";
    }
} else {
    echo "invalid";
}
?>