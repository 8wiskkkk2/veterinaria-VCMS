<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function log_activity($user_id, $action, $description) {
        $data = array(
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description
        );
        return $this->db->insert('activity_log', $data);
    }
    
    public function get_recent_activities($limit = 10) {
        $this->db->select('activity_log.*, users.nombre as usuario');
        $this->db->from('activity_log');
        $this->db->join('users', 'users.id = activity_log.user_id');
        $this->db->order_by('activity_log.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}