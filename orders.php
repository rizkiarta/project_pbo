<?php
require_once 'includes/config.php';
require_once 'includes/functions.php'; // PENTING: Panggil functions dulu
require_once 'includes/head.php';

// SAYA MATIKAN SPINNERNYA BIAR GAK BLANK PUTIH
// require_once 'includes/spinner.php'; 

$current_page = 'orders';
require_once 'includes/navbar.php';

if (!isLoggedIn()) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
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
                    <h3>Belum ada pesanan 😔</h3>
                    <a href="index.php" class="btn btn-primary rounded-pill px-4 py-3 mt-3">Belanja Sekarang</a>
                </div>
            <?php else: ?>
                
                <div class="accordion" id="accordionOrders">
                    <?php $counter = 1; ?>
                    <?php foreach ($orders as $order): ?>
                        <?php 
                            $order_items = getOrderItems($order['id']);
                            $collapseId = "collapse" . $order['id'];
                            $headingId = "heading" . $order['id'];
                            
                            // Warna Status
                            $badgeClass = 'bg-secondary';
                            if($order['status'] == 'pending') $badgeClass = 'bg-warning text-dark';
                            elseif($order['status'] == 'paid') $badgeClass = 'bg-info text-dark';
                            elseif($order['status'] == 'shipped') $badgeClass = 'bg-primary text-white';
                            elseif($order['status'] == 'completed') $badgeClass = 'bg-success text-white';
                            elseif($order['status'] == 'cancelled') $badgeClass = 'bg-danger text-white';
                        ?>
                        
                        <div class="accordion-item mb-3 border rounded shadow-sm">
                            <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                <button class="accordion-button <?php echo $counter > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center me-3">
                                        <span>
                                            <strong>Order #<?php echo $order['id']; ?></strong> 
                                            <span class="text-muted ms-2 small"><?php echo date('d M Y', strtotime($order['created_at'])); ?></span>
                                        </span>
                                        <span>
                                            <span class="badge <?php echo $badgeClass; ?> me-2"><?php echo ucfirst($order['status']); ?></span>
                                            <span class="fw-bold text-primary">Rp <?php echo number_format($order['total_amount']); ?></span>
                                        </span>
                                    </div>
                                </button>
                            </h2>
                            <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse <?php echo $counter == 1 ? 'show' : ''; ?>" data-bs-parent="#accordionOrders">
                                <div class="accordion-body bg-white">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <?php foreach ($order_items as $item): ?>
                                                    <tr class="align-middle border-bottom">
                                                        <td style="width: 80px;">
                                                            <img src="img/<?php echo $item['image']; ?>" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                                        </td>
                                                        <td>
                                                            <h6 class="mb-0"><?php echo $item['name']; ?></h6>
                                                            <small class="text-muted">x <?php echo $item['quantity']; ?></small>
                                                        </td>
                                                        <td class="text-end">
                                                            Rp <?php echo number_format($item['price'] * $item['quantity']); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>