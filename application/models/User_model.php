<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
 
    public function login($rut, $password) {
        $this->db->where('rut', $rut);
        $query = $this->db->get('users');
        
        if($query->num_rows() == 0) {
            return 'rut_invalido';
        }
        
        $user = $query->row();
        
        if(password_verify($password, $user->password)) {
            return $user;
        } else {
            return 'password_invalido';
        }
    }
    
    /**
     * Cuenta el número total de usuarios en el sistema
     * 
     * @return int Número total de usuarios
     */
    // Añade este método si no existe
    public function count_users() {
        return $this->db->count_all('users');
    }

    public function get_all_users() {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function buscar_por_nombre($nombre) {
        $this->db->like('nombre', $nombre);
        $this->db->limit(10); // Limitar resultados para mejor rendimiento
        return $this->db->get('users')->result();
    }

    public function buscar_usuarios_por_rol_y_nombre($rol, $nombre) {
        $this->db->where('role', $rol);
        $this->db->group_start();
        $this->db->like('nombre', $nombre);
        $this->db->or_like('apellido', $nombre);
        $this->db->group_end();
        $this->db->limit(10); // Limitar resultados para mejor rendimiento
        return $this->db->get('users')->result();
    }

    public function crear($datos) {
        // Eliminar confirm_password si existe en el array
        if (isset($datos['confirm_password'])) {
            unset($datos['confirm_password']);
        }
        
        // Asignar rol por defecto si no se especifica
        if (!isset($datos['role']) || empty($datos['role'])) {
            $datos['role'] = 'usuario';
        }
        
        // Encriptar la contraseña antes de guardarla
        $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        
        // Insertar en la base de datos
        return $this->db->insert('users', $datos);
    }

    public function actualizar($id, $datos) {
        // Verificar si el usuario existe
        $usuario_existe = $this->get_user_by_id($id);
        if (!$usuario_existe) {
            return false;
        }
        
        // Verificar si el email ya existe para otro usuario
        if (isset($datos['email'])) {
            $this->db->where('email', $datos['email']);
            $this->db->where('id !=', $id);
            $email_existe = $this->db->get('users')->num_rows() > 0;
            
            if ($email_existe) {
                return false;
            }
        }
        
        // Encriptar la contraseña si se proporciona
        if(isset($datos['password']) && !empty($datos['password'])) {
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
        } else if(isset($datos['password']) && empty($datos['password'])) {
            // Si la contraseña está vacía, no la actualizamos
            unset($datos['password']);
        }
        
        $this->db->where('id', $id);
        return $this->db->update('users', $datos);
    }

    public function actualizar_usuario($id, $datos) {
        return $this->actualizar($id, $datos);
    }

    public function eliminar_usuario($id) {
        // Verificar si el usuario existe
        $usuario_existe = $this->get_user_by_id($id);
        if (!$usuario_existe) {
            return false;
        }
        
        // Verificar si hay registros relacionados en otras tablas
        // Por ejemplo, si hay actividades asociadas a este usuario
        // Nota: En la tabla actividades, el campo es 'usuario', no 'usuario_id'
        $usuario_nombre = $usuario_existe->nombre;
        $this->db->where('usuario', $usuario_nombre);
        $registros_relacionados = $this->db->get('actividades')->num_rows() > 0;
        
        if ($registros_relacionados) {
            // Opción 1: Actualizar el estado del usuario en lugar de eliminarlo
            $this->db->where('id', $id);
            return $this->db->update('users', ['estado' => 'inactivo']);
            
            // Opción 2: Eliminar registros relacionados primero (descomentar si es necesario)
            // $this->db->where('usuario_id', $id);
            // $this->db->delete('actividades');
        }
        
        // Eliminar el usuario
        return $this->db->where('id', $id)->delete('users');
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function get_users_by_role($role) {
        $this->db->where('role', $role);
        $query = $this->db->get('users');
        return $query->result();
    }
    
    // Añadir este método para resolver el error
    public function get_user($id) {
        return $this->get_user_by_id($id);
    }
    
    public function get_by_rut($rut) {
        return $this->db->where('rut', $rut)->get('users')->row();
    }

    public function get_by_email($email) {
        return $this->db->where('email', $email)->get('users')->row();
    }
    
    public function get_propietarios() {
        $this->db->select('id, nombre');
        $this->db->from('users');
        $this->db->where('role', 'propietario');
        return $this->db->get()->result();
    }
    public function buscar_veterinarios_activos($term) {
        $this->db->where('role', 'veterinario');
        $this->db->where('estado', 'activo');
        $this->db->group_start();
        $this->db->like('nombre', $term);
        $this->db->or_like('apellido', $term);
        $this->db->group_end();
        $this->db->limit(10);
        return $this->db->get('users')->result();
    }
    public function verificar_email_existe($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}