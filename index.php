<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';

// Cek Login: Jika belum login, tendang ke welcome.php
if (!isLoggedIn()) {
    header("Location: welcome.php");
    exit;
}

 $current_page = 'home';
?>
<?php include 'includes/navbar.php'; ?>

<!-- Hero Start - FULL WIDTH -->
<div class="container-fluid py-5 mb-5 hero-header px-0">
    <div class="container py-5 px-0">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7 px-5">
                <h4 class="mb-3 text-secondary">100% Organik</h4>
                <h1 class="mb-5 display-3 text-primary">Hidup Sehat dengan Organik Segar</h1>
            </div>
            <div class="col-md-12 col-lg-5 px-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Sayur Segar">
                            <a href="#" class="btn px-2 py-2 text-white rounded position-absolute">Sayur Segar</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="img/hero-img-1.png" class="img-fluid w-500 h-100 rounded" alt="Buah Segar">
                            <a href="#" class="btn px-2 py-2 text-white rounded position-absolute">Buah Segar</a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Best Seller Products -->
<div class="container fruite py-5">
    <div class="container-fluid py-5">
        <div class="tab-class text-center">
            <div class="row g-6 mb-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1>Our Best Seller Products</h1>
                </div>
            </div>

            <?php
            $fruits     = getProducts(4, 'fruits');
            $vegetables = getProducts(4, 'vegetables');
            $products = array_merge($fruits, $vegetables);
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
                                                        <?php echo htmlspecialchars($product['category_name']); ?>
                                                    </div>
                                                    </a>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                                        <p><?php echo htmlspecialchars($product['description'] ?? 'Produk organik segar berkualitas tinggi.'); ?></p>
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
<!-- Best Seller End -->

<!-- Banner Section-->
<div class="container-fluid banner bg-secondary my-5 px-0">
    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 px-5">
                <div class="py-4">
                    <h1 class="display-3 text-white">Dari Kebun Lokal</h1>
                    <p class="fw-normal display-3 text-dark mb-4">ke Rumah Anda</p>
                    <p class="mb-4 text-dark">Mendukung petani lokal sambil menghadirkan produk segar setiap hari tanpa perantara dan harga yang transparan.</p>
                    <a href="shop.php" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BELI</a>
                </div>
            </div>
            <div class="col-lg-6 px-5">
                <div class="position-relative">
                    <img src="img/baner-1.png" class="img-fluid w-100 rounded" alt="">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                        <h1 style="font-size: 100px;">1</h1>
                        <div class="d-flex flex-column">
                            <span class="h2 mb-0">Rp25.000</span>
                            <span class="h4 text-muted mb-0">kg</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Vegetables Carousel - FULL WIDTH -->
<div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0 text-center">Fresh Organic Vegetables</h1>
        <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php
            $vegetables = getProducts(8, 'vegetables');
            if (!empty($vegetables)):
                foreach ($vegetables as $product):
            ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <a href="detail_product.php?id=<?php echo $product['id']; ?>">
                        <div class="vesitable-img">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                class="img-fluid w-100 rounded-top"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                            style="top: 10px; right: 10px;">
                            <?php echo htmlspecialchars($product['category_name']); ?>
                        </div>
                        </a>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p><?php echo htmlspecialchars($product['description'] ?? 'Produk organik segar berkualitas tinggi.'); ?></p>
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
            <?php
                endforeach;
            else:
                echo '<p class="text-center w-100">Belum ada produk sayuran tersedia.</p>';
            endif;
            ?>
        </div>
    </div>
</div>
<!-- Vegetables End -->

<!-- Fact Start - FULL WIDTH -->
<div class="container-fluid py-5 px-0">
    <div class="container">
        <div class="bg-light p-5 rounded">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>satisfied customers</h4>
                        <h1>1963</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>quality of service</h4>
                        <h1>99%</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>quality certificates</h4>
                        <h1>33</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Available Products</h4>
                        <h1>789</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fact End -->

<!-- Testimonial Start - FULL WIDTH -->
<div class="container-fluid testimonial py-5 px-0">
    <div class="container py-5">
        <div class="testimonial-header text-center">
            <h4 class="text-primary">Ulasan Pelanggan</h4>
            <h1 class="display-5 mb-5 text-dark">Ulasan dari Klien Kami!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <!-- Testimonial items (sama seperti asli) -->
             <!-- testimonial item 1 -->
            <div class="testimonial-item img-border-radius bg-light rounded p-4 mx-3">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">“Buahnya segar semua, tidak ada yang busuk. Pengiriman cepat dan packing rapi. Anak-anak di rumah suka banget. Pasti order lagi!”</p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/Testimonial/Client1.jpg" class="img-fluid rounded" style="width: 120px; height: 120px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Rina Oktaviani</h4>
                            <p class="m-0 pb-3">Ibu Rumah Tangga</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              <!-- Tambahkan item testimonial lain kalau ada -->
               <!-- testimonial item 2 -->
                <div class="testimonial-item img-border-radius bg-light rounded p-4 mx-3">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">“Saya pesan apel dan jeruk, semuanya segar dan berkualitas. Anak-anak di sekolah juga suka.”</p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/Testimonial/Client2.jpg" class="img-fluid rounded" style="width: 120px; height: 120px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Dewi Lestari</h4>
                            <p class="m-0 pb-3">Guru</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan item testimonial lain kalau ada -->
             <!-- testimonial item 3 -->
              <div class="testimonial-item img-border-radius bg-light rounded p-4 mx-3">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">Sangat puas dengan hasil kerjanya. Detail diperhatikan dengan baik dan hasil akhir sesuai ekspektasi. Cocok untuk kerja sama jangka panjang.</p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/Testimonial/Client3.jpg" class="img-fluid rounded" style="width: 120px; height: 120px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Nathania</h4>
                            <p class="m-0 pb-3">Ibu Rumah Tangga</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan item testimonial lain kalau ada -->
              <!-- testimonial item 4 -->
              <div class="testimonial-item img-border-radius bg-light rounded p-4 mx-3">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">“Harga terjangkau untuk kualitas sebagus ini. Cocok buat anak kos yang mau hidup lebih sehat.”</p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/Testimonial/Client4.jpg" class="img-fluid rounded" style="width: 120px; height: 120px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Bagus Pratama</h4>
                            <p class="m-0 pb-3">Mahasiswa</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan item testimonial lain kalau ada -->
              <!-- testimonial item 5  -->
              <div class="testimonial-item img-border-radius bg-light rounded p-4 mx-3">
                <div class="position-relative">
                    <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                    <div class="mb-4 pb-4 border-bottom border-secondary">
                        <p class="mb-0">“Pelayanan yang diberikan sangat memuaskan. Website yang dibuat rapi, mudah digunakan, dan sesuai dengan kebutuhan saya. Prosesnya juga cepat dan komunikatif."</p>
                    </div>
                    <div class="d-flex align-items-center flex-nowrap">
                        <div class="bg-secondary rounded">
                            <img src="img/Testimonial/Client5.jpg" class="img-fluid rounded" style="width: 120px; height: 120px;" alt="">
                        </div>
                        <div class="ms-4 d-block">
                            <h4 class="text-dark">Andi Pratama</h4>
                            <p class="m-0 pb-3">Mahasiswa</p>
                            <div class="d-flex pe-5">
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                                <i class="fas fa-star text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tambahkan item testimonial lain kalau ada -->
        </div>
    </div>
</div>
<!-- Testimonial End -->

<!-- Footer - sudah full-width dari template -->
<?php include 'includes/footer.php'; ?>