<div class="page-header">
    <h2>Manajemen Kategori</h2>
    <button class="btn btn-primary" onclick="openAddModal()">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </button>
</div>

<!-- Table Container -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 10%;">ID Kategori</th>
                <th style="width: 25%;">Nama Kategori</th>
                <th style="width: 45%;">Deskripsi Kategori</th>
                <th style="width: 20%; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada kategori yang terdaftar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td style="font-weight: 500; color: var(--text-muted);">#<?= esc($cat['id']) ?></td>
                        <td style="font-weight: 600; color: var(--text-dark);"><?= esc($cat['name']) ?></td>
                        <td style="color: var(--text-muted);"><?= esc($cat['description'] ?: '-') ?></td>
                        <td style="text-align: right;">
                            <div class="btn-group" style="justify-content: flex-end;">
                                <button class="btn btn-secondary btn-sm" onclick="openEditModal(<?= esc($cat['id']) ?>, '<?= addslashes(esc($cat['name'])) ?>', '<?= addslashes(esc($cat['description'] ?: '')) ?>')">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <a href="<?= base_url('categories/delete/' . $cat['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Data monitoring terkait mungkin terdampak.')" style="background-color: transparent; color: var(--danger); border-color: var(--danger);">
                                    <i class="bi bi-trash3"></i> Hapus
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
