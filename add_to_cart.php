<?php
// add_to_cart.php - MODE HAPUS ERROR (CLEAN OUTPUT)

// 1. Tahan semua output
ob_start();

require_once 'includes/functions.php';

// 2. Buang semua pesan error/warning sampah yang muncul dari functions.php
ob_clean(); 

if (!isset($_SESSION['user_id'])) {
    echo "login_required";
    exit;
}

$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        // 3. Pastikan output BERSIH cuma kata "success"
        ob_clean();
        echo "success"; 
    } else {
        ob_clean();
        echo "failed";
    }
} else {
    echo "invalid";
}
?>