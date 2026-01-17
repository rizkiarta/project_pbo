<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
?>

<body>

    <div class="fixed-top bg-white shadow-sm py-2" style="z-index: 10;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="welcome.php" class="text-decoration-none">
                    <h1 class="text-primary mb-0">DariKebun</h1>
                </a>
                
                <div class="d-flex align-items-center">
                    <?php if(!isLoggedIn()): ?>
                        <a href="login.php" class="btn btn-primary border-secondary rounded-pill py-2 px-4 me-2">Masuk</a>
                        <a href="register.php" class="btn btn-outline-primary border-secondary rounded-pill py-2 px-4">Daftar</a>
                    <?php else: ?>
                        <span class="me-3">Halo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="btn btn-danger rounded-pill py-2 px-4">Keluar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid page-header py-5 mb-5 hero-header pt-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown mb-4">Segar dari Kebun, Langsung ke Meja Anda</h1>
                    <p class="fs-4 text-white mb-4 animated slideInDown">Dapatkan buah dan sayuran organik berkualitas premium dengan harga terbaik. Belanja mudah, cepat, dan segar setiap hari.</p>
                    <?php if(!isLoggedIn()): ?>
                        <a href="register.php" class="btn btn-light border-secondary rounded-pill py-3 px-5 animated slideInDown">Ayo Berbelanja</a>
                    <?php else: ?>
                        <a href="index.php" class="btn btn-light border-secondary rounded-pill py-3 px-5 animated slideInDown">Mulai Belanja</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary text-white mb-4 mx-auto">
                            <i class="fas fa-carrot fa-3x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>100% Organik</h5>
                            <p class="mb-0">Ditanam tanpa pestisida berbahaya, aman untuk keluarga Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary text-white mb-4 mx-auto">
                            <i class="fas fa-shipping-fast fa-3x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Pengiriman Cepat</h5>
                            <p class="mb-0">Pesanan diantar langsung dari kebun ke depan pintu rumah Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary text-white mb-4 mx-auto">
                            <i class="fas fa-award fa-3x"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Kualitas Terbaik</h5>
                            <p class="mb-0">Kami hanya memilih produk terbaik dan tersegar untuk Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4 text-center">
                        <h1 class="display-3 text-white">Promo Spesial Hari Ini</h1>
                        <p class="text-white mb-4">Dapatkan diskon hingga 50% untuk pembelian Sayuran Segar secara grosir. Jangan lewatkan kesempatan emas ini!</p>
                        <a href="index.php" class="btn btn-primary border-secondary rounded-pill py-3 px-5">Belanja Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="img/baner-1.png" class="img-fluid w-100 rounded" alt="Promo">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container fruite py-5">
        <div class="container-fluid py-5">
            <div class="tab-class text-center">
                <div class="row g-6 mb-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1>Produk Terlaris Kami</h1>
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
                                                        <?php 
                                                            // Logika: ID 1 = Buah, ID 2 = Sayur
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
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0 text-center">Sayuran Organik Segar</h1>
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
                                Sayur Segar
                            </div>
                            </a>
                            <div class="p-4 rounded-bottom">
                                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                <p><?php echo htmlspecialchars($product['description'] ?? 'Produk organik segar.'); ?></p>
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
                <?php
                    endforeach;
                else:
                    echo '<p class="text-center w-100">Belum ada produk sayuran tersedia.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5 px-0">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>pelanggan puas</h4>
                            <h1>1963</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>kualitas layanan</h4>
                            <h1>99%</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>sertifikat kualitas</h4>
                            <h1>33</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="counter bg-white rounded p-5">
                            <i class="fa fa-users text-secondary"></i>
                            <h4>Produk Tersedia</h4>
                            <h1>789</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid testimonial py-5 px-0">
        <div class="container py-5">
            <div class="testimonial-header text-center">
                <h4 class="text-primary">Ulasan Pelanggan</h4>
                <h1 class="display-5 mb-5 text-dark">Apa Kata Klien Kami!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
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
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 px-0">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5);">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <h1 class="text-primary mb-0">DariKebun</h1>
                            <p class="text-secondary mb-0">Kesegaran yang Bisa Kamu Percaya</p>
                        </a>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Email Anda">
                            <button type="submit" class="btn btn-primary border-0 py-3 px-5 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Langganan</button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Kenapa Memilih Kami?</h4>
                        <p class="mb-4">Kami menyediakan buah dan sayur organik segar langsung dari kebun petani lokal, tanpa pestisida kimia, untuk mendukung gaya hidup sehat Anda.</p>
                        <a href="#" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Info Toko</h4>
                        <a class="btn-link" href="#">Tentang Kami</a>
                        <a class="btn-link" href="contact.php">Hubungi Kami</a>
                        <a class="btn-link" href="">Kebijakan Privasi</a>
                        <a class="btn-link" href="">Syarat & Ketentuan</a>
                        <a class="btn-link" href="">Kebijakan Pengembalian</a>
                        <a class="btn-link" href="">Bantuan & FAQ</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Akun</h4>
                        <a class="btn-link" href="">Akun Saya</a>
                        <a class="btn-link" href="shop.php">Detail Toko</a>
                        <a class="btn-link" href="cart.php">Keranjang Belanja</a>
                        <a class="btn-link" href="">Daftar Keinginan</a>
                        <a class="btn-link" href="orders.php">Riwayat Pesanan</a>
                        <a class="btn-link" href="">Pesanan Internasional</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Kontak</h4>
                        <p>Alamat: Jl. Soekarno Hatta No. 123, Bandar Lampung</p>
                        <p>Email: info@darikebun.com</p>
                        <p>Telepon: +62 821 1234 5678</p>
                        <p>Pembayaran Diterima</p>
                        <img src="img/payment.png" class="img-fluid" alt="Metode Pembayaran">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright bg-dark py-4 px-0">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light">
                        <a href="#"><i class="fas fa-copyright text-light me-2"></i>DariKebun</a>, Hak Cipta Dilindungi.
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    Didesain Oleh <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> 
                    Didistribusikan Oleh <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top">
        <i class="fa fa-arrow-up"></i>
    </a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>

</body>
</html>