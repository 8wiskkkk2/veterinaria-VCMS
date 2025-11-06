<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Veterinario extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_role(['veterinario', 'recepcionista']);
        // Load required models
        $this->load->model('Emergencia_model');
        $this->load->model('Mascota_model');
        $this->load->model('Propietario_model');
        $this->load->model('User_model');

        $this->load->model('Desparacitacion_model');
    }

    public function index()
    {
        // Cargar el modelo de emergencias
        $this->load->model('Emergencia_model');
        
        // Obtener las emergencias pendientes
        $data['emergencias'] = $this->Emergencia_model->get_emergencias_pendientes();
        
        // Cargar la vista del dashboard con los datos
        $this->load->view('veterinario/templates/header');
        $this->load->view('veterinario/dashboard/index', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function atenciones() {
        $data['titulo'] = 'Atenciones';
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/atenciones/index');
        $this->load->view('veterinario/templates/footer');
    }

    public function atenciones_urgencias() {
        $data['titulo'] = 'Atenciones de Urgencia';
        
        // Cargar el modelo de emergencias
        $this->load->model('Emergencia_model');
        
        // Usar el método correcto del modelo
        $data['emergencias'] = $this->Emergencia_model->get_all_emergencias_completo();
        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/atenciones/urgencias', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function get_urgencias_pendientes_veterinario() {
        $this->load->model('Emergencia_model');
        $count = $this->Emergencia_model->contar_urgencias_pendientes();
        echo json_encode(['count' => $count]);
    }

    public function get_total_mascotas_veterinario() {
        $this->load->model('Mascota_model');
        $total = $this->Mascota_model->get_total_mascotas();
        echo json_encode(['count' => $total]);
    }

    public function get_urgencias_tabla_veterinario() {
        $this->load->model('Emergencia_model');
        $urgencias = $this->Emergencia_model->get_urgencias_pendientes_con_detalles();
        echo json_encode(['data' => $urgencias]);
    }

    public function sedaciones() {
        $data['titulo'] = 'Autorizaciones de Sedación';
        
        // Cargar el modelo de autorizaciones
        $this->load->model('Autorizacion_model');
        
        // Obtener todas las sedaciones con detalles
        $data['sedaciones'] = $this->Autorizacion_model->obtener_sedaciones_con_detalles();
        

        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/atenciones/sedaciones', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function cirugias() {
        $this->load->model('Autorizacion_model');
        
        $data['titulo'] = 'Historial de Cirugías';
        $data['cirugias'] = $this->Autorizacion_model->obtener_cirugias_con_detalles();
        

        
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/atenciones/cirugias', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function atenciones_eutanasias() {
        $data['titulo'] = 'Historial de Eutanasias';
        
        $this->load->model('Autorizacion_model');
        
        $data['autorizaciones'] = $this->Autorizacion_model->obtener_eutanasias_con_detalles();
        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/atenciones/eutanasias', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function ver_emergencia($id) {
        $this->load->model('Emergencia_model');
        
        $data['emergencia'] = $this->Emergencia_model->get_emergencia($id);
        
        if (!$data['emergencia']) {
            $this->session->set_flashdata('error', 'La emergencia no existe');
            redirect('veterinario/emergencias');
        }
        
        $data['titulo'] = 'Detalle de Atención de Urgencia';
        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/emergencias/ver', $data);
        $this->load->view('veterinario/templates/footer');
    }
    
    public function emergencias() {
        $data['titulo'] = 'Atenciones de Urgencia';
        
        // Cargar el modelo de emergencias
        $this->load->model('Emergencia_model');
        
        // Obtener las emergencias pendientes
        $data['emergencias'] = $this->Emergencia_model->get_urgencias_pendientes_con_detalles();
        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/emergencias/index', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function cambiar_estado_emergencia($id) {
        $this->load->model('Emergencia_model');
        
        $emergencia = $this->Emergencia_model->get_emergencia($id);
        if (!$emergencia) {
            $this->session->set_flashdata('error', 'La emergencia no existe');
            redirect('veterinario/emergencias');
        }
        
        $nuevo_estado = ($emergencia->estado == 'pendiente') ? 'atendido' : 'pendiente';
        
        if ($this->Emergencia_model->actualizar_estado($id, $nuevo_estado)) {

            $this->session->set_flashdata('success', 'Estado actualizado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar el estado');
        }
        
        redirect('veterinario/emergencias');
    }
    
    public function buscar_mascotas() {
        $this->load->model('Mascota_model');
        $query = $this->input->post('query');
        
        $mascotas = $this->Mascota_model->buscar_mascotas($query);
        echo json_encode($mascotas);
    }

    public function buscar_veterinarios() {
        $this->load->model('User_model');
        $term = $this->input->post('term');
        
        $veterinarios = $this->User_model->buscar_veterinarios_activos($term);
        echo json_encode($veterinarios);
    }

    public function mascotas() {
        $data['titulo'] = 'Mascotas';
        
        // Cargar el modelo de mascotas
        $this->load->model('Mascota_model');
        
        // Obtener todas las mascotas
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        
        // Cargar las vistas
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/mascotas/index', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function editar_mascota($id = null) {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID de mascota no proporcionado');
            redirect('veterinario/mascotas');
        }

        $this->load->model('Mascota_model');

        $data['mascota'] = $this->Mascota_model->get_mascota($id);
        if (!$data['mascota']) {
            $this->session->set_flashdata('error', 'Mascota no encontrada');
            redirect('veterinario/mascotas');
        }

        if ($this->input->post()) {
            $datos_actualizacion = array(
                'nombre' => $this->input->post('nombre'),
                'especie' => $this->input->post('especie'),
                'raza' => $this->input->post('raza'),
                'color' => $this->input->post('color'),
                'edad_aproximada' => $this->input->post('edad_aproximada'),
                'peso' => $this->input->post('peso'),
                'alergias_conocidas' => $this->input->post('alergias_conocidas'),
                'estado_reproductivo' => $this->input->post('estado_reproductivo')
            );

            if ($this->Mascota_model->actualizar_mascota($id, $datos_actualizacion)) {
                $this->session->set_flashdata('success', 'Mascota actualizada correctamente');
                redirect('veterinario/mascotas');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar la mascota');
            }
        }

        $data['titulo'] = 'Editar Mascota';
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/mascotas/editar', $data);
        $this->load->view('veterinario/templates/footer');
    }
    public function get_veterinarios() {
        $this->load->model('User_model');
        $veterinarios = $this->User_model->get_users_by_role('veterinario');
        echo json_encode($veterinarios);
    }
    
    public function vacunas() {
        $this->load->model('Vacuna_model');
        
        $data['titulo'] = 'Gestión de Vacunas';
        $data['vacunas'] = $this->Vacuna_model->get_all_vacunas();
        
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/vacunas/index', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function vacunas_crear() {
        $data['titulo'] = 'Nueva Vacuna';
        $data['mascotas'] = $this->Mascota_model->get_mascotas_para_vacunas();
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario');
        // Asegurar tabla de tipos de vacunas y semillas
        $this->load->model('VacunaTipo_model');
        $this->VacunaTipo_model->ensure_table_and_seed();
        
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/vacunas/crear', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function vacunas_guardar() {
        $this->load->model('Vacuna_model');
        $this->load->model('VacunaTipo_model');
        $this->load->model('Mascota_model');
        
        $data = array(
            'mascota_id' => $this->input->post('mascota_id'),
            'tipo_vacuna' => $this->input->post('tipo_vacuna'),
            'fecha' => $this->input->post('fecha_vacuna'),
            'proxima_dosis' => $this->input->post('proxima_vacuna'),
            'veterinario_id' => $this->input->post('veterinario_id'),
            'peso' => $this->input->post('peso')
    
        );

        // Obtener especie de la mascota seleccionada
        $mascota = null;
        if (!empty($data['mascota_id'])) {
            $mascota = $this->Mascota_model->get_mascota($data['mascota_id']);
        }
        $especieMascota = $mascota ? strtolower($mascota->especie) : null;

        // Si el tipo no existe para esa especie en catálogo, agregarlo (sin intervalo por defecto)
        $tipo = $this->VacunaTipo_model->get_by_nombre_especie($data['tipo_vacuna'], $especieMascota);
        if (!$tipo) {
            $this->VacunaTipo_model->insert_tipo($data['tipo_vacuna'], null, $especieMascota);
        }
        
        if($this->Vacuna_model->insert($data)) {
            $this->session->set_flashdata('success', 'Vacuna registrada correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar la vacuna');
        }
        
        redirect('veterinario/vacunas');
    }

    // Buscar tipos de vacuna para autocomplete
    public function buscar_tipos_vacuna() {
        $this->load->model('VacunaTipo_model');
        $this->VacunaTipo_model->ensure_table_and_seed();
        $term = $this->input->get_post('term');
        $especie = $this->input->get_post('especie');
        // Compatibilidad PHP 5.6
        $term = $term ? $term : '';
        $especie = $especie ? strtolower($especie) : null;
        $tipos = $this->VacunaTipo_model->search($term, $especie);
        $result = [];
        foreach ($tipos as $t) {
            $result[] = [
                'label' => $t->nombre,
                'value' => $t->nombre,
                'dias_intervalo' => $t->dias_intervalo
            ];
        }
        echo json_encode($result);
    }

    // Obtener intervalo en días para un nombre de vacuna
    public function vacuna_intervalo() {
        $this->load->model('VacunaTipo_model');
        $nombre = $this->input->get_post('nombre');
        $especie = $this->input->get_post('especie');
        $especie = $especie ? strtolower($especie) : null;
        $tipo = $this->VacunaTipo_model->get_by_nombre_especie($nombre, $especie);
        $dias = $tipo ? $tipo->dias_intervalo : null;
        echo json_encode(['dias_intervalo' => $dias]);
    }
    
    public function completar_emergencia($id) {
        // Load required models if not already loaded in constructor
        $this->load->model('Emergencia_model');
        $this->load->model('Mascota_model');
        $this->load->model('Propietario_model');
    
        $emergencia = $this->Emergencia_model->get_emergencia($id);
        if (!$emergencia) {
            show_404();
            return;
        }
    
        if ($this->input->post()) {
            $datos_actualizacion = array(
                'anamnesis' => $this->input->post('anamnesis'),
                'diagnostico' => $this->input->post('diagnostico'),
                'tratamiento' => $this->input->post('tratamiento'),
                'indicaciones' => $this->input->post('indicaciones'),
                'observaciones' => $this->input->post('observaciones')
            );
    
            if ($this->Emergencia_model->actualizar_datos($id, $datos_actualizacion)) {
                $this->session->set_flashdata('success', 'Datos de la emergencia actualizados correctamente');
                redirect('veterinario/emergencias');
            } else {
                $this->session->set_flashdata('error', 'Error al actualizar los datos de la emergencia');
            }
        }
    
        $mascota = $this->Mascota_model->get_mascota($emergencia->mascota_id);
        if (!$mascota) {
            show_404();
            return;
        }
    
        $propietario = $this->Propietario_model->get_propietario($mascota->usuario_id);
    
        $data = array(
            'emergencia' => $emergencia,
            'mascota' => $mascota,
            'propietario' => $propietario,
            'titulo' => 'Completar Datos de Emergencia'
        );
    
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/emergencias/completar', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function desparacitaciones() {
        $data['titulo'] = 'Gestión de Desparasitaciones';
        $data['desparacitaciones'] = $this->Desparacitacion_model->get_all_desparacitaciones();
        
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/desparacitaciones/index', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function crear_desparacitacion() {
        $data['titulo'] = 'Nueva Desparasitación';
        $data['mascotas'] = $this->Mascota_model->get_all_mascotas();
        $data['veterinarios'] = $this->User_model->get_users_by_role('veterinario');
        // Asegurar catálogo de tratamientos
        $this->load->model('DesparacitacionTipo_model');
        $this->DesparacitacionTipo_model->ensure_table_and_seed();
        
        $this->load->view('veterinario/templates/header', $data);
        $this->load->view('veterinario/templates/navbar');
        $this->load->view('veterinario/desparacitaciones/crear', $data);
        $this->load->view('veterinario/templates/footer');
    }

    public function guardar_desparacitacion() {
        $data = array(
            'mascota_id' => $this->input->post('mascota_id'),
            'fecha' => $this->input->post('fecha'),
            'tratamiento' => $this->input->post('tratamiento'),
            'proximo_tratamiento' => $this->input->post('proximo_tratamiento'),
            'veterinario_id' => $this->input->post('veterinario_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'peso' => $this->input->post('peso')
        );

        if($this->Desparacitacion_model->insert($data)) {

            $this->session->set_flashdata('success', 'Desparasitación registrada correctamente');
            redirect('veterinario/desparacitaciones');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar la desparasitación');
            redirect('veterinario/desparacitaciones/crear');
        }
    }

    public function buscar_tipos_desparacitacion() {
        $term = $this->input->get('term');
        $especie = $this->input->get('especie');
        $this->load->model('DesparacitacionTipo_model');
        $tipos = $this->DesparacitacionTipo_model->search($term, $especie);
        $result = array();
        foreach ($tipos as $tipo) {
            $result[] = array(
                'label' => $tipo->nombre,
                'value' => $tipo->nombre,
                'dias_intervalo' => (int)$tipo->dias_intervalo
            );
        }
        echo json_encode($result);
    }
}

