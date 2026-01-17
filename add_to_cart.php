<?php
// add_to_cart.php - FINAL FIX (ANTI POP-UP ERROR)
ob_start(); // Tahan output

require_once 'includes/functions.php';

ob_clean(); // Hapus warning/error sampah sebelumnya

// Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "login_required";
    exit;
}

// Tangkap Data
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        ob_clean(); // Bersihkan lagi sebelum kirim "success"
        echo "success"; 
    } else {
        ob_clean();
        echo "failed";
    }
} else {
    echo "invalid";
}
?>