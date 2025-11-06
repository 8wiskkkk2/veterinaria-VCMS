<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Verificar si el usuario está logueado y es administrador
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'administrador') {
            redirect('auth');
        }
    }

    public function index() {
        // Cargar la vista directamente sin usar plantillas
        $this->load->view('admin_dashboard');
    }
}