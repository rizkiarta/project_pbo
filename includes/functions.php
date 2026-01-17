<?php
// includes/functions.php - VERSI LENGKAP (USER + CART + PRODUCT)
require_once 'config.php';

// ==========================================
// FUNGSI USER (LOGIN & REGISTER)
// ==========================================

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function registerUser($data) {
    global $conn; 

    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    // Kita set default role 'customer'
    $role = 'customer';

    // Cek email kembar
    $check_query = "SELECT id FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        return false; 
    }

    // Masukkan data (Tanpa kolom username karena sudah dihapus)
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
// FUNGSI PRODUK (YANG TADI HILANG)
// ==========================================

// Ambil semua produk (bisa dilimit, misal cuma 8 produk teratas)
function getProducts($limit = null) {
    global $conn;
    $query = "SELECT * FROM products ORDER BY id DESC";
    
    if ($limit != null) {
        $query .= " LIMIT $limit";
    }
    
    $result = mysqli_query($conn, $query);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

// Ambil 1 produk berdasarkan ID (untuk halaman detail)
function getProductById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// ==========================================
// FUNGSI KERANJANG (CART)
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
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

function getShippingFee() {
    $items = getCartItems();
    if (empty($items)) return 0;
    return 15000; 
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
        $update = "UPDATE cart SET quantity = '$new_qty' WHERE id = " . $row['id'];
        return mysqli_query($conn, $update);
    } else {
        $insert = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        return mysqli_query($conn, $insert);
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