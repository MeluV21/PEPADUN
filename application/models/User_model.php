<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = [
        'username', 'password', 'nama', 'role',
        'email', 'nip', 'jabatan_id', 'substansi_id', 'image_user', 'level_user', 
        'status_user', 'telp', 'no_dosir', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
        'pangkat', 'tipe_pegawai', 'tmt_pangkat', 'eselon', 'kode_jabatan', 'kelas_jabatan', 
        'fungsi_jabatan', 'pendidikan', 'jurusan', 'tahun_lulus', 'nama_sekolah', 'agama', 
        'tmt_jabatan', 'status_pegawai', 'kedudukan', 'tgl_pensiun', 'masa_kerja', 
        'status_nikah', 'lama_jabatan', 'belum_naikpangkat', 'rumpun_pendidikan', 
        'kontrak_awal', 'kontrak_akhir'
    ];
    protected $useTimestamps    = TRUE;
    protected $createdField     = 'created';
    protected $updatedField     = 'modified';
}
