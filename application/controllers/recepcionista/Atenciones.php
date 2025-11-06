<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atenciones extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cargar los modelos necesarios
        $this->load->model('Autorizacion_model');
    }

    public function eutanasias() {
        $data['titulo'] = 'Eutanasias';
        $data['autorizaciones'] = $this->Autorizacion_model->obtener_eutanasias();
        
        // Cargar la vista
        $this->load->view('recepcionista/atenciones/eutanasias', $data);
    }
}