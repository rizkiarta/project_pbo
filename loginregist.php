<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - Smooth Animation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0d6efd;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background-color: white;
            border-radius: 1.2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        h3 {
            font-weight: 700;
            color: #333;
        }

        /* Tab Pills */
        .nav-pills .nav-link {
            border-radius: 0.75rem;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-pills .nav-link::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, #0d6efd, #0dcaf0);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .nav-pills .nav-link.active {
            color: white;
            background: transparent;
        }

        .nav-pills .nav-link.active::before {
            opacity: 1;
        }

        .nav-pills .nav-link:not(.active) {
            color: #555;
        }

        .nav-pills .nav-link:hover:not(.active) {
            color: #0d6efd;
            background-color: #f0f8ff;
        }

        /* Form Controls */
        .form-control {
            border-radius: 0.75rem;
            padding: 0.85rem 1.2rem;
            border: 1.5px solid #ddd;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            transform: translateY(-2px);
        }

        /* Tab Content Fade Smooth */
        .tab-pane {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Button Login dengan moving gradient */
        .btn-login {
            background: linear-gradient(270deg, #0d6efd, #0dcaf0, #0d6efd);
            background-size: 200% 200%;
            border: none;
            border-radius: 0.75rem;
            padding: 0.9rem;
            font-weight: 600;
            color: white;
            transition: all 0.4s ease;
            animation: gradientMove 6s ease infinite;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* Links */
        .forgot-password, .signup-link a {
            color: #0d6efd;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover, .signup-link a:hover {
            color: #0a58ca;
            text-decoration: underline !important;
        }

        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="text-center mb-4">Login Form</h3>

        <!-- Tabs -->
        <ul class="nav nav-pills mb-4 justify-content-center" id="loginTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button" role="tab">
                    Login
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="signup-tab" data-bs-toggle="pill" data-bs-target="#signup" type="button" role="tab">
                    Signup
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Login Panel -->
            <div class="tab-pane fade show active" id="login" role="tabpanel">
                <form>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-4 text-end">
                        <a href="#" class="text-decoration-none forgot-password">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-login">Login</button>
                </form>
            </div>

            <!-- Signup Panel -->
            <div class="tab-pane fade" id="signup" role="tabpanel">
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn w-100 btn-login">Signup</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <span class="signup-link">Not a member? <a href="#" class="text-decoration-none">Signup now</a></span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Klik "Signup now" langsung pindah ke tab Signup
        document.querySelector('.signup-link a').addEventListener('click', function(e) {
            e.preventDefault();
            const signupTab = new bootstrap.Tab(document.querySelector('#signup-tab'));
            signupTab.show();
        });
    </script>
</body>
</html>