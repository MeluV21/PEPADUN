<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PEPADUN</title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-brand">
                <i class="bi bi-shield-fill-check" style="font-size: 3.5rem; color: var(--primary); display: block; margin-bottom: 0.5rem;"></i>
                <h2>PEPADUN</h2>
                <p style="text-transform: uppercase; font-size: 0.7rem; font-weight: 700; color: var(--text-muted); letter-spacing: 0.05em; margin-bottom: 0.25rem;">BADAN POM</p>
                <span style="font-size: 0.75rem; color: var(--text-muted); display: block; line-height: 1.3;">Percepatan Pantau Dokumen serta Update Data dan Informasi</span>
            </div>

            <!-- Flash alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-person"></i>
                        <input type="text" id="username" name="username" class="form-control form-control-icon" placeholder="Masukkan username..." value="<?= old('username') ?>" required autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" class="form-control form-control-icon" placeholder="Masukkan password..." required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; margin-top: 1.5rem;">
                    <span>Masuk Ke Panel</span> <i class="bi bi-box-arrow-in-right"></i>
                </button>

                <!-- Tombol Kembali ke Beranda (Secondary Button Design System) -->
                <a href="<?= base_url() ?>" style="display: block; width: 100%; text-align: center; padding: 0.75rem; margin-top: 1rem; background-color: transparent; border: 1px solid #0A4D9E; color: #0A4D9E; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 14px; transition: all 0.3s ease;">
                    <i class="bi bi-arrow-left" style="margin-right: 6px;"></i> Kembali ke Beranda
                </a>
            </form>
        </div>
    </div>
</body>
</html>
