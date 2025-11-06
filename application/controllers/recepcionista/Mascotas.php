<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mascotas extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('rol') !== 'recepcionista') {
            redirect('auth/login');
        }
        $this->load->model('mascota_model');
        $this->load->model('usuario_model');
    }

    public function index() {
        $data['mascotas'] = $this->mascota_model->get_all();
        $this->load->view('recepcionista/templates/header');
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/mascotas/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function crear() {
        $data['propietarios'] = $this->usuario_model->get_all_propietarios();
        $this->load->view('recepcionista/templates/header');
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/mascotas/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function guardar() {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'especie' => $this->input->post('especie'),
            'raza' => $this->input->post('raza'),
            'edad' => $this->input->post('edad'),
            'propietario_id' => $this->input->post('propietario_id')
        );

        if ($this->mascota_model->insert($data)) {
            $this->session->set_flashdata('success', 'Mascota registrada exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar la mascota');
        }
        redirect('recepcionista/mascotas');
    }
}