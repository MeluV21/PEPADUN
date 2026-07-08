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

        $currentYear = date('Y');
        $currentTriwulan = ceil(date('m') / 3);
        $db = $this->db;

        // 1. Core counters
        $data['totalUsers'] = $userModel->countAllResults();
        $data['totalCategories'] = $categoryModel->countAllResults();
        
        $queryTotal = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['totalMonitoring'] = $queryTotal->row()->total;

        // 2. Monitoring by status for current triwulan
        $queryCompleted = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE m.status = 'completed' AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['statusCompleted'] = $queryCompleted->row()->total;

        $queryProgress = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE m.status = 'progress' AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['statusProgress'] = $queryProgress->row()->total;

        $queryPending = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.status = 'pending' OR m.status IS NULL) AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['statusPending'] = $queryPending->row()->total;

        if ($data['totalMonitoring'] > 0) {
            $data['tingkatKepatuhan'] = round(($data['statusCompleted'] / $data['totalMonitoring']) * 100);
        } else {
            $data['tingkatKepatuhan'] = 0;
        }

        // 3. Category distribution (for Chart.js)
        $query = $db->query("
            SELECT c.name as category_name, COUNT(mi.id) as total 
            FROM categories c 
            LEFT JOIN master_informasi mi ON c.id = mi.category_id
            LEFT JOIN monitoring m ON mi.id = m.master_id AND m.year = ? AND m.triwulan = ?
            WHERE (m.is_deleted = 0 OR m.is_deleted IS NULL)
            GROUP BY c.id, c.name
        ", [$currentYear, $currentTriwulan]);
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
