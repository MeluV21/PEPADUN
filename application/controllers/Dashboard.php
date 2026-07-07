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

        // 1. Core counters
        $data['totalUsers'] = $userModel->countAllResults();
        $data['totalCategories'] = $categoryModel->countAllResults();
        $data['totalMonitoring'] = $monitoringModel->countAllResults();

        // 2. Monitoring by status
        $data['statusPending'] = $monitoringModel->where('status', 'pending')->countAllResults();
        $data['statusProgress'] = $monitoringModel->where('status', 'progress')->countAllResults();
        $data['statusCompleted'] = $monitoringModel->where('status', 'completed')->countAllResults();

        // 3. Category distribution (for Chart.js)
        $db = $this->db;
        $query = $db->query('
            SELECT c.name as category_name, COUNT(m.id) as total 
            FROM categories c 
            LEFT JOIN monitoring m ON c.id = m.category_id 
            GROUP BY c.id, c.name
        ');
        $data['categoryChart'] = $query->result_array();

        // 4. Recent activities/monitoring
        $data['recentMonitoring'] = $monitoringModel
            ->select('monitoring.*, categories.name as category_name, users.fullname as reporter_name')
            ->join('categories', 'categories.id = monitoring.category_id')
            ->join('users', 'users.id = monitoring.created_by')
            ->orderBy('monitoring.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard';
        $this->load->view('layouts/admin', $data);
    }
}
