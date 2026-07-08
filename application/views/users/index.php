<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<style>
    div.dataTables_wrapper div.dataTables_filter { text-align: right; margin-bottom: 15px; }
    div.dataTables_wrapper div.dataTables_length { margin-bottom: 15px; }
    .dt-buttons { margin-bottom: 15px; }
    th { white-space: nowrap; }
    td { white-space: nowrap; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    .modal-content { max-width: 800px !important; width: 90% !important; max-height: 90vh; overflow-y: auto; }
</style>

<div class="page-header">
    <h2>Data Karyawan</h2>
    <button class="btn btn-primary" onclick="openAddModal()">
        <i class="bi bi-person-plus-fill"></i> Tambah Data
    </button>
</div>

<div class="table-responsive" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <table id="usersTable" class="table table-striped table-bordered custom-table" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Substansi</th>
                <th>Image User</th>
                <th>Level User</th>
                <th>Status User</th>
                <th>Telepon/WhatsApp</th>
                <th>No Dosir</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Pangkat</th>
                <th>Tipe Pegawai</th>
                <th>TMT Pangkat</th>
                <th>Eselon</th>
                <th>Kode Jabatan</th>
                <th>Kelas Jabatan</th>
                <th>Fungsi Jabatan</th>
                <th>Pendidikan</th>
                <th>Jurusan</th>
                <th>Tahun Lulus</th>
                <th>Nama Sekolah</th>
                <th>Agama</th>
                <th>TMT Jabatan</th>
                <th>Status Pegawai</th>
                <th>Kedudukan</th>
                <th>Tgl Pensiun</th>
                <th>Masa Kerja</th>
                <th>Status Nikah</th>
                <th>Lama Jabatan</th>
                <th>Belum Naik Pangkat</th>
                <th>Rumpun Pendidikan</th>
                <th>Kontrak Awal</th>
                <th>Kontrak Akhir</th>
                <th>Role Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $rowIndex = 1; foreach ($users as $user): ?>
                <tr>
                    <td><?= $rowIndex++ ?></td>
                    <td><?= esc($user['username'] ?: '-') ?></td>
                    <td><?= esc($user['email'] ?: '-') ?></td>
                    <td><?= esc($user['fullname'] ?: '-') ?></td>
                    <td><?= esc($user['nip'] ?: '-') ?></td>
                    <td><?= esc($user['jabatan_id'] ?: '-') ?></td>
                    <td><?= esc($user['substansi_id'] ?: '-') ?></td>
                    <td><?= esc($user['image_user'] ?: '-') ?></td>
                    <td><?= esc($user['level_user'] ?: '-') ?></td>
                    <td><?= esc($user['status_user'] ?: '-') ?></td>
                    <td><?= esc($user['telp'] ?: '-') ?></td>
                    <td><?= esc($user['no_dosir'] ?: '-') ?></td>
                    <td><?= esc($user['tempat_lahir'] ?: '-') ?></td>
                    <td><?= esc($user['tanggal_lahir'] ?: '-') ?></td>
                    <td><?= esc($user['jenis_kelamin'] ?: '-') ?></td>
                    <td><?= esc($user['pangkat'] ?: '-') ?></td>
                    <td><?= esc($user['tipe_pegawai'] ?: '-') ?></td>
                    <td><?= esc($user['tmt_pangkat'] ?: '-') ?></td>
                    <td><?= esc($user['eselon'] ?: '-') ?></td>
                    <td><?= esc($user['kode_jabatan'] ?: '-') ?></td>
                    <td><?= esc($user['kelas_jabatan'] ?: '-') ?></td>
                    <td><?= esc($user['fungsi_jabatan'] ?: '-') ?></td>
                    <td><?= esc($user['pendidikan'] ?: '-') ?></td>
                    <td><?= esc($user['jurusan'] ?: '-') ?></td>
                    <td><?= esc($user['tahun_lulus'] ?: '-') ?></td>
                    <td><?= esc($user['nama_sekolah'] ?: '-') ?></td>
                    <td><?= esc($user['agama'] ?: '-') ?></td>
                    <td><?= esc($user['tmt_jabatan'] ?: '-') ?></td>
                    <td><?= esc($user['status_pegawai'] ?: '-') ?></td>
                    <td><?= esc($user['kedudukan'] ?: '-') ?></td>
                    <td><?= esc($user['tgl_pensiun'] ?: '-') ?></td>
                    <td><?= esc($user['masa_kerja'] ?: '-') ?></td>
                    <td><?= esc($user['status_nikah'] ?: '-') ?></td>
                    <td><?= esc($user['lama_jabatan'] ?: '-') ?></td>
                    <td><?= esc($user['belum_naikpangkat'] ?: '-') ?></td>
                    <td><?= esc($user['rumpun_pendidikan'] ?: '-') ?></td>
                    <td><?= esc($user['kontrak_awal'] ?: '-') ?></td>
                    <td><?= esc($user['kontrak_akhir'] ?: '-') ?></td>
                    <td><?= esc($user['role'] ?: '-') ?></td>
                    <td>
                        <div class="btn-group" style="justify-content: flex-start;">
                            <button class="btn btn-secondary btn-sm" onclick='openEditModal(<?= json_encode($user) ?>)'>
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
            <h3>Tambah Data Karyawan</h3>
            <button class="modal-close" type="button" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="<?= base_url('users/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="add_password">Password (Wajib untuk Login)</label>
                <input type="password" id="add_password" name="password" class="form-control" placeholder="Masukkan password (minimal 6 karakter)..." required>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="add_username">Username</label>
                    <input type="text" id="add_username" name="username" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="add_email">Email</label>
                    <input type="text" id="add_email" name="email" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_fullname">Nama</label>
                    <input type="text" id="add_fullname" name="fullname" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="add_nip">NIP</label>
                    <input type="text" id="add_nip" name="nip" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_jabatan_id">Jabatan</label>
                    <input type="text" id="add_jabatan_id" name="jabatan_id" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_substansi_id">Substansi</label>
                    <input type="text" id="add_substansi_id" name="substansi_id" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_image_user">Image User</label>
                    <input type="text" id="add_image_user" name="image_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_level_user">Level User</label>
                    <input type="text" id="add_level_user" name="level_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_status_user">Status User</label>
                    <input type="text" id="add_status_user" name="status_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_telp">Telepon/WhatsApp</label>
                    <input type="text" id="add_telp" name="telp" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_no_dosir">No Dosir</label>
                    <input type="text" id="add_no_dosir" name="no_dosir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="add_tempat_lahir" name="tempat_lahir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tanggal_lahir">Tanggal Lahir</label>
                    <input type="text" id="add_tanggal_lahir" name="tanggal_lahir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_jenis_kelamin">Jenis Kelamin</label>
                    <input type="text" id="add_jenis_kelamin" name="jenis_kelamin" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_pangkat">Pangkat</label>
                    <input type="text" id="add_pangkat" name="pangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tipe_pegawai">Tipe Pegawai</label>
                    <input type="text" id="add_tipe_pegawai" name="tipe_pegawai" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tmt_pangkat">TMT Pangkat</label>
                    <input type="text" id="add_tmt_pangkat" name="tmt_pangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_eselon">Eselon</label>
                    <input type="text" id="add_eselon" name="eselon" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_kode_jabatan">Kode Jabatan</label>
                    <input type="text" id="add_kode_jabatan" name="kode_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_kelas_jabatan">Kelas Jabatan</label>
                    <input type="text" id="add_kelas_jabatan" name="kelas_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_fungsi_jabatan">Fungsi Jabatan</label>
                    <input type="text" id="add_fungsi_jabatan" name="fungsi_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_pendidikan">Pendidikan</label>
                    <input type="text" id="add_pendidikan" name="pendidikan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_jurusan">Jurusan</label>
                    <input type="text" id="add_jurusan" name="jurusan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tahun_lulus">Tahun Lulus</label>
                    <input type="text" id="add_tahun_lulus" name="tahun_lulus" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_nama_sekolah">Nama Sekolah</label>
                    <input type="text" id="add_nama_sekolah" name="nama_sekolah" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_agama">Agama</label>
                    <input type="text" id="add_agama" name="agama" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tmt_jabatan">TMT Jabatan</label>
                    <input type="text" id="add_tmt_jabatan" name="tmt_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_status_pegawai">Status Pegawai</label>
                    <input type="text" id="add_status_pegawai" name="status_pegawai" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_kedudukan">Kedudukan</label>
                    <input type="text" id="add_kedudukan" name="kedudukan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_tgl_pensiun">Tgl Pensiun</label>
                    <input type="text" id="add_tgl_pensiun" name="tgl_pensiun" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_masa_kerja">Masa Kerja</label>
                    <input type="text" id="add_masa_kerja" name="masa_kerja" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_status_nikah">Status Nikah</label>
                    <input type="text" id="add_status_nikah" name="status_nikah" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_lama_jabatan">Lama Jabatan</label>
                    <input type="text" id="add_lama_jabatan" name="lama_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_belum_naikpangkat">Belum Naik Pangkat</label>
                    <input type="text" id="add_belum_naikpangkat" name="belum_naikpangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_rumpun_pendidikan">Rumpun Pendidikan</label>
                    <input type="text" id="add_rumpun_pendidikan" name="rumpun_pendidikan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_kontrak_awal">Kontrak Awal</label>
                    <input type="text" id="add_kontrak_awal" name="kontrak_awal" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_kontrak_akhir">Kontrak Akhir</label>
                    <input type="text" id="add_kontrak_akhir" name="kontrak_akhir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="add_role">Role Akses</label>
                    <select id="add_role" name="role" class="select-control" required>
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer" style="margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Data Karyawan</h3>
            <button class="modal-close" type="button" onclick="closeEditModal()">&times;</button>
        </div>
        <form id="editForm" action="" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="edit_password">Password <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" id="edit_password" name="password" class="form-control" placeholder="Masukkan password baru...">
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="edit_username">Username</label>
                    <input type="text" id="edit_username" name="username" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="text" id="edit_email" name="email" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_fullname">Nama</label>
                    <input type="text" id="edit_fullname" name="fullname" class="form-control" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="edit_nip">NIP</label>
                    <input type="text" id="edit_nip" name="nip" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_jabatan_id">Jabatan</label>
                    <input type="text" id="edit_jabatan_id" name="jabatan_id" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_substansi_id">Substansi</label>
                    <input type="text" id="edit_substansi_id" name="substansi_id" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_image_user">Image User</label>
                    <input type="text" id="edit_image_user" name="image_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_level_user">Level User</label>
                    <input type="text" id="edit_level_user" name="level_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_status_user">Status User</label>
                    <input type="text" id="edit_status_user" name="status_user" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_telp">Telepon/WhatsApp</label>
                    <input type="text" id="edit_telp" name="telp" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_no_dosir">No Dosir</label>
                    <input type="text" id="edit_no_dosir" name="no_dosir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tanggal_lahir">Tanggal Lahir</label>
                    <input type="text" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                    <input type="text" id="edit_jenis_kelamin" name="jenis_kelamin" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_pangkat">Pangkat</label>
                    <input type="text" id="edit_pangkat" name="pangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tipe_pegawai">Tipe Pegawai</label>
                    <input type="text" id="edit_tipe_pegawai" name="tipe_pegawai" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tmt_pangkat">TMT Pangkat</label>
                    <input type="text" id="edit_tmt_pangkat" name="tmt_pangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_eselon">Eselon</label>
                    <input type="text" id="edit_eselon" name="eselon" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_kode_jabatan">Kode Jabatan</label>
                    <input type="text" id="edit_kode_jabatan" name="kode_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_kelas_jabatan">Kelas Jabatan</label>
                    <input type="text" id="edit_kelas_jabatan" name="kelas_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_fungsi_jabatan">Fungsi Jabatan</label>
                    <input type="text" id="edit_fungsi_jabatan" name="fungsi_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_pendidikan">Pendidikan</label>
                    <input type="text" id="edit_pendidikan" name="pendidikan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_jurusan">Jurusan</label>
                    <input type="text" id="edit_jurusan" name="jurusan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tahun_lulus">Tahun Lulus</label>
                    <input type="text" id="edit_tahun_lulus" name="tahun_lulus" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_nama_sekolah">Nama Sekolah</label>
                    <input type="text" id="edit_nama_sekolah" name="nama_sekolah" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_agama">Agama</label>
                    <input type="text" id="edit_agama" name="agama" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tmt_jabatan">TMT Jabatan</label>
                    <input type="text" id="edit_tmt_jabatan" name="tmt_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_status_pegawai">Status Pegawai</label>
                    <input type="text" id="edit_status_pegawai" name="status_pegawai" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_kedudukan">Kedudukan</label>
                    <input type="text" id="edit_kedudukan" name="kedudukan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_tgl_pensiun">Tgl Pensiun</label>
                    <input type="text" id="edit_tgl_pensiun" name="tgl_pensiun" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_masa_kerja">Masa Kerja</label>
                    <input type="text" id="edit_masa_kerja" name="masa_kerja" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_status_nikah">Status Nikah</label>
                    <input type="text" id="edit_status_nikah" name="status_nikah" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_lama_jabatan">Lama Jabatan</label>
                    <input type="text" id="edit_lama_jabatan" name="lama_jabatan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_belum_naikpangkat">Belum Naik Pangkat</label>
                    <input type="text" id="edit_belum_naikpangkat" name="belum_naikpangkat" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_rumpun_pendidikan">Rumpun Pendidikan</label>
                    <input type="text" id="edit_rumpun_pendidikan" name="rumpun_pendidikan" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_kontrak_awal">Kontrak Awal</label>
                    <input type="text" id="edit_kontrak_awal" name="kontrak_awal" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_kontrak_akhir">Kontrak Akhir</label>
                    <input type="text" id="edit_kontrak_akhir" name="kontrak_akhir" class="form-control" autocomplete="off" >
                </div>
                <div class="form-group">
                    <label for="edit_role">Role Akses</label>
                    <select id="edit_role" name="role" class="select-control" required>
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer" style="margin-top: 20px;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            scrollX: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: '<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>' +
                 '<'row'<'col-sm-12'tr>>' +
                 '<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
            ],
            language: {
                search: "Search:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data yang ditemukan",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
        
        table.buttons().container().appendTo( '#usersTable_wrapper .col-md-6:eq(0)' );
    });

    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');

    function openAddModal() {
        addModal.classList.add('show');
    }

    function closeAddModal() {
        addModal.classList.remove('show');
    }

    function openEditModal(userData) {
        editForm.action = `<?= base_url('users/update') ?>/${userData.id}`;
        
        for (const key in userData) {
            const el = document.getElementById('edit_' + key);
            if (el && key !== 'password') {
                el.value = userData[key];
            }
        }
        
        document.getElementById('edit_password').value = '';
        editModal.classList.add('show');
    }

    function closeEditModal() {
        editModal.classList.remove('show');
    }

    window.onclick = function(event) {
        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    }
</script>
