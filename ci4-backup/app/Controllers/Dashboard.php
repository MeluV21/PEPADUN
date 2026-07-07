<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Monitoring;

class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new User();
        $categoryModel = new Category();
        $monitoringModel = new Monitoring();

        // 1. Core counters
        $data['totalUsers'] = $userModel->countAllResults();
        $data['totalCategories'] = $categoryModel->countAllResults();
        $data['totalMonitoring'] = $monitoringModel->countAllResults();

        // 2. Monitoring by status
        $data['statusPending'] = $monitoringModel->where('status', 'pending')->countAllResults();
        $data['statusProgress'] = $monitoringModel->where('status', 'progress')->countAllResults();
        $data['statusCompleted'] = $monitoringModel->where('status', 'completed')->countAllResults();

        // 3. Category distribution (for Chart.js)
        $db = \Config\Database::connect();
        $query = $db->query('
            SELECT c.name as category_name, COUNT(m.id) as total 
            FROM categories c 
            LEFT JOIN monitoring m ON c.id = m.category_id 
            GROUP BY c.id, c.name
        ');
        $data['categoryChart'] = $query->getResultArray();

        // 4. Recent activities/monitoring
        $data['recentMonitoring'] = $monitoringModel
            ->select('monitoring.*, categories.name as category_name, users.fullname as reporter_name')
            ->join('categories', 'categories.id = monitoring.category_id')
            ->join('users', 'users.id = monitoring.created_by')
            ->orderBy('monitoring.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data['title'] = 'Dashboard';
        return view('dashboard', $data);
    }
}
