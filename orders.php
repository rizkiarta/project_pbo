<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';

// Cek Login
if (!isLoggedIn()) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$orders  = getUserOrders($user_id);
$current_page = 'orders'; // Untuk navbar aktif
?>

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid page-header py-5 mb-5">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Riwayat Pesanan</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Orders</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <?php if (empty($orders)): ?>
                    <div class="text-center p-5 bg-light rounded shadow-sm">
                        <i class="fa fa-shopping-basket fa-4x text-primary mb-4"></i>
                        <h3 class="mb-3">Belum ada pesanan nih</h3>
                        <p class="text-muted mb-4">Yuk mulai belanja sayur dan buah segar!</p>
                        <a href="index.php" class="btn btn-primary rounded-pill px-5 py-3">Mulai Belanja</a>
                    </div>
                <?php else: ?>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Daftar Transaksi</h3>
                        <span class="badge bg-primary rounded-pill px-3 py-2"><?php echo count($orders); ?> Pesanan</span>
                    </div>

                    <div class="accordion" id="accordionOrders">
                        <?php 
                        $counter = 1; 
                        foreach ($orders as $order): 
                            $items = getOrderItems($order['id']);
                            // Tentukan Warna Status
                            $statusColor = 'bg-secondary';
                            $statusIcon  = 'fa-clock';
                            if($order['status'] == 'pending') { $statusColor = 'bg-warning text-dark'; $statusIcon = 'fa-hourglass-half'; }
                            elseif($order['status'] == 'processed') { $statusColor = 'bg-info text-white'; $statusIcon = 'fa-cog'; }
                            elseif($order['status'] == 'completed') { $statusColor = 'bg-success text-white'; $statusIcon = 'fa-check-circle'; }
                            elseif($order['status'] == 'cancelled') { $statusColor = 'bg-danger text-white'; $statusIcon = 'fa-times-circle'; }
                        ?>
                        
                        <div class="accordion-item mb-4 border-0 shadow-sm rounded overflow-hidden">
                            <h2 class="accordion-header" id="heading<?php echo $order['id']; ?>">
                                <button class="accordion-button <?php echo $counter > 1 ? 'collapsed' : ''; ?> bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $order['id']; ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center pe-3 flex-wrap gap-2">
                                        
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light p-3 rounded-circle me-3 d-none d-md-block">
                                                <i class="fa fa-receipt text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Order #<?php echo str_pad($order['id'], 4, '0', STR_PAD_LEFT); ?></h6>
                                                <small class="text-muted">
                                                    <i class="fa fa-calendar-alt me-1"></i> 
                                                    <?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?>
                                                </small>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <h6 class="mb-1 text-primary fw-bold">Rp <?php echo number_format($order['total_amount']); ?></h6>
                                            <span class="badge <?php echo $statusColor; ?> rounded-pill">
                                                <i class="fa <?php echo $statusIcon; ?> me-1"></i> <?php echo ucfirst($order['status']); ?>
                                            </span>
                                        </div>

                                    </div>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $order['id']; ?>" class="accordion-collapse collapse <?php echo $counter == 1 ? 'show' : ''; ?>" data-bs-parent="#accordionOrders">
                                <div class="accordion-body bg-light">
                                    
                                    <div class="row mb-4 bg-white p-3 rounded mx-1 border">
                                        <div class="col-md-6 border-end">
                                            <h6 class="text-muted mb-3"><i class="fa fa-user me-2"></i>Penerima</h6>
                                            <p class="mb-1 fw-bold"><?php echo $order['customer_name']; ?></p>
                                            <p class="mb-0 text-muted"><i class="fa fa-phone me-2"></i><?php echo $order['phone']; ?></p>
                                        </div>
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            <h6 class="text-muted mb-3"><i class="fa fa-map-marker-alt me-2"></i>Alamat Pengiriman</h6>
                                            <p class="mb-0"><?php echo nl2br($order['address']); ?></p>
                                        </div>
                                    </div>

                                    <div class="table-responsive bg-white rounded p-3 border">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="text-muted border-bottom">
                                                <tr>
                                                    <th scope="col">Produk</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col" class="text-center">Qty</th>
                                                    <th scope="col" class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($items as $item): ?>
                                                <tr class="border-bottom">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo $item['image']; ?>" class="img-fluid rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                                            <span class="fw-bold"><?php echo $item['name']; ?></span>
                                                        </div>
                                                    </td>
                                                    <td>Rp <?php echo number_format($item['price']); ?></td>
                                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                                    <td class="text-end fw-bold">Rp <?php echo number_format($item['subtotal']); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end text-muted pt-3">Total Pesanan</td>
                                                    <td class="text-end fw-bold fs-5 text-primary pt-3">Rp <?php echo number_format($order['total_amount']); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <?php if($order['status'] == 'pending'): ?>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-outline-danger btn-sm me-2" onclick="return confirm('Batalkan pesanan?')">Batalkan</button>
                                        <button class="btn btn-primary btn-sm">Bayar Sekarang</button>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <?php $counter++; endforeach; ?>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>