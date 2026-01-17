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
 $msgType = ""; // success atau danger

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi sederhana
    if ($password !== $confirm_password) {
        $message = "Konfirmasi password tidak cocok!";
        $msgType = "danger";
    } elseif (strlen($password) < 6) {
        $message = "Password minimal 6 karakter!";
        $msgType = "danger";
    } else {
        // Panggil fungsi register
        if (registerUser($name, $email, $password)) {
            $message = "Pendaftaran berhasil! Silakan login.";
            $msgType = "success";
        } else {
            $message = "Email sudah terdaftar atau terjadi kesalahan.";
            $msgType = "danger";
        }
    }
}
?>

<body>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Register</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="welcome.php" class="text-white">kembali</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->

    <!-- Register Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4 text-center">Buat Akun Baru</h4>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control border-0" id="name" name="name" placeholder="Nama Lengkap" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                                <label for="name">Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control border-0" id="email" name="email" placeholder="Alamat Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                <label for="email">Alamat Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                                <label for="confirm_password">Konfirmasi Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary border-secondary rounded-pill py-3 px-5 w-100" type="submit">Register</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">Sudah punya akun? <a href="login.php" class="text-primary fw-bold">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->

<?php require_once 'includes/footer.php'; ?>