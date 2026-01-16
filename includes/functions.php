<?php

// Fungsi: Ambil semua produk (dengan optional filter kategori)
function getProducts($limit = null, $category_slug = null, $offset = 0) {
    global $connect;

    $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
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

    $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug 
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
function countProductsInCategory($category_slug) {
    global $connect;

    $sql = "SELECT COUNT(*) as total 
            FROM products p 
            JOIN categories c ON p.category_id = c.id 
            WHERE c.slug = ?";

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category_slug);
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


// Fungsi untuk guest: tambah produk ke keranjang pakai session
function addToCart($product_id, $quantity = 1) {
    $product_id = (int)$product_id;
    $quantity = max(1, (int)$quantity);

    // Validasi produk ada
    $product = getProductById($product_id);
    if (!$product) {
        $_SESSION['message'] = "Produk tidak ditemukan!";
        return false;
    }

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

    $_SESSION['message'] = "Produk berhasil ditambahkan ke keranjang!";
    return true;
}

// Ambil item keranjang dari session (untuk guest)
function getCartItems() {
    if (empty($_SESSION['cart'])) {
        return [];
    }

    global $connect;
    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $types = str_repeat('i', count($ids));

    $sql = "SELECT id, name, price, image FROM products WHERE id IN ($placeholders)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$ids);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $items = [];
    while ($product = mysqli_fetch_assoc($result)) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $items[] = $product;
    }

    return $items;
}

// Hitung jumlah item di keranjang (badge)
function getCartCount() {
    return isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
}

// Hitung total harga
function getCartTotal() {
    $items = getCartItems();
    $total = 0;
    foreach ($items as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

// Hapus item
function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Kosongkan keranjang
function clearCart() {
    unset($_SESSION['cart']);
}




?>


