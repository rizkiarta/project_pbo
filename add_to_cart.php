<?php
// add_to_cart.php - ANTI POP-UP ERROR
ob_start(); // Tahan output
require_once 'includes/functions.php';
ob_clean(); // Hapus semua teks sampah/warning sebelumnya

if (!isset($_SESSION['user_id'])) {
    echo "login_required";
    exit;
}

$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        ob_clean(); // Bersihkan lagi biar aman
        echo "success"; 
    } else {
        ob_clean();
        echo "failed";
    }
} else {
    echo "invalid";
}
?>