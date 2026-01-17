<?php
require_once 'includes/config.php';
require_once 'includes/functions.php'; // Pastikan functions dipanggil biar getProducts jalan
require_once 'includes/head.php';
require_once 'includes/spinner.php';
$current_page = 'shop';
require_once 'includes/navbar.php';
?>

<body>

    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Toko Kami</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Toko</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-6 mb-5">
                    <div class="col-lg-6 text-start">
                        <h1>Semua Produk Segar</h1>
                    </div>
                </div>

                <?php
                // Ambil semua produk
                $products = getProducts();
                ?>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-5 justify-content-center">
                            <div class="col-11 col-xl-12">
                                <div class="row g-4">
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <div class="col-md-6 col-lg-6 col-xl-3">
                                                <div class="rounded position-relative fruite-item">
                                                    <a href="detail_product.php?id=<?php echo $product['id']; ?>">
                                                    <div class="fruite-img">
                                                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                                            class="img-fluid w-100 rounded-top"
                                                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                                                    </div>
                                                    
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px; left: 10px;">
                                                        <?php 
                                                            // Logika: ID 1 = Buah, Lainnya = Sayur
                                                            if($product['category_id'] == 1) {
                                                                echo "Buah Segar";
                                                            } else {
                                                                echo "Sayur Segar";
                                                            }
                                                        ?>
                                                    </div>
                                                    </a>
                                                    
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                                        <p><?php echo htmlspecialchars($product['description'] ?? 'Produk organik segar berkualitas tinggi.'); ?></p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0">
                                                                Rp<?php echo number_format($product['price']); ?>
                                                            </p>
                                                            
                                                            <form action="add_to_cart.php" method="POST">
                                                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Beli
                                                                </button>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12 text-center">
                                            <p>Belum ada produk tersedia saat ini.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
require_once 'includes/footer.php'; 
?>