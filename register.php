<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/head.php';
// require_once 'includes/spinner.php'; // <--- SAYA MATIKAN SPINNER SUPAYA TIDAK NYANGKUT

// Jika sudah login, lempar ke home
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirm_password' => $_POST['confirm_password'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address']
    ];

    // Cek password kembar
    if ($data['password'] !== $data['confirm_password']) {
        $message = "Konfirmasi password tidak cocok!";
    } else {
        // Panggil fungsi register dari functions.php
        // Fungsi ini otomatis pakai $conn dari config.php kita yang baru
        if (registerUser($data)) {
            // Kalau sukses, langsung arahkan ke login
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='login.php';</script>";
            exit;
        } else {
            $message = "Registrasi Gagal! Email mungkin sudah terdaftar.";
        }
    }
}
?>

<body>
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Register</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="bg-light rounded p-4">
                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" placeholder="No HP" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Ulangi Password" required>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="address" rows="3" placeholder="Alamat Lengkap" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Daftar Sekarang</button>
                                </div>
                                <div class="col-12 text-center">
                                    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>