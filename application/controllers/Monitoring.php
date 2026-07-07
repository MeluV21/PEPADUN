<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Monitoring_model');
        $this->load->model('Category_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $monitoringModel = $this->Monitoring_model;
        
        $monitoringModel->select('monitoring.*, categories.name as category_name, users.fullname as reporter_name')
            ->join('categories', 'categories.id = monitoring.category_id')
            ->join('users', 'users.id = monitoring.created_by');

        // Year & Triwulan Filters
        $yearFilter = $this->input->get('year') !== NULL ? $this->input->get('year') : '2026';
        $triwulanFilter = $this->input->get('triwulan') !== NULL ? $this->input->get('triwulan') : 1;

        $monitoringModel->where('YEAR(monitoring.activity_date)', (int)$yearFilter);

        // Map Triwulan
        switch ((int)$triwulanFilter) {
            case 2:
                $monitoringModel->where('MONTH(monitoring.activity_date) >=', 4)
                                ->where('MONTH(monitoring.activity_date) <=', 6);
                break;
            case 3:
                $monitoringModel->where('MONTH(monitoring.activity_date) >=', 7)
                                ->where('MONTH(monitoring.activity_date) <=', 9);
                break;
            case 4:
                $monitoringModel->where('MONTH(monitoring.activity_date) >=', 10)
                                ->where('MONTH(monitoring.activity_date) <=', 12);
                break;
            case 1:
            default:
                $monitoringModel->where('MONTH(monitoring.activity_date) >=', 1)
                                ->where('MONTH(monitoring.activity_date) <=', 3);
                break;
        }

        // Text Search Filter
        $searchFilter = $this->input->get('search');
        if (!empty($searchFilter)) {
            $monitoringModel->groupStart()
                ->like('monitoring.title', $searchFilter)
                ->orLike('monitoring.description', $searchFilter)
                ->orLike('categories.name', $searchFilter)
                ->orLike('users.fullname', $searchFilter);

            // Mapping Indonesian status search terms to database status values
            $lowerSearch = strtolower($searchFilter);
            if (strpos($lowerSearch, 'selesai') !== false || strpos($lowerSearch, 'complete') !== false) {
                $monitoringModel->orLike('monitoring.status', 'completed');
            }
            if (strpos($lowerSearch, 'proses') !== false || strpos($lowerSearch, 'progress') !== false || strpos($lowerSearch, 'jalan') !== false) {
                $monitoringModel->orLike('monitoring.status', 'progress');
            }
            if (strpos($lowerSearch, 'belum') !== false || strpos($lowerSearch, 'pending') !== false || strpos($lowerSearch, 'update') !== false) {
                $monitoringModel->orLike('monitoring.status', 'pending');
            }

            $monitoringModel->groupEnd();
        }

        // Category Filter
        $categoryFilter = $this->input->get('category');
        if (!empty($categoryFilter)) {
            $monitoringModel->where('monitoring.category_id', $categoryFilter);
        }

        // Status Filter
        $statusFilter = $this->input->get('status');
        if (!empty($statusFilter)) {
            $monitoringModel->where('monitoring.status', $statusFilter);
        }

        $data['monitoringList'] = $monitoringModel->orderBy('monitoring.activity_date', 'DESC')->findAll();
        
        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        
        $data['selectedYear'] = $yearFilter;
        $data['selectedTriwulan'] = $triwulanFilter;
        $data['selectedCategory'] = $categoryFilter;
        $data['selectedStatus'] = $statusFilter;
        $data['searchQuery'] = $searchFilter;
        $data['title'] = 'Monitoring Keterbukaan Informasi Publik';
        
        $data['content_view'] = 'monitoring/index';
        $this->load->view('layouts/admin', $data);
    }

    public function create() {
        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['title'] = 'Tambah Laporan Monitoring';
        
        $data['content_view'] = 'monitoring/form';
        $this->load->view('layouts/admin', $data);
    }

    public function store() {
        $monitoringModel = $this->Monitoring_model;

        $this->form_validation->set_rules('title', 'Judul', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|min_length[10]');
        $this->form_validation->set_rules('activity_date', 'Tanggal Pelaksanaan', 'required|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,progress,completed]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal. Pastikan deskripsi minimal 10 karakter dan tanggal valid.');
            redirect('monitoring/create');
        }

        $monitoringModel->save([
            'title'         => $this->input->post('title'),
            'category_id'   => $this->input->post('category_id'),
            'description'   => $this->input->post('description'),
            'status'        => $this->input->post('status'),
            'created_by'    => session()->get('id'),
            'activity_date' => $this->input->post('activity_date'),
        ]);

        $date = $this->input->post('activity_date');
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        session()->setFlashdata('success', 'Laporan monitoring berhasil ditambahkan.');
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    public function edit($id) {
        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            session()->setFlashdata('error', 'Data monitoring tidak ditemukan.');
            redirect('monitoring');
        }

        // Access Control: Karyawan can only edit their own reports
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses ditolak. Anda hanya dapat mengedit laporan yang Anda buat sendiri.');
            redirect('monitoring');
        }

        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['monitoring'] = $monitoring;
        $data['title'] = 'Edit Laporan Monitoring';
        
        $data['content_view'] = 'monitoring/form';
        $this->load->view('layouts/admin', $data);
    }

    public function update($id) {
        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            session()->setFlashdata('error', 'Data monitoring tidak ditemukan.');
            redirect('monitoring');
        }

        // Access Control
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            redirect('monitoring');
        }

        $this->form_validation->set_rules('title', 'Judul', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|min_length[10]');
        $this->form_validation->set_rules('activity_date', 'Tanggal Pelaksanaan', 'required|regex_match[/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[pending,progress,completed]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal.');
            redirect("monitoring/edit/{$id}");
        }

        $monitoringModel->update($id, [
            'title'         => $this->input->post('title'),
            'category_id'   => $this->input->post('category_id'),
            'description'   => $this->input->post('description'),
            'status'        => $this->input->post('status'),
            'activity_date' => $this->input->post('activity_date'),
        ]);

        $date = $this->input->post('activity_date');
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        session()->setFlashdata('success', 'Laporan monitoring berhasil diperbarui.');
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }

    public function delete($id) {
        $monitoringModel = $this->Monitoring_model;
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            session()->setFlashdata('error', 'Data monitoring tidak ditemukan.');
            redirect('monitoring');
        }

        // Access Control
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            redirect('monitoring');
        }

        $date = $monitoring['activity_date'];
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        $monitoringModel->delete($id);
        
        session()->setFlashdata('success', 'Laporan monitoring berhasil dihapus.');
        redirect("monitoring?year={$year}&triwulan={$triwulan}");
    }
}
