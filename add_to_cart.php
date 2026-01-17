<?php
// add_to_cart.php - KURIR BARU
require_once 'includes/functions.php';

// 1. Cek Login
if (!isLoggedIn()) {
    echo "<script>
        alert('Eits, Login dulu baru bisa belanja!');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// 2. Tangkap Data (Bisa dari POST atau GET)
$product_id = null;
$quantity = 1; // Default beli 1

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (isset($_POST['quantity'])) {
        $quantity = (int)$_POST['quantity'];
    }
} elseif (isset($_GET['id'])) {
    $product_id = $_GET['id'];
}

// 3. Proses Masukkan
if ($product_id) {
    if (addToCart($product_id, $quantity)) {
        // SUKSES
        echo "<script>
            alert('Berhasil masuk keranjang! 🛒');
            // Kembali ke halaman sebelumnya
            window.history.back(); 
        </script>";
    } else {
        // GAGAL
        echo "<script>
            alert('Gagal masuk keranjang. Coba lagi!');
            window.location.href = 'index.php';
        </script>";
    }
} else {
    // Kalau id produk tidak ada
    header("Location: index.php");
    exit;
}
?>