<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Hanya bisa diakses melalui CLI (Command Line) untuk keamanan
        // if (!is_cli()) {
        //     show_error('Hanya bisa diakses via CLI');
        // }
        
        $this->load->model('Monitoring_model');
        $this->load->model('Master_informasi_model');
        $this->load->model('User_model');
    }

    public function check_deadline() {
        // 1. Ambil semua data monitoring yang belum selesai (pending / progress)
        $this->db->select('monitoring.*, master_informasi.name as master_name, master_informasi.timeline');
        $this->db->from('monitoring');
        $this->db->join('master_informasi', 'master_informasi.id = monitoring.master_id', 'left');
        $this->db->where_in('monitoring.status', ['pending', 'progress']);
        $this->db->where('monitoring.is_deleted', 0);
        $pendingTasks = $this->db->get()->result_array();

        $messagesSent = 0;
        $today = date('Y-m-d');

        foreach ($pendingTasks as $task) {
            // Jika tidak ada PJ, skip
            if (empty($task['pj'])) {
                continue;
            }

            // 2. Cari data karyawan berdasarkan nama PJ
            $this->db->like('nama', $task['pj']);
            $user = $this->db->get('users')->row_array();

            if ($user && !empty($user['telp'])) {
                // 3. Logika Pengecekan Tanggal H-1 berdasarkan Timeline
                $timeline = strtolower($task['timeline']);
                $shouldNotify = false;
                $peringatan = "DEADLINE TINGGAL 1 HARI LAGI";

                if ($timeline == 'harian') {
                    // Harian: Kirim setiap hari
                    $shouldNotify = true;
                } else if ($timeline == 'mingguan') {
                    // Mingguan: Asumsi deadline Jumat, H-1 adalah Kamis (4)
                    if (date('w') == 4) {
                        $shouldNotify = true;
                    }
                } else if ($timeline == 'bulanan') {
                    // Bulanan: H-1 dari hari terakhir bulan ini
                    $last_day_this_month = date('Y-m-t');
                    $h_minus_1 = date('Y-m-d', strtotime($last_day_this_month . ' -1 day'));
                    if ($today == $h_minus_1) {
                        $shouldNotify = true;
                    }
                } else if ($timeline == 'triwulan') {
                    // Triwulan: H-1 dari (31 Mar, 30 Jun, 30 Sep, 31 Des)
                    $currentYear = date('Y');
                    $h_minus_1_triwulans = [
                        $currentYear . '-03-30',
                        $currentYear . '-06-29',
                        $currentYear . '-09-29',
                        $currentYear . '-12-30'
                    ];
                    if (in_array($today, $h_minus_1_triwulans)) {
                        $shouldNotify = true;
                    }
                } else if ($timeline == 'tahunan') {
                    // Tahunan: H-1 dari akhir tahun (31 Des)
                    $h_minus_1 = date('Y') . '-12-30';
                    if ($today == $h_minus_1) {
                        $shouldNotify = true;
                    }
                }
                // Untuk 'realtime', diabaikan karena sudah dikirim saat update form

                if ($shouldNotify) {
                    $title = !empty($task['custom_name']) ? $task['custom_name'] : $task['master_name'];
                    $status_indo = '';
                    if ($task['status'] == 'pending') $status_indo = 'Belum Update';
                    else if ($task['status'] == 'progress') $status_indo = 'Dalam Proses';
                    
                    $message = "Halo *" . $user['nama'] . "*,\n\n";
                    $message .= "Pemberitahuan dari Sistem Monitoring: *" . $peringatan . "*.\n\n";
                    $message .= "Kegiatan: *" . $title . "*\n";
                    $message .= "Status Saat Ini: *" . $status_indo . "*\n\n";
                    $message .= "Mohon segera diselesaikan atau diupdate statusnya menjadi Selesai. Terima kasih.";

                    // 4. Kirim Notifikasi via WhatsApp Local API
                    $this->_sendWhatsApp($user['telp'], $message);
                    $messagesSent++;
                }
            }
        }

        echo "Selesai mengecek deadline. Total pesan WhatsApp dikirim: " . $messagesSent;
    }

    private function _sendWhatsApp($phone, $message) {
        $data = [
            'number' => $phone,
            'message' => $message
        ];

        $ch = curl_init('http://localhost:3000/send-message');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        
        log_message('info', "Respon WA Local API ke $phone: $response | Error: $err");
    }

}
