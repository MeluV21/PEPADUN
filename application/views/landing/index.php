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
                    <?php for ($t = 1; $t <= 4; $t++): ?>
                    <li>
                        <a class="dropdown-item <?= ((int)$currentTriwulanNum === $t) ? 'active' : '' ?>" 
                           href="<?= base_url("landing?year={$currentYearNum}&triwulan={$t}") ?>">
                            Triwulan <?= $triwulanRoman[$t] ?> Tahun <?= $currentYearNum ?>
                        </a>
                    </li>
                    <?php endfor; ?>
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
    <div class="col-lg-12" id="monitoring-data">
        <div class="wf-card dashboard-card" style="padding: 1.75rem; height: auto;">
            <div class="card-header-custom d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2 text-ds-primary" style="color: var(--primary, #0A4D9E);">
                    <i class="bi bi-list-columns-reverse" style="font-size: 1.25rem;"></i>
                    <h3 class="mb-0 fw-bold" style="font-size: 1.1rem; margin: 0;">
                        Data Monitoring Informasi Publik
                    </h3>
                </div>
            </div>

            <!-- Filtering and Search Bar -->
            <div style="margin-bottom: 2rem;">
                <form action="<?= base_url('landing') ?>" method="GET">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                            <div class="input-icon-wrapper" style="width: 200px; margin-bottom: 0; position: relative;">
                                <input type="text" id="search" name="search" class="form-control form-control-icon" placeholder="Cari informasi..." value="<?= esc($searchQuery ?? '') ?>" autocomplete="off" style="padding-top: 0.5rem; padding-bottom: 0.5rem; padding-left: 2.25rem; font-size: 0.85rem;" onkeypress="if(event.keyCode === 13) { event.preventDefault(); submitFilters(); return false; }">
                                <i class="bi bi-search" style="font-size: 0.95rem; position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
                            </div>

                            <select id="category" name="category" class="select-control form-select" onchange="submitFilters()" style="width: 170px; padding: 0.5rem 2.25rem 0.5rem 0.75rem; font-size: 0.85rem;">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat): 
                                    if (strtolower(trim($cat['name'])) === 'tanpa kategori') continue;
                                ?>
                                    <option value="<?= esc($cat['id']) ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                                        <?= esc($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select id="status" name="status" class="select-control form-select" onchange="submitFilters()" style="width: 170px; padding: 0.5rem 2.25rem 0.5rem 0.75rem; font-size: 0.85rem;">
                                <option value="">Semua Status</option>
                                <option value="pending" <?= ($selectedStatus == 'pending') ? 'selected' : '' ?>>Belum Update</option>
                                <option value="progress" <?= ($selectedStatus == 'progress') ? 'selected' : '' ?>>Dalam Proses</option>
                                <option value="completed" <?= ($selectedStatus == 'completed') ? 'selected' : '' ?>>Selesai (Completed)</option>
                            </select>
                            
                            <a href="<?= base_url('landing') ?>#monitoring-data" id="resetFilterBtn" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; <?= (!empty($searchQuery) || !empty($selectedCategory) || !empty($selectedStatus)) ? '' : 'display: none;' ?>">
                                Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Panel -->
            <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
                <table class="table custom-table table-hover" style="min-width: 1000px; margin-bottom: 0;">
                    <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                        <tr>
                            <th style="width: 5%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">No.</th>
                            <th style="width: 25%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Nama Informasi</th>
                            <th style="width: 12%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Kategori</th>
                            <th style="width: 12%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">PJ</th>
                            <th style="width: 10%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Timeline</th>
                            <th style="width: 13%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Status</th>
                            <th style="width: 15%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem;">Keterangan</th>
                            <th style="width: 8%; color: var(--text-muted, #64748B); font-weight: 500; font-size: 0.85rem; border-bottom: 1px solid var(--neutral-light, #E2E8F0); padding: 1rem; text-align: center;">Tautan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($monitoringList)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; color: var(--text-muted, #64748B); padding: 3rem;">
                                    Belum ada data monitoring keterbukaan informasi.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($monitoringList as $index => $item): ?>
                                <tr>
                                    <td style="padding: 1rem;"><?= $index + 1 + (($currentPage - 1) * $perPage) ?></td>
                                    <td style="padding: 1rem; font-weight: 600; color: var(--text-dark, #1E293B);"><?= esc($item['custom_name'] ?: $item['name']) ?></td>
                                    <td style="padding: 1rem; color: var(--text-muted, #64748B); font-size: 0.9rem;"><?= esc(empty($item['category_name']) || strtolower(trim($item['category_name'])) === 'tanpa kategori' || strtolower(trim($item['category_name'])) === 'lainnya' ? '-' : $item['category_name']) ?></td>
                                    <td style="padding: 1rem; font-weight: 500; color: var(--text-muted, #64748B); font-size: 0.9rem;"><?= esc($item['pj'] ?: '-') ?></td>
                                    <td style="padding: 1rem; color: var(--text-dark, #1E293B); font-size: 0.85rem; font-weight: 500;">
                                        <?= esc($item['timeline'] ?: '-') ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php if ($item['status'] === 'completed'): ?>
                                            <span class="badge badge-selesai" style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 600; font-size: 0.75rem; background-color: #ECFDF5; color: #10B981; border: 1px solid #D1FAE5;">
                                                <i class="bi bi-check-circle-fill"></i> Selesai
                                            </span>
                                        <?php elseif ($item['status'] === 'progress'): ?>
                                            <span class="badge badge-proses" style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 600; font-size: 0.75rem; background-color: #FFFBEB; color: #F59E0B; border: 1px solid #FEF3C7;">
                                                <i class="bi bi-clock-fill"></i> Dalam Proses
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-belum-update" style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 600; font-size: 0.75rem; background-color: #FEF2F2; color: #EF4444; border: 1px solid #FEE2E2;">
                                                <i class="bi bi-exclamation-circle-fill"></i> Belum Update
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-muted, #64748B); font-size: 0.85rem;"><?= esc($item['description'] ?: '-') ?></td>
                                    <td style="padding: 1rem; text-align: center;">
                                        <?php if (!empty($item['tautan'])): ?>
                                            <a href="<?= esc($item['tautan']) ?>" target="_blank" class="btn-tertiary" title="<?= esc($item['tautan']) ?>" style="padding: 0; font-size: 1.15rem; color: var(--primary, #0A4D9E);">
                                                <i class="bi bi-link-45deg"></i>
                                            </a>
                                        <?php else: ?>
                                            <span style="color: var(--text-muted, #64748B); font-size: 0.8rem;">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Header Action Card -->
            <?php if (isset($totalRows) && $totalRows > 0): ?>
                <?php
                    $startItem = (($currentPage - 1) * $perPage) + 1;
                    $endItem = min($currentPage * $perPage, $totalRows);
                    
                    $build_page_url = function($p) use ($perPage) {
                        $ci =& get_instance();
                        $params = $ci->input->get();
                        $params['page'] = $p;
                        $params['per_page'] = $perPage;
                        return base_url('landing') . '?' . http_build_query($params) . '#monitoring-data';
                    };
                ?>
            <div class="pagination-wrapper mt-4" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 1rem; border-top: 1px solid var(--neutral-light, #E2E8F0);">
                <div style="color: var(--text-muted, #64748B); font-size: 0.85rem; font-weight: 500;">
                    Menampilkan <?= $startItem ?> - <?= $endItem ?> dari <?= $totalRows ?> data
                </div>
                
                <div class="pagination-pages" style="display: flex; gap: 0.25rem;">
                    <a href="<?= $build_page_url(1) ?>" class="pagination-page-btn btn btn-sm btn-outline-secondary" title="First Page" <?= $currentPage <= 1 ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                    <a href="<?= $build_page_url(max(1, $currentPage - 1)) ?>" class="pagination-page-btn btn btn-sm btn-outline-secondary" title="Previous Page" <?= $currentPage <= 1 ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    
                    <?php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                        if ($startPage > 1) {
                            echo '<button class="pagination-page-btn btn btn-sm btn-outline-secondary d-none d-sm-inline-block" disabled style="cursor: default; border-color: transparent;">...</button>';
                        }
                        for ($p = $startPage; $p <= $endPage; $p++) {
                            $activeClass = $p === $currentPage ? 'active btn-primary' : 'btn-outline-secondary d-none d-sm-inline-block';
                            $activeStyle = $p === $currentPage ? 'background-color: var(--primary, #0A4D9E); color: white; border-color: var(--primary, #0A4D9E);' : '';
                            echo '<a href="'.$build_page_url($p).'" class="pagination-page-btn btn btn-sm '.$activeClass.'" style="text-decoration:none; '.$activeStyle.'">'.$p.'</a>';
                        }
                        if ($endPage < $totalPages) {
                            echo '<button class="pagination-page-btn btn btn-sm btn-outline-secondary d-none d-sm-inline-block" disabled style="cursor: default; border-color: transparent;">...</button>';
                        }
                    ?>
                    
                    <a href="<?= $build_page_url(min($totalPages, $currentPage + 1)) ?>" class="pagination-page-btn btn btn-sm btn-outline-secondary" title="Next Page" <?= $currentPage >= $totalPages ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="<?= $build_page_url($totalPages) ?>" class="pagination-page-btn btn btn-sm btn-outline-secondary" title="Last Page" <?= $currentPage >= $totalPages ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </div>
                
                <div>
                    <select class="select-control form-select" id="perPageSelect" style="padding: 0.35rem 2rem 0.35rem 0.75rem; min-width: 130px; font-size: 0.8rem; border-radius: 6px; border: 1px solid #cbd5e1;" onchange="
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set('per_page', this.value);
                        urlParams.set('page', '1');
                        const newUrl = window.location.pathname + '?' + urlParams.toString();
                        loadLandingData(newUrl);
                    ">
                        <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 / halaman</option>
                        <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25 / halaman</option>
                        <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50 / halaman</option>
                    </select>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
    
    <script>
        window.submitFilters = function() {
            const form = document.querySelector('form[action="<?= base_url('landing') ?>"]');
            if (!form) return;
            const url = new URL(form.action);
            const formData = new FormData(form);
            for (const [key, value] of formData.entries()) {
                if (value) {
                    url.searchParams.append(key, value);
                }
            }
            url.searchParams.delete('page');
            
            const currentUrl = new URL(window.location.href);
            if (currentUrl.searchParams.has('year')) url.searchParams.set('year', currentUrl.searchParams.get('year'));
            if (currentUrl.searchParams.has('triwulan')) url.searchParams.set('triwulan', currentUrl.searchParams.get('triwulan'));
            
            loadLandingData(url.toString());
        };

        window.loadLandingData = function(url, pushState = true) {
            const tbody = document.querySelector('.table-responsive tbody');
            if (tbody) tbody.style.opacity = '0.5';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const activeElementId = document.activeElement ? document.activeElement.id : null;
                const selectionStart = document.activeElement && document.activeElement.tagName === 'INPUT' ? document.activeElement.selectionStart : null;
                const selectionEnd = document.activeElement && document.activeElement.tagName === 'INPUT' ? document.activeElement.selectionEnd : null;

                const newTbody = doc.querySelector('.table-responsive tbody');
                if (newTbody) tbody.innerHTML = newTbody.innerHTML;
                if (tbody) tbody.style.opacity = '1';

                const currentPagination = document.querySelector('.pagination-wrapper');
                const newPagination = doc.querySelector('.pagination-wrapper');
                
                if (currentPagination && newPagination) {
                    currentPagination.innerHTML = newPagination.innerHTML;
                } else if (!currentPagination && newPagination) {
                    document.querySelector('.table-responsive').insertAdjacentElement('afterend', newPagination);
                } else if (currentPagination && !newPagination) {
                    currentPagination.remove();
                }

                const currentResetBtn = document.getElementById('resetFilterBtn');
                const newResetBtn = doc.getElementById('resetFilterBtn');
                if (currentResetBtn && newResetBtn) {
                    currentResetBtn.style.display = newResetBtn.style.display;
                    currentResetBtn.href = newResetBtn.href;
                }

                if (activeElementId) {
                    const el = document.getElementById(activeElementId);
                    if (el) {
                        el.focus();
                        if (el.tagName === 'INPUT' && selectionStart !== null) {
                            el.setSelectionRange(selectionStart, selectionEnd);
                        }
                    }
                }

                if (pushState) {
                    window.history.pushState({path: url}, '', url);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                if (tbody) tbody.style.opacity = '1';
            });
        };

        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            let debounceTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    if (this.value === '') {
                        submitFilters();
                        return;
                    }
                    debounceTimer = setTimeout(() => {
                        submitFilters();
                    }, 600);
                });
            }

            // Handle pagination clicks via AJAX
            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination-page-btn');
                const resetBtn = e.target.closest('.btn-secondary');

                if (paginationLink && paginationLink.tagName === 'A' && !paginationLink.hasAttribute('disabled')) {
                    e.preventDefault();
                    loadLandingData(paginationLink.href);
                } else if (resetBtn && resetBtn.tagName === 'A' && resetBtn.textContent.trim() === 'Reset Filter') {
                    e.preventDefault();
                    const url = new URL(resetBtn.href);
                    // Ensure year/triwulan is kept when resetting
                    const currentUrl = new URL(window.location.href);
                    if (currentUrl.searchParams.has('year')) url.searchParams.set('year', currentUrl.searchParams.get('year'));
                    if (currentUrl.searchParams.has('triwulan')) url.searchParams.set('triwulan', currentUrl.searchParams.get('triwulan'));
                    
                    // Reset input values manually so they clear right away
                    if(document.getElementById('search')) document.getElementById('search').value = '';
                    if(document.getElementById('category')) document.getElementById('category').value = '';
                    if(document.getElementById('status')) document.getElementById('status').value = '';
                    
                    loadLandingData(url.toString());
                }
            });

            // Handle back/forward buttons
            window.addEventListener('popstate', function() {
                loadLandingData(window.location.href, false);
            });
        });
    </script>

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
                        <div class="icon-status status-danger"><i class="bi bi-exclamation-circle"></i></div>
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
                <img src="<?= base_url('images/logo_pepadun.png'); ?>" alt="Logo PEPADUN" class="tentang-logo-img mb-2" style="max-height: 120px; object-fit: contain;">
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
