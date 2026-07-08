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
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
</head>
<body>
    <div class="login-container">
        <div class="auth-card">
            
            <!-- Tombol Kembali di Pojok Kiri Atas -->
            <a href="<?= base_url() ?>" class="btn-back-top">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <div class="auth-brand">
                <img src="<?= base_url('images/logo_text.png') ?>" alt="Logo BPOM">
                
                <h2 class="auth-title">Selamat Datang</h2>
                <p class="auth-subtitle">Silakan masuk untuk melanjutkan ke sistem<br>PEPADUN BBPOM di Bandar Lampung</p>
            </div>

            <!-- Flash alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" style="padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-check-circle-fill"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="username">Email</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-envelope left-icon"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan email Anda" value="<?= old('username') ?>" required autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-icon-wrapper">
                        <i class="bi bi-lock left-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                        <i class="bi bi-eye right-icon" id="togglePassword"></i>
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="ingat_saya" name="ingat_saya">
                    <label for="ingat_saya">Ingat saya</label>
                </div>

                <button type="submit" class="btn-masuk" style="margin-bottom: 0;">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
