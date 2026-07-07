<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Quarter Tabs System (Triwulan I - IV) protected by current year state -->
<div class="triwulan-tabs-container">
    <?php for ($t = 1; $t <= 4; $t++): ?>
        <a href="<?= base_url("monitoring?year={$selectedYear}&triwulan={$t}") ?>" 
           class="triwulan-tab-btn <?= ((int)$selectedTriwulan === $t) ? 'active' : '' ?>">
            Triwulan <?= str_repeat('I', $t === 4 ? 3 : $t) ?><?= $t === 4 ? 'V' : '' /* Simple Roman numerals I, II, III, IV */ ?>
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
                    <i class="bi bi-search" style="font-size: 0.95rem;"></i>
                </div>

                <!-- Category filter dropdown -->
                <select id="category" name="category" class="select-control" style="width: 170px; padding: 0.5rem 2rem 0.5rem 0.75rem; font-size: 0.85rem;">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
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
                    Terapkan Filter
                </button>
            </div>

            <!-- Right side: Actions (Add Data & Exports) on the same line -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <a href="<?= base_url('monitoring/create') ?>" class="btn btn-primary" style="background-color: #0c3d79; border-color: #0c3d79; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
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
                <th style="width: 13%;">Status</th>
                <th style="width: 12%;">PJ</th>
                <th style="width: 12%;">Timeline</th>
                <th style="width: 12%;">Keterangan</th>
                <th style="width: 4%; text-align: center;">Tautan</th>
                <th style="width: 10%; text-align: right;">Aksi</th>
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
                        <td><?= $index + 1 ?></td>
                        <td style="font-weight: 600; color: var(--text-dark);"><?= esc($item['title']) ?></td>
                        <td><?= esc($item['category_name']) ?></td>
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
                        <td style="font-weight: 500;"><?= esc($item['reporter_name']) ?></td>
                        <td style="color: var(--text-muted); font-size: 0.8rem;">
                            <?= date('d M Y H:i', strtotime($item['created_at'])) ?>
                        </td>
                        <td style="color: var(--text-muted); font-size: 0.8rem;"><?= esc($item['description'] ?: '-') ?></td>
                        <td style="text-align: center;">
                            <a href="#" class="btn-tertiary" title="Buka tautan dokumen" style="padding: 0; font-size: 1.15rem; color: var(--primary);">
                                <i class="bi bi-link-45deg"></i>
                            </a>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <?php 
                                $canModify = false;
                                if (session()->get('role') === 'admin' || $item['created_by'] == session()->get('id')) {
                                    $canModify = true;
                                }
                            ?>
                            <div style="display: inline-flex; gap: 0.35rem; align-items: center; vertical-align: middle;">
                                <?php if ($canModify): ?>
                                    <a href="<?= base_url('monitoring/edit/' . $item['id']) ?>" class="btn btn-secondary btn-sm" title="Edit Laporan" style="padding: 0.25rem 0.45rem; font-size: 0.85rem; background-color: #EAF2FF; border-color: #3882F6; color: #0A4D9E;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('monitoring/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm" title="Hapus Laporan" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan monitoring ini?')" style="padding: 0.25rem 0.45rem; font-size: 0.85rem; background-color: #FEF2F2; border-color: #FCA5A5; color: #EF4444;">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                <?php else: ?>
                                    <span style="font-size: 0.8rem; color: var(--text-disabled); font-style: italic; margin-right: 0.5rem;" title="Terkunci: Laporan milik pengguna lain">
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

<!-- Pagination UI matching Mockup -->
<div class="pagination-wrapper">
    <div style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">
        Menampilkan 1 - <?= count($monitoringList) ?> dari <?= count($monitoringList) ?> data
    </div>
    

    
    <div>
        <select class="select-control" style="padding: 0.35rem 2rem 0.35rem 0.75rem; min-width: 130px; font-size: 0.8rem; border-radius: var(--br-6);">
            <option>10 / halaman</option>
            <option>25 / halaman</option>
            <option>50 / halaman</option>
        </select>
    </div>
</div>
<?= $this->endSection() ?>
