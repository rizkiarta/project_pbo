<?php
// includes/functions.php - VERSI FINAL + FIX GETCARTCOUNT
require_once 'config.php';

// Fix Koneksi
if (isset($connect)) {
    $conn = $connect;
}

// Cek Login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// --- FUNGSI PRODUK ---
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

function getProductById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// --- FUNGSI ORDER (RIWAYAT) ---
function getUserOrders($user_id) {
    global $conn;
    $query = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

function getOrderItems($order_id) {
    global $conn;
    $query = "SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = '$order_id'";
    $result = mysqli_query($conn, $query);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return $items;
}

// --- FUNGSI KERANJANG (CART) ---

// 1. Ambil Barang di Cart
function getCartItems() {
    global $conn;
    if (!isset($_SESSION['user_id'])) return [];
    $user_id = $_SESSION['user_id'];
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

// 2. Hitung Total Harga Barang
function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

// 3. Hitung Ongkir (YANG TADI HILANG)
function getShippingFee() {
    $items = getCartItems();
    return empty($items) ? 0 : 15000; 
}

// 4. Hitung Grand Total (YANG TADI HILANG)
function getGrandTotal() {
    return getCartTotal() + getShippingFee();
}

// 5. Tambah ke Cart
function addToCart($product_id, $quantity) {
    global $conn;
    if (!isset($_SESSION['user_id'])) return false;
    $user_id = $_SESSION['user_id'];

    $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $new_qty = $row['quantity'] + $quantity;
        return mysqli_query($conn, "UPDATE cart SET quantity = '$new_qty' WHERE id = " . $row['id']);
    } else {
        return mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')");
    }
}

// 6. Hitung Jumlah Item untuk Badge Navbar (INI PENYEBAB ERRORNYA!)
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