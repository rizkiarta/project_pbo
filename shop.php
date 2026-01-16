<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
$current_page = 'shop';
require_once 'includes/navbar.php';
?>

<body>

    <!-- Single Page Header start -->
<div class="container-fluid page-header py-5 mb-5">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Shop</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Shop</li>
            </ol>
        </nav>
    </div>
</div>
    <!-- Single Page Header End -->


<!-- Fruits Shop Start -->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-6 mb-5">
                <div class="col-lg-6 text-start">
                    <h1>Our Best Seller Products</h1>
                </div>
            </div>

            <?php
            $products = getProducts();
            ?>

            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                        <div class="col-md-6 col-lg-6 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                                        class="img-fluid w-100 rounded-top"
                                                        alt="<?php echo htmlspecialchars($product['name']); ?>">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">
                                                    <?php echo htmlspecialchars($product['category_name']); ?>
                                                </div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">
                                                            Rp<?php echo number_format($product['price']); ?>
                                                        </p>
                                                        <button type="button" class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart-btn"
                                                            data-product-id="<?php echo $product['id']; ?>">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-center">
                                        <p>Belum ada produk tersedia.</p>
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
<!-- Fruits Shop End -->


<?php
require_once 'includes/footer.php'; 
?>