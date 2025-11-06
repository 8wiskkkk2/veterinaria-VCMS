<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_role(['administrador']);
        $this->load->model('User_model');
        $this->load->model('Mascota_model');

        $this->load->library('pagination'); // Añadimos esta línea
    }

    public function index() {
        $data['titulo'] = 'Dashboard Administrativo';
        
    
        $data['total_usuarios'] = $this->User_model->count_users();
        $data['total_mascotas'] = $this->Mascota_model->count_mascotas();
        $data['total_citas'] = 0; 
        
        

        
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function usuarios() {
        $data['titulo'] = 'Gestión de Usuarios';
        $data['usuarios'] = $this->User_model->get_all_users();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/usuarios/index', $data);
        $this->load->view('admin/templates/footer');
     }

    public function actualizar_usuario($id) {
        if ($this->input->post()) {
            $datos = $this->input->post();
            
            if($this->User_model->actualizar_usuario($id, $datos)) {
                $nombre_admin = $this->session->userdata('nombre');

                
                $this->session->set_flashdata('success', 'Usuario actualizado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar el usuario');
            }
            redirect('admin/usuarios');
        }
    }

    public function eliminar_usuario($id) {
        // Verificar que no se intente eliminar al usuario actual
        if ($id == $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'No puedes eliminar tu propio usuario');
            redirect('admin/usuarios');
            return;
        }
    
        // Obtener información del usuario antes de eliminarlo
        $usuario = $this->User_model->get_user_by_id($id);
        
        if (!$usuario) {
            $this->session->set_flashdata('error', 'Usuario no encontrado');
            redirect('admin/usuarios');
            return;
        }
        
        try {

            
            if ($this->User_model->eliminar_usuario($id)) {
                $this->session->set_flashdata('success', 'Usuario eliminado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al eliminar el usuario');
            }
        } catch (Exception $e) {
            log_message('error', 'Error al eliminar usuario: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
        
        redirect('admin/usuarios');
    }

    public function crear_usuario() {
        if($this->input->method() === 'post') {
            $this->load->library('form_validation');
            
            $this->form_validation->set_message('is_unique', 'El %s ya está registrado en el sistema');
            $this->form_validation->set_message('valid_email', 'El campo %s debe contener una dirección de correo válida');
            $this->form_validation->set_message('required', 'El campo %s es obligatorio');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres');
            $this->form_validation->set_message('matches', 'Las contraseñas no coinciden');
            
            $this->form_validation->set_rules('rut', 'RUT', 'required|is_unique[users.rut]');
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('direccion', 'Dirección', 'required');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'required|matches[password]');
            $this->form_validation->set_rules('role', 'Rol', 'required');
            
            if($this->form_validation->run()) {
                $datos = array(
                    'rut' => $this->input->post('rut'),
                    'nombre' => $this->input->post('nombre'),
                    'email' => $this->input->post('email'),
                    'direccion' => $this->input->post('direccion'),
                    'telefono' => $this->input->post('telefono'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role')
                );
                
                if($this->User_model->crear($datos)) {
                    $nombre_admin = $this->session->userdata('nombre');

                    
                    $this->session->set_flashdata('success', 'Usuario creado correctamente');
                    redirect('admin/usuarios');
                } else {
                    $this->session->set_flashdata('error', 'Error al crear el usuario');
                    redirect('admin/usuarios/crear');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin/usuarios/crear');
            }
        }
        
        $data['titulo'] = 'Crear Nuevo Usuario';
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/usuarios/crear', $data);
        $this->load->view('admin/templates/footer');
    }

    public function editar_usuario($id) {
        // Primero cargar las reglas de validación
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('role', 'Rol', 'required');
    
        // Verificar si hay datos POST
        if ($this->input->post()) {
            // Verificar si el email ya existe para otro usuario
            $email = $this->input->post('email');
            $this->db->where('email', $email);
            $this->db->where('id !=', $id);
            $email_existe = $this->db->get('users')->num_rows() > 0;
            
            if ($email_existe) {
                $this->session->set_flashdata('error', 'El email ya está registrado para otro usuario');
                redirect('admin/editar_usuario/' . $id);
                return;
            }
            
            $datos_actualizacion = array(
                'nombre' => $this->input->post('nombre'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'direccion' => $this->input->post('direccion'),
                'role' => $this->input->post('role')
            );

            if ($this->input->post('password') && !empty($this->input->post('password'))) {
                $datos_actualizacion['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            
            try {
                if ($this->User_model->actualizar_usuario($id, $datos_actualizacion)) {

                    
                    $this->session->set_flashdata('success', 'Usuario actualizado correctamente');
                    redirect('admin/usuarios');
                    return;
                }
            } catch (Exception $e) {
                log_message('error', 'Error al actualizar usuario: ' . $e->getMessage());
            }
            
            $this->session->set_flashdata('error', 'Error al actualizar el usuario');
            redirect('admin/usuarios');
            return;
        }

        // Si no hay POST, mostrar el formulario
        $data['titulo'] = 'Editar Usuario';
        $data['usuario'] = $this->User_model->get_user_by_id($id);
        
        if (!$data['usuario']) {
            $this->session->set_flashdata('error', 'Usuario no encontrado');
            redirect('admin/usuarios');
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/usuarios/editar', $data);
        $this->load->view('admin/templates/footer');
    }

    // Funciones para Mascotas
    public function mascotas() {
        $data['title'] = 'Mascotas';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        // Cambiar esta línea para usar un método que sí exista en tu modelo
        // En lugar de get_users_by_role, usamos get_all_users y filtramos por rol
        $data['propietarios'] = $this->User_model->get_all_users();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar'); // Añadiendo esta línea para cargar el navbar
        $this->load->view('admin/mascotas/index', $data);
        $this->load->view('admin/templates/footer');
    }

    public function crear_mascota($propietario_id = null) {
        // Verificar si se proporcionó un ID de propietario
        if ($propietario_id === null) {
            $this->session->set_flashdata('error', 'Debe seleccionar un propietario para la mascota');
            redirect('admin/mascotas');
        }
        
        // Obtener datos del propietario
        $propietario = $this->User_model->get_user_by_id($propietario_id);
        if (!$propietario) {
            $this->session->set_flashdata('error', 'El propietario seleccionado no existe');
            redirect('admin/mascotas');
        }
        
        // Procesar el formulario si se envió
        if ($this->input->post()) {
            $datos = $this->input->post();
            
            // Asignar el ID del propietario
            $datos['usuario_id'] = $propietario_id;
            
            // Guardar la mascota
            if ($this->Mascota_model->crear_mascota($datos)) {

                $this->session->set_flashdata('success', 'Mascota creada correctamente');
                redirect('admin/mascotas');
            } else {
                $this->session->set_flashdata('error', 'Error al crear la mascota');
            }
        }
        
        // Cargar la vista con los datos del propietario
        $data['propietario'] = $propietario;
        $data['title'] = 'Crear Nueva Mascota';
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/mascotas/crear', $data);
        $this->load->view('admin/templates/footer');
    }

    public function editar_mascota($id) {
        if ($this->input->post()) {
            $datos = $this->input->post();
            if($this->Mascota_model->actualizar_mascota($id, $datos)) {

                $this->session->set_flashdata('success', 'Mascota actualizada correctamente');
                redirect('admin/mascotas');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar la mascota');
            }
        }

        $data['titulo'] = 'Editar Mascota';
        $data['mascota'] = $this->Mascota_model->get_mascota($id);
        $data['usuarios'] = $this->User_model->get_all_users();
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/mascotas/editar', $data);
        $this->load->view('admin/templates/footer');
    }

    public function eliminar_mascota($id) {
        // Obtener información de la mascota antes de eliminarla
        $mascota = $this->Mascota_model->get_mascota($id);
        
        if (!$mascota) {
            $this->session->set_flashdata('error', 'La mascota no existe o ya ha sido eliminada');
            redirect('admin/mascotas');
        }
        
        // Intentar eliminar la mascota
        if ($this->Mascota_model->eliminar_mascota($id)) {

            
            $this->session->set_flashdata('success', 'Mascota eliminada correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar la mascota');
        }
        
        redirect('admin/mascotas');
    }
    
    // Añadir este método al controlador Admin
    // Cambiar de private a public para que sea accesible desde la vista
    public function get_badge_color($accion) {
        switch(strtoupper($accion)) {
            case 'CREATE':
                return 'bg-success';
            case 'UPDATE':
                return 'bg-warning';
            case 'DELETE':
                return 'bg-danger';
            case 'LOGIN':
                return 'bg-info';
            case 'LOGOUT':
                return 'bg-secondary';
            default:
                return 'bg-secondary';
        }
    }


    

    public function citas() {
        $data['titulo'] = 'Gestión de Citas';
        $data['mensaje_desarrollo'] = 'Esta sección está en desarrollo. Próximamente podrás gestionar las citas veterinarias desde aquí.';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/citas/index', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function estadisticas() {
        $data['titulo'] = 'Estadísticas del Sistema';
        
        // Cargar datos para los gráficos
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['usuarios'] = $this->User_model->get_all_users();
        
        // Agregar contadores de autorizaciones
        $data['total_autorizaciones_cirugia'] = $this->db->count_all('autorizaciones_cirugia');
        $data['total_autorizaciones_eutanasia'] = $this->db->count_all('autorizaciones_eutanasia');
        $data['total_autorizaciones_sedacion'] = $this->db->count_all('autorizaciones_sedacion');
        
        // Agregar contador de vacunas y desparasitaciones
        $data['total_vacunas'] = $this->db->count_all('vacunas');
        $data['total_desparasitaciones'] = $this->db->count_all('desparacitaciones'); // Agregar esta línea
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/navbar');
        $this->load->view('admin/estadisticas/index', $data);
        $this->load->view('admin/templates/footer');
    }
    
    public function buscar_usuarios() {
        // Check if this is an AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $query = $this->input->post('query');
        $this->load->model('User_model');
        $usuarios = $this->User_model->buscar_usuarios_por_nombre($query);
        
        echo json_encode($usuarios);
    }
}