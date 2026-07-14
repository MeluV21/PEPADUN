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
                <div class="input-icon-wrapper" style="width: 200px; margin-bottom: 0;">
                    <input type="text" id="search" name="search" class="form-control form-control-icon" placeholder="Cari informasi..." value="<?= esc($searchQuery ?? '') ?>" autocomplete="off" style="padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.85rem;" onkeypress="if(event.keyCode === 13) { this.form.submit(); return false; }">
                    <i class="bi bi-search" style="font-size: 0.95rem;"></i>
                </div>

                <!-- Category filter dropdown -->
                <select id="category" name="category" class="select-control" onchange="this.form.submit()" style="width: 170px; padding: 0.5rem 2.5rem 0.5rem 0.75rem; font-size: 0.85rem;">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): 
                        if (strtolower(trim($cat['name'])) === 'tanpa kategori') continue;
                    ?>
                        <option value="<?= esc($cat['id']) ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Status filter dropdown -->
                <select id="status" name="status" class="select-control" onchange="this.form.submit()" style="width: 170px; padding: 0.5rem 2.5rem 0.5rem 0.75rem; font-size: 0.85rem;">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($selectedStatus == 'pending') ? 'selected' : '' ?>>Belum Update</option>
                    <option value="progress" <?= ($selectedStatus == 'progress') ? 'selected' : '' ?>>Dalam Proses</option>
                    <option value="completed" <?= ($selectedStatus == 'completed') ? 'selected' : '' ?>>Selesai (Completed)</option>
                </select>
                
                <!-- Action buttons for filtering -->
                <?php if (!empty($searchQuery) || !empty($selectedCategory) || !empty($selectedStatus)): ?>
                    <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$selectedTriwulan}") ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                        Reset Filter
                    </a>
                <?php endif; ?>
            </div>

            <!-- Right side: Actions -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <button type="button" class="btn btn-primary" onclick="openTambahModal()" style="background-color: #0c3d79; border-color: #0c3d79; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                    <i class="bi bi-plus-lg"></i> Tambah
                </button>
                <?php
                    $exportQuery = "year={$selectedYear}&triwulan={$selectedTriwulan}";
                    if (!empty($selectedCategory)) $exportQuery .= "&category=" . urlencode($selectedCategory);
                    if (!empty($selectedStatus)) $exportQuery .= "&status=" . urlencode($selectedStatus);
                    if (!empty($searchQuery)) $exportQuery .= "&search=" . urlencode($searchQuery);
                ?>
                
                <!-- Custom Export Dropdown -->
                <div style="position: relative; display: inline-block;" onmouseover="this.querySelector('.export-menu').style.display='block'" onmouseout="this.querySelector('.export-menu').style.display='none'">
                    <button type="button" class="btn btn-secondary" style="padding: 0.5rem 1.25rem; font-size: 0.85rem; color: #0c3d79; border-color: #0c3d79;">
                        <i class="bi bi-download"></i> Export <i class="bi bi-chevron-down" style="font-size: 0.7rem; margin-left: 5px;"></i>
                    </button>
                    <!-- padding-top is used to bridge the hover gap between button and menu -->
                    <div class="export-menu" style="display: none; position: absolute; right: 0; top: 100%; min-width: 140px; z-index: 10; padding-top: 5px;">
                        <div style="background-color: #fff; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; padding: 0.5rem 0;">
                            <a href="<?= base_url('monitoring/export_excel?' . $exportQuery) ?>" style="color: #334155; padding: 8px 16px; text-decoration: none; display: block; font-size: 0.85rem; font-weight: 500;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'">
                                <i class="bi bi-file-earmark-excel" style="color: #10b981; margin-right: 5px;"></i> Excel
                            </a>
                            <a href="<?= base_url('monitoring/export_pdf?' . $exportQuery) ?>" target="_blank" style="color: #334155; padding: 8px 16px; text-decoration: none; display: block; font-size: 0.85rem; font-weight: 500;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'">
                                <i class="bi bi-file-earmark-pdf" style="color: #ef4444; margin-right: 5px;"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Table Panel -->
<div class="table-responsive">
    <table class="custom-table" style="min-width: 1000px;">
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
                <th style="width: 8%; text-align: center;">Aksi</th>
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
                                <a href="<?= esc($item['tautan']) ?>" target="_blank" class="btn-tertiary" title="<?= esc($item['tautan']) ?>" style="padding: 0; font-size: 1.15rem; color: var(--primary);">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 0.8rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            <?php 
                                $canModify = false;
                                if (session()->get('role') === 'admin' || $item['created_by'] == session()->get('id') || !$item['created_by']) {
                                    $canModify = true;
                                }
                            ?>
                            <div style="display: inline-flex; gap: 0.75rem; align-items: center; vertical-align: middle;">
                                <?php if ($canModify): ?>
                                    <button type="button" onclick="openEditModal(<?= $item['id'] ?>, <?= $selectedYear ?>, <?= $selectedTriwulan ?>, '<?= addslashes(esc($item['custom_name'] ?: $item['name'])) ?>', '<?= addslashes(esc($item['status'] ?: 'pending')) ?>', '<?= addslashes(esc($item['pj'] ?: '')) ?>', '<?= addslashes(esc(preg_replace("/\r|\n/", "\\n", $item['description'] ?: ''))) ?>', '<?= $item['category_id'] ?>', '<?= $item['timeline'] ?>', '<?= addslashes(esc($item['tautan'] ?: '')) ?>')" title="Update Status" style="border: none; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px; font-size: 1.1rem; background-color: #F0F5FF; color: #2563EB; border-radius: 10px; transition: all 0.2s;">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" onclick="openDeleteModal(<?= $item['id'] ?>, <?= $selectedYear ?>, <?= $selectedTriwulan ?>)" title="Hapus Laporan" style="border: none; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px; font-size: 1.1rem; background-color: #FFF0F0; color: #EF4444; border-radius: 10px; transition: all 0.2s;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php else: ?>
                                    <span style="font-size: 0.85rem; color: var(--text-disabled); font-style: italic;" title="Terkunci: Diubah oleh pengguna lain">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
/* Seamless TomSelect Integration */
.custom-ts-wrapper .ts-control {
    border: 1px solid #d1d5db !important;
    border-radius: 6px !important;
    padding: 0.55rem 0.75rem !important;
    box-shadow: none !important;
    background-color: #fff !important;
    font-size: 0.9rem !important;
}
.custom-ts-wrapper.focus .ts-control {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
}
.custom-ts-wrapper .ts-control > input {
    font-size: 0.9rem !important;
}
.custom-ts-wrapper .ts-control .item {
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    color: #1e293b !important;
    font-size: 0.9rem !important;
}
.custom-ts-wrapper .ts-dropdown {
    background-color: #ffffff !important;
    color: #1e293b !important;
    border: 1px solid #d1d5db !important;
    border-radius: 6px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}
.custom-ts-wrapper .ts-dropdown .option, 
.custom-ts-wrapper .ts-dropdown .create {
    padding: 10px 15px !important;
    color: #1e293b !important;
}
.custom-ts-wrapper .ts-dropdown .option.active, 
.custom-ts-wrapper .ts-dropdown .create.active {
    background-color: #f1f5f9 !important;
    color: #0f172a !important;
}
</style>

<!-- Header Action Card -->
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

<!-- Modal Tambah Data Global -->
<div id="tambahDataModal" class="modal">
  <div class="modal-content" style="max-width: 650px;">
      <div class="modal-header">
        <h3 class="modal-title">Tambah Informasi</h3>
        <button type="button" class="modal-close" onclick="closeTambahModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('monitoring/store_master') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="year" value="<?= esc($selectedYear) ?>">
            <input type="hidden" name="triwulan" value="<?= esc($selectedTriwulan) ?>">

            <div class="form-group">
                <label for="add_name">Nama Informasi <span style="color: red;">*</span></label>
                <input type="text" id="add_name" name="name" class="form-control" placeholder="Tulis nama informasi..." required autocomplete="off">
            </div>
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="add_category">Kategori <span style="color: red;">*</span></label>
                    <select id="add_category" name="category_id" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <?php if (strtolower(trim($cat['name'])) !== 'tanpa kategori'): ?>
                                <option value="<?= esc($cat['id']) ?>"><?= esc($cat['name']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="add_timeline">Timeline <span style="color: red;">*</span></label>
                    <select id="add_timeline" name="timeline" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="">Pilih Timeline</option>
                        <option value="Realtime">Realtime</option>
                        <option value="Harian">Harian</option>
                        <option value="Mingguan">Mingguan</option>
                        <option value="Bulanan">Bulanan</option>
                        <option value="Triwulan">Triwulan</option>
                        <option value="Tahunan">Tahunan</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="add_status">Status <span style="color: red;">*</span></label>
                    <select id="add_status" name="status" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="pending" selected>Belum Update</option>
                        <option value="progress">Dalam Proses</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="add_pj">Penanggung Jawab (Opsional)</label>
                    <select id="add_pj" name="pj" placeholder="Pilih atau ketik nama PJ..." autocomplete="off">
                        <option value="">Pilih atau ketik nama PJ...</option>
                        <?php if(isset($users)): ?>
                            <?php foreach($users as $user): ?>
                                <option value="<?= esc($user['nama']) ?>"><?= esc($user['nama']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="add_tautan">Tautan / Link <span style="color: red;">*</span></label>
                <input type="url" id="add_tautan" name="tautan" class="form-control" placeholder="Contoh: https://link-dokumen.com" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="add_description">Keterangan (Opsional)</label>
                <textarea id="add_description" name="description" class="textarea-control" style="min-height: 100px;" placeholder="Tuliskan keterangan..."></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeTambahModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
  </div>
</div>

<!-- Modal Update Status Monitoring -->
<div id="editDataModal" class="modal">
  <div class="modal-content" style="max-width: 650px;">
      <div class="modal-header">
        <h3 class="modal-title">Update Data Monitoring</h3>
        <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
      </div>
      <div class="modal-body">
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;" id="editModalSubtitle">
          Mengupdate data untuk Triwulan
        </p>
        
        <form id="editForm" action="" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="edit_custom_name">Nama Informasi <span style="color: red;">*</span></label>
                <input type="text" id="edit_custom_name" name="custom_name" class="form-control" required autocomplete="off">
            </div>
            
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="edit_category">Kategori <span style="color: red;">*</span></label>
                    <select id="edit_category" name="category_id" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <?php if (strtolower(trim($cat['name'])) !== 'tanpa kategori'): ?>
                                <option value="<?= esc($cat['id']) ?>"><?= esc($cat['name']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="edit_timeline">Timeline <span style="color: red;">*</span></label>
                    <select id="edit_timeline" name="timeline" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="">Pilih Timeline</option>
                        <option value="Realtime">Realtime</option>
                        <option value="Harian">Harian</option>
                        <option value="Mingguan">Mingguan</option>
                        <option value="Bulanan">Bulanan</option>
                        <option value="Triwulan">Triwulan</option>
                        <option value="Tahunan">Tahunan</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end;">
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="edit_status">Status <span style="color: red;">*</span></label>
                    <select id="edit_status" name="status" class="select-control" required style="background-position: right 1.25rem center; padding-right: 3rem;">
                        <option value="pending">Belum Update</option>
                        <option value="progress">Dalam Proses</option>
                        <option value="completed">Selesai (Completed)</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1; margin-bottom: 0;">
                    <label for="edit_pj">Penanggung Jawab (Opsional)</label>
                    <select id="edit_pj" name="pj" placeholder="Pilih atau ketik nama PJ..." autocomplete="off">
                        <option value="">Pilih atau ketik nama PJ...</option>
                        <?php if(isset($users)): ?>
                            <?php foreach($users as $user): ?>
                                <option value="<?= esc($user['nama']) ?>"><?= esc($user['nama']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="edit_tautan">Tautan / Link <span style="color: red;">*</span></label>
                <input type="url" id="edit_tautan" name="tautan" class="form-control" placeholder="Contoh: https://link-dokumen.com" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="edit_description">Keterangan (Opsional)</label>
                <textarea id="edit_description" name="description" class="textarea-control" style="min-height: 100px;" placeholder="Tuliskan keterangan..."></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tsConfig = {
            create: true,
            maxItems: 1,
            placeholder: "Pilih atau ketik nama PJ...",
            wrapperClass: "ts-wrapper custom-ts-wrapper",
            render: {
                option_create: function(data, escape) {
                    return '<div class="create">Tambahkan <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                },
                no_results: function(data, escape) {
                    return '<div class="no-results" style="padding:10px 15px; color:#64748b;">Tidak ditemukan, ketik untuk menambahkan</div>';
                }
            }
        };
        
        let tsAdd = new TomSelect("#add_pj", tsConfig);
        let tsEdit = new TomSelect("#edit_pj", tsConfig);
        
        // Expose to window for the edit modal to update its value dynamically
        window.tsEdit = tsEdit;
    });

    const tambahModal = document.getElementById('tambahDataModal');
    const editModal = document.getElementById('editDataModal');
    
    function openEditModal(masterId, year, triwulan, customName, status, pj, desc, categoryId, timeline, tautan) {
        document.getElementById('editForm').action = `<?= base_url('monitoring/update') ?>/${masterId}/${year}/${triwulan}`;
        document.getElementById('edit_custom_name').value = customName;
        document.getElementById('edit_status').value = status || 'pending';
        
        if(window.tsEdit) {
            if(pj && pj.trim() !== '') {
                window.tsEdit.addOption({value: pj, text: pj});
                window.tsEdit.setValue(pj);
            } else {
                window.tsEdit.clear();
            }
        }
        
        document.getElementById('edit_description').value = desc || '';
        document.getElementById('edit_category').value = categoryId || '';
        document.getElementById('edit_timeline').value = timeline || '';
        document.getElementById('edit_tautan').value = tautan || '';
        
        let triwulanRoman = triwulan == 1 ? 'I' : (triwulan == 2 ? 'II' : (triwulan == 3 ? 'III' : 'IV'));
        document.getElementById('editModalSubtitle').innerHTML = `Mengupdate data untuk <strong style="color: #0c3d79;">Triwulan ${triwulanRoman} Tahun ${year}</strong>`;
        
        if(editModal) editModal.classList.add('show');
    }
    
    function closeEditModal() {
        if(editModal) editModal.classList.remove('show');
    }
    
    function openTambahModal() {
        if(tambahModal) tambahModal.classList.add('show');
    }
    
    function closeTambahModal() {
        if(tambahModal) tambahModal.classList.remove('show');
    }
    
    // Close modal if clicked outside
    window.addEventListener('click', function(event) {
        if (event.target === tambahModal) {
            closeTambahModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    });

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
        
        const statusSelect = document.getElementById('status');
        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                this.form.submit();
            });
            statusSelect.addEventListener('keypress', function(e) {
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

<!-- Delete Choice Modal -->
<div id="deleteModal" class="modal-overlay" onclick="closeDeleteModal()" style="display: none; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); position: fixed; inset: 0; z-index: 1000; opacity: 0; transition: opacity 0.3s ease;">
    <div class="modal-content" onclick="event.stopPropagation()" style="background: white; border-radius: 12px; padding: 2rem; max-width: 400px; width: 90%; transform: scale(0.95); transition: transform 0.3s ease;">
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 3rem; color: #f59e0b;"></i>
            <h3 style="margin-top: 1rem; color: #1e293b; font-size: 1.25rem; margin-bottom: 0;">Hapus Data Monitoring</h3>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <a id="btnDeleteLocal" href="#" class="btn btn-warning" style="display: flex; align-items: center; justify-content: center; padding: 0.75rem; gap: 0.5rem; background-color: #f59e0b; border: none; color: white; border-radius: 8px; text-decoration: none;">
                <i class="bi bi-calendar-x"></i> Hanya Hapus di Triwulan Ini
            </a>
            <a id="btnDeleteGlobal" href="#" class="btn btn-danger" style="display: flex; align-items: center; justify-content: center; padding: 0.75rem; gap: 0.5rem; background-color: #ef4444; border: none; color: white; border-radius: 8px; text-decoration: none;" onclick="return confirm('PERINGATAN: Ini akan menghapus data selamanya dari Triwulan 1 sampai 4! Anda yakin?')">
                <i class="bi bi-trash-fill"></i> Hapus Seluruhnya
            </a>
        </div>
    </div>
</div>

<script>
function openDeleteModal(masterId, year, triwulan) {
    const modal = document.getElementById('deleteModal');
    
    // Set URLs
    const baseUrl = '<?= base_url() ?>';
    document.getElementById('btnDeleteLocal').href = baseUrl + 'monitoring/delete/' + masterId + '/' + year + '/' + triwulan;
    document.getElementById('btnDeleteGlobal').href = baseUrl + 'monitoring/delete_global/' + masterId + '/' + year + '/' + triwulan;
    
    // Show modal with animation
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.querySelector('.modal-content').style.transform = 'scale(1)';
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.opacity = '0';
    modal.querySelector('.modal-content').style.transform = 'scale(0.95)';
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}
</script>
