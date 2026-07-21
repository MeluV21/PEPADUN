<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Monitoring_model');
        $this->load->model('Category_model');
        $this->load->model('Master_informasi_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $masterModel = $this->Master_informasi_model;
        
        $yearFilter = $this->input->get('year') !== NULL ? $this->input->get('year') : date('Y');
        $triwulanFilter = $this->input->get('triwulan') !== NULL ? $this->input->get('triwulan') : ceil(date('m') / 3);

        $searchFilter = $this->input->get('search');
        $categoryFilter = $this->input->get('category');
        $statusFilter = $this->input->get('status');

        $buildQuery = function() use ($masterModel, $yearFilter, $triwulanFilter, $searchFilter, $categoryFilter, $statusFilter) {
            $masterModel->select('master_informasi.*, categories.name as category_name, monitoring.id as monitoring_id, monitoring.status, monitoring.pj, monitoring.description, monitoring.triwulan, monitoring.year, monitoring.custom_name, users.nama as reporter_name')
            ->join('categories', 'categories.id = master_informasi.category_id', 'left')
            ->join('monitoring', "monitoring.master_id = master_informasi.id AND monitoring.triwulan = " . (int)$triwulanFilter . " AND monitoring.year = " . (int)$yearFilter, 'left')
            ->join('users', 'users.id_user = monitoring.created_by', 'left');

        // Hide deleted items for this triwulan
        $masterModel->groupStart()
                    ->where('monitoring.is_deleted', 0)
                    ->orWhere('monitoring.is_deleted IS NULL')
                    ->groupEnd();

        if (!empty($searchFilter)) {
            $masterModel->groupStart()
                ->like('master_informasi.name', $searchFilter)
                ->orLike('monitoring.custom_name', $searchFilter)
                ->orLike('monitoring.description', $searchFilter)
                ->orLike('categories.name', $searchFilter)
                ->orLike('monitoring.pj', $searchFilter)
                ->orLike('master_informasi.timeline', $searchFilter)
                ->orLike('users.nama', $searchFilter);

            $lowerSearch = strtolower($searchFilter);
            if (strpos($lowerSearch, 'selesai') !== false || strpos($lowerSearch, 'complete') !== false) {
                $masterModel->orLike('monitoring.status', 'completed');
            }
            if (strpos($lowerSearch, 'proses') !== false || strpos($lowerSearch, 'progress') !== false || strpos($lowerSearch, 'jalan') !== false) {
                $masterModel->orLike('monitoring.status', 'progress');
            }
            if (strpos($lowerSearch, 'belum') !== false || strpos($lowerSearch, 'pending') !== false || strpos($lowerSearch, 'update') !== false) {
                $masterModel->orLike('monitoring.status', 'pending');
                $masterModel->orWhere('monitoring.status IS NULL');
            }
            $masterModel->groupEnd();
        }

        if (!empty($categoryFilter)) {
            $masterModel->where('master_informasi.category_id', $categoryFilter);
        }

        if (!empty($statusFilter)) {
            if ($statusFilter == 'pending') {
                $masterModel->groupStart()
                    ->where('monitoring.status', 'pending')
                    ->orWhere('monitoring.status IS NULL')
                    ->groupEnd();
            } else {
                $masterModel->where('monitoring.status', $statusFilter);
            }
        }
        };

        // Pagination logic
        $page = (int)$this->input->get('page');
        if ($page < 1) $page = 1;
        
        $perPage = (int)$this->input->get('per_page');
        if (!in_array($perPage, [10, 25, 50])) $perPage = 10;
        
        $offset = ($page - 1) * $perPage;
        
        // Count total results before applying limit
        $buildQuery();
        $totalRows = $masterModel->countAllResults();
        
        // Fetch paginated results
        $buildQuery();
        $data['monitoringList'] = $masterModel->orderBy("CASE WHEN categories.name IS NULL OR LOWER(TRIM(categories.name)) = 'tanpa kategori' OR LOWER(TRIM(categories.name)) = 'lainnya' THEN master_informasi.id ELSE (SELECT MIN(mi2.id) FROM master_informasi mi2 LEFT JOIN categories c2 ON c2.id = mi2.category_id WHERE mi2.category_id = master_informasi.category_id AND c2.name IS NOT NULL AND LOWER(TRIM(c2.name)) != 'tanpa kategori' AND LOWER(TRIM(c2.name)) != 'lainnya') END", "ASC")
                                              ->orderBy('master_informasi.id', 'ASC')
                                              ->limit($perPage, $offset)
                                              ->findAll();
        
        $data['currentPage'] = $page;
        $data['perPage'] = $perPage;
        $data['totalRows'] = $totalRows;
        $data['totalPages'] = ceil($totalRows / $perPage);

        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        
        $this->load->model('User_model');
        $data['users'] = $this->User_model->orderBy('nama', 'ASC')->findAll();
        
        $data['selectedYear'] = $yearFilter;
        $data['selectedTriwulan'] = $triwulanFilter;
        $data['selectedCategory'] = $categoryFilter;
        $data['selectedStatus'] = $statusFilter;
        $data['searchQuery'] = $searchFilter;
        $data['title'] = 'Monitoring Keterbukaan Informasi Publik';
        
        $data['content_view'] = 'monitoring/index';
        $this->load->view('layouts/admin', $data);
    }

    public function create_master() {
        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        
        $this->load->model('User_model');
        $data['users'] = $this->User_model->orderBy('nama', 'ASC')->findAll();
        $data['title'] = 'Tambah Informasi Global';
        
        $data['content_view'] = 'monitoring/form_master';
        $this->load->view('layouts/admin', $data);
    }

    public function store_master() {
        $year = $this->input->post('year') !== NULL ? (int)$this->input->post('year') : (int)date('Y');
        $triwulan = $this->input->post('triwulan') !== NULL ? (int)$this->input->post('triwulan') : (int)ceil(date('m') / 3);

        $this->form_validation->set_rules('name', 'Nama Informasi', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('timeline', 'Timeline', 'required|in_list[Realtime,Harian,Mingguan,Bulanan,Triwulan,Semester,Tahunan]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,progress,completed]');
        $this->form_validation->set_rules('tautan', 'Tautan', 'required|valid_url');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal. Pastikan form terisi dengan benar (Nama min. 3 karakter).');
            redirect("monitoring?year={$year}&triwulan={$triwulan}");
        }

        $categoryId = $this->input->post('category_id');
        $categoryId = empty($categoryId) ? NULL : $categoryId;

        $timeline = $this->input->post('timeline');
        $timeline = empty($timeline) ? NULL : $timeline;

        // Save to master_informasi first
        $masterId = $this->Master_informasi_model->save([
            'name' => $this->input->post('name'),
            'category_id' => $categoryId,
            'timeline' => $timeline,
            'tautan' => $this->input->post('tautan')
        ]);

        // Save status, pj, description to monitoring table for current triwulan and year
        $status = $this->input->post('status') !== NULL ? $this->input->post('status') : 'pending';
        $pj = $this->input->post('pj');
        $description = $this->input->post('description');

        $this->Monitoring_model->save([
            'master_id'   => $masterId,
            'year'        => $year,
            'triwulan'    => $triwulan,
            'custom_name' => NULL,
            'status'      => $status,
            'pj'          => $pj,
            'description' => $description,
            'created_by'  => session()->get('id_user'),
            'is_deleted'  => 0
        ]);

        // --- WHATSAPP NOTIFICATION LOGIC ---
        if (!empty($pj)) {
            $this->load->model('User_model');
            $user = $this->User_model->where('nama', $pj)->first();
            if ($user && !empty($user['telp'])) {
                if ($status == 'pending' || $status == 'progress') {
                    $status_indo = '';
                    if ($status == 'pending') $status_indo = 'Belum Update';
                    else if ($status == 'progress') $status_indo = 'Dalam Proses';
                    
                    $infoName = $this->input->post('name');
                    $wa_message = "Halo *" . $user['nama'] . "*,\n\nAda tugas/informasi baru untuk Anda:\n"
                                . "Kegiatan: *" . $infoName . "*\n"
                                . "Status: *" . $status_indo . "*\n\n"
                                . "Silakan cek di sistem Monitoring.";
                    
                    $this->_send_whatsapp($user['telp'], $wa_message);
                }
            }
        }
        // ------------------------------------

        session()->setFlashdata('success', 'Informasi baru dan status perkembangannya berhasil ditambahkan.');
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    public function edit($master_id, $year, $triwulan) {
        $masterModel = $this->Master_informasi_model;
        $masterInfo = $masterModel->find($master_id);
        
        if (!$masterInfo) {
            session()->setFlashdata('error', 'Informasi Master tidak ditemukan.');
            redirect('monitoring');
        }

        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->where('master_id', $master_id)
                                      ->where('year', $year)
                                      ->where('triwulan', $triwulan)
                                      ->where('is_deleted', 0)
                                      ->first();

        if ($monitoring && session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Akses ditolak. Laporan ini diupdate oleh user lain.');
            redirect('monitoring');
        }

        $data['masterInfo'] = $masterInfo;
        $data['monitoring'] = $monitoring;
        $data['year'] = $year;
        $data['triwulan'] = $triwulan;
        $data['title'] = 'Update Status Monitoring';
        
        $data['content_view'] = 'monitoring/form';
        $this->load->view('layouts/admin', $data);
    }

    public function update($master_id, $year, $triwulan) {
        $masterModel = $this->Master_informasi_model;
        $masterInfo = $masterModel->find($master_id);
        
        if (!$masterInfo) {
            session()->setFlashdata('error', 'Informasi Master tidak ditemukan.');
            redirect('monitoring');
        }

        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->where('master_id', $master_id)
                                      ->where('year', $year)
                                      ->where('triwulan', $triwulan)
                                      ->where('is_deleted', 0)
                                      ->first();

        if ($monitoring && session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            redirect('monitoring');
        }

        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,progress,completed]');
        $this->form_validation->set_rules('custom_name', 'Nama Informasi', 'required');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('timeline', 'Timeline', 'required|in_list[Realtime,Harian,Mingguan,Bulanan,Triwulan,Semester,Tahunan]');
        $this->form_validation->set_rules('tautan', 'Tautan', 'required|valid_url');
        
        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal. Pastikan form terisi dengan benar.');
            redirect("monitoring?year={$year}&triwulan={$triwulan}");
        }

        // Update master information details
        $categoryId = $this->input->post('category_id');
        $categoryId = empty($categoryId) ? NULL : $categoryId;

        $timeline = $this->input->post('timeline');
        $timeline = empty($timeline) ? NULL : $timeline;

        $this->Master_informasi_model->update($master_id, [
            'name'        => $this->input->post('custom_name'),
            'category_id' => $categoryId,
            'timeline'    => $timeline,
            'tautan'      => $this->input->post('tautan')
        ]);

        $saveData = [
            'master_id'   => $master_id,
            'year'        => $year,
            'triwulan'    => $triwulan,
            'custom_name' => NULL, // Always reset custom_name to NULL to use the updated master name
            'status'      => $this->input->post('status'),
            'description' => $this->input->post('description'),
            'pj'          => $this->input->post('pj'),
            'is_deleted'  => 0
        ];

        if ($monitoring) {
            $monitoringModel->update($monitoring['id'], $saveData);
        } else {
            $saveData['created_by'] = session()->get('id_user');
            $monitoringModel->save($saveData);
        }

        $infoName = $this->input->post('custom_name');
        
        // --- WHATSAPP NOTIFICATION LOGIC ---
        $pjName = $this->input->post('pj');
        if (!empty($pjName)) {
            $this->load->model('User_model');
            $user = $this->User_model->where('nama', $pjName)->first();
            if ($user && !empty($user['telp'])) {
                if ($saveData['status'] == 'pending' || $saveData['status'] == 'progress') {
                    $status_indo = '';
                    if ($saveData['status'] == 'pending') $status_indo = 'Belum Update';
                    else if ($saveData['status'] == 'progress') $status_indo = 'Dalam Proses';
                    
                    $wa_message = "Halo *" . $user['nama'] . "*,\n\nAda update status untuk kegiatan Anda:\n"
                                . "Kegiatan: *" . $infoName . "*\n"
                                . "Status Baru: *" . $status_indo . "*\n\n"
                                . "Silakan cek di sistem Monitoring.";
                    
                    $this->_send_whatsapp($user['telp'], $wa_message);
                }
            }
        }
        // ------------------------------------

        session()->setFlashdata('success', "\"$infoName\" berhasil diperbarui.");
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    public function delete_global($master_id, $year, $triwulan) {
        $masterModel = $this->Master_informasi_model;
        $masterInfo = $masterModel->find($master_id);
        
        if (!$masterInfo) {
            session()->setFlashdata('error', 'Informasi Master tidak ditemukan.');
            redirect("monitoring?year={$year}&triwulan={$triwulan}");
        }

        // Delete the master record and all its associated monitoring data
        $masterModel->delete($master_id);
        $this->db->where('master_id', $master_id)->delete('monitoring');

        session()->setFlashdata('success', "Data {$masterInfo['name']} berhasil dihapus dari semua triwulan.");
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    public function delete($master_id, $year, $triwulan) {
        $masterModel = $this->Master_informasi_model;
        $masterInfo = $masterModel->find($master_id);
        
        if (!$masterInfo) {
            session()->setFlashdata('error', 'Informasi Master tidak ditemukan.');
            redirect("monitoring?year={$year}&triwulan={$triwulan}");
        }

        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->where('master_id', $master_id)
                                      ->where('year', $year)
                                      ->where('triwulan', $triwulan)
                                      ->first();

        if ($monitoring && session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            redirect("monitoring?year={$year}&triwulan={$triwulan}");
        }

        if ($monitoring) {
            $monitoringModel->update($monitoring['id'], ['is_deleted' => 1]);
        } else {
            // If it never existed, create a deleted marker
            $saveData = [
                'master_id'   => $master_id,
                'year'        => $year,
                'triwulan'    => $triwulan,
                'created_by'  => session()->get('id'),
                'is_deleted'  => 1
            ];
            $monitoringModel->save($saveData);
        }

        session()->setFlashdata('success', "Informasi berhasil dihapus dari Triwulan {$triwulan}.");
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    private function _getExportData() {
        $masterModel = $this->Master_informasi_model;
        $yearFilter = $this->input->get('year') !== NULL ? $this->input->get('year') : date('Y');
        $triwulanFilter = $this->input->get('triwulan') !== NULL ? $this->input->get('triwulan') : ceil(date('m') / 3);
        $searchFilter = $this->input->get('search');
        $categoryFilter = $this->input->get('category');
        $statusFilter = $this->input->get('status');

        $masterModel->select('master_informasi.*, categories.name as category_name, monitoring.id as monitoring_id, monitoring.status, monitoring.pj, monitoring.description, monitoring.triwulan, monitoring.year, monitoring.custom_name, users.nama as reporter_name')
            ->join('categories', 'categories.id = master_informasi.category_id', 'left')
            ->join('monitoring', "monitoring.master_id = master_informasi.id AND monitoring.triwulan = " . (int)$triwulanFilter . " AND monitoring.year = " . (int)$yearFilter, 'left')
            ->join('users', 'users.id_user = monitoring.created_by', 'left');

        $masterModel->groupStart()
                    ->where('monitoring.is_deleted', 0)
                    ->orWhere('monitoring.is_deleted IS NULL')
                    ->groupEnd();

        if (!empty($searchFilter)) {
            $masterModel->groupStart()
                ->like('master_informasi.name', $searchFilter)
                ->orLike('monitoring.custom_name', $searchFilter)
                ->orLike('monitoring.description', $searchFilter)
                ->orLike('categories.name', $searchFilter)
                ->orLike('monitoring.pj', $searchFilter)
                ->orLike('master_informasi.timeline', $searchFilter)
                ->orLike('users.nama', $searchFilter);

            $lowerSearch = strtolower($searchFilter);
            if (strpos($lowerSearch, 'selesai') !== false || strpos($lowerSearch, 'complete') !== false) {
                $masterModel->orLike('monitoring.status', 'completed');
            }
            if (strpos($lowerSearch, 'proses') !== false || strpos($lowerSearch, 'progress') !== false || strpos($lowerSearch, 'jalan') !== false) {
                $masterModel->orLike('monitoring.status', 'progress');
            }
            if (strpos($lowerSearch, 'belum') !== false || strpos($lowerSearch, 'pending') !== false || strpos($lowerSearch, 'update') !== false) {
                $masterModel->orLike('monitoring.status', 'pending');
                $masterModel->orWhere('monitoring.status IS NULL');
            }
            $masterModel->groupEnd();
        }

        if (!empty($categoryFilter)) {
            $masterModel->where('master_informasi.category_id', $categoryFilter);
        }

        if (!empty($statusFilter)) {
            if ($statusFilter == 'pending') {
                $masterModel->groupStart()
                    ->where('monitoring.status', 'pending')
                    ->orWhere('monitoring.status IS NULL')
                    ->groupEnd();
            } else {
                $masterModel->where('monitoring.status', $statusFilter);
            }
        }

        return $masterModel->orderBy("CASE WHEN categories.name IS NULL OR LOWER(TRIM(categories.name)) = 'tanpa kategori' OR LOWER(TRIM(categories.name)) = 'lainnya' THEN master_informasi.id ELSE (SELECT MIN(mi2.id) FROM master_informasi mi2 LEFT JOIN categories c2 ON c2.id = mi2.category_id WHERE mi2.category_id = master_informasi.category_id AND c2.name IS NOT NULL AND LOWER(TRIM(c2.name)) != 'tanpa kategori' AND LOWER(TRIM(c2.name)) != 'lainnya') END", "ASC")
                            ->orderBy('master_informasi.id', 'ASC')
                            ->findAll();
    }

    public function export_excel() {
        $data['monitoringList'] = $this->_getExportData();
        $data['year'] = $this->input->get('year') !== NULL ? $this->input->get('year') : date('Y');
        $data['triwulan'] = $this->input->get('triwulan') !== NULL ? $this->input->get('triwulan') : ceil(date('m') / 3);
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_Monitoring_Triwulan_{$data['triwulan']}_{$data['year']}.xls");
        
        $this->load->view('monitoring/export_excel', $data);
    }

    public function export_pdf() {
        $data['monitoringList'] = $this->_getExportData();
        $data['year'] = $this->input->get('year') !== NULL ? $this->input->get('year') : date('Y');
        $data['triwulan'] = $this->input->get('triwulan') !== NULL ? $this->input->get('triwulan') : ceil(date('m') / 3);
        
        $this->load->view('monitoring/export_pdf', $data);
    }
    private function _send_whatsapp($number, $message) {
        $data = [
            'number' => $number,
            'message' => $message
        ];

        $ch = curl_init('http://localhost:3000/send-message');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return json_decode($response, true);
    }
}
