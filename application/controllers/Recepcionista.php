<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcionista extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Verificar si el usuario está logueado y es recepcionista
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        if ($this->session->userdata('role') !== 'recepcionista') {
            $this->session->set_flashdata('error', 'No tienes permiso para acceder a esta sección');
            redirect($this->session->userdata('role'));
        }
        
        $this->load->model('User_model');
        $this->load->model('Mascota_model');
        $this->load->model('Autorizacion_model');
        // Modelos para especie/raza (crean tablas si no existen)
        $this->load->model('Especie_model');
        $this->load->model('Raza_model');

        
        // Cargar datos para el navbar
        $data['usuarios'] = $this->User_model->get_all_users();
        $data['total_usuarios'] = count($data['usuarios']);
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['total_mascotas'] = count($data['mascotas']);
        
        $this->load->vars($data);
    }

    public function index() {
        $data['titulo'] = 'Panel de Recepción';
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/dashboard/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function mascotas() {
        $data['titulo'] = 'Gestión de Mascotas';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/mascotas/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function usuarios() {
        $data['titulo'] = 'Gestión de Usuarios';
        $data['usuarios'] = $this->User_model->get_users_by_role('usuario');
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/usuarios/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function citas() {
        $data['titulo'] = 'Gestión de Citas';
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/citas/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function crear_mascota() {
        $data['titulo'] = 'Registrar Nueva Mascota';
        $data['propietarios'] = $this->User_model->get_all_users();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/mascotas/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function guardar_mascota() {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            // Guardamos nombres por compatibilidad actual
            'especie' => $this->input->post('especie'),
            'raza' => $this->input->post('raza'),
            'color' => $this->input->post('color'),
            'sexo' => $this->input->post('sexo'),
            'edad_aproximada' => $this->input->post('edad_aproximada'),
            'peso' => $this->input->post('peso'),
            'estado_reproductivo' => $this->input->post('estado_reproductivo'),
            'usuario_id' => $this->input->post('usuario_id'),
            'alergias_conocidas' => $this->input->post('alergias_conocidas')
        );
        $this->load->model('Mascota_model');
        $this->Mascota_model->crear_mascota($data);
        redirect('recepcionista/mascotas');
    }

    public function editar_mascota($id) {
        $data['titulo'] = 'Editar Mascota';
        $data['mascota'] = $this->Mascota_model->get_mascota($id);
        $data['propietarios'] = $this->User_model->get_all_users();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/mascotas/editar', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function actualizar_mascota($id) {
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'especie' => $this->input->post('especie'),
            'raza' => $this->input->post('raza'),
            'color' => $this->input->post('color'),
            'sexo' => $this->input->post('sexo'),
            'edad_aproximada' => $this->input->post('edad_aproximada'),
            'peso' => $this->input->post('peso'),
            'estado_reproductivo' => $this->input->post('estado_reproductivo'),
            'usuario_id' => $this->input->post('usuario_id'),
            'alergias_conocidas' => $this->input->post('alergias_conocidas')
        );
        $this->load->model('Mascota_model');
        $this->Mascota_model->actualizar_mascota($id, $data);
        redirect('recepcionista/mascotas');
    }

    // --- Endpoints AJAX para especie/raza ---
    public function buscar_especies() {
        if (!$this->input->is_ajax_request()) { show_404(); }
        $term = $this->input->get('term');
        $especies = $this->Especie_model->buscar_especies($term);
        $out = array();
        foreach ($especies as $e) {
            $out[] = array('id' => $e->id, 'nombre' => $e->nombre);
        }
        echo json_encode($out);
    }

    public function buscar_razas() {
        if (!$this->input->is_ajax_request()) { show_404(); }
        $especie_id = (int)$this->input->get('especie_id');
        $term = $this->input->get('term');
        $razas = $this->Raza_model->buscar_razas_por_especie($especie_id, $term);
        $out = array();
        foreach ($razas as $r) {
            $out[] = array('id' => $r->id, 'nombre' => $r->nombre);
        }
        echo json_encode($out);
    }

    public function editar_usuario($id) {
        $data['titulo'] = 'Editar Usuario';
        $data['usuario'] = $this->User_model->get_user($id);
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/usuarios/editar', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function actualizar_usuario() {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $datos = array(
                'nombre' => $this->input->post('nombre'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'direccion' => $this->input->post('direccion')
            );
            
            if ($this->User_model->actualizar($id, $datos)) {
                $this->session->set_flashdata('success', 'Usuario actualizado correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar el usuario');
            }
        }
        redirect('recepcionista/usuarios');
    }
    public function autorizaciones() {
        $data['titulo'] = 'Gestión de Autorizaciones';
        
        // Cargar el modelo de autorizaciones
        $this->load->model('Autorizacion_model');
        
        // Obtener todas las autorizaciones
        $data['autorizaciones'] = $this->Autorizacion_model->get_all();
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function eutanasia_crear() {
        $data['titulo'] = 'Nueva Autorización de Eutanasia';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario'); 
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/eutanasia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function cirugia_crear() {
        $data['titulo'] = 'Nueva Autorización de Cirugía';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario'); 
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/cirugia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function sedacion_crear() {
        $data['titulo'] = 'Nueva Autorización de Sedación';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario'); // Agregar esta línea
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/sedacion/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    // Los métodos para eutanasia, cirugía y sedación ya están implementados correctamente
    public function atenciones() {
        $data['titulo'] = 'Historial de Atenciones';
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/atenciones/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function atenciones_eutanasias() {
        $data['titulo'] = 'Historial de Eutanasias';
        
        // Cargar el modelo de autorizaciones
        $this->load->model('Autorizacion_model');
        
        // Obtener todas las autorizaciones de eutanasia
        $data['autorizaciones'] = $this->Autorizacion_model->obtener_eutanasias_con_detalles();
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/atenciones/eutanasias', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function atenciones_urgencias() {
        $data['titulo'] = 'Historial de Urgencias';
        
        // Cargar el modelo de emergencias
        $this->load->model('Emergencia_model');
        
        // Obtener todas las emergencias con estado 'atendido'
        $data['emergencias'] = $this->Emergencia_model->get_all_emergencias_completo();
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/atenciones/urgencias', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function emergencias() {
        $data['titulo'] = 'Atenciones de Urgencia';
        
        // Cargar el modelo si aún no está cargado
        $this->load->model('Emergencia_model');
        
        // Cambiar get_all_emergencias() por get_all_emergencias_completo()
        $data['emergencias'] = $this->Emergencia_model->get_all_emergencias_completo();
        
        // Agregar la variable para el tipo de atención
        $data['tipo_atencion'] = 'urgencias';
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/emergencias/index', $data);
        $this->load->view('recepcionista/templates/footer');
    }
    
    public function obtener_datos_tabla() {
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $tipo = $this->input->post('tipo');
        
        switch($tipo) {
            case 'urgencias':
                $this->load->model('Emergencia_model');
                $datos = $this->Emergencia_model->get_all_emergencias();
                break;
            case 'citas':
                $this->load->model('Cita_model');
                $datos = $this->Cita_model->get_all_citas();
                break;
            case 'controles':
                $this->load->model('Control_model');
                $datos = $this->Control_model->get_all_controles();
                break;
            default:
                $this->load->model('Atencion_model');
                $datos = $this->Atencion_model->get_all_atenciones();
        }
        
        echo json_encode([
            'success' => true,
            'data' => $datos
        ]);
    }

    public function crear_emergencia() {
        $data['titulo'] = 'Nueva Atención de Urgencia';
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/emergencias/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function guardar_emergencia() {
        if ($this->input->post()) {
            // Cargar el modelo si no está cargado
            $this->load->model('Emergencia_model');
            
            // Preparar los datos para la inserción
            $datos = array(
                'mascota_id' => $this->input->post('id_mascota'),
                'fecha_registro' => date('Y-m-d H:i:s'),
                'nivel_urgencia' => $this->input->post('nivel_urgencia'),
                'motivo_consulta' => $this->input->post('motivo_consulta'),
                'anamnesis' => $this->input->post('anamnesis'),
                'diagnostico' => $this->input->post('diagnostico'),
                'tratamiento' => $this->input->post('tratamiento'),
                'indicaciones' => $this->input->post('indicaciones'),
                'observaciones' => $this->input->post('observaciones'),
                'estado' => 'pendiente'
            );

            
            if ($this->Emergencia_model->crear($datos)) {
                $this->session->set_flashdata('success', 'Emergencia registrada correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al registrar la emergencia');
            }
            
            redirect('recepcionista/emergencias');
        }
    }

    public function ver_emergencia($id) {
        
        $this->load->model('Emergencia_model');
        

        $data['emergencia'] = $this->Emergencia_model->get_emergencia($id);
        
        if (!$data['emergencia']) {
            $this->session->set_flashdata('error', 'La emergencia no existe');
            redirect('recepcionista/emergencias');
        }
        
        $data['titulo'] = 'Detalle de Atención de Urgencia';
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/emergencias/ver', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function buscar_propietarios() {
        $q = $this->input->post('query');
        if (!$q) {
            $q = $this->input->post('rut');
        }
        $this->db->from('users');
        $this->db->group_start();
        $this->db->like('nombre', $q);
        $this->db->or_like('rut', $q);
        $this->db->group_end();
        $this->db->limit(10);
        $query = $this->db->get();
        echo json_encode($query->result());
    }

    public function buscar_mascotas() {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    
        $query = $this->input->post('query');
        $propietario_id = $this->input->post('propietario_id');
        
        // Cargar el modelo si aún no está cargado
        $this->load->model('Mascota_model');
        
        // Realizar la búsqueda
        $mascotas = $this->Mascota_model->buscar_mascotas($query, $propietario_id);
        
        // Devolver los resultados como JSON
        echo json_encode($mascotas);
    }

    public function buscar_propietario_nombre($nombre) {
        $usuarios = $this->User_model->buscar_por_nombre($nombre);
        
        echo json_encode([
            'success' => true,
            'usuarios' => array_map(function($usuario) {
                return [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'rut' => $usuario->rut
                ];
            }, $usuarios)
        ]);
    }

    public function buscar_veterinarios() {
        $term = $this->input->get('term');
        $this->load->model('User_model');
        $veterinarios = $this->User_model->buscar_usuarios_por_rol_y_nombre('veterinario', $term);
        
        $results = array();
        foreach ($veterinarios as $veterinario) {
            $results[] = array(
                'id' => $veterinario->id,
                'label' => $veterinario->nombre . ' ' . $veterinario->apellido . ' (Veterinario)',
                'value' => $veterinario->nombre . ' ' . $veterinario->apellido
            );
        }
        
        echo json_encode($results);
    }

    public function guardar_autorizacion_eutanasia() {
        if ($this->input->post()) {
            // Obtener el ID de la mascota
            $mascota_id = $this->input->post('mascota_id');
            
            // Obtener la información de la mascota
            $mascota = $this->Mascota_model->get_mascota($mascota_id);
            if (!$mascota) {
                $this->session->set_flashdata('error', 'La mascota seleccionada no existe');
                redirect('recepcionista/eutanasia_crear');
                return;
            }
            
            $datos = array(
                'mascota_id' => $mascota_id,
                'usuario_id' => $mascota->usuario_id,
                'veterinario_tratante' => $this->input->post('veterinario_tratante'),
                'motivo' => $this->input->post('motivo'),  // Agregar esta línea
                'fecha' => date('Y-m-d H:i:s')
            );
            
            if ($this->Autorizacion_model->crear_autorizacion_eutanasia($datos)) {
                $this->session->set_flashdata('success', 'Autorización de eutanasia registrada correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al registrar la autorización de eutanasia');
            }
            
            redirect('recepcionista/autorizaciones');
        }
    }

    public function crear_autorizacion_cirugia($mascota_id) {
        $data['titulo'] = 'Nueva Autorización de Cirugía';
        $data['mascota'] = $this->Mascota_model->get_mascota($mascota_id);
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario');
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/cirugia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function guardar_autorizacion_cirugia() {
        if ($this->input->post()) {
            // Obtener el ID de la mascota
            $mascota_id = $this->input->post('mascota_id');
            
            // Obtener la información de la mascota
            $mascota = $this->Mascota_model->get_mascota($mascota_id);
            if (!$mascota) {
                $this->session->set_flashdata('error', 'La mascota seleccionada no existe');
                redirect('recepcionista/cirugia_crear');
                return;
            }
            
            $datos = array(
                'mascota_id' => $mascota_id,
                'fecha' => date('Y-m-d H:i:s'),
                'veterinario_tratante' => $this->input->post('veterinario_tratante'),
                'usuario_id' => $mascota->usuario_id  // Usar el ID del propietario de la mascota
            );
            
            if ($this->Autorizacion_model->crear_autorizacion_cirugia($datos)) {
                $this->session->set_flashdata('success', 'Autorización de cirugía registrada correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al registrar la autorización');
            }
        }
        redirect('recepcionista/autorizaciones');
    }

    public function crear_autorizacion_sedacion($mascota_id) {
        $data['titulo'] = 'Nueva Autorización de Sedación';
        $data['mascota'] = $this->Mascota_model->get_mascota($mascota_id);
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario');
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/sedacion/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function crear_autorizacion_eutanasia($mascota_id) {
        $data['titulo'] = 'Nueva Autorización de Eutanasia';
        $data['mascota'] = $this->Mascota_model->get_mascota($mascota_id);
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario');
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/autorizaciones/eutanasia/crear', $data);
        $this->load->view('recepcionista/templates/footer');
    }

    public function guardar_autorizacion_sedacion() {
        if ($this->input->post()) {
            // Obtener el ID de la mascota
            $mascota_id = $this->input->post('mascota_id');
            
            // Obtener la información de la mascota
            $mascota = $this->Mascota_model->get_mascota($mascota_id);
            if (!$mascota) {
                $this->session->set_flashdata('error', 'La mascota seleccionada no existe');
                redirect('recepcionista/sedacion_crear');
                return;
            }
            
            $datos = array(
                'mascota_id' => $mascota_id,
                'usuario_id' => $mascota->usuario_id,
                'veterinario_tratante' => $this->input->post('veterinario_tratante'),
                'emergencia' => $this->input->post('emergencia'),
                'fecha' => date('Y-m-d H:i:s')
            );
            
            if ($this->Autorizacion_model->crear_autorizacion_sedacion($datos)) {
                $this->session->set_flashdata('success', 'Autorización de sedación registrada correctamente');
            } else {
                $this->session->set_flashdata('error', 'Error al registrar la autorización de sedación');
            }
            
            redirect('recepcionista/autorizaciones');
        }
    }

    public function sedaciones() {
        $data['titulo'] = 'Autorizaciones de Sedación';
        
        // Cargar el modelo de autorizaciones
        $this->load->model('Autorizacion_model');
        
        // Obtener todas las sedaciones con detalles
        $data['sedaciones'] = $this->Autorizacion_model->obtener_sedaciones_con_detalles();
        
        // Cargar las vistas
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/atenciones/sedaciones', $data);
        $this->load->view('recepcionista/templates/footer');
    }
    public function cirugias() {
        $this->load->model('Autorizacion_model');
        
        $data['titulo'] = 'Historial de Cirugías';
        $data['cirugias'] = $this->Autorizacion_model->obtener_cirugias_con_detalles();
        
        $this->load->view('recepcionista/templates/header', $data);
        $this->load->view('recepcionista/templates/navbar');
        $this->load->view('recepcionista/atenciones/cirugias', $data);
        $this->load->view('recepcionista/templates/footer');
    }
    
    

    public function verificar_rut() {
        if ($this->input->is_ajax_request()) {
            $rut = $this->input->post('rut');
            $exists = $this->User_model->verificar_rut_existe($rut);
            $response = array('exists' => $exists);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function verificar_email() {
        if ($this->input->is_ajax_request()) {
            $email = $this->input->post('email');
            $exists = $this->User_model->verificar_email_existe($email);
            $response = array('exists' => $exists);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

}

