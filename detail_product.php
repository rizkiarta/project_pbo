<?php
require_once 'includes/config.php';
require_once 'includes/functions.php'; // Pastikan functions ada
require_once 'includes/head.php';
require_once 'includes/spinner.php';

$current_page = 'shop';

// Cek parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='shop.php';</script>";
    exit();
}

$product_id = (int)$_GET['id'];
$product = getProductById($product_id);

// Kalau produk tidak ditemukan
if (!$product) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='shop.php';</script>";
    exit();
}

require_once 'includes/navbar.php';
?>

<body>
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Detail Produk</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="shop.php" class="text-white">Toko</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                
                <div class="col-lg-6">
                    <div class="border rounded shadow-sm">
                        <a href="#">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded w-100" alt="Gambar <?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h4>
                    <p class="mb-3 text-muted">Kategori: 
                        <span class="text-primary fw-bold">
                            <?php echo ($product['category_id'] == 1) ? 'Buah Segar' : 'Sayur Segar'; ?>
                        </span>
                    </p>
                    <h5 class="fw-bold mb-3 text-dark fs-2">Rp <?php echo number_format($product['price']); ?></h5>
                    
                    <div class="d-flex mb-4">
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-secondary"></i>
                        <span class="ms-2 text-muted">(12 Ulasan)</span>
                    </div>

                    <p class="mb-4 text-secondary">
                        <?php echo htmlspecialchars($product['description'] ?? 'Deskripsi produk ini belum tersedia. Namun kami menjamin kesegaran dan kualitasnya.'); ?>
                    </p>

                    <div class="mb-4 p-3 bg-light rounded border">
                        <p class="mb-0 text-dark"><i class="fa fa-check-circle text-success me-2"></i>Stok Tersedia: <strong><?php echo $product['stock']; ?> kg</strong></p>
                    </div>

                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        
                        <div class="input-group quantity mb-4" style="width: 150px;">
                            <span class="input-group-text">Qty</span>
                            <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="<?php echo $product['stock']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary border-secondary rounded-pill px-5 py-3 text-white">
                            <i class="fa fa-shopping-bag me-2"></i> Masukkan Keranjang
                        </button>
                    </form>

                </div>
                
                <div class="col-lg-12 mt-5">
                    <nav>
                        <div class="nav nav-tabs mb-3">
                            <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                aria-controls="nav-about" aria-selected="true">Spesifikasi</button>
                            <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                aria-controls="nav-mission" aria-selected="false">Ulasan</button>
                        </div>
                    </nav>
                    <div class="tab-content mb-5">
                        <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Berat</th>
                                                <td>1 kg</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Negara Asal</th>
                                                <td>Indonesia (Lokal)</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kualitas</th>
                                                <td>Organik</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kategori</th>
                                                <td><?php echo ($product['category_id'] == 1) ? 'Buah-buahan' : 'Sayuran'; ?></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kesehatan</th>
                                                <td>Bebas Pestisida</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded" style="width: 150px; height: 150px; object-fit: cover;" alt="">
                                        <div class="ms-4">
                                            <h5 class="fw-bold">Jaminan Segar</h5>
                                            <p class="mb-0">Kami menjamin produk dikirim dalam keadaan segar langsung dari kebun mitra kami.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                            <div class="d-flex">
                                <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                <div class="">
                                    <p class="mb-2" style="font-size: 14px;">14 April 2025</p>
                                    <div class="d-flex justify-content-between">
                                        <h5>Budi Santoso</h5>
                                        <div class="d-flex mb-3">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <p>Produk sangat segar dan pengiriman cepat. Sangat puas belanja di sini!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>