<!-- Header Action Card -->
<div class="card" style="margin-bottom: 2rem; padding: 1rem 1.25rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
        <!-- Left side: Search Filter -->
        <form action="<?= base_url('categories') ?>" method="GET" style="margin: 0; flex: 1; max-width: 300px;">
            <div style="position: relative; width: 100%;">
                <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="<?= isset($searchQuery) ? esc($searchQuery) : '' ?>" autocomplete="off" style="padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.85rem; padding-right: 2.5rem; width: 100%;">
                <button type="submit" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; margin: 0; outline: none; cursor: pointer; color: var(--text-muted);">
                    <i class="bi bi-search" style="font-size: 0.95rem;"></i>
                </button>
            </div>
        </form>

        <!-- Right side: Actions -->
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <?php if (!empty($searchQuery)): ?>
                <a href="<?= base_url('categories') ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                    Reset
                </a>
            <?php endif; ?>
            <button type="button" class="btn btn-primary" onclick="openAddModal()" style="background-color: #0c3d79; border-color: #0c3d79; padding: 0.5rem 1.25rem; font-size: 0.85rem;">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
        </div>
    </div>
</div>

<!-- Table Container -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 10%;">No.</th>
                <th style="width: 25%;">Nama Kategori</th>
                <th style="width: 45%;">Deskripsi Kategori</th>
                <th style="width: 15%; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 4rem 2rem;">
                        <i class="bi bi-folder-x" style="font-size: 3rem; color: #cbd5e1; display: block; margin-bottom: 1rem;"></i>
                        Belum ada kategori yang terdaftar.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $index => $cat): ?>
                    <tr>
                        <td style="font-weight: 500; color: var(--text-muted);"><?= $index + 1 ?></td>
                        <td style="font-weight: 600; color: var(--text-dark);"><?= esc($cat['name']) ?></td>
                        <td style="color: var(--text-muted);"><?= esc($cat['description'] ?: '-') ?></td>
                        <td style="text-align: center; white-space: nowrap;">
                            <div style="display: inline-flex; gap: 0.75rem; align-items: center; vertical-align: middle;">
                                <button type="button" onclick="openEditModal(<?= esc($cat['id']) ?>, '<?= addslashes(esc($cat['name'])) ?>', '<?= addslashes(esc($cat['description'] ?: '')) ?>')" title="Edit Kategori" style="border: none; cursor: pointer; display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px; font-size: 1.1rem; background-color: #F0F5FF; color: #2563EB; border-radius: 10px; transition: all 0.2s;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="<?= base_url('categories/delete/' . $cat['id']) ?>" title="Hapus Kategori" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Data monitoring terkait mungkin terdampak.')" style="display: inline-flex; justify-content: center; align-items: center; width: 36px; height: 36px; font-size: 1.1rem; background-color: #FFF0F0; color: #EF4444; border-radius: 10px; text-decoration: none; transition: all 0.2s;">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Kategori Baru</h3>
            <button class="modal-close" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="<?= base_url('categories/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="add_name">Nama Kategori</label>
                <input type="text" id="add_name" name="name" class="form-control" placeholder="Masukkan nama kategori (misal: Kepegawaian)..." required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="add_description">Deskripsi</label>
                <textarea id="add_description" name="description" class="textarea-control" placeholder="Masukkan deskripsi singkat kategori kerja..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Kategori</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" action="" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="edit_name">Nama Kategori</label>
                <input type="text" id="edit_name" name="name" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="edit_description">Deskripsi</label>
                <textarea id="edit_description" name="description" class="textarea-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui Kategori</button>
            </div>
        </form>
    </div>
</div>

<script>
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const editName = document.getElementById('edit_name');
    const editDesc = document.getElementById('edit_description');

    function openAddModal() {
        addModal.classList.add('show');
    }

    function closeAddModal() {
        addModal.classList.remove('show');
    }

    function openEditModal(id, name, description) {
        editForm.action = `<?= base_url('categories/update') ?>/${id}`;
        editName.value = name;
        editDesc.value = description;
        editModal.classList.add('show');
    }

    function closeEditModal() {
        editModal.classList.remove('show');
    }

    // Close modal on click outside
    window.onclick = function(event) {
        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    }
</script>
