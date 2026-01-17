<?php
require_once 'includes/config.php';
// Panggil functions.php AGAR FUNGSI ORDER DITEMUKAN
require_once 'includes/functions.php'; 
require_once 'includes/head.php';

// Hapus baris spinner.php kalau bikin loading terus
// require_once 'includes/spinner.php';

$current_page = 'orders';
require_once 'includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
// Sekarang fungsi ini pasti ada karena functions.php sudah dipanggil
$orders = getUserOrders($user_id); 
?>

<body>
    <div class="container-fluid page-header py-5 mb-5">
        <h1 class="text-center text-white display-6">Riwayat Pesanan</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active text-white">Orders</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <?php if (empty($orders)): ?>
                <div class="text-center py-5 bg-light rounded">
                    <h3>Belum ada pesanan</h3>
                </div>
            <?php else: ?>
                <div class="accordion" id="accordionOrders">
                    <?php $no=1; foreach ($orders as $order): ?>
                        <div class="accordion-item mb-3 border">
                            <h2 class="accordion-header" id="heading<?php echo $order['id']; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $order['id']; ?>">
                                    Order #<?php echo $order['id']; ?> - Rp <?php echo number_format($order['total_amount']); ?> (<?php echo $order['status']; ?>)
                                </button>
                            </h2>
                            <div id="collapse<?php echo $order['id']; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionOrders">
                                <div class="accordion-body">
                                    <table class="table">
                                        <?php 
                                        $items = getOrderItems($order['id']); 
                                        foreach($items as $item): 
                                        ?>
                                        <tr>
                                            <td style="width: 60px;">
                                                <img src="img/<?php echo $item['image']; ?>" width="50">
                                            </td>
                                            <td><?php echo $item['name']; ?></td>
                                            <td><?php echo $item['quantity']; ?> x</td>
                                            <td>Rp <?php echo number_format($item['price']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>