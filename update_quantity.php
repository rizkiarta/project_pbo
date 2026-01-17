<?php
session_start();
require_once 'includes/config.php';

// Pastikan ada parameter ID dan Action dari URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = $_GET['id'];
    $action     = $_GET['action'];

    // Cek apakah produk tersebut ada di keranjang session
    if (isset($_SESSION['cart'][$product_id])) {
        
        // --- LOGIKA TAMBAH (+) ---
        if ($action == 'increase') {
            $_SESSION['cart'][$product_id]++;
        } 
        
        // --- LOGIKA KURANG (-) ---
        elseif ($action == 'decrease') {
            $_SESSION['cart'][$product_id]--;

            // Jaga-jaga biar tidak minus atau nol
            if ($_SESSION['cart'][$product_id] < 1) {
                $_SESSION['cart'][$product_id] = 1;
                // Jika kamu ingin otomatis hapus barang kalau jadi 0, 
                // ganti baris atas dengan: unset($_SESSION['cart'][$product_id]);
            }
        }
    }
}

// --- BAGIAN KUNCI ---
// Setelah session diubah, langsung lempar balik (Redirect) ke cart.php
// Halaman cart.php akan otomatis menghitung ulang total harga saat dimuat.
header("Location: cart.php");
exit;
?>