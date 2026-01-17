<?php
// process_order.php - VERSI FINAL (HITUNG OTOMATIS + ANTI NOL)
session_start();
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Proses Checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];
    // $total = $_POST['total_amount']; <--- KITA BUANG CARA LAMA INI (RAWAN ERROR/0)
    
    // 3. Validasi & Hitung Ulang Total (Server Side Calculation)
    $cart_items = getCartItems();
    if (empty($cart_items)) {
        echo "<script>alert('Keranjang kosong!'); window.location.href='index.php';</script>";
        exit;
    }

    // Hitung manual biar PASTI BENAR
    $subtotal = getCartTotal(); // Ambil dari functions.php
    $ongkir   = getShippingFee(); // Ambil dari functions.php (15000)
    $real_total = $subtotal + $ongkir;

    // A. BUAT ORDER DENGAN TOTAL YANG SUDAH DIHITUNG
    $order_id = createOrder($user_id, $name, $phone, $address, $real_total);

    if ($order_id) {
        // B. PINDAHKAN ITEM
        foreach ($cart_items as $item) {
            createOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
        }

        // C. BERSIHKAN KERANJANG
        clearCart($user_id);

        // D. SUKSES
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