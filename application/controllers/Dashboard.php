<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Category_model');
        $this->load->model('Monitoring_model');
    }

    public function index() {
        $userModel = $this->User_model;
        $categoryModel = $this->Category_model;
        $monitoringModel = $this->Monitoring_model;

        $this->load->model('Master_informasi_model');
        $masterModel = $this->Master_informasi_model;

        // 1. Core counters
        $data['totalUsers'] = $userModel->countAllResults();
        $data['totalCategories'] = $categoryModel->countAllResults();
        $data['totalMonitoring'] = $masterModel->countAllResults(); // Use master as the source of truth for total items

        // 2. Monitoring by status (only count active overrides)
        $data['statusPending'] = $monitoringModel->where('status', 'pending')->where('is_deleted', 0)->countAllResults();
        $data['statusProgress'] = $monitoringModel->where('status', 'progress')->where('is_deleted', 0)->countAllResults();
        $data['statusCompleted'] = $monitoringModel->where('status', 'completed')->where('is_deleted', 0)->countAllResults();

        // 3. Category distribution (for Chart.js)
        $db = $this->db;
        $query = $db->query('
            SELECT c.name as category_name, COUNT(m.id) as total 
            FROM categories c 
            LEFT JOIN master_informasi mi ON c.id = mi.category_id
            LEFT JOIN monitoring m ON mi.id = m.master_id AND m.is_deleted = 0
            GROUP BY c.id, c.name
        ');
        $data['categoryChart'] = $query->result_array();

        // 4. Recent activities/monitoring
        $data['recentMonitoring'] = $monitoringModel
            ->select('monitoring.*, IFNULL(monitoring.custom_name, master_informasi.name) as title, categories.name as category_name, users.fullname as reporter_name', false)
            ->join('master_informasi', 'master_informasi.id = monitoring.master_id')
            ->join('categories', 'categories.id = master_informasi.category_id')
            ->join('users', 'users.id = monitoring.created_by', 'left')
            ->where('monitoring.is_deleted', 0)
            ->orderBy('monitoring.updated_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard';
        $this->load->view('layouts/admin', $data);
    }
}
