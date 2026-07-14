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
        $this->db->select('monitoring.*, master_informasi.name as master_name');
        $this->db->from('monitoring');
        $this->db->join('master_informasi', 'master_informasi.id = monitoring.master_id', 'left');
        $this->db->where_in('monitoring.status', ['pending', 'progress']);
        $this->db->where('monitoring.is_deleted', 0);
        $pendingTasks = $this->db->get()->result_array();

        $messagesSent = 0;

        foreach ($pendingTasks as $task) {
            // Jika tidak ada PJ, skip
            if (empty($task['pj'])) {
                continue;
            }

            // 2. Cari data karyawan berdasarkan nama PJ
            // Menggunakan pencarian LIKE karena pj bisa berupa teks bebas
            $this->db->like('nama', $task['pj']);
            $user = $this->db->get('users')->row_array();

            if ($user) {
                // 3. Logika Pengecekan Tanggal
                // KARENA 'deadline_date' BELUM ADA DI DATABASE, INI ADALAH KERANGKA LOGIKANYA:
                $isHMinus3 = false;
                $isHariH = false;

                // [NANTI KETIKA FIELD deadline_date DIBUAT, UNCOMMENT KODE DI BAWAH INI]
                /*
                if (isset($task['deadline_date']) && !empty($task['deadline_date'])) {
                    $deadline = strtotime($task['deadline_date']);
                    $today = strtotime(date('Y-m-d'));
                    
                    // Selisih dalam hari
                    $diffDays = round(($deadline - $today) / (60 * 60 * 24));
                    
                    if ($diffDays == 3) {
                        $isHMinus3 = true;
                    } elseif ($diffDays == 0) {
                        $isHariH = true;
                    }
                }
                */

                // UNTUK TESTING SAAT INI, KITA ANGGAP SELALU TERPENUHI ATAU BISA DI-MOCK:
                // Hapus atau comment baris ini nanti saat production
                $isHMinus3 = true; // Flag testing

                if ($isHMinus3 || $isHariH) {
                    $title = !empty($task['custom_name']) ? $task['custom_name'] : $task['master_name'];
                    $peringatan = $isHariH ? "HARI INI ADALAH DEADLINE" : "DEADLINE TINGGAL 3 HARI LAGI";
                    
                    $message = "Halo *" . $user['nama'] . "*,\n\n";
                    $message .= "Pemberitahuan dari Sistem PEPADUN: " . $peringatan . ".\n\n";
                    $message .= "Informasi/Laporan: *" . $title . "*\n";
                    $message .= "Status Saat Ini: " . strtoupper($task['status']) . "\n\n";
                    $message .= "Mohon segera diselesaikan atau diupdate statusnya. Terima kasih.";

                    // 4. Kirim Notifikasi via WhatsApp
                    if (!empty($user['telp'])) {
                        $this->_sendWhatsApp($user['telp'], $message);
                        $messagesSent++;
                    }

                    // 5. Kirim Notifikasi via Email
                    if (!empty($user['email'])) {
                        $emailSubject = "[$peringatan] - Monitoring $title";
                        $this->_sendEmail($user['email'], $emailSubject, $message);
                    }
                }
            }
        }

        echo "Selesai mengecek deadline. Total pesan WhatsApp dikirim: " . $messagesSent;
    }

    private function _sendWhatsApp($phone, $message) {
        // [TODO] Integrasi dengan WhatsApp API Pihak Ketiga (Contoh: Fonnte, Watzap, Wablas)
        // Di bawah ini adalah contoh template menggunakan curl untuk Fonnte API
        
        /*
        $apiToken = 'TOKEN_API_ANDA_DISINI';
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $phone,
            'message' => $message, 
          ),
          CURLOPT_HTTPHEADER => array(
            "Authorization: $apiToken"
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        // return json_decode($response, true);
        */
        
        // Log untuk simulasi jika belum ada API
        log_message('info', "Simulasi WA Terkirim ke $phone:\n$message");
    }

    private function _sendEmail($to, $subject, $message) {
        $this->load->library('email');
        
        // [TODO] Konfigurasi SMTP (sesuaikan dengan server Anda di application/config/email.php atau di sini)
        /*
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'email_anda@gmail.com',
            'smtp_pass' => 'password_app_anda',
            'mailtype'  => 'text', 
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        */
        
        $this->email->from('no-reply@pepadun.com', 'Sistem PEPADUN');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        // $this->email->send();
        
        log_message('info', "Simulasi Email Terkirim ke $to dengan subjek: $subject");
    }
}
