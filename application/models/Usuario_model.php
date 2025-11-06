<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function get_usuario($id) {
        $this->db->select('id, rut, nombre, email, telefono, direccion');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return false;
    }

    public function get_usuario_by_id($user_id) {
        $this->db->select('nombre, email, telefono, direccion');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        
        return $query->row();
    }

    public function actualizar($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    
    public function actualizar_usuario($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function crear($datos) {
        // Log de datos recibidos (excluyendo la contraseña por seguridad)
        $datos_log = $datos;
        unset($datos_log['password']);
        unset($datos_log['confirm_password']);
        log_message('debug', 'Datos recibidos para crear usuario: ' . print_r($datos_log, true));
        
        // Validar datos requeridos
        $campos_requeridos = ['rut', 'nombre', 'email', 'password'];
        foreach ($campos_requeridos as $campo) {
            if (!isset($datos[$campo]) || empty($datos[$campo])) {
                log_message('error', 'Campo requerido faltante: ' . $campo);
                return false;
            }
        }
        
        // Eliminar confirm_password si existe
        if (isset($datos['confirm_password'])) {
            unset($datos['confirm_password']);
        }
        
        // Encriptar la contraseña
        if (isset($datos['password'])) {
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        }
        
        // Asegurar que el rol sea 'usuario'
        $datos['role'] = 'usuario';
        
        try {
            // Intentar insertar el usuario
            $resultado = $this->db->insert('users', $datos);
            
            if ($resultado) {
                log_message('debug', 'Usuario creado exitosamente. ID: ' . $this->db->insert_id());
                return true;
            } else {
                log_message('error', 'Error al insertar usuario: ' . $this->db->error()['message']);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Excepción al crear usuario: ' . $e->getMessage());
            return false;
        }
    }

    public function verificar_rut_existe($rut) {
        $this->db->where('rut', $rut);
        $query = $this->db->get('users'); 
        return $query->num_rows() > 0;
    }
    
    public function get_usuarios_by_role($role) {
        $this->db->select('id, rut, nombre, email, telefono, direccion');
        $this->db->from('users');
        $this->db->where('role', $role);
        $query = $this->db->get();
        
        return $query->result();
    }
}