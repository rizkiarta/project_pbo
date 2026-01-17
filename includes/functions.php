<?php
// includes/functions.php - VERSI UNIVERSAL (Bisa $conn atau $connect)
require_once 'config.php';

// --- [FIX KRUSIAL] PENYAMBUNG KABEL DATABASE ---
// Kode ini akan mendeteksi nama variabel di config kamu
if (isset($connect)) {
    $conn = $connect;
} elseif (!isset($conn)) {
    // Kalau dua-duanya tidak ada, matikan
    die("Error: Variabel koneksi database tidak ditemukan di config.php");
}
// -----------------------------------------------

// Cek Login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi Produk (Index)
function getProducts($limit = null) {
    global $conn;
    $query = "SELECT * FROM products ORDER BY id DESC";
    if ($limit != null) {
        $query .= " LIMIT $limit";
    }
    $result = mysqli_query($conn, $query);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Fix warning category
        $row['category_name'] = isset($row['category_name']) ? $row['category_name'] : 'Sayur Segar';
        $products[] = $row;
    }
    return $products;
}

// Fungsi Detail Produk
function getProductById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// --- FUNGSI KERANJANG (CART) ---

function addToCart($product_id, $quantity) {
    global $conn;
    if (!isset($_SESSION['user_id'])) return false;
    $user_id = $_SESSION['user_id'];

    // Cek stok/barang ada atau tidak di cart
    $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $new_qty = $row['quantity'] + $quantity;
        $update = "UPDATE cart SET quantity = '$new_qty' WHERE id = " . $row['id'];
        return mysqli_query($conn, $update);
    } else {
        $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        return mysqli_query($conn, $insert);
    }
}

function getCartItems() {
    global $conn;
    if (!isset($_SESSION['user_id'])) return [];
    
    $user_id = $_SESSION['user_id'];
    // Join tabel supaya dapat nama & gambar produk
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

function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

function getShippingFee() {
    $items = getCartItems();
    return empty($items) ? 0 : 15000; 
}

function getGrandTotal() {
    return getCartTotal() + getShippingFee();
}

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