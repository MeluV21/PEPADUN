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
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'fullname'   => $user['fullname'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true,
                ]);
                redirect('dashboard');
            }

            session()->setFlashdata('error', 'Username atau Password salah.');
            redirect('login');
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        session()->destroy();
        redirect(base_url());
    }
}
