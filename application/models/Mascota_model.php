<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mascota_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function buscar_mascotas($query) {
        $this->db->select('mascotas.id, mascotas.nombre, mascotas.especie, mascotas.raza, 
                           mascotas.edad_aproximada, mascotas.sexo, mascotas.color, mascotas.peso,
                           users.nombre as nombre_propietario, users.rut as rut_propietario,
                           users.telefono as telefono_propietario, users.direccion as direccion_propietario');
        $this->db->from('mascotas');
        $this->db->join('users', 'users.id = mascotas.usuario_id', 'left');
        $this->db->group_start()
            ->like('mascotas.nombre', $query)
            ->or_like('mascotas.especie', $query)
            ->or_like('mascotas.raza', $query)
        ->group_end();
        $this->db->limit(5);
        return $this->db->get()->result_array();
    }

    public function get_all_mascotas() {
        $this->db->select('mascotas.*, users.nombre as nombre_propietario');
        $this->db->from('mascotas');
        $this->db->join('users', 'users.id = mascotas.usuario_id', 'left');
        return $this->db->get()->result();
    }

    public function count_mascotas() {
        return $this->db->count_all('mascotas');
    }

    public function get_mascota($id) {
        $this->db->select('mascotas.*, users.nombre as nombre_propietario');
        $this->db->from('mascotas');
        $this->db->join('users', 'users.id = mascotas.usuario_id', 'left');
        $this->db->where('mascotas.id', $id);
        return $this->db->get()->row();
    }

    public function get_mascotas_para_vacunas() {
        $this->db->select('mascotas.*, CONCAT(users.nombre, " - RUT: ", users.rut) as propietario');
        $this->db->from('mascotas');
        $this->db->join('users', 'users.id = mascotas.usuario_id', 'left');
        $this->db->order_by('mascotas.nombre', 'ASC');
        return $this->db->get()->result();
    }

    public function crear_mascota($datos) {
        return $this->db->insert('mascotas', $datos);
    }

    public function actualizar_mascota($id, $datos) {
        $this->db->where('id', $id);
        return $this->db->update('mascotas', $datos);
    }

    public function get_mascotas_by_usuario($usuario_id) {
        $this->db->select('mascotas.*, users.nombre as nombre_propietario');
        $this->db->from('mascotas');
        $this->db->join('users', 'users.id = mascotas.usuario_id', 'left');
        $this->db->where('mascotas.usuario_id', $usuario_id);
        return $this->db->get()->result();
    }
}
