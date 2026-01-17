<?php
// add_to_cart.php - VERSI MANUAL (FORM HANDLER)
session_start();
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Eits, Login dulu baru bisa belanja!'); 
        window.location.href='login.php';
    </script>";
    exit;
}

// 2. Tangkap Data dari Form
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : (isset($_GET['id']) ? $_GET['id'] : null);
$quantity   = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

// 3. Proses Masuk Keranjang
if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        // SUKSES: Tampilkan pesan lalu banting setir balik ke halaman sebelumnya
        echo "<script>
            // alert('Berhasil masuk keranjang! 🛒'); // Hapus tanda // jika ingin ada notif muncul
            window.history.back(); 
        </script>";
    } else {
        // GAGAL
        echo "<script>
            alert('Gagal menambah barang.'); 
            window.history.back();
        </script>";
    }
} else {
    // Kalau iseng buka file ini tanpa data
    header("Location: index.php");
    exit;
}
?>