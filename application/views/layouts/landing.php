<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'PEPADUN - Monitoring Informasi Publik' ?></title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS based on Design System -->
    <link rel="stylesheet" href="<?= base_url('css/landing.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/informasi.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/tentang.css') ?>">
</head>
<body tabindex="0">
    
    <!-- Navbar -->
<nav id="navbarPepadun" class="navbar navbar-expand-lg fixed-top">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand" href="#beranda">

            <img src="<?= base_url('images/logo_text.png') ?>" alt="Logo BBPOM" class="logo-img">

            <div class="logo-content">

                <h1>PEPADUN</h1>

                <p class="logo-desc">
                    Percepatan Pantau Dokumen serta<br>
                    Update Data dan Informasi
                </p>

                <span class="bbpom-badge">
                    BBPOM di Bandar Lampung
                </span>
            </div>
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="#beranda">
                        <i class="bi bi-house-door-fill"></i>
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#informasi">
                        <i class="bi bi-info-circle-fill"></i>
                        Informasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#tentang">
                        <i class="bi bi-question-circle-fill"></i>
                        Tentang
                    </a>
                </li>

            </ul>

            <a href="<?= base_url('login') ?>" class="btn-login">
                MASUK
            </a>

        </div>

    </div>

</nav>

    <!-- Main Content -->
    <main class="landing-main">
        <?php $this->load->view('landing/index'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-ds-primary text-ds-white py-5">
        <div class="container mt-4 mb-2">
            <div class="row gy-4 align-items-start">
                
                <!-- Col 1: Logo -->
                <div class="col-lg-2 col-md-3 text-center text-lg-start">
                    <img src="<?= base_url('images/logo_text.png') ?>" alt="Logo BBPOM" class="img-fluid" style="max-height: 95px;">
                </div>
                
                <!-- Col 2: Text PEPADUN -->
                <div class="col-lg-4 col-md-9 mb-4 mb-lg-0">
                    <h4 class="mb-2" style="color: white; font-weight: 700; font-size: 24px;">PEPADUN</h4>
                    <div style="opacity: 0.9; font-size: 13px; line-height: 1.7;">
                        Percepatan Pantau Dokumen serta<br>
                        Update Data dan Informasi<br>
                        BBPOM di Bandar Lampung
                    </div>
                </div>
                
                <!-- Col 3: Tautan -->
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h5 class="mb-3" style="color: white; font-weight: 600; font-size: 18px;">Tautan</h5>
                    <ul class="list-unstyled" style="font-size: 13px; opacity: 0.9;">
                        <li class="mb-3"><a href="#beranda" class="text-decoration-none text-ds-white footer-link">Beranda</a></li>
                        <li class="mb-3"><a href="#tentang" class="text-decoration-none text-ds-white footer-link">Tentang PEPADUN</a></li>
                        <li class="mb-3"><a href="#informasi" class="text-decoration-none text-ds-white footer-link">Informasi Publik</a></li>
                        <li class="mb-3"><a href="#" class="text-decoration-none text-ds-white footer-link">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Col 4: Kontak Kami -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-3" style="color: white; font-weight: 600; font-size: 18px;">Kontak Kami</h5>
                    <ul class="list-unstyled" style="font-size: 13px; opacity: 0.9;">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-geo-alt me-3 mt-1" style="font-size: 16px;"></i> 
                            <span>Jl. Dr. Susilo No. 12, Bandar Lampung, 35124</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-telephone me-3" style="font-size: 16px;"></i> 
                            <span>(0721) 778852</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-envelope me-3" style="font-size: 16px;"></i> 
                            <span>bbpom_lampung@pom.go.id</span>
                        </li>
                    </ul>
                </div>

            </div>
            
            <div class="text-center mt-5" style="font-size: 13px; opacity: 0.8;">
                <i class="bi bi-c-circle"></i> <?= date('Y') ?> BBPOM di Bandar Lampung, All right reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('js/landing.js') ?>?v=<?= time() ?>"></script>
</body>
</html>
