<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';
// require_once 'includes/spinner.php'; // <--- SPINNER DIMATIKAN

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Panggil fungsi login
    // Karena config.php sudah punya $conn, fungsi ini pasti jalan
    if (loginUser($email, $password)) {
        // Redirect pakai Javascript biar lebih kuat
        echo "<script>window.location.href='index.php';</script>";
        exit;
    } else {
        $message = "Email atau password salah!";
    }
}
?>

<body>
        <div class="container mt-5">
            <div class="text-center">
                <a href="welcome.php" class="">
                    <h1 class="text-primary fw-bold">DariKebun</h1>
                </a>
            </div>
        </div>
    <div class="container-fluid page-header py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Login</h1>
        </div>
    </div>

    <div class="container-fluid py-0 mb-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-light rounded p-5">
                        <h4 class="mb-5 text-center fw-bold">Login Akun</h4>

                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-4">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fs-5 text-light">Masuk</button>
                        </form>
                        <div class="text-center mt-4">
                            Belum punya akun?
                            <a href="register.php" class="fw-bold">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright bg-dark py-4 mb-0">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>

</body>
</html>