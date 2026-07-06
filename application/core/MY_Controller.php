<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
}

class Auth_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('isLoggedIn')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('login');
        }
    }
}

class Admin_Controller extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Halaman ini hanya untuk Administrator.');
            redirect('dashboard');
        }
    }
}
