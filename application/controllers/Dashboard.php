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

        $selectedYear = $this->input->get('year') !== NULL ? (int)$this->input->get('year') : (int)date('Y');
        $selectedTriwulan = $this->input->get('triwulan') !== NULL ? (int)$this->input->get('triwulan') : (int)ceil(date('m') / 3);
        $db = $this->db;

        // 1. Core counters
        $data['totalUsers'] = $userModel->countAllResults();
        $data['totalCategories'] = $categoryModel->countAllResults();
        
        $queryTotal = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$selectedYear, $selectedTriwulan]);
        $data['totalMonitoring'] = $queryTotal->row()->total;

        // 2. Monitoring by status for current triwulan
        $queryCompleted = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE m.status = 'completed' AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$selectedYear, $selectedTriwulan]);
        $data['statusCompleted'] = $queryCompleted->row()->total;

        $queryProgress = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE m.status = 'progress' AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$selectedYear, $selectedTriwulan]);
        $data['statusProgress'] = $queryProgress->row()->total;

        $queryPending = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.status = 'pending' OR m.status IS NULL) AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$selectedYear, $selectedTriwulan]);
        $data['statusPending'] = $queryPending->row()->total;

        if ($data['totalMonitoring'] > 0) {
            $data['tingkatKepatuhan'] = round(($data['statusCompleted'] / $data['totalMonitoring']) * 100);
        } else {
            $data['tingkatKepatuhan'] = 0;
        }

        // Fetch last update time
        $queryLastUpdate = $db->query("
            SELECT MAX(updated_at) as last_update
            FROM monitoring 
            WHERE year = ? AND triwulan = ? AND (is_deleted = 0 OR is_deleted IS NULL)
        ", [$selectedYear, $selectedTriwulan]);
        $data['lastUpdate'] = $queryLastUpdate->row()->last_update;

        // 3. Category distribution (for Chart.js) showing compliance percentage
        $query = $db->query("
            SELECT 
                c.name as category_name,
                ROUND(
                    IF(
                        COUNT(mi.id) > 0, 
                        (SUM(CASE WHEN m.status = 'completed' THEN 1 ELSE 0 END) / COUNT(mi.id)) * 100, 
                        0
                    )
                ) as total
            FROM categories c 
            LEFT JOIN master_informasi mi ON c.id = mi.category_id
            LEFT JOIN monitoring m ON mi.id = m.master_id AND m.year = ? AND m.triwulan = ?
            WHERE (m.is_deleted = 0 OR m.is_deleted IS NULL)
            GROUP BY c.id, c.name
            ORDER BY c.name ASC
        ", [$selectedYear, $selectedTriwulan]);
        $data['categoryChart'] = $query->result_array();

        // 4. Pending / Progress items for the selected year and triwulan
        $queryRecentPending = $db->query("
            SELECT mi.name as master_name, m.custom_name, IFNULL(m.custom_name, mi.name) as title, 
                   c.name as category_name, IFNULL(m.status, 'pending') as status, m.description
            FROM master_informasi mi
            LEFT JOIN categories c ON c.id = mi.category_id
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.status != 'completed' OR m.status IS NULL) 
              AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
            ORDER BY mi.id ASC
            LIMIT 5
        ", [$selectedYear, $selectedTriwulan]);
        $data['recentMonitoring'] = $queryRecentPending->result_array();

        $data['selectedYear'] = $selectedYear;
        $data['selectedTriwulan'] = $selectedTriwulan;
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard';
        $this->load->view('layouts/admin', $data);
    }
}
