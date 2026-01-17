<?php
// update_quantity.php (MODE DEBUG)
session_start();
require_once 'includes/config.php';

$id_dari_tombol = isset($_GET['id']) ? $_GET['id'] : 'TIDAK ADA ID';
$action = isset($_GET['action']) ? $_GET['action'] : 'TIDAK ADA ACTION';

echo "<h1>Mode Detektif 🕵️‍♂️</h1>";
echo "<h3>1. Data yang diterima dari tombol:</h3>";
echo "ID Produk: <strong>" . $id_dari_tombol . "</strong><br>";
echo "Action: <strong>" . $action . "</strong><br>";

echo "<hr>";
echo "<h3>2. Isi Keranjang di Session Server:</h3>";
echo "<pre>";
print_r($_SESSION['cart']);
echo "</pre>";

echo "<hr>";
echo "<h3>3. Analisa Pencocokan:</h3>";

if (isset($_SESSION['cart'][$id_dari_tombol])) {
    echo "✅ <strong>COCOK!</strong> ID " . $id_dari_tombol . " ditemukan di session.<br>";
    echo "Jumlah sekarang: " . $_SESSION['cart'][$id_dari_tombol] . "<br>";
    echo "Seharusnya kalau ditambah jadi: " . ($_SESSION['cart'][$id_dari_tombol] + 1);
} else {
    echo "❌ <strong>GAGAL!</strong> ID " . $id_dari_tombol . " TIDAK ditemukan di kunci array session di atas.<br>";
    echo "Coba perhatikan output 'Isi Keranjang' di poin 2. Apakah ID-nya berbeda?";
}

echo "<br><br><a href='cart.php'>Kembali ke Cart</a>";
exit();
?>