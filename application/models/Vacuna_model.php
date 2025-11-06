<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vacuna_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_vacunas() {
        $this->db->select('v.*, m.nombre as nombre_mascota, u.nombre as nombre_propietario, vet.nombre as nombre_veterinario');
        $this->db->from('vacunas v');
        $this->db->join('mascotas m', 'm.id = v.mascota_id');
        $this->db->join('users u', 'u.id = m.usuario_id');
        $this->db->join('users vet', 'vet.id = v.veterinario_id AND vet.role = "veterinario"');
        $this->db->order_by('v.fecha', 'DESC');
        return $this->db->get()->result();
    }
    
    public function insert($data) {
        return $this->db->insert('vacunas', $data);
    }
    
    public function get_vacunas_historial($mascotas_ids) {
        $this->db->select('v.*, m.nombre as nombre_mascota');
        $this->db->from('vacunas v');
        $this->db->join('mascotas m', 'm.id = v.mascota_id');
        $this->db->where_in('v.mascota_id', $mascotas_ids);
        $this->db->order_by('v.fecha', 'DESC');
        return $this->db->get()->result();
    }
}