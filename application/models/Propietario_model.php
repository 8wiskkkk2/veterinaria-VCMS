<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propietario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function buscar_propietarios($query) {
        $this->db->select('id, nombre, rut, telefono, direccion, email');
        $this->db->from('users');
        $this->db->group_start()
            ->like('nombre', $query)
            ->or_like('rut', $query)
        ->group_end();
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function get_propietario($id)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.id', $id);
        $this->db->where('users.role', 'propietario');
        return $this->db->get()->row();
    }
}