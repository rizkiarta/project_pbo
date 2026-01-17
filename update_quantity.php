<?php
// update_quantity.php
// 1. Pastikan session dimulai
session_start(); 

// (Opsional) Jika config.php kamu juga start session, baris ini aman kok
require_once 'includes/config.php'; 

// 2. Ambil data
if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = $_GET['id'];
    $action     = $_GET['action'];

    // Debugging (Kalau masih gagal, nanti kita aktifkan ini)
    // echo "ID: " . $product_id . " - Action: " . $action; exit;

    // 3. Cek apakah keranjang ada
    if (isset($_SESSION['cart'])) {
        
        // Cek apakah produk ini ada di keranjang
        // Kita pakai loop untuk mencari kalau key-nya bukan ID langsung, 
        // ATAU akses langsung kalau strukturnya [id => jumlah]
        
        // Skenario A: Jika struktur session kamu sederhana: $_SESSION['cart'][ID] = JUMLAH
        if (isset($_SESSION['cart'][$product_id])) {
            if ($action == 'increase') {
                $_SESSION['cart'][$product_id]++;
            } elseif ($action == 'decrease') {
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] < 1) {
                    $_SESSION['cart'][$product_id] = 1;
                }
            }
        } 
        // Skenario B: Jaga-jaga jika ID terdeteksi sebagai string/integer beda tipe
        // (Kadang '1' beda dengan 1 di beberapa settingan PHP lama, meski jarang)
        elseif (isset($_SESSION['cart'][(int)$product_id])) {
             $int_id = (int)$product_id;
             if ($action == 'increase') {
                $_SESSION['cart'][$int_id]++;
            } elseif ($action == 'decrease') {
                $_SESSION['cart'][$int_id]--;
                if ($_SESSION['cart'][$int_id] < 1) {
                    $_SESSION['cart'][$int_id] = 1;
                }
            }
        }
    }
}

// 4. PENTING: Paksa simpan session sebelum pindah
session_write_close();

// 5. Kembalikan ke halaman cart
header("Location: cart.php");
exit();
?>