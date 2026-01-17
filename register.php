<?php
// register.php - MODE DETEKTIF (Tampilkan Semua Error)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/config.php';

// Cek apakah functions.php aman
if (!file_exists('includes/functions.php')) {
    die("FATAL ERROR: File includes/functions.php TIDAK DITEMUKAN!");
}
require_once 'includes/functions.php';
require_once 'includes/head.php';

// SPINNER DIMATIKAN LEWAT KODE JUGA
// require_once 'includes/spinner.php'; 

// Jika sudah login, lempar ke home
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address']
    ];

    if ($data['password'] !== $data['confirm_password']) {
        $message = "Password tidak sama!";
    } else {
        // Panggil fungsi register
        // Kalau functions.php error, dia akan berhenti di sini dan menampilkan pesan error
        if (function_exists('registerUser')) {
            if (registerUser($data)) {
                echo "<script>alert('Berhasil! Silakan Login'); window.location.href='login.php';</script>";
                exit;
            } else {
                $message = "Gagal Register (Mungkin email sudah dipakai).";
            }
        } else {
            die("FATAL ERROR: Fungsi 'registerUser' TIDAK DITEMUKAN di functions.php. Cek file functions.php kamu!");
        }
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Daftar</h1>
        </div>
    </div>

    <div class="container-fluid py-0 mb-4">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-light rounded p-5">
                        <h4 class="mb-4 text-center fw-bold">Daftar Akun</h4>

                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php endif; ?>

<form action="" method="POST">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>HP</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Ulangi Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 text-light">Daftar</button>
                </form>
                        <div class="text-center mt-4">
                            Sudah punya akun?
                            <a href="login.php" class="fw-bold">Masuk</a>
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