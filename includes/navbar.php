<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'head.php';
?>

<!-- Navbar Start - FULL WIDTH -->
<div class="fixed-top" style="left: 0; right: 0; width: 100%;"> <!-- Full width, fixed -->
    <div class="container px-0"> <!-- Hapus padding container agar mentok ke tepi -->
        <nav class="navbar navbar-light bg-white navbar-expand-xl px-4 px-lg-5"> <!-- Padding hanya di dalam nav -->
            <a href="index.php" class="navbar-brand">
                <h1 class="text-primary display-6 mb-0">DariKebun</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>">Home</a>
                    <a href="shop.php" class="nav-item nav-link <?php echo ($current_page == 'shop') ? 'active' : ''; ?>">Shop</a>
                    <a href="about.php" class="nav-item nav-link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">Pesanan</a>
                    <a href="contact.php" class="nav-item nav-link <?php echo ($current_page == 'contact') ? 'active' : ''; ?>">Contact</a>
                </div>
                <div class="d-flex align-items-center m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" 
                            data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-primary"></i>
                    </button>
                    <a href="cart.php" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1 cart-count" 
                              style="top: -5px; left: 15px; height: 20px; min-width: 20px; font-size: 12px;">
                            <?php echo getCartCount(); ?>
                        </span>
                    </a>
                    <a href="#" class="my-auto">
                        <i class="fas fa-user fa-2x"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->