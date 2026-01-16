<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
$current_page = 'about'; // Untuk active menu di navbar
?>
<?php require_once 'includes/navbar.php'; ?>

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5">
    <div class="container py-5">
        <h1 class="display-3 text-white mb-3 animated slideInDown">About Us</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb text-uppercase">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">About</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-12">
                        <img class="img-fluid rounded w-100" src="img/best-product-4.jpg" alt="Fruitables Store">
                    </div>
                    <div class="col-6">
                        <img class="img-fluid rounded w-100" src="img/best-product-2.jpg" alt="Fresh Fruits">
                    </div>
                    <div class="col-6">
                        <img class="img-fluid rounded w-100" src="img/best-product-5.jpg" alt="Organic Vegetables">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="mb-4">Welcome to <span class="text-primary">Fruitables</span></h1>
                <p class="mb-4">Fruitables adalah toko organik yang menyediakan buah dan sayur segar berkualitas tinggi langsung dari petani lokal. Kami berkomitmen menghadirkan produk alami tanpa pestisida kimia untuk mendukung gaya hidup sehat Anda dan keluarga.</p>
                <p class="mb-4">Setiap produk kami dipilih dengan teliti, dipanen pada waktu yang tepat, dan dikirim dengan cepat agar tetap segar sampai di tangan Anda.</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check fa-2x text-primary me-3"></i>
                            <h5>100% Organik</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check fa-2x text-primary me-3"></i>
                            <h5>Harga Terjangkau</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check fa-2x text-primary me-3"></i>
                            <h5>Pengiriman Cepat</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-check fa-2x text-primary me-3"></i>
                            <h5>Layanan 24/7</h5>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary rounded-pill py-3 px-5" href="shop.php">Belanja Sekarang</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Fact Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="bg-light p-5 rounded">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-users text-secondary"></i>
                        <h4>Pelanggan Puas</h4>
                        <h1>5000+</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-apple-alt text-secondary"></i>
                        <h4>Produk Organik</h4>
                        <h1>100%</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-truck text-secondary"></i>
                        <h4>Pengiriman Cepat</h4>
                        <h1>24 Jam</h1>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fa fa-leaf text-secondary"></i>
                        <h4>Petani Lokal</h4>
                        <h1>150+</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fact End -->

<?php require_once 'includes/footer.php'; ?>