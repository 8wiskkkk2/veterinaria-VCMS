<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RoleCheck {
    
    public function verify() {
        $CI =& get_instance();
        
        if (!isset($CI->session)) {
            $CI->load->library('session');
        }
        
        if (!$CI->session->userdata('logged_in')) {
            return;
        }
        
        $role = $CI->session->userdata('role');
        $current_controller = $CI->router->fetch_class();
        
        if ($role === 'administrador' && $current_controller !== 'admin' && $current_controller !== 'auth') {
            redirect('admin/dashboard');
        } elseif ($role === 'veterinario' && $current_controller !== 'veterinario' && $current_controller !== 'auth') {
            redirect('veterinario/dashboard');
        } elseif ($role !== 'administrador' && $role !== 'veterinario' && $current_controller === 'admin') {
            redirect('user/index');
        }
    }
}