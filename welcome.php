<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
?>

<body>

    <!-- Judul Aplikasi Statis (Pengganti Navbar) -->
    <div class="fixed-top bg-white shadow-sm py-2" style="z-index: 10;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="welcome.php" class="text-decoration-none">
                    <h1 class="text-primary mb-0">DariKebun</h1>
                </a>
                
                <!-- Tombol Login / Register -->
                <div class="d-flex align-items-center">
                    <?php if(!isLoggedIn()): ?>
                        <a href="login.php" class="btn btn-primary border-secondary rounded-pill py-2 px-4 me-2">Login</a>
                        <a href="register.php" class="btn btn-outline-primary border-secondary rounded-pill py-2 px-4">Register</a>
                    <?php else: ?>
                        <span class="me-3">Halo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="btn btn-danger rounded-pill py-2 px-4">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Header Start -->
    <!-- Tambahkan padding-top (pt-5) agar konten tidak tertutup header -->
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
    <!-- Hero Header End -->

    <!-- About / Promo Start -->
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
    <!-- About / Promo End -->

    <!-- Banner Start -->
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4 text-center">
                        <h1 class="display-3 text-white">Promo Spesial Hari Ini</h1>
                        <p class="text-white mb-4">Dapatkan diskon hingga 50% untuk pembelian Sayuran Segar secara grosir. Jangan lewatkan kesempatan emas ini!</p>
                        <a href="register.php" class="btn btn-primary border-secondary rounded-pill py-3 px-5">Belanja Sekarang</a>
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
    <!-- Banner End -->

   <!-- Footer Start - FULL WIDTH -->
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
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Your Email">
                            <button type="submit" class="btn btn-primary border-0 py-3 px-5 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
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
                        <h4 class="text-light mb-3">Why People Like us!</h4>
                        <p class="mb-4">Kami menyediakan buah dan sayur organik segar langsung dari kebun petani lokal, tanpa pestisida kimia, untuk mendukung gaya hidup sehat Anda.</p>
                        <a href="#" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Shop Info</h4>
                        <a class="btn-link" href="#">About Us</a>
                        <a class="btn-link" href="contact.php">Contact Us</a>
                        <a class="btn-link" href="">Privacy Policy</a>
                        <a class="btn-link" href="">Terms & Condition</a>
                        <a class="btn-link" href="">Return Policy</a>
                        <a class="btn-link" href="">FAQs & Help</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        <a class="btn-link" href="">My Account</a>
                        <a class="btn-link" href="shop.php">Shop Details</a>
                        <a class="btn-link" href="cart.php">Shopping Cart</a>
                        <a class="btn-link" href="">Wishlist</a>
                        <a class="btn-link" href="orders.php">Order History</a>
                        <a class="btn-link" href="">International Orders</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: Jl. Soekarno Hatta No. 123, Bandar Lampung</p>
                        <p>Email: info@darikebun.com</p>
                        <p>Phone: +62 821 1234 5678</p>
                        <p>Payment Accepted</p>
                        <img src="img/payment.png" class="img-fluid" alt="Payment Methods">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start - FULL WIDTH -->
    <div class="container-fluid copyright bg-dark py-4 px-0">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light">
                        <a href="#"><i class="fas fa-copyright text-light me-2"></i>DariKebun</a>, All rights reserved.
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> 
                    Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top">
        <i class="fa fa-arrow-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>
</html>