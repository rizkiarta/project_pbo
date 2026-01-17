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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light p-4 rounded">
                <h3 class="text-center mb-4">Register Detektif</h3>
                
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
                    <button type="submit" class="btn btn-primary w-100">DAFTAR</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="login.php">Login</a>
                </div>
            </div>
        </div>
    </div>
</body>