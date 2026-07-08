<?php 
    $actionUrl = base_url('monitoring/store_master');
?>

<div class="page-header">
    <h2><?= esc($title) ?></h2>
    <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--neutral-light);">
        <h4 style="margin-bottom: 0.5rem; color: var(--text-dark);">Informasi Master Baru</h4>
        <div style="font-size: 0.85rem; color: var(--text-muted);">
            Data yang ditambahkan di sini akan otomatis muncul di seluruh triwulan (Triwulan 1 sampai 4).
        </div>
    </div>

    <form action="<?= $actionUrl ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Nama Informasi / Laporan <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Tuliskan nama laporan/informasi baru..." value="<?= old('name') ?>" required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="category_id">Kategori <span style="color: red;">*</span></label>
            <select id="category_id" name="category_id" class="select-control" required>
                <option value="" selected disabled>Pilih Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['id']) ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="timeline">Timeline Waktu <span style="color: red;">*</span></label>
            <select id="timeline" name="timeline" class="select-control" required>
                <option value="" selected disabled>Pilih Timeline...</option>
                <option value="Realtime" <?= old('timeline') == 'Realtime' ? 'selected' : '' ?>>Realtime</option>
                <option value="Harian" <?= old('timeline') == 'Harian' ? 'selected' : '' ?>>Harian</option>
                <option value="Mingguan" <?= old('timeline') == 'Mingguan' ? 'selected' : '' ?>>Mingguan</option>
                <option value="Bulanan" <?= old('timeline') == 'Bulanan' ? 'selected' : '' ?>>Bulanan</option>
                <option value="Triwulan" <?= old('timeline') == 'Triwulan' ? 'selected' : '' ?>>Triwulan</option>
                <option value="Tahunan" <?= old('timeline') == 'Tahunan' ? 'selected' : '' ?>>Tahunan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tautan">Tautan / Link URL <span style="color: red;">*</span></label>
            <input type="url" id="tautan" name="tautan" class="form-control" placeholder="Contoh: https://link-dokumen.com" value="<?= old('tautan') ?>" required autocomplete="off">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; border-top: 1px solid var(--neutral-light); padding-top: 1.25rem;">
            <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary" style="padding: 0.6rem 1.5rem;">
                Batal
            </a>
            <button type="submit" class="btn btn-primary" style="padding: 0.6rem 2rem;">
                <i class="bi bi-cloud-arrow-up"></i> Simpan Data Global
            </button>
        </div>
    </form>
</div>
