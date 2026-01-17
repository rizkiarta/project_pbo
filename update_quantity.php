<?php
session_start();

// Include config dan functions
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Pastikan tidak ada output APA PUN sebelum header
ob_clean(); // bersihin buffer kalau ada warning sebelumnya

header('Content-Type: application/json');

// Validasi input
if (!isset($_POST['product_id']) || !isset($_POST['change'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$product_id = (int)$_POST['product_id'];
$change     = (int)$_POST['change']; // +1 atau -1

// Kalau produk nggak ada di keranjang
if (!isset($_SESSION['cart'][$product_id])) {
    echo json_encode(['success' => false, 'message' => 'Produk tidak ada di keranjang']);
    exit;
}

// Hitung quantity baru
$new_quantity = $_SESSION['cart'][$product_id] + $change;

if ($new_quantity <= 0) {
    unset($_SESSION['cart'][$product_id]);
    $new_quantity = 0;
} else {
    $_SESSION['cart'][$product_id] = $new_quantity;
}

// Ambil ulang data keranjang
$items = getCartItems();
$current_item = null;
foreach ($items as $item) {
    if ($item['id'] == $product_id) {
        $current_item = $item;
        break;
    }
}

// Hitung ulang dengan jelas
 $cart_total_new = getCartTotal(); 
 $shipping = 20000; // Pastikan sesuai dengan getShippingFee()
 $grand_total_new = $cart_total_new + $shipping;

echo json_encode([
    'success'         => true,
    'quantity'        => $new_quantity,
    'subtotal'        => $current_item ? 'Rp ' . number_format($current_item['subtotal']) : 'Rp 0',
    // Tambahkan key baru untuk sidebar
    'sidebar_subtotal' => 'Rp ' . number_format($cart_total_new),
    'grand_total'     => 'Rp ' . number_format($grand_total_new), 
    'remove'          => ($new_quantity == 0),
    'cart_count'      => getCartCount()
]);

exit;
?>