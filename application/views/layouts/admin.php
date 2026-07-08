<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'Pepadun Console' ?> - PEPADUN</title>
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
    <script>
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.body.classList.add('sidebar-collapsed');
        }
    </script>
    <div class="layout-container">
        <!-- Sidebar Partial View -->
        <?php $this->load->view('layouts/sidebar'); ?>

        <!-- Main Panel Content -->
        <div style="flex-grow: 1;">
            <main class="main-content">
                <div class="container-1200">
                    <!-- Top Navbar Panel matching mockup -->
                    <div class="top-navbar-panel">
                        <div class="top-navbar-left">
                            <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary); margin: 0; line-height: 1.2;"><?= isset($title) ? esc($title) : 'Monitoring Keterbukaan Informasi Publik' ?></h2>
                            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; margin-top: 0.1rem;">PEPADUN - Monitoring Keterbukaan Informasi Publik</p>
                        </div>
                        <div class="top-navbar-right">
                            <div class="top-profile-badge" title="Profil Pengguna">
                                <div class="top-profile-avatar">
                                    <?= strtoupper(substr(session()->get('fullname') ?? 'U', 0, 1)) ?>
                                </div>
                                <span style="color: var(--text-dark);"><?= esc(session()->get('fullname') ?? 'User') ?></span>
                                <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Alerts / Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill" style="font-size: 1.25rem;"></i>
                            <div><?= session()->getFlashdata('success') ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle-fill" style="font-size: 1.25rem;"></i>
                            <div><?= session()->getFlashdata('error') ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- View content -->
                    <?php $this->load->view($content_view); ?>
                </div>
            </main>

        </div>
    </div>
</body>
</html>
