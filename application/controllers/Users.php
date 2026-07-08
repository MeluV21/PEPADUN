<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $userModel = $this->User_model;
        $data['users'] = $userModel->orderBy('fullname', 'ASC')->findAll();
        $data['title'] = 'Manajemen Pengguna';
        $data['content_view'] = 'users/index';
        $this->load->view('layouts/admin', $data);
    }

    public function store() {
        $userModel = $this->User_model;

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,karyawan]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal. Pastikan username unik (min 3 karakter) dan password minimal 6 karakter.');
            redirect('users');
        }

        $data = $this->input->post();
        if (isset($data[$this->security->get_csrf_token_name()])) {
            unset($data[$this->security->get_csrf_token_name()]);
        }
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $userModel->save($data);

        session()->setFlashdata('success', 'Data karyawan berhasil ditambahkan.');
        redirect('users');
    }

    public function update($id) {
        $userModel = $this->User_model;

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,karyawan]');

        if ($this->form_validation->run() === FALSE) {
            session()->setFlashdata('error', 'Validasi gagal.');
            redirect('users');
        }

        $username = $this->input->post('username');
        $existingUser = $userModel->find($id);

        if (!$existingUser) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
            redirect('users');
        }

        // Check if username is changed and conflict exists
        if ($existingUser['username'] !== $username) {
            $conflictUser = $userModel->where('username', $username)->first();
            if ($conflictUser) {
                session()->setFlashdata('error', 'Validasi gagal. Username sudah digunakan.');
                redirect('users');
            }
        }

        $data = $this->input->post();
        if (isset($data[$this->security->get_csrf_token_name()])) {
            unset($data[$this->security->get_csrf_token_name()]);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $userModel->update($id, $data);

        // Update session if editing self
        if (session()->get('id') == $id) {
            session()->set([
                'username' => $data['username'],
                'fullname' => $data['fullname'],
                'role'     => $data['role'],
            ]);
        }

        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui.');
        redirect('users');
    }

    public function delete($id) {
        $userModel = $this->User_model;

        if (session()->get('id') == $id) {
            session()->setFlashdata('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            redirect('users');
        }

        try {
            $userModel->delete($id);
            session()->setFlashdata('success', 'Pengguna berhasil dihapus.');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus pengguna. Pengguna ini mungkin memiliki data monitoring.');
        }
        redirect('users');
    }
}
