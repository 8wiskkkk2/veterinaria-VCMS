<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VacunaTipo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Garantizar que la tabla, índices y semillas estén correctos en cada carga
        $this->ensure_table_and_seed();
    }

    public function ensure_table_and_seed() {
        // Crear tabla si no existe
        if (!$this->db->table_exists('vacuna_tipos')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `vacuna_tipos` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `nombre` VARCHAR(100) NOT NULL UNIQUE,
                `dias_intervalo` INT NULL,
                `especie` VARCHAR(20) NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Asegurar columna especie si la tabla existía sin ella
        $col = $this->db->query("SHOW COLUMNS FROM `vacuna_tipos` LIKE 'especie'")->row();
        if (!$col) {
            $this->db->query("ALTER TABLE `vacuna_tipos` ADD COLUMN `especie` VARCHAR(20) NULL AFTER `dias_intervalo`");
        }

        // Asegurar índice único compuesto (nombre, especie) para permitir mismo nombre en especies distintas
        $indexes = $this->db->query("SHOW INDEX FROM `vacuna_tipos`")->result();
        $has_unique_nombre = false;
        $has_unique_comp = false;
        foreach ($indexes as $idx) {
            if (isset($idx->Key_name) && isset($idx->Non_unique)) {
                if ($idx->Key_name === 'nombre' && (int)$idx->Non_unique === 0) {
                    $has_unique_nombre = true;
                }
                if ($idx->Key_name === 'unique_nombre_especie' && (int)$idx->Non_unique === 0) {
                    $has_unique_comp = true;
                }
            }
        }
        if ($has_unique_nombre) {
            // Quitar índice único solo por nombre si existe
            $this->db->query("DROP INDEX `nombre` ON `vacuna_tipos`");
        }
        if (!$has_unique_comp) {
            // Añadir índice único compuesto si no existe
            $this->db->query("ALTER TABLE `vacuna_tipos` ADD UNIQUE KEY `unique_nombre_especie` (`nombre`,`especie`)");
        }

        // Semillas básicas si está vacío
        $count = $this->db->count_all('vacuna_tipos');
        if ($count == 0) {
            $tipos = [
                // Perro
                ['nombre' => 'Rabia', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Polivalente (DHPP)', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Sextuple Canina', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Parvovirus', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Moquillo', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Leptospirosis', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Hepatitis', 'dias_intervalo' => 365, 'especie' => 'perro'],
                ['nombre' => 'Bordetella', 'dias_intervalo' => 180, 'especie' => 'perro'],
                // Gato
                ['nombre' => 'Rabia', 'dias_intervalo' => 365, 'especie' => 'gato'],
                ['nombre' => 'Triple Felina', 'dias_intervalo' => 365, 'especie' => 'gato'],
                ['nombre' => 'Leucemia Felina', 'dias_intervalo' => 365, 'especie' => 'gato'],
            ];
            foreach ($tipos as $t) {
                $this->db->insert('vacuna_tipos', $t);
            }
        }

        // Completar especie en filas existentes si están en NULL
        $this->db->query("UPDATE `vacuna_tipos` SET `especie`='perro' WHERE `especie` IS NULL AND `nombre` IN ('Polivalente (DHPP)','Sextuple Canina','Parvovirus','Moquillo','Leptospirosis','Hepatitis','Bordetella')");
        $this->db->query("UPDATE `vacuna_tipos` SET `especie`='gato' WHERE `especie` IS NULL AND `nombre` IN ('Triple Felina','Leucemia Felina')");
        // Asegurar dos entradas de Rabia (perro y gato)
        $rabias = $this->db->where('nombre', 'Rabia')->get('vacuna_tipos')->result();
        $rabia_perro = false; $rabia_gato = false; $rabia_sin_especie = null;
        foreach ($rabias as $r) {
            $esp = isset($r->especie) ? strtolower($r->especie) : null;
            if ($esp === 'perro') { $rabia_perro = true; }
            elseif ($esp === 'gato') { $rabia_gato = true; }
            else { $rabia_sin_especie = $r; }
        }
        if (!$rabia_perro) {
            if ($rabia_sin_especie) {
                $this->db->where('id', $rabia_sin_especie->id)->update('vacuna_tipos', ['especie' => 'perro']);
            } else {
                $this->db->insert('vacuna_tipos', ['nombre' => 'Rabia', 'dias_intervalo' => 365, 'especie' => 'perro']);
            }
        }
        if (!$rabia_gato) {
            $this->db->insert('vacuna_tipos', ['nombre' => 'Rabia', 'dias_intervalo' => 365, 'especie' => 'gato']);
        }
    }

    public function search($term, $especie = null, $limit = 10) {
        if ($term) {
            $this->db->like('nombre', $term);
        }
        // Si se pasa especie, preferir coincidencias por especie pero permitir NULL como respaldo
        if ($especie) {
            $this->db->group_start();
            $this->db->where('especie', strtolower($especie));
            // incluir tipos sin especie definida como opciones generales
            $this->db->or_where('especie IS NULL', null, false);
            $this->db->group_end();
        }
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get('vacuna_tipos', $limit);
        return $query->result();
    }

    public function get_by_nombre($nombre) {
        return $this->db->get_where('vacuna_tipos', ['nombre' => $nombre])->row();
    }

    public function get_by_nombre_especie($nombre, $especie) {
        if (!$especie) {
            return $this->get_by_nombre($nombre);
        }
        // 1) Intentar coincidencia específica por especie
        $row = $this->db->get_where('vacuna_tipos', [
            'nombre' => $nombre,
            'especie' => strtolower($especie)
        ])->row();
        if ($row) { return $row; }

        // 2) Respaldo: mismo nombre con especie NULL (tipo general)
        $row = $this->db->where('nombre', $nombre)
                        ->where('especie IS NULL', null, false)
                        ->get('vacuna_tipos')
                        ->row();
        if ($row) { return $row; }

        // 3) Último recurso: cualquier registro por nombre (otra especie)
        return $this->db->get_where('vacuna_tipos', ['nombre' => $nombre])->row();
    }

    public function insert_tipo($nombre, $dias_intervalo = null, $especie = null) {
        return $this->db->insert('vacuna_tipos', [
            'nombre' => $nombre,
            'dias_intervalo' => $dias_intervalo,
            'especie' => $especie ? strtolower($especie) : null
        ]);
    }
}