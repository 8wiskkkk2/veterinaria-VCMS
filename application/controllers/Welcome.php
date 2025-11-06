<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Página principal de bienvenida
     * Muestra información de la veterinaria y botón de acceso al login
     */
    public function index() {
        // Verificar si ya está logueado y redirigir según el rol
        if($this->session->userdata('logged_in')) {
            switch($this->session->userdata('role')) {
                case 'administrador':
                    redirect('admin');
                    break;
                case 'recepcionista':
                    redirect('recepcionista');
                    break;
                case 'veterinario':
                    redirect('veterinario');
                    break;
                default:
                    redirect('user/index');
            }
        }
        
        // Cargar la vista de bienvenida
        $this->load->view('welcome/index');
    }

    /**
     * Redirige al login
     */
    public function login() {
        redirect('auth/login');
    }
}
