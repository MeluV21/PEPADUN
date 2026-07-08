<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    
    public function index() {
        $this->load->database();
        $db = $this->db;
        
        $currentYear = date('Y');
        $currentTriwulan = ceil(date('m') / 3);

        $queryTotal = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['total_item'] = $queryTotal->row()->total;

        $queryCompleted = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE m.status = 'completed' AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['selesai_update'] = $queryCompleted->row()->total;

        $queryPending = $db->query("
            SELECT COUNT(mi.id) as total
            FROM master_informasi mi
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.status = 'pending' OR m.status IS NULL) AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
        ", [$currentYear, $currentTriwulan]);
        $data['belum_update'] = $queryPending->row()->total;

        if ($data['total_item'] > 0) {
            $data['tingkat_kepatuhan'] = round(($data['selesai_update'] / $data['total_item']) * 100);
        } else {
            $data['tingkat_kepatuhan'] = 0;
        }

        $queryBelumUpdateList = $db->query("
            SELECT mi.name as judul, c.name as kategori
            FROM master_informasi mi
            LEFT JOIN categories c ON c.id = mi.category_id
            LEFT JOIN monitoring m ON m.master_id = mi.id AND m.year = ? AND m.triwulan = ?
            WHERE (m.status = 'pending' OR m.status IS NULL) AND (m.is_deleted = 0 OR m.is_deleted IS NULL)
            LIMIT 10
        ", [$currentYear, $currentTriwulan]);
        $data['belumUpdate'] = $queryBelumUpdateList->result_array();

        $queryCategoryCompliance = $db->query("
            SELECT 
                c.name as category_name, 
                COUNT(mi.id) as total_items,
                SUM(CASE WHEN m.status = 'completed' AND (m.is_deleted = 0 OR m.is_deleted IS NULL) THEN 1 ELSE 0 END) as completed_items
            FROM categories c
            LEFT JOIN master_informasi mi ON c.id = mi.category_id
            LEFT JOIN monitoring m ON mi.id = m.master_id AND m.year = ? AND m.triwulan = ?
            GROUP BY c.id, c.name
        ", [$currentYear, $currentTriwulan]);
        
        $chartData = [];
        foreach ($queryCategoryCompliance->result_array() as $row) {
            $total = (int)$row['total_items'];
            $completed = (int)$row['completed_items'];
            $kepatuhan = $total > 0 ? round(($completed / $total) * 100) : 0;
            $chartData[] = [
                'label' => $row['category_name'],
                'value' => $kepatuhan
            ];
        }
        $data['chartData'] = json_encode($chartData);

        $data['title'] = 'Beranda - PEPADUN';
        
        // Memuat view landing page menggunakan arsitektur layouting
        $this->load->view('layouts/landing', $data);
    }
}
