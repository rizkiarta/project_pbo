<?php
// update_quantity.php - ALL IN ONE (Tambah/Kurang/Hapus)
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $product_id = (int)$_GET['id'];
    $action     = $_GET['action'];
    $user_id    = (int)$_SESSION['user_id'];

    if ($action == 'delete') {
        $query = "DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($conn, $query);
    } else {
        $query = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $qty = (int)$row['quantity'];
            
            if ($action == 'increase') $qty++;
            if ($action == 'decrease') $qty--;

            if ($qty > 0) {
                mysqli_query($conn, "UPDATE cart SET quantity = '$qty' WHERE user_id='$user_id' AND product_id='$product_id'");
            } else {
                // Kalau 0, hapus saja
                mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
            }
        }
    }
}

header("Location: cart.php");
exit;
?>