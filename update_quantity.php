<?php
// update_quantity.php - FULL VERSION
require_once 'includes/functions.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 2. Tangkap Data
if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = (int)$_GET['id'];
    $action     = $_GET['action'];
    $user_id    = (int)$_SESSION['user_id'];

    // 3. Ambil data keranjang saat ini
    $query = "SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_qty = (int)$row['quantity'];
        $cart_id = $row['id'];
        
        // 4. Hitung Matematika
        if ($action == 'increase') {
            $new_qty = $current_qty + 1;
        } elseif ($action == 'decrease') {
            $new_qty = $current_qty - 1;
        } else {
            $new_qty = $current_qty;
        }

        // 5. Simpan ke Database
        if ($new_qty > 0) {
            // Update jumlah baru
            $update_query = "UPDATE cart SET quantity = '$new_qty' WHERE id = '$cart_id'";
            mysqli_query($conn, $update_query);
        } else {
            // Kalau 0, hapus barangnya
            $delete_query = "DELETE FROM cart WHERE id = '$cart_id'";
            mysqli_query($conn, $delete_query);
        }
    }
}

// 6. Refresh Halaman Cart (Supaya harga & notif kuning update)
header("Location: cart.php");
exit;
?>