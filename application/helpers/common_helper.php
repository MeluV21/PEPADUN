<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 1. Session Wrapper Class to mimic CodeIgniter 4 Session object
if (!class_exists('CI3_Session_Wrapper')) {
    class CI3_Session_Wrapper {
        protected $session;

        public function __construct() {
            $this->session =& get_instance()->session;
        }

        public function get($key) {
            return $this->session->userdata($key);
        }

        public function set($data, $value = NULL) {
            if (is_array($data)) {
                $this->session->set_userdata($data);
            } else {
                $this->session->set_userdata($data, $value);
            }
        }

        public function destroy() {
            $this->session->sess_destroy();
        }

        public function getFlashdata($key) {
            return $this->session->flashdata($key);
        }

        public function setFlashdata($key, $value) {
            $this->session->set_flashdata($key, $value);
        }
    }
}

// 2. Global session() Helper function
if (!function_exists('session')) {
    function session() {
        static $wrapper = null;
        if ($wrapper === null) {
            $CI =& get_instance();
            if (!isset($CI->session)) {
                $CI->load->library('session');
            }
            $wrapper = new CI3_Session_Wrapper();
        }
        return $wrapper;
    }
}

// 3. Global old() Helper function for form recovery
if (!function_exists('old')) {
    function old($key, $default = '') {
        $CI =& get_instance();
        
        // Try POST data first
        $post_val = $CI->input->post($key);
        if ($post_val !== NULL) {
            return html_escape($post_val);
        }
        
        // Try GET data next
        $get_val = $CI->input->get($key);
        if ($get_val !== NULL) {
            return html_escape($get_val);
        }
        
        return html_escape($default);
    }
}

// 4. Global esc() Helper function for HTML escaping
if (!function_exists('esc')) {
    function esc($val) {
        return html_escape($val);
    }
}

// 5. Global csrf_field() Helper function
if (!function_exists('csrf_field')) {
    function csrf_field() {
        $CI =& get_instance();
        if ($CI->config->item('csrf_protection') === TRUE) {
            $name = $CI->security->get_csrf_token_name();
            $hash = $CI->security->get_csrf_hash();
            return '<input type="hidden" name="' . $name . '" value="' . $hash . '">';
        }
        return '';
    }
}
