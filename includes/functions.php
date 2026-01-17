<?php
// includes/functions.php - VERSI BERSIH DARI GIT CONFLICT
require_once 'config.php';

// Fungsi Cek Login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi Register User Baru
function registerUser($data) {
    global $conn; // Panggil koneksi $conn dari config.php

    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT); // Enkripsi password
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $role = 'customer';

    // 1. Cek apakah email sudah ada?
    $check_query = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        return false; // Gagal, email sudah dipakai
    }

    // 2. Masukkan ke database
    $query = "INSERT INTO users (name, email, password, phone, address, role) 
              VALUES ('$name', '$email', '$password', '$phone', '$address', '$role')";
    
    if (mysqli_query($conn, $query)) {
        return true; // Sukses
    } else {
        // Jika error database, tampilkan errornya (untuk debugging)
        echo "Error Database: " . mysqli_error($conn); 
        return false;
    }
}

// Fungsi Login User
function loginUser($email, $password) {
    global $conn;
    
    $email = mysqli_real_escape_string($conn, $email);
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Cek Password
        if (password_verify($password, $user['password'])) {
            // Set Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

// ==========================================
// FUNGSI KERANJANG (CART)
// ==========================================

// Ambil semua item di keranjang user saat ini
function getCartItems() {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) {
        return [];
    }
    
    $user_id = $_SESSION['user_id'];
    
    // Gabungkan tabel cart dan products
    $query = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = '$user_id'";
              
    $result = mysqli_query($conn, $query);
    
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $items[] = $row;
    }
    return $items;
}

// Hitung Total Harga Barang
function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

// Hitung Ongkir (Flat Rate contoh 15.000)
function getShippingFee() {
    $items = getCartItems();
    if (empty($items)) return 0;
    return 15000; 
}

// Hitung Grand Total (Barang + Ongkir)
function getGrandTotal() {
    return getCartTotal() + getShippingFee();
}

// Tambah ke Cart (Dipakai di add_to_cart.php)
function addToCart($product_id, $quantity) {
    global $conn;
    
    if (!isset($_SESSION['user_id'])) return false;
    $user_id = $_SESSION['user_id'];

    // Cek apakah barang sudah ada?
    $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        // Update jumlahnya
        $row = mysqli_fetch_assoc($res);
        $new_qty = $row['quantity'] + $quantity;
        $update = "UPDATE cart SET quantity = '$new_qty' WHERE id = " . $row['id'];
        return mysqli_query($conn, $update);
    } else {
        // Insert baru
        $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        return mysqli_query($conn, $insert);
    }
}

// Hitung jumlah item unik di keranjang (untuk badge notifikasi)
function getCartCount() {
    global $conn;
    if (!isset($_SESSION['user_id'])) return 0;
    
    $user_id = $_SESSION['user_id'];
    $query = "SELECT SUM(quantity) as total FROM cart WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ? (int)$row['total'] : 0;
}
?>