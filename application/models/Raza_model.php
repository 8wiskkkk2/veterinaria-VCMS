<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Raza_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // La creación de tabla ocurre en Especie_model::ensure_schema()
    }

    public function buscar_razas_por_especie($especie_id, $term = null) {
        if ($especie_id) {
            $this->db->where('especie_id', (int)$especie_id);
        }
        if ($term) {
            $this->db->like('nombre', $term);
        }
        $this->db->order_by('nombre', 'ASC');
        return $this->db->get('razas')->result();
    }
}