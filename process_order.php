<?php
// process_order.php - VERSI FINAL (SIMPAN ORDER + HAPUS KERANJANG)
session_start();
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek apakah ada data POST dari form checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];
    $total   = $_POST['total_amount']; // Pastikan di form checkout ada input hidden ini
    
    // Validasi keranjang tidak kosong
    $cart_items = getCartItems();
    if (empty($cart_items)) {
        echo "<script>alert('Keranjang kosong!'); window.location.href='index.php';</script>";
        exit;
    }

    // A. BUAT ORDER UTAMA
    $order_id = createOrder($user_id, $name, $phone, $address, $total);

    if ($order_id) {
        // B. PINDAHKAN ITEM DARI KERANJANG KE ORDER_ITEMS
        // (Ini yang bikin tabel di halaman order ada isinya)
        foreach ($cart_items as $item) {
            createOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
        }

        // C. HAPUS BARANG DARI KERANJANG (Sesuai request kamu)
        clearCart($user_id);

        // D. SUKSES! KE HALAMAN ORDER
        header("Location: orders.php?status=success");
        exit;
    } else {
        echo "Gagal membuat pesanan.";
    }
} else {
    header("Location: checkout.php");
    exit;
}
?>