<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
 $current_page = 'shop';
require_once 'includes/navbar.php';

// Cek Login
if (!isLoggedIn()) {
    header("Location: login.php"); 
    exit;
}

// Panggil Fungsi
 $cart_items = getCartItems();

if (empty($cart_items)) {
    header("Location: index.php");
    exit;
}

 $cart_total = getCartTotal();
 $shipping = getShippingFee();
 $grand_total = getCartTotal() + $shipping;
?>

<body>

    <!-- Single Page Header start -->
<div class="container-fluid page-header py-5 mb-5">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Checkout</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                <li class="breadcrumb-item"><a href="cart.php" class="text-white">Cart</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>
    <!-- Single Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-5">
                
                <!-- Kolom Kiri: Form Checkout -->
                <div class="col-md-12 col-lg-8 col-xl-8">
                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4">Detail Pengiriman</h4>
                        <form action="process_order.php" method="POST">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="name" name="name" placeholder="Nama Lengkap" required value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>">
                                        <label for="name">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="email" placeholder="Email" value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>" readonly style="background-color: #e9ecef;">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="phone" name="phone" placeholder="No. Telepon / WhatsApp" required>
                                        <label for="phone">No. Telepon / WhatsApp</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Alamat Lengkap" id="address" name="address" style="height: 150px" required></textarea>
                                        <label for="address">Alamat Lengkap (Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Catatan Tambahan (Opsional)" id="notes" name="notes" style="height: 100px"></textarea>
                                        <label for="notes">Catatan Kurir (Warna rumah, patokan, dll)</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary border-secondary rounded-pill py-3 px-5 text-white w-100" type="submit">Place Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan -->
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4">Ringkasan Pesanan</h4>
                        
                        <div class="border-bottom pb-3 mb-3">
                            <?php foreach($cart_items as $item): ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted"><?php echo htmlspecialchars($item['name']); ?> x<?php echo $item['quantity']; ?></span>
                                    <span class="small fw-bold">Rp <?php echo number_format($item['subtotal']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0">Rp <?php echo number_format($cart_total); ?></p>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Shipping:</h5>
                            <p class="mb-0">Rp <?php echo number_format($shipping); ?></p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mt-4">
                            <h5 class="mb-0 me-4">Total Bayar:</h5>
                            <p class="mb-0 fw-bold text-primary">Rp <?php echo number_format($grand_total); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

<?php require_once 'includes/footer.php'; ?>