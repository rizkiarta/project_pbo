<?php

// ========== FUNGSI AUTH (LOGIN & REGISTER) ==========

// Fungsi: Register User Baru
function registerUser($name, $email, $password) {
    global $connect;

    // 1. Cek apakah email sudah terdaftar
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        return false; // Email sudah ada
    }
    mysqli_stmt_close($stmt);

    // 2. Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 3. Insert user baru
    $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        return true; // Sukses
    } else {
        return false; // Gagal query
    }
}

// Fungsi: Login User
function loginUser($email, $password) {
    global $connect;

    // 1. Cari user berdasarkan email
    $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // 2. Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            
            return true; // Login Berhasil
        }
    }
    
    return false; // Email salah / password salah
}



// Fungsi: Ambil semua produk (dengan optional filter kategori)
function getProducts($limit = null, $category_slug = null, $offset = 0) {
    global $connect;

    $sql = "SELECT p.*, c.name AS category_name, c.slug 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id";

    $conditions = [];
    $params = [];
    $types = '';

    if ($category_slug) {
        $conditions[] = "c.slug = ?";
        $params[] = $category_slug;
        $types .= 's';
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY p.created_at DESC";

    if ($limit !== null) {
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = (int)$limit;
        $params[] = (int)$offset;
        $types .= 'ii';
    }

    $stmt = mysqli_prepare($connect, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

// Fungsi: Ambil satu produk berdasarkan ID
function getProductById($id) {
    global $connect;

    $sql = "SELECT p.*, c.name AS category_name, c.slug 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = ?";

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// Fungsi: Ambil semua kategori (untuk menu/navbar)
function getCategories() {
    global $connect;

    $sql = "SELECT * FROM categories ORDER BY name";
    $result = mysqli_query($connect, $sql);

    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

// Fungsi: Hitung jumlah produk di kategori tertentu
function countProductsInCategory($slug) {
    global $connect;

    $sql = "SELECT COUNT(*) as total 
            FROM products p 
            JOIN categories c ON p.category_id = c.id 
            WHERE c.slug = ?";

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

function countAllProducts() {
    global $connect;
    $sql = "SELECT COUNT(*) as total FROM products";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// ========== FUNGSI CART (MIXED: SESSION & DATABASE) ==========

// Fungsi universal: tambah ke keranjang
function addToCart($product_id, $quantity = 1) {
    $product_id = (int)$product_id;
    $quantity = max(1, (int)$quantity);

    // Validasi produk ada
    $product = getProductById($product_id);
    if (!$product) {
        $_SESSION['message'] = "Produk tidak ditemukan!";
        return false;
    }

    // Cek stok
    if ($product['stock'] < $quantity) {
        $_SESSION['message'] = "Stok tidak mencukupi! Stok tersedia: " . $product['stock'];
        return false;
    }

    // Jika user sudah login, simpan ke database
    if (isset($_SESSION['user_id'])) {
        global $connect;
        
        // Cek apakah produk sudah ada di cart user
        $sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existing = mysqli_fetch_assoc($result);
        
        if ($existing) {
            // Update quantity
            $new_qty = $existing['quantity'] + $quantity;
            $sql = "UPDATE cart SET quantity = ?, updated_at = NOW() WHERE id = ?";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $new_qty, $existing['id']);
            mysqli_stmt_execute($stmt);
        } else {
            // Insert baru
            $sql = "INSERT INTO cart (user_id, product_id, quantity, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $_SESSION['user_id'], $product_id, $quantity);
            mysqli_stmt_execute($stmt);
        }
    } 
    // Jika guest, simpan di session
    else {
        // Inisialisasi keranjang kalau belum ada
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Tambah atau update quantity
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    $_SESSION['message'] = "Produk berhasil ditambahkan ke keranjang!";
    return true;
}

// Fungsi universal: ambil item keranjang
function getCartItems() {
    $items = [];
    
    // Jika user login, ambil dari database
    if (isset($_SESSION['user_id'])) {
        global $connect;
        
        $sql = "SELECT c.id as cart_id, p.id, p.name, p.price, p.image, c.quantity 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $row['subtotal'] = $row['price'] * $row['quantity'];
            $items[] = $row;
        }
    } 
    // Jika guest, ambil dari session
    else if (!empty($_SESSION['cart'])) {
        global $connect;
        $ids = array_keys($_SESSION['cart']);
        
        if (empty($ids)) return [];
        
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $types = str_repeat('i', count($ids));

        $sql = "SELECT id, name, price, image FROM products WHERE id IN ($placeholders)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$ids);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($product = mysqli_fetch_assoc($result)) {
            $product['quantity'] = $_SESSION['cart'][$product['id']];
            $product['subtotal'] = $product['price'] * $product['quantity'];
            $items[] = $product;
        }
    }

    return $items;
}

// Fungsi universal: hitung jumlah item di keranjang
function getCartCount() {
    $total = 0;
    
    if (isset($_SESSION['user_id'])) {
        global $connect;
        $sql = "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'] ?? 0;
    } else if (isset($_SESSION['cart'])) {
        $total = array_sum($_SESSION['cart']);
    }
    
    return $total;
}

// Fungsi universal: hitung total harga keranjang
function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}
// Fungsi universal: hitung ongkir (flat rate)
function getShippingFee() {
    return 20000; // Ongkir flat rate Rp20.000
}           

// Fungsi universal: hitung total harga keranjang + ongkir
function getGrandTotal() {
    $cart_total = getCartTotal();
    $shipping = getShippingFee();
    return $cart_total + $shipping;
}

// Fungsi universal: hapus item dari keranjang
function removeFromCart($product_id) {
    $product_id = (int)$product_id;
    
    if (isset($_SESSION['user_id'])) {
        global $connect;
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $product_id);
        mysqli_stmt_execute($stmt);
    } else if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Fungsi universal: update quantity item
function updateCartQuantity($product_id, $quantity) {
    $product_id = (int)$product_id;
    $quantity = max(0, (int)$quantity);
    
    if ($quantity == 0) {
        removeFromCart($product_id);
        return;
    }
    
    // Cek stok
    $product = getProductById($product_id);
    if ($product && $product['stock'] < $quantity) {
        $_SESSION['message'] = "Stok tidak mencukupi! Stok tersedia: " . $product['stock'];
        return;
    }
    
    if (isset($_SESSION['user_id'])) {
        global $connect;
        
        if ($quantity > 0) {
            $sql = "UPDATE cart SET quantity = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $quantity, $_SESSION['user_id'], $product_id);
            mysqli_stmt_execute($stmt);
        } else {
            removeFromCart($product_id);
        }
    } else {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// Fungsi universal: kosongkan keranjang
function clearCart() {
    if (isset($_SESSION['user_id'])) {
        global $connect;
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
    } else {
        unset($_SESSION['cart']);
    }
}

// Fungsi: Cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi: Cek apakah user adalah admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// ========== FUNGSI ORDER ===========

// Fungsi: Buat Order Baru
function createOrder($user_id, $customer_name, $phone, $address, $total_amount) {
    global $connect;
    
    // 1. Insert ke tabel 'orders'
    $status = 'pending'; 
    $sql = "INSERT INTO orders (user_id, customer_name, phone, address, total_amount, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
    $stmt = mysqli_prepare($connect, $sql);
    // Bind: i=integer, s=string, s=string, s=string, d=double, s=string
    mysqli_stmt_bind_param($stmt, "isssds", $user_id, $customer_name, $phone, $address, $total_amount, $status);
    mysqli_stmt_execute($stmt);
    
    $order_id = mysqli_insert_id($connect); // Ambil ID Order yang baru dibuat
    
    // 2. Ambil item keranjang dan simpan ke 'order_items'
    $cart_items = getCartItems(); // Panggil fungsi keranjang yang sudah ada
    
    foreach ($cart_items as $item) {
        $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt_item = mysqli_prepare($connect, $sql_item);
        mysqli_stmt_bind_param($stmt_item, "iiidd", $order_id, $item['id'], $item['quantity'], $item['price'], $item['subtotal']);
        mysqli_stmt_execute($stmt_item);
    }
    
    // 3. Kosongkan keranjang
    clearCart();
    
    return $order_id;
}

// Fungsi: Ambil semua pesanan user
function getUserOrders($user_id) {
    global $connect;
    $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

// Fungsi: Ambil detail item dalam satu pesanan
function getOrderItems($order_id) {
    global $connect;
    $sql = "SELECT oi.*, p.name, p.image 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return $items;
}

// Fungsi: Batalkan Pesanan
function cancelOrder($order_id, $user_id) {
    global $connect;
    
    // Pastikan order milik user yang sedang login
    $sql = "UPDATE orders SET status = 'cancelled' WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

// Fungsi: Proses Pembayaran (Update Status jadi 'paid')
function payOrder($order_id, $user_id) {
    global $connect;
    
    // Pastikan order milik user
    $sql = "UPDATE orders SET status = 'paid' WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

// Fungsi: Update Status Jadi Selesai (Received)
function completeOrder($order_id, $user_id) {
    global $connect;
    
    // Kita lakukan cek sederhana: Update status jadi 'completed' jika ID dan User cocok.
    // (Untuk sistem yang lebih ketat, biasanya cek dulu apakah statusnya 'shipped')
    
    $sql = "UPDATE orders SET status = 'completed' 
            WHERE id = ? AND user_id = ?";
            
    $stmt = mysqli_prepare($connect, $sql);
    
    // Bind param: 'ii' berarti dua integer (order_id dan user_id)
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}


?>

