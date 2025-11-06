<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autorizacion_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db->select('autorizaciones_eutanasia.*, mascotas.nombre as nombre_mascota, 
            users.nombre as nombre_propietario, vet.nombre as nombre_veterinario, "eutanasia" as tipo');
        $this->db->from('autorizaciones_eutanasia');
        $this->db->join('mascotas', 'mascotas.id = autorizaciones_eutanasia.mascota_id');
        $this->db->join('users', 'users.id = autorizaciones_eutanasia.usuario_id');
        $this->db->join('users as vet', 'vet.id = autorizaciones_eutanasia.veterinario_tratante', 'left');
        $eutanasia = $this->db->get()->result();
    
        // Obtener autorizaciones de cirugía
        $this->db->select('autorizaciones_cirugia.*, mascotas.nombre as nombre_mascota, 
            users.nombre as nombre_propietario, vet.nombre as nombre_veterinario, "cirugia" as tipo');
        $this->db->from('autorizaciones_cirugia');
        $this->db->join('mascotas', 'mascotas.id = autorizaciones_cirugia.mascota_id');
        $this->db->join('users', 'users.id = autorizaciones_cirugia.usuario_id');
        $this->db->join('users as vet', 'vet.id = autorizaciones_cirugia.veterinario_tratante', 'left');
        $cirugia = $this->db->get()->result();
    
        // Obtener autorizaciones de sedación
        $this->db->select('autorizaciones_sedacion.*, mascotas.nombre as nombre_mascota, 
            users.nombre as nombre_propietario, vet.nombre as nombre_veterinario, "sedacion" as tipo');
        $this->db->from('autorizaciones_sedacion');
        $this->db->join('mascotas', 'mascotas.id = autorizaciones_sedacion.mascota_id');
        $this->db->join('users', 'users.id = autorizaciones_sedacion.usuario_id');
        $this->db->join('users as vet', 'vet.id = autorizaciones_sedacion.veterinario_tratante', 'left');
        $sedacion = $this->db->get()->result();
    
        return array_merge($eutanasia, $cirugia, $sedacion);
    }

    public function crear_autorizacion_eutanasia($datos) {
        return $this->db->insert('autorizaciones_eutanasia', $datos);
    }

    public function crear_autorizacion_cirugia($datos) {
        return $this->db->insert('autorizaciones_cirugia', $datos);
    }

    public function crear_autorizacion_sedacion($datos) {
        return $this->db->insert('autorizaciones_sedacion', $datos);
    }

    public function get_eutanasias() {
        $this->db->select('autorizaciones_eutanasia.*, mascotas.nombre as nombre_mascota, users.nombre as nombre_propietario');
        $this->db->from('autorizaciones_eutanasia');
        $this->db->join('mascotas', 'mascotas.id = autorizaciones_eutanasia.mascota_id');
        $this->db->join('users', 'users.id = autorizaciones_eutanasia.usuario_id');
        return $this->db->get()->result();
    }

    public function obtener_cirugias_con_detalles() {
        $this->db->select('ac.*, m.nombre as nombre_mascota, m.especie, u.nombre as nombre_propietario, vet.nombre as nombre_veterinario');
        $this->db->from('autorizaciones_cirugia ac');
        $this->db->join('mascotas m', 'm.id = ac.mascota_id');
        $this->db->join('users u', 'u.id = ac.usuario_id');
        $this->db->join('users as vet', 'vet.id = ac.veterinario_tratante', 'left');
        $this->db->order_by('ac.fecha', 'DESC');
        return $this->db->get()->result();
    }

    public function obtener_eutanasias_con_detalles() {
        $this->db->select('ae.*, m.nombre as nombre_mascota, u.nombre as nombre_propietario, vet.nombre as nombre_veterinario');
        $this->db->from('autorizaciones_eutanasia ae');
        $this->db->join('mascotas m', 'm.id = ae.mascota_id');
        $this->db->join('users u', 'u.id = ae.usuario_id');
        $this->db->join('users as vet', 'vet.id = ae.veterinario_tratante', 'left');
        $this->db->order_by('ae.fecha', 'DESC');
        return $this->db->get()->result();
    }

    public function obtener_sedaciones_con_detalles() {
        $this->db->select('autorizaciones_sedacion.*, mascotas.nombre as nombre_mascota, 
            users.nombre as nombre_propietario, vet.nombre as nombre_veterinario');
        $this->db->from('autorizaciones_sedacion');
        $this->db->join('mascotas', 'mascotas.id = autorizaciones_sedacion.mascota_id');
        $this->db->join('users', 'users.id = mascotas.usuario_id');
        $this->db->join('users as vet', 'vet.id = autorizaciones_sedacion.veterinario_tratante', 'left');
        $this->db->order_by('autorizaciones_sedacion.fecha', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_autorizaciones_historial($usuario_id) {
        // Obtener autorizaciones de eutanasia
        $this->db->select('ae.*, m.nombre as nombre_mascota, "eutanasia" as tipo');
        $this->db->from('autorizaciones_eutanasia ae');
        $this->db->join('mascotas m', 'm.id = ae.mascota_id');
        $this->db->where('ae.usuario_id', $usuario_id);
        $eutanasia = $this->db->get()->result();
    
        // Obtener autorizaciones de cirugía
        $this->db->select('ac.*, m.nombre as nombre_mascota, "cirugia" as tipo');
        $this->db->from('autorizaciones_cirugia ac');
        $this->db->join('mascotas m', 'm.id = ac.mascota_id');
        $this->db->where('ac.usuario_id', $usuario_id);
        $cirugia = $this->db->get()->result();
    
        // Obtener autorizaciones de sedación
        $this->db->select('as.*, m.nombre as nombre_mascota, "sedacion" as tipo');
        $this->db->from('autorizaciones_sedacion as');
        $this->db->join('mascotas m', 'm.id = as.mascota_id');
        $this->db->where('as.usuario_id', $usuario_id);
        $sedacion = $this->db->get()->result();
    
        // Combinar todos los resultados
        return array_merge($eutanasia, $cirugia, $sedacion);
    }
}