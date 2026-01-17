<?php
// update_quantity.php - VERSI ALL IN ONE ($connect)
require_once 'includes/config.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = (int)$_GET['id'];
    $action     = $_GET['action'];
    $user_id    = (int)$_SESSION['user_id'];

    // --- KASUS 1: TOMBOL SAMPAH DIPENCET (DELETE) ---
    if ($action == 'delete') {
        // Hapus barang ini dari user ini
        $query = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($connect, $query);
    } 
    
    // --- KASUS 2: TOMBOL TAMBAH / KURANG DIPENCET ---
    else {
        // Cek jumlah sekarang
        $query = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $current_qty = (int)$row['quantity'];
            
            if ($action == 'increase') {
                $new_qty = $current_qty + 1;
            } elseif ($action == 'decrease') {
                $new_qty = $current_qty - 1;
            } else {
                $new_qty = $current_qty;
            }

            // Simpan ke database
            if ($new_qty > 0) {
                // Update jumlah baru
                $update = "UPDATE cart SET quantity = '$new_qty' WHERE user_id = '$user_id' AND product_id = '$product_id'";
                mysqli_query($connect, $update);
            } else {
                // Kalau dikurangi sampai 0, kembalikan ke 1 (Sesuai request kamu sebelumnya)
                $update = "UPDATE cart SET quantity = '1' WHERE user_id = '$user_id' AND product_id = '$product_id'";
                mysqli_query($connect, $update);
            }
        }
    }
}

// Balik ke keranjang, harga & notif otomatis update
header("Location: cart.php");
exit;
?>