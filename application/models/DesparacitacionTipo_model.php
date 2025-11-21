<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DesparacitacionTipo_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    public function ensure_table_and_seed() {
        // Crear tabla si no existe
        if (!$this->db->table_exists('desparacitacion_tipos')) {
            $fields = array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'nombre' => array('type' => 'VARCHAR', 'constraint' => '100'),
                'especie' => array('type' => 'VARCHAR', 'constraint' => '10', 'null' => TRUE), // 'perro' | 'gato' | NULL (general)
                'dias_intervalo' => array('type' => 'INT', 'null' => FALSE, 'default' => 0),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('desparacitacion_tipos', TRUE);
        } else {
            // Asegurar columnas requeridas
            $columns = $this->db->list_fields('desparacitacion_tipos');
            if (!in_array('especie', $columns)) {
                $this->dbforge->add_column('desparacitacion_tipos', array(
                    'especie' => array('type' => 'VARCHAR', 'constraint' => '10', 'null' => TRUE)
                ));
            }
            if (!in_array('dias_intervalo', $columns)) {
                $this->dbforge->add_column('desparacitacion_tipos', array(
                    'dias_intervalo' => array('type' => 'INT', 'null' => FALSE, 'default' => 0)
                ));
            }
        }

        // Asegurar índice único compuesto (nombre + especie)
        $unique_exists = FALSE;
        $query = $this->db->query("SHOW INDEX FROM desparacitacion_tipos");
        foreach ($query->result() as $idx) {
            if ($idx->Key_name === 'uniq_nombre_especie') {
                $unique_exists = TRUE;
                break;
            }
        }
        if (!$unique_exists) {
            $this->db->query("CREATE UNIQUE INDEX uniq_nombre_especie ON desparacitacion_tipos (nombre, especie)");
        }

        // Semillas básicas por especie
        $seed = array(
            // Perros
            array('nombre' => 'Desparasitación interna', 'especie' => 'perro', 'dias_intervalo' => 90),
            array('nombre' => 'Desparasitación externa', 'especie' => 'perro', 'dias_intervalo' => 30),
            array('nombre' => 'Desparasitación mixta',  'especie' => 'perro', 'dias_intervalo' => 60),
            // Gatos
            array('nombre' => 'Desparasitación interna', 'especie' => 'gato', 'dias_intervalo' => 90),
            array('nombre' => 'Desparasitación externa', 'especie' => 'gato', 'dias_intervalo' => 30),
            array('nombre' => 'Desparasitación mixta',  'especie' => 'gato', 'dias_intervalo' => 60),
            // General (aplicable a ambas especies)
            array('nombre' => 'Tratamiento general',     'especie' => NULL,   'dias_intervalo' => 60)
        );

        foreach ($seed as $row) {
            $exists = $this->db->get_where('desparacitacion_tipos', array(
                'nombre' => $row['nombre'],
                'especie' => $row['especie']
            ))->row();
            if (!$exists) {
                $row['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('desparacitacion_tipos', $row);
            }
        }
    }

    public function search($term, $especie = NULL, $limit = 20) {
        $this->db->select('nombre, dias_intervalo');
        $this->db->from('desparacitacion_tipos');
        if ($term) {
            $this->db->like('nombre', $term);
        }
        if ($especie) {
            $this->db->group_start();
            $this->db->where('especie', $especie);
            $this->db->or_where('especie IS NULL', NULL, FALSE); // incluir generales
            $this->db->group_end();
        }
        $this->db->order_by('nombre', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function insert_tipo($nombre, $dias_intervalo = 0, $especie = NULL) {
        $data = array(
            'nombre' => $nombre,
            'dias_intervalo' => (int)$dias_intervalo,
            'especie' => $especie ? strtolower($especie) : NULL,
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('desparacitacion_tipos', $data);
    }

    public function get_all() {
        $this->db->order_by('nombre', 'ASC');
        return $this->db->get('desparacitacion_tipos')->result();
    }
}