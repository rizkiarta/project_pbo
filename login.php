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
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Login</h1>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-light rounded p-4">
                        <h4 class="mb-4 text-center">Login Akun</h4>
                        
                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3">Masuk</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php">Belum punya akun? Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>