<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
 $current_page = 'orders';
require_once 'includes/navbar.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

 $user_id = $_SESSION['user_id'];
 $orders = getUserOrders($user_id);
?>

<body>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">My Orders</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Orders</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Orders Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            
            <!-- Notifikasi Status -->
            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i> Pesanan berhasil dibuat!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif($_GET['status'] == 'cancelled'): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i> Pesanan berhasil dibatalkan.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif($_GET['status'] == 'paid'): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fa fa-money-bill-wave me-2"></i> Pembayaran berhasil! Pesanan sedang diproses.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif($_GET['status'] == 'completed'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-smile-beam me-2"></i> Terima kasih! Pesanan telah selesai.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (empty($orders)): ?>
                <div class="text-center py-5 bg-light rounded">
                    <h4 class="mb-3">Belum ada riwayat pesanan.</h4>
                    <a href="index.php" class="btn btn-primary border-secondary rounded-pill px-4 py-3">Mulai Belanja</a>
                </div>
            <?php else: ?>
                
                <div class="accordion" id="accordionOrders">
                    <?php $counter = 1; ?>
                    <?php foreach ($orders as $order): ?>
                        <?php 
                            $order_items = getOrderItems($order['id']);
                            $collapseId = "collapse" . $order['id'];
                            $headingId = "heading" . $order['id'];
                            
                            // Logika Warna Badge
                            $badgeClass = 'bg-secondary';
                            $textBadge = 'text-dark';
                            if($order['status'] == 'pending') { $badgeClass = 'bg-warning'; $textBadge = 'text-dark'; }
                            elseif($order['status'] == 'paid') { $badgeClass = 'bg-info'; $textBadge = 'text-dark'; }
                            elseif($order['status'] == 'shipped') { $badgeClass = 'bg-primary'; $textBadge = 'text-white'; }
                            elseif($order['status'] == 'completed') { $badgeClass = 'bg-success'; $textBadge = 'text-white'; }
                            elseif($order['status'] == 'cancelled') { $badgeClass = 'bg-danger'; $textBadge = 'text-white'; }
                        ?>
                        
                        <div class="accordion-item mb-3 border rounded shadow-sm overflow-hidden">
                            <h2 class="accordion-header" id="<?php echo $headingId; ?>">
                                <button class="accordion-button bg-light <?php echo $counter > 1 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="<?php echo $counter == 1 ? 'true' : 'false'; ?>" aria-controls="<?php echo $collapseId; ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold me-2">Order #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?></span>
                                            <small class="text-muted ms-2">
                                                <i class="fa fa-clock-o"></i> <?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?>
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge <?php echo $badgeClass . ' ' . $textBadge; ?> me-3">
                                                <?php echo ucfirst($order['status']); ?>
                                            </span>
                                            <span class="fw-bold text-primary">
                                                Rp <?php echo number_format($order['total_amount']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse <?php echo $counter == 1 ? 'show' : ''; ?>" aria-labelledby="<?php echo $headingId; ?>" data-bs-parent="#accordionOrders">
                                <div class="accordion-body bg-white">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Informasi Penerima</h5>
                                            <p class="mb-1"><strong>Nama:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                            <p class="mb-1"><strong>Telepon:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                                            <p class="mb-1"><strong>Alamat:</strong> <?php echo nl2br(htmlspecialchars($order['address'])); ?></p>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <h5 class="mb-3">Status Pesanan</h5>
                                            
                                            <?php if($order['status'] == 'pending'): ?>
                                                <a href="pay_order.php?id=<?php echo $order['id']; ?>" class="btn btn-success rounded-pill px-4 mb-2" onclick="return confirm('Lanjutkan pembayaran?')">Bayar Sekarang</a>
                                                <a href="cancel_order.php?id=<?php echo $order['id']; ?>" class="btn btn-outline-danger rounded-pill px-4 mb-2" onclick="return confirm('Batalkan pesanan?')">Batalkan</a>
                                            
                                            <?php elseif($order['status'] == 'paid'): ?>
                                                <button class="btn btn-info text-white rounded-pill px-4 mb-2" disabled>Pesanan Diproses</button>
                                                <p class="small text-muted">Admin sedang menyiapkan barangmu.</p>

                                            <?php elseif($order['status'] == 'shipped'): ?>
                                                <!-- TOMBOL BARU: PESANAN DITERIMA -->
                                                <a href="complete_order.php?id=<?php echo $order['id']; ?>" class="btn btn-primary rounded-pill px-4 mb-2" onclick="return confirm('Apakah barang sudah kamu terima? Klik ini untuk menyelesaikan pesanan.')">
                                                    <i class="fa fa-check me-2"></i> Pesanan Diterima
                                                </a>
                                                <p class="small text-muted">Barang sedang dalam perjalanan kurir.</p>

                                            <?php elseif($order['status'] == 'completed'): ?>
                                                <button class="btn btn-success rounded-pill px-4 mb-2" disabled><i class="fa fa-check-circle me-2"></i> Selesai</button>
                                                <p class="small text-muted">Terima kasih telah berbelanja!</p>
                                            
                                            <?php elseif($order['status'] == 'cancelled'): ?>
                                                <button class="btn btn-danger rounded-pill px-4 mb-2" disabled>Dibatalkan</button>
                                                <p class="small text-muted">Pesanan ini dibatalkan.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <h5 class="mb-3">Detail Produk</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th style="width: 80px;">Gambar</th>
                                                    <th>Produk</th>
                                                    <th class="text-center">Harga</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach ($order_items as $item): ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td>
                                                            <img src="<?php echo htmlspecialchars($item['image']); ?>" class="img-fluid rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                                        </td>
                                                        <td>
                                                            <span class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></span>
                                                        </td>
                                                        <td class="text-center">Rp <?php echo number_format($item['price']); ?></td>
                                                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                                                        <td class="text-end">Rp <?php echo number_format($item['subtotal']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="text-end">Total Bayar</th>
                                                    <th class="text-end text-primary">Rp <?php echo number_format($order['total_amount']); ?></th>
                                                </tr>
                                            </tfoot>
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
    <!-- Orders End -->

<?php require_once 'includes/footer.php'; ?>