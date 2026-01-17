<?php
// includes/functions.php - VERSI FINAL (LOGIN + CART + CHECKOUT)
require_once 'config.php';

// Fix Koneksi ($conn vs $connect)
if (isset($connect)) {
    $conn = $connect;
}

// ==========================================
// 1. FUNGSI USER (LOGIN & REGISTER)
// ==========================================

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function registerUser($data) {
    global $conn; 
    $name     = mysqli_real_escape_string($conn, $data['name']);
    $email    = mysqli_real_escape_string($conn, $data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $phone    = mysqli_real_escape_string($conn, $data['phone']);
    $address  = mysqli_real_escape_string($conn, $data['address']);
    $role     = 'customer';

    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) return false; 

    $query = "INSERT INTO users (name, email, password, phone, address, role) 
              VALUES ('$name', '$email', '$password', '$phone', '$address', '$role')";
    return mysqli_query($conn, $query);
}

function loginUser($email, $password) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
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
// 2. FUNGSI PRODUK
// ==========================================

function getProducts($limit = null, $category_slug = null) {
    global $conn;
    $query = "SELECT * FROM products";
    if ($category_slug != null) {
        if($category_slug == 'fruits') { $query .= " WHERE category_id = 1"; } 
        elseif ($category_slug == 'vegetables') { $query .= " WHERE category_id = 2"; }
    }
    $query .= " ORDER BY id DESC";
    if ($limit != null) { $query .= " LIMIT $limit"; }

    $result = mysqli_query($conn, $query);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
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

// ==========================================
// 3. FUNGSI CHECKOUT & ORDER (INI YANG TADI HILANG!)
// ==========================================

// Fungsi Membuat Order Baru
function createOrder($user_id, $data) {
    global $conn;
    $name    = mysqli_real_escape_string($conn, $data['name']);
    $phone   = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $note    = mysqli_real_escape_string($conn, $data['note']);
    $total   = $data['total_amount'];
    $status  = 'pending';
    $date    = date('Y-m-d H:i:s');

    $query = "INSERT INTO orders (user_id, customer_name, phone, address, note, total_amount, status, created_at)
              VALUES ('$user_id', '$name', '$phone', '$address', '$note', '$total', '$status', '$date')";
    
    if (mysqli_query($conn, $query)) {
        return mysqli_insert_id($conn); // Balikkan ID order yang baru dibuat
    }
    return false;
}

// Fungsi Memasukkan Barang ke Order
function createOrderItem($order_id, $product_id, $quantity, $price) {
    global $conn;
    $subtotal = $quantity * $price;
    $query = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal)
              VALUES ('$order_id', '$product_id', '$quantity', '$price', '$subtotal')";
    return mysqli_query($conn, $query);
}

// Fungsi Membersihkan Keranjang setelah Checkout
function clearCart($user_id) {
    global $conn;
    return mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");
}

// Fungsi Riwayat Order
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

// ==========================================
// 4. FUNGSI KERANJANG (CART)
// ==========================================

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

function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) { $total += $item['subtotal']; }
    return $total;
}

function getShippingFee() {
    $items = getCartItems();
    return empty($items) ? 0 : 15000; 
}

function getGrandTotal() {
    return getCartTotal() + getShippingFee();
}

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