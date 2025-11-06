<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Especie_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->ensure_schema();
    }

    private function ensure_schema() {
        // Crear tabla especies si no existe
        $this->db->query("CREATE TABLE IF NOT EXISTS especies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        // Crear tabla razas si no existe
        $this->db->query("CREATE TABLE IF NOT EXISTS razas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            especie_id INT NOT NULL,
            nombre VARCHAR(100) NOT NULL,
            UNIQUE KEY unique_nombre_especie (especie_id, nombre),
            CONSTRAINT fk_razas_especie FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        // Semillas básicas si está vacío
        $count = $this->db->count_all('especies');
        if ($count === 0) {
            $this->db->insert_batch('especies', [
                ['nombre' => 'Perro'],
                ['nombre' => 'Gato'],
            ]);

            // Obtener IDs
            $perro = $this->db->get_where('especies', ['nombre' => 'Perro'])->row();
            $gato  = $this->db->get_where('especies', ['nombre' => 'Gato'])->row();
            if ($perro) {
                $this->db->insert_batch('razas', [
                    ['especie_id' => $perro->id, 'nombre' => 'Labrador Retriever'],
                    ['especie_id' => $perro->id, 'nombre' => 'Pastor Alemán'],
                    ['especie_id' => $perro->id, 'nombre' => 'Poodle'],
                    ['especie_id' => $perro->id, 'nombre' => 'Bulldog'],
                    ['especie_id' => $perro->id, 'nombre' => 'Schnauzer'],
                ]);
            }
            if ($gato) {
                $this->db->insert_batch('razas', [
                    ['especie_id' => $gato->id, 'nombre' => 'Siamés'],
                    ['especie_id' => $gato->id, 'nombre' => 'Persa'],
                    ['especie_id' => $gato->id, 'nombre' => 'Maine Coon'],
                    ['especie_id' => $gato->id, 'nombre' => 'Mestizo'],
                ]);
            }
        }
    }

    public function buscar_especies($term) {
        if ($term) {
            $this->db->like('nombre', $term);
        }
        $this->db->order_by('nombre', 'ASC');
        return $this->db->get('especies')->result();
    }

}