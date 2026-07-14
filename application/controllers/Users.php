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
        
        $search = $this->input->get('search');
        if (!empty($search)) {
            $userModel->groupStart();
            $userModel->like('nama', $search);
            $userModel->orLike('username', $search);
            $userModel->orLike('email', $search);
            $userModel->orLike('role', $search);
            $userModel->orLike('nip', $search);
            $userModel->groupEnd();
        }
        
        $data['searchQuery'] = $search;
        $data['users'] = $userModel->orderBy('nama', 'ASC')->findAll();
        $data['title'] = 'Manajemen Data Karyawan';
        $data['content_view'] = 'users/index';
        $this->load->view('layouts/admin', $data);
    }

    public function store() {
        $userModel = $this->User_model;

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
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

        if (!empty($_FILES['image_user']['name'])) {
            $config['upload_path']   = './uploads/users/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048; // 2MB
            $config['encrypt_name']  = FALSE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image_user')) {
                $uploadData = $this->upload->data();
                $data['image_user'] = $uploadData['file_name'];
            } else {
                session()->setFlashdata('error', 'Gagal mengupload foto: ' . $this->upload->display_errors('',''));
                redirect('users');
            }
        }

        $userModel->save($data);

        session()->setFlashdata('success', 'Data karyawan berhasil ditambahkan.');
        redirect('users');
    }

    public function update($id) {
        $userModel = $this->User_model;

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
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

        if (isset($data['old_image_user'])) {
            unset($data['old_image_user']);
        }

        if (!empty($_FILES['image_user']['name'])) {
            $config['upload_path']   = './uploads/users/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = 2048; // 2MB
            $config['encrypt_name']  = FALSE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image_user')) {
                $uploadData = $this->upload->data();
                $data['image_user'] = $uploadData['file_name'];
                
                // Optionally delete the old image if it exists
                $old_image = $this->input->post('old_image_user');
                if (!empty($old_image) && file_exists('./uploads/users/' . $old_image)) {
                    unlink('./uploads/users/' . $old_image);
                }
            } else {
                session()->setFlashdata('error', 'Gagal mengupload foto: ' . $this->upload->display_errors('',''));
                redirect('users');
            }
        } else {
            // Keep the old image
            $data['image_user'] = $this->input->post('old_image_user');
        }

        $userModel->update($id, $data);

        // Update session if editing self
        if (session()->get('id_user') == $id) {
            session()->set([
                'username' => $data['username'],
                'nama' => $data['nama'],
                'role'     => $data['role'],
                'image_user' => $data['image_user'] ?? session()->get('image_user'),
            ]);
        }

        session()->setFlashdata('success', 'Data karyawan berhasil diperbarui.');
        redirect('users');
    }

    public function delete($id) {
        $userModel = $this->User_model;

        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Hanya Admin yang dapat menghapus data pengguna.');
            redirect('users');
        }

        if (session()->get('id_user') == $id) {
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
