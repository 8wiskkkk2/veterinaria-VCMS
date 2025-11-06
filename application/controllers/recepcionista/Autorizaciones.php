<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autorizaciones extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cargar los modelos necesarios
        $this->load->model('Mascota_model');
        $this->load->model('Autorizacion_model');
        
        // Verificar que el usuario esté logueado y sea recepcionista
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'recepcionista') {
            redirect('auth');
        }
    }

    public function index() {
        $data['titulo'] = 'Autorizaciones';
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/index');
        $this->load->view('recepcionista/templates/footer');
    }

    // Método para el formulario de eutanasia
    public function eutanasia_crear() {
        $data['titulo'] = 'Nueva Autorización de Eutanasia';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/eutanasia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    // Método para el formulario de cirugía
    public function cirugia_crear() {
        $data['titulo'] = 'Nueva Autorización de Cirugía';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/cirugia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    // Método para el formulario de sedación
    public function sedacion_crear() {
        $data['titulo'] = 'Nueva Autorización de Sedación';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/sedacion/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }
}

