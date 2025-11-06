<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atencion_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_all_atenciones() {
        $this->db->select('atenciones.*, mascotas.nombre as nombre_mascota, usuarios.nombre as nombre_propietario');
        $this->db->from('atenciones');
        $this->db->join('mascotas', 'mascotas.id = atenciones.mascota_id', 'left');
        $this->db->join('usuarios', 'usuarios.id = mascotas.propietario_id', 'left');
        $this->db->order_by('atenciones.fecha', 'DESC');
        return $this->db->get()->result();
    }

    public function get_atencion($id) {
        $this->db->select('atenciones.*, mascotas.nombre as nombre_mascota, usuarios.nombre as nombre_propietario');
        $this->db->from('atenciones');
        $this->db->join('mascotas', 'mascotas.id = atenciones.mascota_id', 'left');
        $this->db->join('usuarios', 'usuarios.id = mascotas.propietario_id', 'left');
        $this->db->where('atenciones.id', $id);
        return $this->db->get()->row();
    }
}