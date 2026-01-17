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
$current_page = 'orders';
?>

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid page-header py-5 mb-5">
    <div class="container text-center py-5">
        <h1 class="display-3 text-white mb-3">Riwayat Pesanan</h1>
        <nav aria-label="breadcrumb">
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
                        <a href="index.php" class="btn btn-primary rounded-pill px-5 py-3">Mulai Belanja</a>
                    </div>
                <?php else: ?>

                    <h3 class="mb-4">Daftar Transaksi Kamu</h3>

                    <div class="accordion" id="accordionOrders">
                        <?php 
                        $counter = 1; 
                        foreach ($orders as $order): 
                            $items = getOrderItems($order['id']);
                            
                            // LOGIKA STATUS & WARNA
                            $statusLabel = ucfirst($order['status']);
                            $statusColor = 'bg-secondary';
                            
                            if($order['status'] == 'pending') { 
                                $statusLabel = 'Menunggu Pembayaran'; 
                                $statusColor = 'bg-warning text-dark'; 
                            }
                            elseif($order['status'] == 'shipped') { 
                                // INI REQUEST KAMU: Kalo sudah bayar -> Siap Diantar
                                $statusLabel = 'SIAP DIANTAR 🛵'; 
                                $statusColor = 'bg-primary text-white'; 
                            }
                            elseif($order['status'] == 'completed') { 
                                $statusLabel = 'Selesai'; 
                                $statusColor = 'bg-success text-white'; 
                            }
                            elseif($order['status'] == 'cancelled') { 
                                $statusColor = 'bg-danger text-white'; 
                            }
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
                                                <h6 class="mb-0 fw-bold">Order #<?php echo $order['id']; ?></h6>
                                                <small class="text-muted"><?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?></small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="mb-1 text-primary fw-bold">Rp <?php echo number_format($order['total_amount']); ?></h6>
                                            <span class="badge <?php echo $statusColor; ?> rounded-pill">
                                                <?php echo $statusLabel; ?>
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $order['id']; ?>" class="accordion-collapse collapse <?php echo $counter == 1 ? 'show' : ''; ?>" data-bs-parent="#accordionOrders">
                                <div class="accordion-body bg-light">
                                    
                                    <div class="row mb-4 bg-white p-3 rounded mx-1 border">
                                        <div class="col-md-6 border-end">
                                            <small class="text-muted">Penerima</small>
                                            <p class="mb-0 fw-bold"><?php echo $order['customer_name']; ?></p>
                                            <p class="mb-0 text-muted"><?php echo $order['phone']; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <small class="text-muted">Alamat</small>
                                            <p class="mb-0"><?php echo nl2br($order['address']); ?></p>
                                        </div>
                                    </div>

                                    <div class="table-responsive bg-white rounded p-3 border">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="text-muted border-bottom">
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Harga</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($items)): ?>
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
                                                <?php else: ?>
                                                    <tr><td colspan="4" class="text-center text-muted">Detail produk tidak tersedia.</td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php if($order['status'] == 'pending'): ?>
                                    <div class="text-end mt-3">
                                        <a href="pay_order.php?id=<?php echo $order['id']; ?>" class="btn btn-success rounded-pill px-4" onclick="return confirm('Bayar pesanan ini sekarang?')">
                                            <i class="fa fa-wallet me-2"></i> Bayar Sekarang
                                        </a>
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