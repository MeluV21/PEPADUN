<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if (session()->get('isLoggedIn')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $userModel = $this->User_model;
            $user = $userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set([
                    'id_user'    => $user['id_user'],
                    'username'   => $user['username'],
                    'nama'       => $user['nama'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true,
                ]);

                // Fitur Ingat Saya
                $this->load->helper('cookie');
                if ($this->input->post('ingat_saya')) {
                    set_cookie('remember_email', $username, 3600 * 24 * 30); // 30 hari
                    set_cookie('remember_password', $password, 3600 * 24 * 30);
                } else {
                    delete_cookie('remember_email');
                    delete_cookie('remember_password');
                }

                redirect('dashboard');
            }

            session()->setFlashdata('error', 'Username atau Password salah.');
            redirect('login');
        }

        $this->load->helper('cookie');
        $data['remember_email'] = get_cookie('remember_email');
        $data['remember_password'] = get_cookie('remember_password');

        $this->load->view('auth/login', $data);
    }

    public function logout() {
        session()->destroy();
        redirect(base_url());
    }
}
