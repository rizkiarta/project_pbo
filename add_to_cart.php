<?php
// add_to_cart.php - CLEAN VERSION
// Pastikan TIDAK ADA spasi atau baris kosong sebelum tag <?php ini

session_start();
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    // Jika Request via AJAX (JavaScript)
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Silakan login terlebih dahulu!']);
        exit;
    }
    // Jika Request Biasa
    $_SESSION['error_msg'] = "Login dulu ya!";
    header("Location: login.php");
    exit;
}

// 2. Tangkap Data
 $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
 $quantity   = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// 3. Validasi Data
if ($product_id > 0) {
    
    // Proses Tambah ke Keranjang (menggunakan fungsi dari functions.php)
    if (addToCart($product_id, $quantity)) {
        $newCount = getCartCount();

        // --- RESPON SUKSES UNTUK AJAX ---
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'cart_count' => $newCount
            ]);
            exit; // PENTING: Stop script di sini agar tidak muncul HTML sisa
        }

        // --- RESPON SUKSES UNTUK BIASA (RELOAD) ---
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;

    } else {
        // --- GAGAL MENAMBAH (GAGAL DB) ---
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Gagal menambah ke database.']);
            exit;
        }
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    // ID Produk tidak valid
    header("Location: index.php");
    exit;
}
?>