<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seed extends CI_Controller {
    public function index() {
        if (!is_cli()) {
            show_error('CLI access only.');
        }

        $this->load->database();

        echo "Seeding database...\n";

        // Disable foreign key checks for seeding
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->truncate('monitoring');
        $this->db->truncate('categories');
        $this->db->truncate('users');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // 1. Seed Users
        $users = [
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'fullname'   => 'Admin Super',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'karyawan',
                'password'   => password_hash('karyawan123', PASSWORD_BCRYPT),
                'fullname'   => 'Ahmad Karyawan',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'andi',
                'password'   => password_hash('andi123', PASSWORD_BCRYPT),
                'fullname'   => 'Andi Pratama',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'siti',
                'password'   => password_hash('siti123', PASSWORD_BCRYPT),
                'fullname'   => 'Siti Aisyah',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'budi',
                'password'   => password_hash('budi123', PASSWORD_BCRYPT),
                'fullname'   => 'Budi Santoso',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'dewi',
                'password'   => password_hash('dewi123', PASSWORD_BCRYPT),
                'fullname'   => 'Dewi Lestari',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'rizky',
                'password'   => password_hash('rizky123', PASSWORD_BCRYPT),
                'fullname'   => 'Rizky Pratama',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'maya',
                'password'   => password_hash('maya123', PASSWORD_BCRYPT),
                'fullname'   => 'Maya Sari',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'fajar',
                'password'   => password_hash('fajar123', PASSWORD_BCRYPT),
                'fullname'   => 'Fajar Nugroho',
                'role'       => 'karyawan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->insert_batch('users', $users);

        // Fetch User IDs
        $userIds = [];
        $usersList = $this->db->get('users')->result();
        foreach ($usersList as $u) {
            $userIds[$u->fullname] = $u->id;
        }

        // 2. Seed Categories
        $categories = [
            [
                'name'        => 'Profil PPID',
                'description' => 'Dokumen profil Pejabat Pengelola Informasi dan Dokumentasi.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Regulasi',
                'description' => 'Dokumen regulasi dan standar prosedur operasional.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Laporan',
                'description' => 'Dokumen laporan tahunan dan berkala BBPOM.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Kinerja',
                'description' => 'Laporan program kerja dan sasaran kinerja bulanan.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Keuangan',
                'description' => 'Laporan realisasi anggaran dan keuangan.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Layanan Publik',
                'description' => 'Informasi standardisasi dan kepuasan pelayanan publik.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->insert_batch('categories', $categories);

        // Fetch Category IDs
        $catIds = [];
        $catsList = $this->db->get('categories')->result();
        foreach ($catsList as $c) {
            $catIds[$c->name] = $c->id;
        }

        // 3. Seed Monitoring Data
        $monitoring = [
            [
                'title'         => 'Sejarah Singkat BBPOM di Bandar Lampung',
                'category_id'   => $catIds['Profil PPID'],
                'description'   => '-',
                'status'        => 'completed',
                'created_by'    => $userIds['Andi Pratama'],
                'activity_date' => '2025-01-10',
                'created_at'    => '2025-01-10 09:15:00',
                'updated_at'    => '2025-01-10 09:15:00',
            ],
            [
                'title'         => 'Visi dan Misi',
                'category_id'   => $catIds['Profil PPID'],
                'description'   => 'Dokumen tersedia di website',
                'status'        => 'pending',
                'created_by'    => $userIds['Siti Aisyah'],
                'activity_date' => '2025-01-10',
                'created_at'    => '2025-01-10 09:20:00',
                'updated_at'    => '2025-01-10 09:20:00',
            ],
            [
                'title'         => 'Struktur Organisasi',
                'category_id'   => $catIds['Profil PPID'],
                'description'   => 'Update setiap tahun',
                'status'        => 'pending',
                'created_by'    => $userIds['Budi Santoso'],
                'activity_date' => '2025-01-09',
                'created_at'    => '2025-01-09 14:30:00',
                'updated_at'    => '2025-01-09 14:30:00',
            ],
            [
                'title'         => 'Daftar Informasi Publik (DIP)',
                'category_id'   => $catIds['Regulasi'],
                'description'   => 'Data per 10 Jan 2025',
                'status'        => 'progress',
                'created_by'    => $userIds['Dewi Lestari'],
                'activity_date' => '2025-01-08',
                'created_at'    => '2025-01-08 11:10:00',
                'updated_at'    => '2025-01-08 11:10:00',
            ],
            [
                'title'         => 'Laporan Tahunan',
                'category_id'   => $catIds['Laporan'],
                'description'   => 'Dokumen terbaru',
                'status'        => 'completed',
                'created_by'    => $userIds['Rizky Pratama'],
                'activity_date' => '2025-01-12',
                'created_at'    => '2025-01-12 16:45:00',
                'updated_at'    => '2025-01-12 16:45:00',
            ],
            [
                'title'         => 'Program dan Kegiatan',
                'category_id'   => $catIds['Kinerja'],
                'description'   => 'Laporan bulanan',
                'status'        => 'pending',
                'created_by'    => $userIds['Maya Sari'],
                'activity_date' => '2025-01-10',
                'created_at'    => '2025-01-10 10:00:00',
                'updated_at'    => '2025-01-10 10:00:00',
            ],
            [
                'title'         => 'Informasi Anggaran',
                'category_id'   => $catIds['Keuangan'],
                'description'   => '-',
                'status'        => 'completed',
                'created_by'    => $userIds['Fajar Nugroho'],
                'activity_date' => '2025-01-11',
                'created_at'    => '2025-01-11 13:30:00',
                'updated_at'    => '2025-01-11 13:30:00',
            ],
            [
                'title'         => 'Standar Operasional Prosedur',
                'category_id'   => $catIds['Regulasi'],
                'description'   => 'SOP terbaru',
                'status'        => 'pending',
                'created_by'    => $userIds['Dewi Lestari'],
                'activity_date' => '2025-01-07',
                'created_at'    => '2025-01-07 15:45:00',
                'updated_at'    => '2025-01-07 15:45:00',
            ],
            [
                'title'         => 'Laporan Realisasi Anggaran',
                'category_id'   => $catIds['Keuangan'],
                'description'   => 'Realisasi per triwulan',
                'status'        => 'progress',
                'created_by'    => $userIds['Fajar Nugroho'],
                'activity_date' => '2025-01-10',
                'created_at'    => '2025-01-10 11:30:00',
                'updated_at'    => '2025-01-10 11:30:00',
            ],
            [
                'title'         => 'Informasi Layanan Publik',
                'category_id'   => $catIds['Layanan Publik'],
                'description'   => 'Informasi layanan publik terbaru',
                'status'        => 'completed',
                'created_by'    => $userIds['Andi Pratama'],
                'activity_date' => '2025-01-12',
                'created_at'    => '2025-01-12 09:00:00',
                'updated_at'    => '2025-01-12 09:00:00',
            ],
            [
                'title'         => 'Rencana Kerja Triwulan I BBPOM Lampung',
                'category_id'   => $catIds['Kinerja'],
                'description'   => 'Sudah diunggah ke portal utama',
                'status'        => 'completed',
                'created_by'    => $userIds['Andi Pratama'],
                'activity_date' => '2026-02-15',
                'created_at'    => '2026-02-15 10:15:00',
                'updated_at'    => '2026-02-15 10:15:00',
            ],
            [
                'title'         => 'Evaluasi Kinerja Pegawai Triwulan I',
                'category_id'   => $catIds['Kinerja'],
                'description'   => 'Sedang dikompilasi oleh kepegawaian',
                'status'        => 'progress',
                'created_by'    => $userIds['Dewi Lestari'],
                'activity_date' => '2026-03-10',
                'created_at'    => '2026-03-10 14:00:00',
                'updated_at'    => '2026-03-10 14:00:00',
            ],
            [
                'title'         => 'Pengecekan Server PPID Lampung',
                'category_id'   => $catIds['Laporan'],
                'description'   => 'Server berjalan stabil 99.9% uptime',
                'status'        => 'completed',
                'created_by'    => $userIds['Admin Super'],
                'activity_date' => '2026-05-18',
                'created_at'    => '2026-05-18 09:30:00',
                'updated_at'    => '2026-05-18 09:30:00',
            ],
        ];

        $this->db->insert_batch('monitoring', $monitoring);
        echo "Seeding completed successfully!\n";
    }
}
