<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        if(!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }
        
        // Verificar que sea un usuario normal y tenga rol definido
        if($this->session->userdata('role') === 'administrador') {
            redirect('admin/dashboard');
            return;
        }
        
        $this->load->model('Mascota_model');

        $this->load->model('Vacuna_model');
        $this->load->model('Desparacitacion_model');
        $this->load->model('Emergencia_model');
        $this->load->model('Autorizacion_model');
    }

    public function index() {
        $data['page_title'] = 'Panel de Usuario';
        $this->load->view('templates/header', $data);
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }
    
    public function mascotas() {
        $this->load->model('Mascota_model');
        $usuario_id = $this->session->userdata('id');
        
        $data['mascotas'] = $this->Mascota_model->get_mascotas_by_usuario($usuario_id);
        $data['page_title'] = 'Mis Mascotas';
        
        $this->load->view('templates/header', $data);
        $this->load->view('user/mascotas', $data);
        $this->load->view('templates/footer');
    }

    public function citas() {
        $this->load->view('templates/header');
        $this->load->view('user/citas');
        $this->load->view('templates/footer');
    }

    public function historial() {
        $usuario_id = $this->session->userdata('id');
        
        // Obtener las mascotas del usuario
        $mascotas = $this->Mascota_model->get_mascotas_by_usuario($usuario_id);
        
        // Modificar esta línea para asegurarnos de obtener los IDs correctamente
        $mascotas_ids = [];
        foreach ($mascotas as $mascota) {
            $mascotas_ids[] = $mascota->id;
        }
        
        $data = array(
            'page_title' => 'Historial Médico - Veterinaria Municipal',  // Agregar esta línea
            'vacunas' => array(),
            'desparacitaciones' => array(),
            'emergencias' => array(),
            'autorizaciones' => array()
        );
    
        // Si el usuario tiene mascotas, obtener sus historiales
        if (!empty($mascotas_ids)) {
            $data['vacunas'] = $this->Vacuna_model->get_vacunas_historial($mascotas_ids);
            $data['desparacitaciones'] = $this->Desparacitacion_model->get_desparacitaciones_historial($mascotas_ids);
            $data['emergencias'] = $this->Emergencia_model->get_emergencias_historial($mascotas_ids);
        }

        // Obtener autorizaciones directamente por el ID del usuario
        $data['autorizaciones'] = $this->Autorizacion_model->get_autorizaciones_historial($usuario_id);

        $this->load->view('templates/header', $data);  // Pasar $data al header
        $this->load->view('user/historial', $data);
        $this->load->view('templates/footer');
    }

    public function mapa() {
        // Cargar directamente la vista sin el template
        $this->load->view('user/mapa');
    }

    public function perfil() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
            return;
        }
    
        $user_id = $this->session->userdata('id');
        $this->load->model('Usuario_model');
        $data['usuario'] = $this->Usuario_model->get_usuario($user_id);
    
        if (!$data['usuario']) {
            $this->session->set_flashdata('error', 'No se pudo cargar la información del usuario');
            redirect('user/index');
            return;
        }
        
        // Asegurarse de que el RUT esté disponible
        if (!isset($data['usuario']->rut) && $this->session->userdata('rut')) {
            $data['usuario']->rut = $this->session->userdata('rut');
        }
    
        $this->load->view('user/perfil_nuevo', $data);
    }

    public function editar_perfil() {
        // Obtener datos del usuario actual
        $usuario_id = $this->session->userdata('id');
        $data['usuario'] = $this->Usuario_model->get_usuario($usuario_id);
        
        if (!$data['usuario']) {
            $this->session->set_flashdata('error', 'No se pudo cargar la información del usuario');
            redirect('user/index');
            return;
        }
        
        // Asegurarse de que el RUT esté disponible
        if (!isset($data['usuario']->rut) && $this->session->userdata('rut')) {
            $data['usuario']->rut = $this->session->userdata('rut');
        }
        
        // Cargar solo la vista sin header ni navbar
        $this->load->view('user/editar_perfil', $data);
    }

    public function actualizar_perfil() {
        if ($this->input->post()) {
            $id = $this->session->userdata('id');
            $datos = array(
                'nombre' => $this->input->post('nombre'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'direccion' => $this->input->post('direccion')
            );
            
            // Agregar la actualización de contraseña si se proporciona una nueva
            if ($this->input->post('password') && $this->input->post('password') !== '') {
                $datos['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            
            if ($this->Usuario_model->actualizar_usuario($id, $datos)) {
                $this->session->set_flashdata('success', 'Perfil actualizado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar el perfil');
            }
        }
        redirect('user/perfil');
    }

    public function eliminar_cuenta() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        $id = $this->session->userdata('id');
        $usuario = $this->Usuario_model->get_usuario($id);

        if ($this->Usuario_model->eliminar($id)) {

            
            $this->session->sess_destroy();
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar la cuenta');
            redirect('user/perfil');
        }
    }

    public function nueva_mascota() {
        // Display the form
        $this->load->view('templates/header');
        $this->load->view('user/nueva_mascota');
        $this->load->view('templates/footer');
    }

    public function agregar_mascota() {
        if ($this->input->post()) {
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'especie' => $this->input->post('especie'),
                'raza' => $this->input->post('raza'),
                'sexo' => $this->input->post('sexo'),
                'edad_aproximada' => $this->input->post('edad_aproximada'),
                'peso' => $this->input->post('peso'),
                'color' => $this->input->post('color'),
                'alergias_conocidas' => $this->input->post('alergias_conocidas') ?: 'Ninguna conocida',
                'usuario_id' => $this->session->userdata('id')
            );
            
            if ($this->Mascota_model->crear_mascota($data)) {
                $nombre_usuario = $this->session->userdata('nombre');

                
                $this->session->set_flashdata('success', 'Mascota agregada exitosamente');
                redirect('user/mascotas');
            } else {
                $this->session->set_flashdata('error', 'Error al agregar la mascota');
                redirect('user/nueva_mascota');
            }
        } else {
            // Si no hay datos POST, mostrar el formulario
            $this->load->view('templates/header');
            $this->load->view('user/nueva_mascota');
            $this->load->view('templates/footer');
        }
    }

    public function editar_mascota($id) {
        // Agregar debug para verificar los datos
        $data['mascota'] = $this->Mascota_model->get_mascota($id);
        
        if ($this->input->method() == 'post') {
            $update_data = array(
                'nombre' => $this->input->post('nombre'),
                'especie' => $this->input->post('especie'),
                'raza' => $this->input->post('raza'),
                'sexo' => $this->input->post('sexo'),
                'edad_aproximada' => $this->input->post('edad_aproximada'),
                'peso' => $this->input->post('peso'),
                'color' => $this->input->post('color'),
                'alergias_conocidas' => $this->input->post('alergias_conocidas') ?: 'Ninguna conocida'
            );
        
            // Agregar log para debug
            log_message('debug', 'Actualizando mascota: ' . print_r($update_data, true));
        
            if ($this->Mascota_model->actualizar_mascota($id, $update_data)) {

                
                $this->session->set_flashdata('success', 'Mascota actualizada exitosamente');
                redirect('user/mascotas');
            }
            else {
                $this->session->set_flashdata('error', 'Error al actualizar la mascota');
                redirect('user/editar_mascota/' . $id);
            }
        }

        $this->load->view('templates/header');
        $this->load->view('user/editar_mascota', $data);
        $this->load->view('templates/footer');
    }

    public function eliminar_mascota($id) {
        $mascota = $this->Mascota_model->get_mascota($id);
        
        // Verificar que la mascota exista y pertenezca al usuario actual
        if (!$mascota || $mascota->usuario_id != $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'No tienes permiso para eliminar esta mascota');
            redirect('user/mascotas');
            return;
        }
    
        if ($this->Mascota_model->eliminar_mascota($id)) {
            $this->session->set_flashdata('success', 'Mascota eliminada exitosamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar la mascota');
            log_message('error', 'Error al eliminar mascota: ' . $this->db->error()['message']);
        }
        
        redirect('user/mascotas');
    }

    public function debug_session() {
        echo "<pre>";
        print_r($this->session->userdata());
        echo "\nID de usuario: " . $this->session->userdata('id');
        echo "\nLogged in: " . ($this->session->userdata('logged_in') ? 'true' : 'false');
        echo "</pre>";
        die();
    }
    
    // Añadir cualquier otro método que necesites aquí
    
} // Esta es la llave de cierre que falta para la clase User


    function subir_foto($mascota_id) {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $config['upload_path'] = './uploads/mascotas/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'mascota_' . $mascota_id . '_' . time();

            $this->load->library('upload', $config);

            // Crear el directorio si no existe
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto_nombre = $upload_data['file_name'];

                // Actualizar la foto en la base de datos
                if ($this->Mascota_model->actualizar_foto($mascota_id, $foto_nombre)) {
                    $this->session->set_flashdata('success', 'Foto subida correctamente');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar la foto en la base de datos');
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
        
        // Redireccionar a la página de mascotas
        redirect('user/mascotas');
    }