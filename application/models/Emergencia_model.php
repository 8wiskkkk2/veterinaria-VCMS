<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emergencia_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function crear($datos) {
        if (!isset($datos['nivel_urgencia'])) {
            $datos['nivel_urgencia'] = 'media'; 
        }
        
        if (!isset($datos['estado'])) {
            $datos['estado'] = 'pendiente';
        }
        
        return $this->db->insert('emergencias', $datos);
    }

    public function get_all_with_mascotas()
    {
        $this->db->select('emergencias.*, mascotas.especie');
        $this->db->from('emergencias');
        $this->db->join('mascotas', 'mascotas.id = emergencias.mascota_id', 'left');
        return $this->db->get()->result();
    }

    public function get_all_emergencias_completo() {
        $this->db->select('emergencias.*, mascotas.nombre as nombre_mascota, mascotas.especie');
        $this->db->from('emergencias');
        $this->db->join('mascotas', 'mascotas.id = emergencias.mascota_id');
        $this->db->order_by('FIELD(nivel_urgencia, "alta", "media", "baja")', false);
        $this->db->order_by('fecha_registro', 'DESC');
        return $this->db->get()->result();
    }

    public function get_emergencia($id)
    {
        $this->db->select('emergencias.*, mascotas.nombre as nombre_mascota, mascotas.especie as especie_mascota');
        $this->db->from('emergencias');
        $this->db->join('mascotas', 'mascotas.id = emergencias.mascota_id', 'left');
        $this->db->where('emergencias.id', $id);
        return $this->db->get()->row();
    }

    public function get_emergencias_pendientes()
    {
        $this->db->where('estado', 'pendiente');
        return $this->db->get('emergencias')->result();
    }

    public function get_urgencias_pendientes_con_detalles() {
        $this->db->select('emergencias.*, mascotas.nombre as nombre_mascota, mascotas.especie, users.nombre as nombre_propietario');
        $this->db->from('emergencias');
        $this->db->join('mascotas', 'mascotas.id = emergencias.mascota_id');
        $this->db->join('users', 'users.id = mascotas.usuario_id');
        $this->db->where('emergencias.estado', 'pendiente');
        $this->db->order_by('FIELD(nivel_urgencia, "alta", "media", "baja")', FALSE);
        return $this->db->get()->result();
    }

    public function contar_urgencias_pendientes() {
        $this->db->where('estado', 'pendiente');
        return $this->db->count_all_results('emergencias');
    }

    public function actualizar_estado($id, $estado) {
        return $this->db->update('emergencias', ['estado' => $estado], ['id' => $id]);
    }

    public function actualizar_datos($id, $datos) {
        return $this->db->update('emergencias', $datos, ['id' => $id]);
    }

    public function get_emergencias_historial($mascotas_ids) {
        $this->db->select('e.*, m.nombre as nombre_mascota');
        $this->db->from('emergencias e');
        $this->db->join('mascotas m', 'm.id = e.mascota_id');
        $this->db->where_in('e.mascota_id', $mascotas_ids);
        $this->db->where('e.estado', 'atendido');
        $this->db->order_by('e.fecha_registro', 'DESC');
        return $this->db->get()->result();
    }
}