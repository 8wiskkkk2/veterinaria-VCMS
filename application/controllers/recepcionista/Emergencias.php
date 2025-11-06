public function buscar_propietario() {
    $term = $this->input->get('term');
    $this->load->model('propietario_model');
    $propietarios = $this->propietario_model->buscar_propietarios($term);
    echo json_encode($propietarios);
}

public function buscar_mascotas() {
    $dni_propietario = $this->input->get('dni_propietario');
    $this->load->model('mascota_model');
    $mascotas = $this->mascota_model->obtener_mascotas_por_propietario($dni_propietario);
    echo json_encode($mascotas);
}

public function obtener_mascota() {
    $id = $this->input->get('id');
    $this->load->model('mascota_model');
    $mascota = $this->mascota_model->obtener_mascota($id);
    echo json_encode($mascota);
}

public function guardar() {
    if ($this->input->post()) {
        $datos = array(
            'mascota_id' => $this->input->post('id_mascota'),
            'fecha_registro' => date('Y-m-d H:i:s'),
            'nivel_urgencia' => $this->input->post('nivel_urgencia'),
            'motivo_consulta' => $this->input->post('motivo_consulta'),
            'diagnostico' => $this->input->post('diagnostico'),
            'tratamiento' => $this->input->post('tratamiento'),
            'indicaciones' => $this->input->post('indicaciones'),
            'observaciones' => $this->input->post('observaciones'),
            'estado' => 'pendiente'
        );

        $this->load->model('Emergencia_model');
        if ($this->Emergencia_model->crear($datos)) {
            $this->session->set_flashdata('success', 'Ingreso realizado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar la emergencia');
        }
        redirect('recepcionista/emergencias');
    }
}

public function index()
{
    // Cargar los modelos necesarios
    $this->load->model('Emergencia_model');
    $this->load->model('Mascota_model');
    
    // Obtener todas las emergencias con la información de las mascotas y especies
    $data['emergencias'] = $this->Emergencia_model->get_all_emergencias_completo();
    
    // Cargar la vista con los datos
    $data['titulo'] = 'Atenciones de Urgencia';
    $this->load->view('recepcionista/templates/header', $data);
    $this->load->view('recepcionista/emergencias/index', $data);
    $this->load->view('recepcionista/templates/footer');
}