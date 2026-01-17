<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
// [PENTING] Baris ini wajib ada biar desainnya muncul
require_once 'includes/head.php'; 
require_once 'includes/spinner.php'; 

$current_page = 'contact'; 
require_once 'includes/navbar.php'; 
?>

<body>
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Hubungi Kami</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Kontak</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kontak Kami</h6>
                <h1 class="mb-5">Hubungi Kami Untuk Pertanyaan</h1>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="row gy-4">
                        <div class="col-md-4">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 text-center rounded">
                                <i class="fa fa-map-marker-alt fa-3x text-primary mb-4"></i>
                                <h5>Alamat</h5>
                                <p class="mb-0">Jl. Soekarno Hatta No. 123, Bandar Lampung</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 text-center rounded">
                                <i class="fa fa-phone-alt fa-3x text-primary mb-4"></i>
                                <h5>Telepon</h5>
                                <p class="mb-0">+62 821 1234 5678</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light d-flex flex-column justify-content-center p-4 text-center rounded">
                                <i class="fa fa-envelope fa-3x text-primary mb-4"></i>
                                <h5>Email</h5>
                                <p class="mb-0">info@darikebun.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <div class="mb-4 text-center">
                        <h2 class="text-primary mb-4">Mengapa Menghubungi Kami?</h2>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-4 mb-2 fs-5 fw-bold ">
                                <i class="fa fa-check-circle text-primary me-2"></i>
                                Respon Cepat (≤ 1×24 jam)
                            </div>
                            <div class="col-12 col-md-4 mb-2 fs-5 fw-bold">
                                <i class="fa fa-check-circle text-primary me-2"></i>
                                Konsultasi Gratis
                            </div>
                            <div class="col-12 col-md-4 mb-2 fs-5 fw-bold">
                                <i class="fa fa-check-circle text-primary me-2"></i>
                                Data Anda Aman & Terjaga
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                    <iframe
                        class="rounded w-100"
                        style="height: 450px;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.227276497743!2d105.2572!3d-5.3812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMjInNTIuMyJTIDEwNcKwMTUnMjUuOSJF!5e0!3m2!1sen!2sid!4v1632987654321!5m2!1sen!2sid"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <p class="mb-4">
                            Silakan isi formulir di bawah ini untuk menghubungi kami. Tim kami akan merespons pesan Anda secepat mungkin!
                        </p>

                        <form action="send_message.php" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required>
                                        <label for="name">Nama Anda</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Anda" required>
                                        <label for="email">Email Anda</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subjek" required>
                                        <label for="subject">Subjek</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Pesan Anda" id="message" name="message" style="height: 150px" required></textarea>
                                        <label for="message">Pesan Anda</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Kirim Pesan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>