<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    protected function check_role($allowed_roles) {
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $current_role = $this->session->userdata('role');
        if(!in_array($current_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'No tienes permiso para acceder a esta sección');
            
            // Corregir las rutas de redirección según el rol
            switch($current_role) {
                case 'usuario':
                    redirect('user');
                    break;
                case 'veterinario':
                    redirect('veterinario');
                    break;
                case 'recepcionista':
                    redirect('recepcionista');
                    break;
                default:
                    redirect('auth/login');
            }
        }
    }
}