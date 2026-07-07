<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h2>Manajemen Pengguna</h2>
    <button class="btn btn-primary" onclick="openAddModal()">
        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
    </button>
</div>

<!-- Table Container -->
<div class="table-responsive">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 10%;">ID User</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 25%;">Username</th>
                <th style="width: 15%;">Role Akses</th>
                <th style="width: 20%; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td style="font-weight: 500; color: var(--text-muted);">#<?= esc($user['id']) ?></td>
                    <td style="font-weight: 600; color: var(--text-dark);"><?= esc($user['fullname']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td>
                        <span class="badge badge-<?= esc($user['role']) ?>">
                            <?= esc($user['role'] === 'admin' ? 'Admin' : 'Karyawan') ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div class="btn-group" style="justify-content: flex-end;">
                            <button class="btn btn-secondary btn-sm" onclick="openEditModal(<?= esc($user['id']) ?>, '<?= esc($user['fullname'], 'js') ?>', '<?= esc($user['username'], 'js') ?>', '<?= esc($user['role'], 'js') ?>')">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <?php if (session()->get('id') != $user['id']): ?>
                                <a href="<?= base_url('users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" style="background-color: transparent; color: var(--danger); border-color: var(--danger);">
                                    <i class="bi bi-trash3"></i> Hapus
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled style="opacity: 0.4;" title="Tidak dapat menghapus akun sendiri">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Pengguna Baru</h3>
            <button class="modal-close" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="<?= base_url('users/store') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="add_fullname">Nama Lengkap</label>
                <input type="text" id="add_fullname" name="fullname" class="form-control" placeholder="Masukkan nama lengkap pengguna..." required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="add_username">Username</label>
                <input type="text" id="add_username" name="username" class="form-control" placeholder="Masukkan username unik..." required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="add_password">Password</label>
                <input type="password" id="add_password" name="password" class="form-control" placeholder="Masukkan password (minimal 6 karakter)..." required>
            </div>
            <div class="form-group">
                <label for="add_role">Role Akses</label>
                <select id="add_role" name="role" class="select-control" required>
                    <option value="karyawan">Karyawan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Pengguna</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" action="" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="edit_fullname">Nama Lengkap</label>
                <input type="text" id="edit_fullname" name="fullname" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="edit_username">Username</label>
                <input type="text" id="edit_username" name="username" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="edit_password">Password <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" id="edit_password" name="password" class="form-control" placeholder="Masukkan password baru...">
            </div>
            <div class="form-group">
                <label for="edit_role">Role Akses</label>
                <select id="edit_role" name="role" class="select-control" required>
                    <option value="karyawan">Karyawan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const editFullname = document.getElementById('edit_fullname');
    const editUsername = document.getElementById('edit_username');
    const editRole = document.getElementById('edit_role');

    function openAddModal() {
        addModal.classList.add('show');
    }

    function closeAddModal() {
        addModal.classList.remove('show');
    }

    function openEditModal(id, fullname, username, role) {
        editForm.action = `<?= base_url('users/update') ?>/${id}`;
        editFullname.value = fullname;
        editUsername.value = username;
        editRole.value = role;
        document.getElementById('edit_password').value = ''; // Reset password field
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
<?= $this->endSection() ?>
