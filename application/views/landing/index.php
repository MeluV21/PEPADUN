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
                <?php 
                    $triwulanRoman = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
                    $currentTriwulanNum = isset($currentTriwulan) ? $currentTriwulan : ceil(date('m') / 3);
                    $currentYearNum = isset($currentYear) ? $currentYear : date('Y');
                ?>
                <button class="ds-dropdown-btn-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">

                    <span>
                        <i class="bi bi-calendar-event me-2"></i>
                        TRIWULAN <?= $triwulanRoman[$currentTriwulanNum] ?> TAHUN <?= $currentYearNum ?>
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
    <div class="col-lg-12">
        <div class="wf-card dashboard-card" style="padding: 1.75rem;">
            <div class="card-header-custom d-flex justify-content-between align-items-center mb-4" style="padding-bottom: 1rem; border-bottom: 1px dashed var(--neutral-light, #E2E8F0);">
                <div class="d-flex align-items-center gap-2 text-ds-primary" style="color: var(--primary, #0A4D9E);">
                    <i class="bi bi-bar-chart-fill" style="font-size: 1.25rem;"></i>
                    <h3 class="mb-0 fw-bold" style="font-size: 1.1rem; margin: 0;">
                        Presentase Kepatuhan Per Kategori
                    </h3>
                </div>
            </div>
            <div class="chart-scroll" style="position: relative; height: 320px; width: 100%; overflow-x: auto;">
                <div class="chart-wrapper" style="min-width: 600px; height: 100%;">
                    <canvas id="kepatuhanChart"></canvas>
                    <script>
                        window.kepatuhanChartData = <?= $chartData ?? '[]' ?>;
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM BELUM UPDATE -->
    <div class="col-lg-12">
        <div class="wf-card dashboard-card" style="padding: 1.75rem;">
            <div class="card-header-custom d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <div style="background-color: var(--danger, #dc3545); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold;">!</div>
                    <h3 class="mb-0 fw-bold" style="font-size: 1.1rem; margin: 0;">
                        Item Belum Update
                    </h3>
                </div>

            </div>

            <div class="table-responsive" id="containerBelumUpdate" style="max-height: 400px; overflow-y: auto;">
                <table class="table custom-table table-hover" style="border-top: 1px dashed var(--neutral-light, #E2E8F0); min-width: 800px; margin-bottom: 0;">
                    <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                        <tr>
                            <th style="width: 35%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Item Informasi</th>
                            <th style="width: 15%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Kategori</th>
                            <th style="width: 15%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">PJ</th>
                            <th style="width: 10%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Timeline</th>
                            <th style="width: 15%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Keterangan</th>
                            <th style="width: 10%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem; text-align: center;">Tautan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $belumUpdate = $belumUpdate ?? [];
                        ?>

                        <?php if (empty($belumUpdate)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted, #64748B); padding: 2rem;">
                                    Tidak ada item yang belum diupdate.
                                </td>
                            </tr>
                        <?php else: ?>

                        <?php foreach($belumUpdate as $row): ?>
                        <tr>
                            <td style="padding: 1rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 1.1rem;"></i>
                                    <span class="fw-medium text-dark" style="font-size: 0.9rem;">
                                        <?= esc($row['judul']); ?>
                                    </span>
                                </div>
                            </td>
                            <td class="text-secondary" style="font-size: 0.9rem; padding: 1rem;">
                                <?php 
                                    $catName = esc($row['kategori'] ?? '');
                                    if (empty($catName) || strtolower(trim($catName)) === 'tanpa kategori' || strtolower(trim($catName)) === 'lainnya') {
                                        $catName = '-';
                                    }
                                    echo $catName;
                                ?>
                            </td>
                            <td class="text-secondary" style="font-size: 0.9rem; padding: 1rem;">
                                <?= (!empty($row['pj'])) ? esc($row['pj']) : '-'; ?>
                            </td>
                            <td class="text-secondary" style="font-size: 0.9rem; padding: 1rem;">
                                <?= (!empty($row['timeline'])) ? esc($row['timeline']) : '-'; ?>
                            </td>
                            <td class="text-secondary" style="font-size: 0.9rem; padding: 1rem;">
                                <?= (!empty($row['keterangan'])) ? esc($row['keterangan']) : '-'; ?>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <?php if (!empty($row['tautan'])): ?>
                                    <a href="<?= esc($row['tautan']) ?>" target="_blank" class="btn-tertiary" title="<?= esc($row['tautan']) ?>" style="padding: 0; font-size: 1.15rem; color: var(--primary, #0A4D9E);">
                                        <i class="bi bi-link-45deg"></i>
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--text-muted, #64748b); font-size: 0.8rem;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                        <h6 class="fw-bold mb-2" style="color: #000000">Dashboard Monitoring</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Menampilkan ringkasan kepatuhan informasi secara visual.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-file-earmark-check"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #000000">Monitoring & Update</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Melakukan update dan monitoring dokumen informasi setiap bidang.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-download"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #000000">Export Laporan</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Menyediakan export laporan dalam format PDF dan Excel.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="fitur-icon mb-3 shadow-sm">
                            <i class="bi bi-bell"></i>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #000000">Notifikasi</h6>
                        <p class="text-secondary mb-0" style="font-size: 12.5px; line-height: 1.5;">Pengingat dan informasi terkait jadwal monitoring.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
