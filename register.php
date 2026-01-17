<?php
// register.php - VERSI ANTI-LOADING
require_once 'includes/config.php';
require_once 'includes/functions.php'; // <--- Kalau ini error, halaman bakal putih
require_once 'includes/head.php';

// 1. MATIKAN SPINNER (Kasih tanda // di depan)
// require_once 'includes/spinner.php'; 

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
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
        $message = "Password konfirmasi tidak cocok!";
    } else {
        // Coba jalankan fungsi register
        // Kalau functions.php rusak, dia akan error di baris ini
        $result = registerUser($data);

        if ($result) {
            // Pake Javascript biar gak mental
            echo "<script>
                alert('Registrasi Berhasil! Silakan Login.');
                window.location.href = 'login.php';
            </script>";
            exit;
        } else {
            $message = "Gagal Register! Email mungkin sudah dipakai.";
        }
    }
}
?>

<body>
    <div class="container py-5">
        <h2 class="text-center mb-4">Daftar Akun Baru</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($message): ?>
                    <div class="alert alert-danger"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="" method="POST" class="bg-light p-4 rounded shadow">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>No HP</label>
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
                    
                    <button type="submit" class="btn btn-success w-100 py-2">Daftar Sekarang</button>
                    
                    <div class="mt-3 text-center">
                        <a href="login.php">Sudah punya akun? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>