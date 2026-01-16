<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (isset($_GET['id'])) {
    removeFromCart((int)$_GET['id']);
}

header('Location: cart.php');
exit;
?>