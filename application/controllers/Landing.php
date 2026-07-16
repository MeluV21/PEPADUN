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

        $searchFilter = $this->input->get('search');
        $categoryFilter = $this->input->get('category');
        $statusFilter = $this->input->get('status');
        
        $page = (int)$this->input->get('page');
        if ($page < 1) $page = 1;
        
        $perPage = (int)$this->input->get('per_page');
        if (!in_array($perPage, [10, 25, 50])) $perPage = 10;
        
        $offset = ($page - 1) * $perPage;

        $buildQuery = function() use ($db, $currentYear, $currentTriwulan, $searchFilter, $categoryFilter, $statusFilter) {
            $db->select('master_informasi.*, categories.name as category_name, monitoring.id as monitoring_id, monitoring.status, monitoring.pj, monitoring.description, monitoring.triwulan, monitoring.year, monitoring.custom_name, users.nama as reporter_name')
               ->from('master_informasi')
               ->join('categories', 'categories.id = master_informasi.category_id', 'left')
               ->join('monitoring', "monitoring.master_id = master_informasi.id AND monitoring.triwulan = " . (int)$currentTriwulan . " AND monitoring.year = " . (int)$currentYear, 'left')
               ->join('users', 'users.id_user = monitoring.created_by', 'left');

            $db->group_start()
               ->where('monitoring.is_deleted', 0)
               ->or_where('monitoring.is_deleted IS NULL')
               ->group_end();

            if (!empty($searchFilter)) {
                $db->group_start()
                   ->like('master_informasi.name', $searchFilter)
                   ->or_like('monitoring.custom_name', $searchFilter)
                   ->or_like('monitoring.description', $searchFilter)
                   ->or_like('categories.name', $searchFilter)
                   ->or_like('monitoring.pj', $searchFilter)
                   ->or_like('master_informasi.timeline', $searchFilter)
                   ->or_like('users.nama', $searchFilter);

                $lowerSearch = strtolower($searchFilter);
                if (strpos($lowerSearch, 'selesai') !== false || strpos($lowerSearch, 'complete') !== false) {
                    $db->or_like('monitoring.status', 'completed');
                }
                if (strpos($lowerSearch, 'proses') !== false || strpos($lowerSearch, 'progress') !== false || strpos($lowerSearch, 'jalan') !== false) {
                    $db->or_like('monitoring.status', 'progress');
                }
                if (strpos($lowerSearch, 'belum') !== false || strpos($lowerSearch, 'pending') !== false || strpos($lowerSearch, 'update') !== false) {
                    $db->or_like('monitoring.status', 'pending');
                    $db->or_where('monitoring.status IS NULL');
                }
                $db->group_end();
            }

            if (!empty($categoryFilter)) {
                $db->where('master_informasi.category_id', $categoryFilter);
            }

            if (!empty($statusFilter)) {
                if ($statusFilter == 'pending') {
                    $db->group_start()
                       ->where('monitoring.status', 'pending')
                       ->or_where('monitoring.status IS NULL')
                       ->group_end();
                } else {
                    $db->where('monitoring.status', $statusFilter);
                }
            }
        };

        $buildQuery();
        $totalRows = $db->count_all_results('', TRUE); // TRUE resets the AR state
        
        $buildQuery(); // Rebuild the query for the actual fetch
        $db->order_by("CASE WHEN categories.name IS NULL OR LOWER(TRIM(categories.name)) = 'tanpa kategori' OR LOWER(TRIM(categories.name)) = 'lainnya' THEN master_informasi.id ELSE (SELECT MIN(mi2.id) FROM master_informasi mi2 LEFT JOIN categories c2 ON c2.id = mi2.category_id WHERE mi2.category_id = master_informasi.category_id AND c2.name IS NOT NULL AND LOWER(TRIM(c2.name)) != 'tanpa kategori' AND LOWER(TRIM(c2.name)) != 'lainnya') END", "ASC");
        $db->order_by('master_informasi.id', 'ASC');
        $db->limit($perPage, $offset);
        
        $data['monitoringList'] = $db->get()->result_array();

        $data['currentPage'] = $page;
        $data['perPage'] = $perPage;
        $data['totalRows'] = $totalRows;
        $data['totalPages'] = ceil($totalRows / $perPage);
        
        $db->order_by('name', 'ASC');
        $data['categories'] = $db->get('categories')->result_array();
        
        $data['selectedCategory'] = $categoryFilter;
        $data['selectedStatus'] = $statusFilter;
        $data['searchQuery'] = $searchFilter;

        $data['currentYear'] = $currentYear;
        $data['currentTriwulan'] = $currentTriwulan;

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
