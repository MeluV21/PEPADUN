<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php 
    $isEdit = isset($monitoring);
    $actionUrl = $isEdit ? base_url('monitoring/update/' . $monitoring['id']) : base_url('monitoring/store');
?>

<div class="page-header">
    <h2><?= esc($title) ?></h2>
    <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <form action="<?= $actionUrl ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="title">Judul Laporan / Kegiatan Kerja</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Tuliskan nama laporan kegiatan (minimal 5 karakter)..." value="<?= old('title', $isEdit ? $monitoring['title'] : '') ?>" required autocomplete="off">
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="category_id">Kategori Kerja</label>
                <select id="category_id" name="category_id" class="select-control" required>
                    <option value="" disabled <?= !$isEdit ? 'selected' : '' ?>>Pilih Kategori...</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat['id']) ?>" <?= old('category_id', $isEdit ? $monitoring['category_id'] : '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="activity_date">Tanggal Pelaksanaan</label>
                <input type="date" id="activity_date" name="activity_date" class="form-control" value="<?= old('activity_date', $isEdit ? $monitoring['activity_date'] : date('Y-m-d')) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status Perkembangan</label>
            <select id="status" name="status" class="select-control" required>
                <option value="pending" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'pending' ? 'selected' : '' ?>>Belum Update (Pending)</option>
                <option value="progress" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'progress' ? 'selected' : '' ?>>Dalam Proses (Progress)</option>
                <option value="completed" <?= old('status', $isEdit ? $monitoring['status'] : '') === 'completed' ? 'selected' : '' ?>>Selesai (Completed)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Kegiatan & Catatan Perkembangan</label>
            <textarea id="description" name="description" class="textarea-control" style="min-height: 180px;" placeholder="Tuliskan deskripsi lengkap pengerjaan kegiatan serta catatannya di sini (minimal 10 karakter)..." required><?= old('description', $isEdit ? $monitoring['description'] : '') ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; border-top: 1px solid var(--neutral-light); padding-top: 1.25rem;">
            <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary" style="padding: 0.6rem 1.5rem;">
                Batal
            </a>
            <button type="submit" class="btn btn-primary" style="padding: 0.6rem 2rem;">
                <i class="bi bi-cloud-arrow-up"></i> <?= $isEdit ? 'Perbarui Laporan' : 'Simpan Laporan' ?>
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
