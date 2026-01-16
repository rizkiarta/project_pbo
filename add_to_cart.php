<?php
// add_to_cart_ajax.php 
require_once 'includes/config.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Produk tidak valid']);
    exit;
}

$product_id = (int)$_POST['product_id'];
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($quantity < 1) $quantity = 1;

$result = addToCart($product_id, $quantity);

if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan ke keranjang!',
        'cart_count' => getCartCount()
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menambahkan produk. Mungkin produk tidak ditemukan.'
    ]);
}
exit;
?>