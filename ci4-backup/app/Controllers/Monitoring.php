<?php

namespace App\Controllers;

use App\Models\Monitoring as MonitoringModel;
use App\Models\Category as CategoryModel;

class Monitoring extends BaseController
{
    public function index()
    {
        $monitoringModel = new MonitoringModel();
        
        // Select core fields, category, and reporter name
        $monitoringModel->select('monitoring.*, categories.name as category_name, users.fullname as reporter_name')
            ->join('categories', 'categories.id = monitoring.category_id')
            ->join('users', 'users.id = monitoring.created_by');

        // Year & Triwulan (Quarter) Filtering
        $yearFilter = $this->request->getGet('year') ?? '2026';
        $triwulanFilter = $this->request->getGet('triwulan') ?? 1;

        $monitoringModel->where('YEAR(monitoring.activity_date)', (int)$yearFilter);

        // Map triwulan quarters to month ranges
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
        $searchFilter = $this->request->getGet('search');
        if (!empty($searchFilter)) {
            $monitoringModel->groupStart()
                ->like('monitoring.title', $searchFilter)
                ->orLike('monitoring.description', $searchFilter)
                ->groupEnd();
        }

        // Category Filter
        $categoryFilter = $this->request->getGet('category');
        if (!empty($categoryFilter)) {
            $monitoringModel->where('monitoring.category_id', $categoryFilter);
        }

        // Status Filter
        $statusFilter = $this->request->getGet('status');
        if (!empty($statusFilter)) {
            $monitoringModel->where('monitoring.status', $statusFilter);
        }

        $data['monitoringList'] = $monitoringModel->orderBy('monitoring.activity_date', 'DESC')->findAll();
        
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        
        $data['selectedYear'] = $yearFilter;
        $data['selectedTriwulan'] = $triwulanFilter;
        $data['selectedCategory'] = $categoryFilter;
        $data['selectedStatus'] = $statusFilter;
        $data['searchQuery'] = $searchFilter;
        $data['title'] = 'Monitoring Keterbukaan Informasi Publik';
        
        return view('monitoring/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['title'] = 'Tambah Laporan Monitoring';
        return view('monitoring/form', $data);
    }

    public function store()
    {
        $monitoringModel = new MonitoringModel();

        $rules = [
            'title'         => 'required|min_length[5]|max_length[255]',
            'category_id'   => 'required|is_not_unique[categories.id]',
            'description'   => 'required|min_length[10]',
            'activity_date' => 'required|valid_date[Y-m-d]',
            'status'        => 'required|in_list[pending,progress,completed]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal. Pastikan deskripsi minimal 10 karakter dan tanggal valid.')->withInput();
        }

        $monitoringModel->save([
            'title'         => $this->request->getPost('title'),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description'),
            'status'        => $this->request->getPost('status'),
            'created_by'    => session()->get('id'),
            'activity_date' => $this->request->getPost('activity_date'),
        ]);

        // Redirect back with year and triwulan parameters based on the saved activity date
        $date = $this->request->getPost('activity_date');
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        return redirect()->to("monitoring?year={$year}&triwulan={$triwulan}")->with('success', 'Laporan monitoring berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $monitoringModel = new MonitoringModel();
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            return redirect()->to('/monitoring')->with('error', 'Data monitoring tidak ditemukan.');
        }

        // Access Control: Karyawan can only edit their own reports
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            return redirect()->to('/monitoring')->with('error', 'Akses ditolak. Anda hanya dapat mengedit laporan yang Anda buat sendiri.');
        }

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['monitoring'] = $monitoring;
        $data['title'] = 'Edit Laporan Monitoring';
        
        return view('monitoring/form', $data);
    }

    public function update($id)
    {
        $monitoringModel = new MonitoringModel();
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            return redirect()->to('/monitoring')->with('error', 'Data monitoring tidak ditemukan.');
        }

        // Access Control: Karyawan can only edit their own reports
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            return redirect()->to('/monitoring')->with('error', 'Akses ditolak.');
        }

        $rules = [
            'title'         => 'required|min_length[5]|max_length[255]',
            'category_id'   => 'required|is_not_unique[categories.id]',
            'description'   => 'required|min_length[10]',
            'activity_date' => 'required|valid_date[Y-m-d]',
            'status'        => 'required|in_list[pending,progress,completed]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Validasi gagal.')->withInput();
        }

        $monitoringModel->update($id, [
            'title'         => $this->request->getPost('title'),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description'),
            'status'        => $this->request->getPost('status'),
            'activity_date' => $this->request->getPost('activity_date'),
        ]);

        $date = $this->request->getPost('activity_date');
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        return redirect()->to("monitoring?year={$year}&triwulan={$triwulan}")->with('success', 'Laporan monitoring berhasil diperbarui.');
    }

    public function delete($id)
    {
        $monitoringModel = new MonitoringModel();
        $monitoring = $monitoringModel->find($id);

        if (!$monitoring) {
            return redirect()->to('/monitoring')->with('error', 'Data monitoring tidak ditemukan.');
        }

        // Access Control: Karyawan can only delete their own reports
        if (session()->get('role') === 'karyawan' && $monitoring['created_by'] != session()->get('id')) {
            return redirect()->to('/monitoring')->with('error', 'Akses ditolak.');
        }

        $date = $monitoring['activity_date'];
        $year = date('Y', strtotime($date));
        $month = (int)date('m', strtotime($date));
        $triwulan = ceil($month / 3);

        $monitoringModel->delete($id);
        return redirect()->to("monitoring?year={$year}&triwulan={$triwulan}")->with('success', 'Laporan monitoring berhasil dihapus.');
    }
}
