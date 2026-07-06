<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    
    public function index() {
        // Data statis untuk sementara
        $data['title'] = 'Beranda - PEPADUN';
        
        // Memuat view landing page menggunakan arsitektur layouting
        $this->load->view('layouts/landing', $data);
    }

}
