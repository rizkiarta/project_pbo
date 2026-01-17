<?php
// update_quantity.php - SUDAH DIPERBAIKI (Versi $connect)

// Kita panggil config.php dulu. 
// File ini sudah otomatis menjalankan session_start() dan membuat koneksi database ($connect)
require_once 'includes/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    // Kalau belum login, lempar ke halaman login (opsional)
    header("Location: login.php");
    exit;
}

// Tangkap data dari URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = (int)$_GET['id'];
    $action     = $_GET['action'];
    $user_id    = (int)$_SESSION['user_id']; // Ambil ID user dari session

    // -----------------------------------------------------------
    // Menggunakan variabel $connect (sesuai config.php kamu)
    // -----------------------------------------------------------

    // 1. Ambil jumlah (quantity) saat ini dari Database
    // Asumsi nama tabel: 'cart' (jika masih error, cek nama tabel di database)
    $query = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_qty = (int)$row['quantity'];
        
        // 2. Hitung Quantity Baru
        if ($action == 'increase') {
            $new_qty = $current_qty + 1;
        } elseif ($action == 'decrease') {
            $new_qty = $current_qty - 1;
        } else {
            $new_qty = $current_qty;
        }

        // 3. Update ke Database
        if ($new_qty > 0) {
            // Update angka baru
            $update_query = "UPDATE cart SET quantity = '$new_qty' WHERE user_id = '$user_id' AND product_id = '$product_id'";
            mysqli_query($connect, $update_query);
        } else {
            // LOGIKA PENGHAPUSAN/BATAS MINIMAL
            // Jika jumlah jadi 0, kita set mentok di 1 saja.
            // (Kalau mau dihapus otomatis, ganti query ini dengan DELETE)
            $update_query = "UPDATE cart SET quantity = '1' WHERE user_id = '$user_id' AND product_id = '$product_id'";
            mysqli_query($connect, $update_query);
        }
    }
}

// 4. Redirect kembali ke halaman cart
header("Location: cart.php");
exit;
?>