<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $categoryModel = $this->Category_model;
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();
        $data['title'] = 'Manajemen Kategori';
        $data['content_view'] = 'categories/index';
        $this->load->view('layouts/admin', $data);
    }

    public function store() {
        $categoryModel = $this->Category_model;

        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal. Nama kategori minimal 3 karakter.');
            redirect('categories');
        }

        $categoryModel->save([
            'name'        => $this->input->post('name'),
            'description' => $this->input->post('description'),
        ]);

        session()->setFlashdata('success', 'Kategori berhasil ditambahkan.');
        redirect('categories');
    }

    public function update($id) {
        $categoryModel = $this->Category_model;

        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal.');
            redirect('categories');
        }

        $categoryModel->update($id, [
            'name'        => $this->input->post('name'),
            'description' => $this->input->post('description'),
        ]);

        session()->setFlashdata('success', 'Kategori berhasil diperbarui.');
        redirect('categories');
    }

    public function delete($id) {
        $categoryModel = $this->Category_model;

        try {
            $categoryModel->delete($id);
            session()->setFlashdata('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus kategori. Kategori ini mungkin masih digunakan oleh data monitoring.');
        }
        redirect('categories');
    }
}
