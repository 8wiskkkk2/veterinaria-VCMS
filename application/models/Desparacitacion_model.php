<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desparacitacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_desparacitaciones() {
        $this->db->select('d.*, m.nombre as nombre_mascota, u.nombre as nombre_veterinario, p.nombre as nombre_propietario');
        $this->db->from('desparacitaciones d');
        $this->db->join('mascotas m', 'm.id = d.mascota_id');
        $this->db->join('users u', 'u.id = d.veterinario_id');
        $this->db->join('users p', 'p.id = m.usuario_id');
        $this->db->order_by('d.fecha', 'DESC');
        return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert('desparacitaciones', $data);
    }

    public function get_desparacitacion($id) {
        $this->db->where('id', $id);
        return $this->db->get('desparacitaciones')->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('desparacitaciones', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('desparacitaciones');
    }

    public function get_desparacitaciones_historial($mascotas_ids) {
        $this->db->select('d.*, m.nombre as nombre_mascota');
        $this->db->from('desparacitaciones d');
        $this->db->join('mascotas m', 'm.id = d.mascota_id');
        $this->db->where_in('d.mascota_id', $mascotas_ids);
        $this->db->order_by('d.fecha', 'DESC');
        return $this->db->get()->result();
    }
}