<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
require_once 'includes/functions.php';

$current_page = 'shop';

// Cek parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: shop.php');
    exit();
}

$product_id = (int)$_GET['id'];
$product = getProductById($product_id);

if (!$product) {
    header('Location: shop.php');
    exit();
}

require_once 'includes/navbar.php';
?>

<body>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Detail Produk</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="shop.php" class="text-white">Shop</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->
    
    <!-- Single Product Start -->
    <div class="container-fluid align-items-center py-5">
        <div class="container py-5">
            <div class="row g-4 mb-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     class="img-fluid rounded" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p class="mb-3">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                            <h5 class="fw-bold mb-3">Rp<?php echo number_format($product['price']); ?></h5>
                            
                            <!-- Tampilkan stock -->
                            <div class="mb-3">
                                <p><strong>Stock Tersedia:</strong> <?php echo $product['stock']; ?> unit</p>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star text-secondary"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <p class="mb-4"><?php echo htmlspecialchars($product['description'] ?? 'Produk organik segar berkualitas tinggi.'); ?></p>
                            
                            <div class="input-group quantity mb-5" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="#" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary add-to-cart-btn"
                               data-product-id="<?php echo $product['id']; ?>">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                            </a>
                        </div>
                        
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">Description</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p><?php echo htmlspecialchars($product['description'] ?? 'Deskripsi produk akan segera ditambahkan.'); ?></p>
                                    
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Category</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?php echo htmlspecialchars($product['category_name']); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Price</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Rp<?php echo number_format($product['price']); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Stock</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?php echo $product['stock']; ?> unit</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->

    <?php
    require_once 'includes/footer.php';
    ?>
</body>
</html>