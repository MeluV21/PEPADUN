<!-- =========================
     SECTION BERANDA
========================= -->
<section id="beranda" class="hero-section">
<div class="container">

    <div class="row align-items-center gx-5">

        <!-- HERO LEFT -->
        <div class="col-lg-6">

            <h1 class="ds-display-1 text-ds-primary mb-4">
                Monitoring Keterbukaan<br>
                Informasi Publik
            </h1>

            <p class="ds-body-large text-ds-neutral mb-5">
                PEPADUN adalah sistem monitoring dan evaluasi keterbukaan informasi publik pada BBPOM di Bandar Lampung.
            </p>

            <div class="dropdown">
                <button class="ds-dropdown-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">

                    <span>
                        <i class="bi bi-calendar-event me-2"></i>
                        TRIWULAN I TAHUN <?= date('Y') ?>
                    </span>

                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#">
                            Triwulan I Tahun <?= date('Y') ?>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            Triwulan II Tahun <?= date('Y') ?>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            Triwulan III Tahun <?= date('Y') ?>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="#">
                            Triwulan IV Tahun <?= date('Y') ?>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- HERO IMAGE -->
        <div class="col-lg-6">

            <div class="hero-image-wrapper">

                <img
                    src="<?= base_url('images/gedung_bbpom.jpg') ?>"
                    class="hero-image"
                    alt="Gedung BBPOM">

            </div>

        </div>

    </div>

<?php

$tingkat_kepatuhan = $tingkat_kepatuhan ?? 85;
$selesai_update    = $selesai_update ?? 70;
$belum_update      = $belum_update ?? 20;
$total_item        = $total_item ?? 90;

$persen_selesai = $total_item > 0 ? ($selesai_update/$total_item)*100 : 0;
$persen_belum   = $total_item > 0 ? ($belum_update/$total_item)*100 : 0;

?>

<!-- =========================
     STATISTIC CARD
========================= -->

<div class="row g-4 mt-4">

    <!-- CARD 1 -->
    <div class="col-lg-3 col-md-6">
        <div class="wf-card stat-card bg-primary-custom">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-chart">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-title text-white">Tingkat Kepatuhan</div>
                    <div class="stat-value text-white" id="val-kepatuhan"><?= $tingkat_kepatuhan ?>%</div>
                    <div class="stat-subtitle text-white stat-opacity">Kepatuhan Informasi Publik</div>
                </div>
            </div>
            <div class="wf-progress mt-3 stat-progress-bg-blue">
                <div class="wf-progress-bar bg-white" id="bar-kepatuhan" style="width:<?= $tingkat_kepatuhan ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-lg-3 col-md-6">
        <div class="wf-card stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-check">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-title">Selesai / Update</div>
                    <div class="stat-value" id="val-selesai"><?= $selesai_update ?></div>
                    <div class="stat-subtitle">Dari <span id="val-total1"><?= $total_item ?></span> Item</div>
                </div>
            </div>
            <div class="wf-progress mt-3 stat-progress-bg-gray">
                <div class="wf-progress-bar bg-ds-success" id="bar-selesai" style="width:<?= $persen_selesai ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-lg-3 col-md-6">
        <div class="wf-card stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon stat-icon-clock">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-title">Belum Update</div>
                    <div class="stat-value" id="val-belum"><?= $belum_update ?></div>
                    <div class="stat-subtitle">Dari <span id="val-total2"><?= $total_item ?></span> Item</div>
                </div>
            </div>
            <div class="wf-progress mt-3 stat-progress-bg-gray">
                <div class="wf-progress-bar bg-ds-danger" id="bar-belum" style="width:<?= $persen_belum ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-lg-3 col-md-6">
        <div class="wf-card stat-card">
            <div class="stat-top h-100 d-flex align-items-center justify-content-center">
                <div class="stat-icon stat-icon-folder">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div class="ms-3">
                    <div class="stat-title" style="font-size: 20px;">Total Item</div>
                    <div class="stat-value" id="val-total3"><?= $total_item ?></div>
                    <div class="stat-subtitle" style="font-size: 15px;">Item Informasi</div>
                </div>
            </div>
        </div>
    </div>

</div>
        
<!-- =========================
     CHART & ITEM BELUM UPDATE
========================= -->

<div class="row g-4 mt-4">

    <!-- CHART -->
    <div class="col-lg-6">
        <div class="wf-card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold text-ds-primary" style="font-size: 18px;">
                    Presentase Kepatuhan Per Kategori
                </h5>
            </div>
            <div class="chart-scroll">
                <div class="chart-wrapper">
                    <canvas id="kepatuhanChart"></canvas>
                    <script>
                        window.kepatuhanChartData = <?= $chartData ?? '[]' ?>;
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM BELUM UPDATE -->
    <div class="col-lg-6">
        <div class="wf-card dashboard-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold text-ds-primary" style="font-size: 18px;">
                    Item Belum Update
                </h5>
            </div>

            <div class="item-scroll" id="containerBelumUpdate">
                <?php
                $belumUpdate = $belumUpdate ?? [
                    ['judul'=>'Struktur Organisasi', 'kategori'=>'Profil PPID'],
                    ['judul'=>'Registrasi Permintaan Informasi', 'kategori'=>'Laporan'],
                    ['judul'=>'Laporan Keberatan', 'kategori'=>'Laporan'],
                ];
                ?>

                <?php foreach($belumUpdate as $row): ?>
                <div class="list-row-item py-3 border-bottom d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 18px;"></i>
                    </div>
                    <div class="title fw-semibold text-dark flex-grow-1" style="font-size: 14px;">
                        <?= $row['judul']; ?>
                    </div>
                    <div class="text-secondary" style="font-size: 13px; width: 120px;">
                        <?= $row['kategori']; ?>
                    </div>
                    <div class="text-end text-secondary" style="font-size: 13px; width: 30px;">
                        -
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

</div>
</section>

<!-- ===================================================== -->
<!-- INFORMASI -->
<!-- ===================================================== -->

<section id="informasi" class="section-padding bg-white">
    <div class="container">
        
        <!-- Banner Informasi Publik -->
        <div class="info-banner mb-5">
            <div class="row align-items-center">
                <div class="col-md-7 info-banner-text p-md-4">
                    <h2 class="info-banner-title">Informasi Publik</h2>
                    <p class="info-banner-desc">Berikut informasi mengenai monitoring keterbukaan<br>informasi publik di BBPOM di Bandar Lampung.</p>
                </div>
                <div class="col-md-5 text-center position-relative">
                    <div class="info-icon-fallback py-3">
                        <i class="bi bi-clipboard-check" style="font-size: 120px; color: #155bb5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apa itu PEPADUN? -->
        <div class="row mb-5 align-items-center mt-5">
            <div class="col-md-6 pe-md-5">
                <h3 class="info-section-title mb-3">Apa itu PEPADUN?</h3>
                <p class="info-section-desc">PEPADUN adalah sistem monitoring dan evaluasi keterbukaan informasi publik yang digunakan untuk memantau pembaruan dokumen informasi pada setiap bidang di lingkungan BBPOM di Bandar Lampung secara berkala setiap triwulan.</p>
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <div class="info-card-highlight">
                    <div class="icon-circle">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div>
                        <h5>Monitoring Dilakukan Setiap</h5>
                        <h3 class="fw-bold">3 Bulan (Triwulan)</h3>
                        <p>Triwulan I, II, III, dan IV setiap tahun</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Monitoring Triwulan -->
        <div class="mb-5 mt-5 pt-4">
            <h3 class="info-section-title mb-4 text-center text-md-start">Jadwal Monitoring Triwulan</h3>
            <div class="row g-4 align-items-stretch">
                <div class="col-md-3 position-relative">
                    <div class="info-box-timeline text-center">
                        <div class="icon-timeline icon-tw1"><i class="bi bi-calendar-event"></i></div>
                        <h5>Triwulan I</h5>
                        <p>1 Januari - 31 Maret</p>
                    </div>
                    <div class="arrow-right d-none d-md-block"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="col-md-3 position-relative">
                    <div class="info-box-timeline text-center">
                        <div class="icon-timeline icon-tw2"><i class="bi bi-calendar-event"></i></div>
                        <h5>Triwulan II</h5>
                        <p>1 April - 30 Juni</p>
                    </div>
                    <div class="arrow-right d-none d-md-block"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="col-md-3 position-relative">
                    <div class="info-box-timeline text-center">
                        <div class="icon-timeline icon-tw3"><i class="bi bi-calendar-event"></i></div>
                        <h5>Triwulan III</h5>
                        <p>1 Juli - 30 September</p>
                    </div>
                    <div class="arrow-right d-none d-md-block"><i class="bi bi-arrow-right"></i></div>
                </div>
                <div class="col-md-3">
                    <div class="info-box-timeline text-center">
                        <div class="icon-timeline icon-tw4"><i class="bi bi-calendar-event"></i></div>
                        <h5>Triwulan IV</h5>
                        <p>1 Oktober - 31 Desember</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arti Status Monitoring -->
        <div class="mt-5 pt-4">
            <h3 class="info-section-title mb-4 text-center text-md-start">Arti Status Monitoring</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-status-card">
                        <div class="icon-status status-success"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <h5>Selesai / Update</h5>
                            <p>Bidang telah memperbarui dan melengkapi dokumen informasi sesuai ketentuan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-status-card">
                        <div class="icon-status status-danger"><i class="bi bi-x-circle"></i></div>
                        <div>
                            <h5>Belum Update</h5>
                            <p>Bidang belum memperbarui dokumen informasi pada triwulan berjalan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-status-card">
                        <div class="icon-status status-warning"><i class="bi bi-clock"></i></div>
                        <div>
                            <h5>Dalam Proses</h5>
                            <p>Bidang sedang dalam proses melengkapi dan memperbarui dokumen informasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ===================================================== -->
<!-- TENTANG -->
<!-- ===================================================== -->

<section id="tentang" class="section-padding bg-white mt-5">
    <div class="container">
        
        <!-- Hero Tentang -->
        <div class="tentang-hero">
            <div class="row align-items-center w-100 m-0">
                <div class="col-md-7 tentang-hero-text">
                    <h2 class="tentang-title">Tentang PEPADUN</h2>
                    <p class="tentang-subtitle">
                        Sistem Monitoring Keterbukaan Informasi Publik<br>
                        BBPOM di Bandar Lampung
                    </p>
                </div>
            </div>
            <!-- Image positioned absolute -->
            <div class="tentang-hero-img-container d-none d-md-flex">
                <img src="<?= base_url('images/gedung_bbpom_2.jpg'); ?>" onerror="this.src='<?= base_url('images/gedung_bbpom.jpg');?>'" alt="BBPOM Bandar Lampung" class="tentang-hero-img">
            </div>
        </div>

        <!-- Apa itu PEPADUN? -->
        <div class="row mt-5 pt-4 align-items-center">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="<?= base_url('images/logo_text.png'); ?>" alt="Logo PEPADUN" class="tentang-logo-img mb-2" style="max-height: 90px; object-fit: contain;">
                <h4 class="fw-bold mb-1 mt-3" style="color: #0d47a1; letter-spacing: 1px;">PEPADUN</h4>
                <p class="text-secondary small mb-0" style="font-size: 11px;">Percepatan Pantau Dokumen serta<br>Update Data dan Informasi</p>
            </div>
            <div class="col-md-8 pl-md-5">
                <div class="ps-md-4 border-start border-2 border-primary-subtle" style="border-left-color: #0d47a1 !important; border-left-width: 3px !important;">
                    <h3 class="fw-bold mb-3" style="color: #0d47a1;">Apa itu PEPADUN?</h3>
                    <p class="text-secondary" style="font-size: 15px; line-height: 1.8;">
                        PEPADUN merupakan sistem informasi yang dikembangkan oleh BBPOM di Bandar Lampung
                        untuk melakukan monitoring dan evaluasi keterbukaan informasi publik pada setiap bidang
                        secara berkala setiap triwulan.
                    </p>
                </div>
            </div>
        </div>

        <!-- 3 Cards -->
        <div class="row mt-5 pt-2 g-4 justify-content-center">
            <div class="col-md-4">
                <div class="tentang-card h-100">
                    <div class="d-flex align-items-center mb-4">
                        <div class="tentang-icon-circle text-primary" style="background-color: #e8f0fe;">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h5 class="fw-bold ms-3 mb-0" style="color: #0d47a1; font-size: 1.1rem;">Tujuan</h5>
                    </div>
                    <ul class="tentang-list">
                        <li>Meningkatkan transparansi dan akuntabilitas pengelolaan informasi publik.</li>
                        <li>Mempermudah proses monitoring dan evaluasi pembaruan dokumen informasi.</li>
                        <li>Menyediakan data dan informasi secara cepat, akurat, dan terintegrasi.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tentang-card h-100">
                    <div class="d-flex align-items-center mb-4">
                        <div class="tentang-icon-circle text-success" style="background-color: #e6f4ea;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h5 class="fw-bold ms-3 mb-0" style="color: #0d47a1; font-size: 1.1rem;">Manfaat</h5>
                    </div>
                    <ul class="tentang-list">
                        <li>Memudahkan Tim MONEV dalam melakukan pemantauan.</li>
                        <li>Membantu pimpinan dalam pengambilan keputusan berbasis data.</li>
                        <li>Meningkatkan kualitas pelayanan informasi publik kepada masyarakat.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tentang-card h-100">
                    <div class="d-flex align-items-center mb-4">
                        <div class="tentang-icon-circle" style="color: #6f42c1; background-color: #f3e8ff;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h5 class="fw-bold ms-3 mb-0" style="color: #0d47a1; font-size: 1.1rem;">Pengguna Sistem</h5>
                    </div>
                    <ul class="tentang-list">
                        <li>Tim Monitoring dan Evaluasi (MONEV)</li>
                        <li>Petugas PPID di setiap bidang</li>
                        <li>Pimpinan BBPOM di Bandar Lampung</li>
                        <li>Masyarakat (akses informasi umum)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Fitur Utama -->
        <div class="mt-5 pt-5 mb-5">
            <h3 class="fw-bold mb-4 pb-2" style="color: #0d47a1;">Fitur Utama</h3>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-bar-chart-line-fill"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Dashboard <span class="fw-normal text-secondary" style="font-size:12px;">Monitoring</span></h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Menampilkan ringkasan kepatuhan informasi secara visual.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Monitoring & Update</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Melakukan update dan monitoring dokumen informasi setiap bidang.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-download"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Export Laporan</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Menyediakan export laporan dalam format PDF dan Excel.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Notifikasi</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Pengingat dan informasi terkait jadwal monitoring.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
