<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';

// Jika sudah login, arahkan ke home
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

 $message = "";
 $msgType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Panggil fungsi login
    if (loginUser($email, $password)) {
        // Cek apakah ada keranjang di session yang perlu disimpan atau merge (opsional, untuk sekarang direct saja)
        header("Location: index.php");
        exit;
    } else {
        $message = "Email atau password salah!";
        $msgType = "danger";
    }
}
?>

<body>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Login</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="welcome.php" class="text-white">kembali</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Login Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4 text-center">Login Akun</h4>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Alamat Email" required>
                                <label for="email">Alamat Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary border-secondary rounded-pill py-3 px-5 w-100" type="submit">Login</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">Belum punya akun? <a href="register.php" class="text-primary fw-bold">Register disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->

<?php require_once 'includes/footer.php'; ?>