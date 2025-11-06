<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
    }

    public function verificar_rut() {
        if($this->input->is_ajax_request()) {
            $rut = $this->input->post('rut');
            
            // Verificar si el RUT existe
            $exists = $this->Usuario_model->verificar_rut_existe($rut);
            
            echo json_encode(['exists' => $exists]);
        }
    }

    public function guardar() {
        if ($this->input->post()) {
            $datos = $this->input->post();
            
            // Verificar que las contraseñas coincidan
            if ($datos['password'] !== $datos['confirm_password']) {
                $this->session->set_flashdata('error', 'Las contraseñas no coinciden');
                redirect('recepcionista/usuarios/crear');
                return;
            }
            
            // Verificar si el RUT ya existe
            if ($this->Usuario_model->verificar_rut_existe($datos['rut'])) {
                $this->session->set_flashdata('rut_error', 'El RUT ya está registrado en el sistema');
                redirect('recepcionista/usuarios/crear');
                return;
            }
            
            // Intentar crear el usuario
            if ($this->Usuario_model->crear($datos)) {
                $this->session->set_flashdata('success', 'Usuario creado correctamente');
                redirect('recepcionista/usuarios');
            } else {
                $this->session->set_flashdata('error', 'Error al crear el usuario');
                redirect('recepcionista/usuarios/crear');
            }
        }
    }

    public function index() {
        $data['usuarios'] = $this->Usuario_model->get_usuarios_by_role('usuario');
        $data['title'] = 'Lista de Usuarios';
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/usuarios/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function ver($id) {
        $usuario = $this->Usuario_model->get_usuario($id);
        
        if ($usuario) {
            header('Content-Type: application/json');
            echo json_encode($usuario);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }

    public function editar($id) {
        $data['usuario'] = $this->Usuario_model->get_usuario($id);
        
        if (!$data['usuario']) {
            $this->session->set_flashdata('error', 'Usuario no encontrado');
            redirect('recepcionista/usuarios');
            return;
        }
    
        $data['title'] = 'Editar Usuario';
    
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/usuarios/editar', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function actualizar($id) {
        $data = $this->input->post();
        
        if ($this->Usuario_model->actualizar($id, $data)) {
            $this->session->set_flashdata('success', 'Usuario actualizado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar el usuario');
        }
        
        redirect('recepcionista/usuarios');
    }
}