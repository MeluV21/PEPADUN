<?php 
    $isEdit = isset($monitoring) && !empty($monitoring);
    $actionUrl = base_url("monitoring/update/{$masterInfo['id']}/{$year}/{$triwulan}");
    $currentName = $isEdit && !empty($monitoring['custom_name']) ? $monitoring['custom_name'] : $masterInfo['name'];
?>

<div class="page-header">
    <h2><?= esc($title) ?></h2>
    <a href="<?= base_url("monitoring?year={$year}&triwulan={$triwulan}") ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    
    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--neutral-light);">
        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.5rem;">
            <span>Mengupdate data untuk <strong>Triwulan <?= esc($triwulan) ?> Tahun <?= esc($year) ?></strong></span>
        </div>
    </div>

    <form action="<?= $actionUrl ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="custom_name">Nama Informasi / Laporan <span style="color: red;">*</span></label>
            <input type="text" id="custom_name" name="custom_name" class="form-control" value="<?= old('custom_name', $currentName) ?>" required autocomplete="off">
            <small style="color: var(--text-muted); font-size: 0.8rem;">Mengubah nama di sini hanya akan berlaku untuk Triwulan <?= esc($triwulan) ?> saja.</small>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="status">Status Perkembangan <span style="color: red;">*</span></label>
                <select id="status" name="status" class="select-control" required>
                    <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Pilih Status...</option>
                    <option value="pending" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'pending' ? 'selected' : '' ?>>Belum Update (Pending)</option>
                    <option value="progress" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'progress' ? 'selected' : '' ?>>Dalam Proses (Progress)</option>
                    <option value="completed" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'completed' ? 'selected' : '' ?>>Selesai (Completed)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="pj">Penanggung Jawab (PJ) <span style="color: var(--text-muted); font-weight: normal; font-size: 0.8rem;">(Opsional)</span></label>
                <input type="text" id="pj" name="pj" class="form-control" placeholder="Tuliskan nama PJ..." value="<?= old('pj', $isEdit ? $monitoring['pj'] : '') ?>" autocomplete="off">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi & Catatan Perkembangan <span style="color: var(--text-muted); font-weight: normal; font-size: 0.8rem;">(Opsional)</span></label>
            <textarea id="description" name="description" class="textarea-control" style="min-height: 180px;" placeholder="Tuliskan catatan atau link dokumen di sini..."><?= old('description', $isEdit ? $monitoring['description'] : '') ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; border-top: 1px solid var(--neutral-light); padding-top: 1.25rem;">
            <a href="<?= base_url("monitoring?year={$year}&triwulan={$triwulan}") ?>" class="btn btn-secondary" style="padding: 0.6rem 1.5rem;">
                Batal
            </a>
            <button type="submit" class="btn btn-primary" style="padding: 0.6rem 2rem;">
                <i class="bi bi-cloud-arrow-up"></i> Simpan Status
            </button>
        </div>
    </form>
</div>
