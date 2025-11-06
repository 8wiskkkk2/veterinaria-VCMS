<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cita_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function contar_citas() {
        return $this->db->count_all('citas');
    }
    
    public function get_all_citas() {
        return $this->db->get('citas')->result();
    }
    
    public function get_cita_by_id($id) {
        return $this->db->get_where('citas', ['id' => $id])->row();
    }
    
    public function create_cita($data) {
        return $this->db->insert('citas', $data);
    }
    
    public function update_cita($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('citas', $data);
    }
    
    public function delete_cita($id) {
        $this->db->where('id', $id);
        return $this->db->delete('citas');
    }
}