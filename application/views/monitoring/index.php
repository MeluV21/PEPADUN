<!-- Quarter Tabs System (Triwulan I - IV) protected by current year state -->
<div class="triwulan-tabs-container">
    <?php 
        $triwulanLabels = [
            1 => 'Triwulan I (Jan - Mar)',
            2 => 'Triwulan II (Apr - Jun)',
            3 => 'Triwulan III (Jul - Sep)',
            4 => 'Triwulan IV (Okt - Des)'
        ];
        for ($t = 1; $t <= 4; $t++): 
    ?>
        <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$t}") ?>" 
           class="triwulan-tab-btn <?= ((int)$selectedTriwulan === $t) ? 'active' : '' ?>">
            <?= $triwulanLabels[$t] ?>
        </a>
    <?php endfor; ?>
</div>

<!-- Filtering and Search Bar matching Mockup exactly on a single line -->
<div class="card" style="margin-bottom: 2rem; padding: 1rem 1.25rem;">
    <form action="<?= base_url('monitoring') ?>" method="GET">
        <!-- Preserve year and triwulan states -->
        <input type="hidden" name="year" value="<?= esc($selectedYear) ?>">
        <input type="hidden" name="triwulan" value="<?= esc($selectedTriwulan) ?>">
        
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
            <!-- Left side: Filters -->
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <!-- Search input -->
                <div class="input-icon-wrapper" style="width: 200px;">
                    <input type="text" id="search" name="search" class="form-control form-control-icon" placeholder="Cari informasi..." value="<?= esc($searchQuery) ?>" autocomplete="off" style="padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.85rem;">
                    <i class="bi bi-search" id="searchIcon" style="font-size: 0.95rem; cursor: pointer;" title="Cari sekarang"></i>
                </div>

                <!-- Category filter dropdown -->
                <select id="category" name="category" class="select-control" style="width: 170px; padding: 0.5rem 2rem 0.5rem 0.75rem; font-size: 0.85rem;">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): 
                        if (strtolower(trim($cat['name'])) === 'tanpa kategori') continue;
                    ?>
                        <option value="<?= esc($cat['id']) ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Action buttons for filtering -->
                <?php if (!empty($searchQuery) || !empty($selectedCategory) || !empty($selectedStatus)): ?>
                    <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$selectedTriwulan}") ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        Reset Filter
                    </a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem; background-color: #0c3d79; border-color: #0c3d79;">
                    Cari
                </button>
            </div>

            <!-- Right side: Actions (Add Data & Exports) on the same line -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <a href="<?= base_url('monitoring/create_master') ?>" class="btn btn-primary" style="background-color: #0c3d79; border-color: #0c3d79; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
                <button type="button" class="btn btn-export-excel" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;" onclick="alert('Export Excel berhasil diunduh.')">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </button>
                <button type="button" class="btn btn-export-pdf" style="padding: 0.5rem 1.25rem; font-size: 0.85rem;" onclick="alert('Export PDF berhasil diunduh.')">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Table Panel -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 25%;">Nama Informasi</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 12%;">PJ</th>
                <th style="width: 10%;">Timeline</th>
                <th style="width: 13%;">Status</th>
                <th style="width: 12%;">Keterangan</th>
                <th style="width: 6%; text-align: center;">Tautan</th>
                <th style="width: 5%; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($monitoringList)): ?>
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--text-muted); padding: 3rem;">
                        Belum ada data monitoring keterbukaan informasi pada Triwulan ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($monitoringList as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 + (($currentPage - 1) * $perPage) ?></td>
                        <td style="font-weight: 600; color: var(--text-dark);"><?= esc($item['custom_name'] ?: $item['name']) ?></td>
                        <td><?= esc(empty($item['category_name']) || strtolower(trim($item['category_name'])) === 'tanpa kategori' || strtolower(trim($item['category_name'])) === 'lainnya' ? '-' : $item['category_name']) ?></td>
                        <td style="font-weight: 500;"><?= esc($item['pj'] ?: '-') ?></td>
                        <td style="color: var(--text-dark); font-size: 0.85rem; font-weight: 500;">
                            <?= esc($item['timeline'] ?: '-') ?>
                        </td>
                        <td>
                            <?php if ($item['status'] === 'completed'): ?>
                                <span class="badge badge-selesai">
                                    <i class="bi bi-check-circle-fill"></i> Selesai
                                </span>
                            <?php elseif ($item['status'] === 'progress'): ?>
                                <span class="badge badge-proses">
                                    <i class="bi bi-clock-fill"></i> Dalam Proses
                                </span>
                            <?php else: ?>
                                <span class="badge badge-belum-update">
                                    <i class="bi bi-exclamation-circle-fill"></i> Belum Update
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.8rem;"><?= esc($item['description'] ?: '-') ?></td>
                        <td style="text-align: center;">
                            <?php if (!empty($item['tautan'])): ?>
                                <a href="<?= esc($item['tautan']) ?>" target="_blank" class="btn-tertiary" title="Buka tautan dokumen" style="padding: 0; font-size: 1.15rem; color: var(--primary);">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 0.8rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <?php 
                                $canModify = false;
                                if (session()->get('role') === 'admin' || $item['created_by'] == session()->get('id') || !$item['created_by']) {
                                    $canModify = true;
                                }
                            ?>
                            <div style="display: inline-flex; gap: 0.35rem; align-items: center; vertical-align: middle;">
                                <?php if ($canModify): ?>
                                    <a href="<?= base_url("monitoring/edit/{$item['id']}/{$selectedYear}/{$selectedTriwulan}") ?>" class="btn btn-secondary btn-sm" title="Update Status" style="padding: 0.25rem 0.45rem; font-size: 0.85rem; background-color: #EAF2FF; border-color: #3882F6; color: #0A4D9E;">
                                        <i class="bi bi-pencil"></i> Update
                                    </a>
                                    <a href="<?= base_url("monitoring/delete/{$item['id']}/{$selectedYear}/{$selectedTriwulan}") ?>" class="btn btn-danger btn-sm" title="Hapus dari Triwulan ini" onclick="return confirm('Yakin ingin menyembunyikan laporan ini dari Triwulan <?= $selectedTriwulan ?>?')" style="padding: 0.25rem 0.45rem; font-size: 0.85rem; background-color: #FEF2F2; border-color: #FCA5A5; color: #EF4444;">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                <?php else: ?>
                                    <span style="font-size: 0.8rem; color: var(--text-disabled); font-style: italic; margin-right: 0.5rem;" title="Terkunci: Diubah oleh pengguna lain">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                <?php endif; ?>
                                <button class="btn btn-sm" style="padding: 0.25rem 0.15rem; background: transparent; border: none; color: var(--text-muted); cursor: pointer;" title="Lainnya">
                                    <i class="bi bi-three-dots-vertical" style="font-size: 0.95rem;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination UI -->
<?php if ($totalRows > 0): ?>
    <?php
        $startItem = (($currentPage - 1) * $perPage) + 1;
        $endItem = min($currentPage * $perPage, $totalRows);
        
        $build_page_url = function($p) use ($perPage) {
            $ci =& get_instance();
            $params = $ci->input->get();
            $params['page'] = $p;
            $params['per_page'] = $perPage;
            return base_url('monitoring') . '?' . http_build_query($params);
        };
    ?>
<div class="pagination-wrapper" style="justify-content: space-between;">
    <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">
        Menampilkan <?= $startItem ?> - <?= $endItem ?> dari <?= $totalRows ?> data
    </div>
    
    <div class="pagination-pages">
        <a href="<?= $build_page_url(1) ?>" class="pagination-page-btn" title="First Page" <?= $currentPage <= 1 ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
            <i class="bi bi-chevron-double-left"></i>
        </a>
        <a href="<?= $build_page_url(max(1, $currentPage - 1)) ?>" class="pagination-page-btn" title="Previous Page" <?= $currentPage <= 1 ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
            <i class="bi bi-chevron-left"></i>
        </a>
        
        <?php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            if ($startPage > 1) echo '<button class="pagination-page-btn" disabled style="cursor: default; border-color: transparent;">...</button>';
            for ($p = $startPage; $p <= $endPage; $p++) {
                $activeClass = $p === $currentPage ? 'active' : '';
                echo '<a href="'.$build_page_url($p).'" class="pagination-page-btn '.$activeClass.'" style="text-decoration:none;">'.$p.'</a>';
            }
            if ($endPage < $totalPages) echo '<button class="pagination-page-btn" disabled style="cursor: default; border-color: transparent;">...</button>';
        ?>
        
        <a href="<?= $build_page_url(min($totalPages, $currentPage + 1)) ?>" class="pagination-page-btn" title="Next Page" <?= $currentPage >= $totalPages ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
            <i class="bi bi-chevron-right"></i>
        </a>
        <a href="<?= $build_page_url($totalPages) ?>" class="pagination-page-btn" title="Last Page" <?= $currentPage >= $totalPages ? 'style="pointer-events:none; opacity:0.5;"' : '' ?>>
            <i class="bi bi-chevron-double-right"></i>
        </a>
    </div>
    
    <div>
        <select class="select-control" id="perPageSelect" style="padding: 0.35rem 2rem 0.35rem 0.75rem; min-width: 130px; font-size: 0.8rem; border-radius: var(--br-6);">
            <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 / halaman</option>
            <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25 / halaman</option>
            <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50 / halaman</option>
        </select>
    </div>
</div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search');
        const searchIcon = document.getElementById('searchIcon');
        const categorySelect = document.getElementById('category');
        
        let debounceTimer;

        // Restore focus if it was focused before form submission
        if (sessionStorage.getItem('searchFocus') === '1' && searchInput) {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
            sessionStorage.removeItem('searchFocus');
        } else if (searchInput && searchInput.value !== '') {
            // Also focus if there's a search value (user arrived from a search link)
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                
                // If it is completely cleared, submit immediately to show all data
                if (this.value === '') {
                    sessionStorage.setItem('searchFocus', '1');
                    this.form.submit();
                    return;
                }
                
                // Debounce search: submit form after 600ms of no typing
                debounceTimer = setTimeout(() => {
                    sessionStorage.setItem('searchFocus', '1');
                    this.form.submit();
                }, 600);
            });
            
            // If they press Enter, remember focus
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sessionStorage.setItem('searchFocus', '1');
                }
            });
        }

        if (searchIcon && searchInput) {
            searchIcon.addEventListener('click', function() {
                sessionStorage.setItem('searchFocus', '1');
                searchInput.form.submit();
            });
        }

        if (categorySelect) {
            // Auto submit when category is selected
            categorySelect.addEventListener('change', function() {
                this.form.submit();
            });
            
            // Allow Enter key to submit on select dropdown as well
            categorySelect.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });
        }
        
        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('per_page', this.value);
                urlParams.set('page', '1');
                window.location.search = urlParams.toString();
            });
        }
    });
</script>
