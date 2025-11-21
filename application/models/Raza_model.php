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

    public function exists_by_nombre_especie($especie_id, $nombre) {
        return $this->db->where('especie_id', (int)$especie_id)
                        ->where('nombre', $nombre)
                        ->count_all_results('razas') > 0;
    }

    public function insert_raza($especie_id, $nombre) {
        if (!$especie_id || !$nombre) return false;
        $nombre_norm = ucfirst(strtolower($nombre));
        if ($this->exists_by_nombre_especie((int)$especie_id, $nombre_norm)) {
            return false;
        }
        return $this->db->insert('razas', array('especie_id' => (int)$especie_id, 'nombre' => $nombre_norm));
    }
}