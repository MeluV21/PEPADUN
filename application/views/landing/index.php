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
                <div class="stat-top h-100 d-flex align-items-center justify-content-center">                <div class="stat-icon stat-icon-folder">
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

    </div>

</div>

</div>

</section>

<!-- ===================================================== -->
<!-- INFORMASI -->
<!-- ===================================================== -->

<section id="informasi" class="section-padding">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <h2>Jadwal Monitoring</h2>
            <p>Monitoring keterbukaan informasi publik dilakukan setiap triwulan.</p>
        </div>
        <div class="timeline-wrapper">
            <?php
            $timeline = $timeline ?? [
                ['title'=>'Triwulan I','bulan'=>'Januari - Maret'],
                ['title'=>'Triwulan II','bulan'=>'April - Juni'],
                ['title'=>'Triwulan III','bulan'=>'Juli - September'],
                ['title'=>'Triwulan IV','bulan'=>'Oktober - Desember']
            ];
            ?>
            <?php foreach($timeline as $i=>$row): ?>
            <div class="timeline-item">
                <div class="timeline-circle">
                    <?= $i+1 ?>
                </div>
                <h5><?= $row['title']; ?></h5>
                <span><?= $row['bulan']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="status-wrapper mt-5">
            <div class="status-card success">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <h6>Sudah Update</h6>
                    <small>Dokumen telah diperbarui.</small>
                </div>
            </div>
            <div class="status-card warning">
                <i class="bi bi-clock-fill"></i>
                <div>
                    <h6>Proses</h6>
                    <small>Menunggu proses verifikasi.</small>
                </div>
            </div>
            <div class="status-card danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    <h6>Belum Update</h6>
                    <small>Dokumen belum diperbarui.</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================================================== -->
<!-- TENTANG -->
<!-- ===================================================== -->

<section id="tentang" class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-label">
                    Tentang PEPADUN
                </span>
                <h2 class="mt-3">
                    Percepatan Pantau Dokumen serta Update Data dan Informasi
                </h2>
                <p class="mt-4">
                    PEPADUN merupakan sistem monitoring keterbukaan informasi publik
                    yang digunakan untuk membantu BBPOM di Bandar Lampung dalam
                    melakukan pemantauan, evaluasi, serta pengelolaan informasi publik
                    secara efektif dan terstruktur.
                </p>
                <div class="feature-list mt-4">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Monitoring Dokumen</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Evaluasi Berkala</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Dashboard Interaktif</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Laporan Otomatis</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img
                        src="<?= base_url('images/tentang_bbpom.jpg');?>"
                        onerror="this.src='<?= base_url('images/gedung_bbpom.jpg');?>'"
                        alt="BBPOM Bandar Lampung">
                </div>
            </div>
        </div>
    </div>
</section>
