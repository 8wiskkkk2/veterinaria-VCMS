<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function db_init() {
        // Verificar conexión
        if (!$this->db->conn_id) {
            show_error('No hay conexión a la base de datos. Revisa application/config/database.php');
            return;
        }

        $created = [];
        $errors = [];

        // Helper para ejecutar CREATE TABLE IF NOT EXISTS
        $exec = function($sql, $name) use (&$created, &$errors) {
            try {
                $this->db->query($sql);
                $created[] = $name;
            } catch (Exception $e) {
                $errors[] = $name . ': ' . $e->getMessage();
            }
        };

        // Tabla users
        $exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `nombre` VARCHAR(100) NOT NULL,
            `apellido` VARCHAR(100) NULL,
            `rut` VARCHAR(20) NOT NULL UNIQUE,
            `email` VARCHAR(150) NULL UNIQUE,
            `telefono` VARCHAR(50) NULL,
            `direccion` VARCHAR(255) NULL,
            `role` VARCHAR(20) NOT NULL DEFAULT 'usuario',
            `estado` VARCHAR(20) NOT NULL DEFAULT 'activo',
            `password` VARCHAR(255) NOT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'users');

        // Tabla mascotas
        $exec("CREATE TABLE IF NOT EXISTS `mascotas` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `usuario_id` INT UNSIGNED NOT NULL,
            `nombre` VARCHAR(100) NOT NULL,
            `especie` VARCHAR(20) NOT NULL,
            `raza` VARCHAR(100) NULL,
            `edad_aproximada` VARCHAR(50) NULL,
            `sexo` VARCHAR(20) NULL,
            `color` VARCHAR(50) NULL,
            `peso` DECIMAL(6,2) NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (`usuario_id`),
            CONSTRAINT `fk_mascotas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'mascotas');

        // Tabla vacunas
        $exec("CREATE TABLE IF NOT EXISTS `vacunas` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `tipo_vacuna` VARCHAR(100) NOT NULL,
            `fecha` DATE NOT NULL,
            `proxima_dosis` DATE NULL,
            `veterinario_id` INT UNSIGNED NULL,
            `peso` DECIMAL(6,2) NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (`mascota_id`),
            INDEX (`veterinario_id`),
            CONSTRAINT `fk_vacunas_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_vacunas_veterinario` FOREIGN KEY (`veterinario_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'vacunas');

        // Tabla desparacitaciones
        $exec("CREATE TABLE IF NOT EXISTS `desparacitaciones` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `fecha` DATE NOT NULL,
            `tratamiento` VARCHAR(100) NOT NULL,
            `proximo_tratamiento` DATE NULL,
            `veterinario_id` INT UNSIGNED NULL,
            `peso` DECIMAL(6,2) NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (`mascota_id`),
            INDEX (`veterinario_id`),
            CONSTRAINT `fk_despara_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_despara_vet` FOREIGN KEY (`veterinario_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'desparacitaciones');

        // Tabla emergencias
        $exec("CREATE TABLE IF NOT EXISTS `emergencias` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `fecha_registro` DATETIME NOT NULL,
            `nivel_urgencia` VARCHAR(10) NOT NULL DEFAULT 'media',
            `motivo_consulta` TEXT NULL,
            `anamnesis` TEXT NULL,
            `diagnostico` TEXT NULL,
            `tratamiento` TEXT NULL,
            `indicaciones` TEXT NULL,
            `observaciones` TEXT NULL,
            `estado` VARCHAR(20) NOT NULL DEFAULT 'pendiente',
            INDEX (`mascota_id`),
            CONSTRAINT `fk_emergencias_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'emergencias');

        // Autorizaciones: cirugía
        $exec("CREATE TABLE IF NOT EXISTS `autorizaciones_cirugia` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `usuario_id` INT UNSIGNED NOT NULL,
            `veterinario_tratante` INT UNSIGNED NULL,
            `fecha` DATETIME NOT NULL,
            INDEX (`mascota_id`), INDEX (`usuario_id`), INDEX (`veterinario_tratante`),
            CONSTRAINT `fk_cirugia_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_cirugia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_cirugia_vet` FOREIGN KEY (`veterinario_tratante`) REFERENCES `users`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'autorizaciones_cirugia');

        // Autorizaciones: eutanasia
        $exec("CREATE TABLE IF NOT EXISTS `autorizaciones_eutanasia` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `usuario_id` INT UNSIGNED NOT NULL,
            `veterinario_tratante` INT UNSIGNED NULL,
            `fecha` DATETIME NOT NULL,
            INDEX (`mascota_id`), INDEX (`usuario_id`), INDEX (`veterinario_tratante`),
            CONSTRAINT `fk_eutanasia_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_eutanasia_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_eutanasia_vet` FOREIGN KEY (`veterinario_tratante`) REFERENCES `users`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'autorizaciones_eutanasia');

        // Autorizaciones: sedación
        $exec("CREATE TABLE IF NOT EXISTS `autorizaciones_sedacion` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NOT NULL,
            `usuario_id` INT UNSIGNED NOT NULL,
            `veterinario_tratante` INT UNSIGNED NULL,
            `emergencia` TINYINT(1) NOT NULL DEFAULT 0,
            `fecha` DATETIME NOT NULL,
            INDEX (`mascota_id`), INDEX (`usuario_id`), INDEX (`veterinario_tratante`),
            CONSTRAINT `fk_sedacion_mascota` FOREIGN KEY (`mascota_id`) REFERENCES `mascotas`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_sedacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_sedacion_vet` FOREIGN KEY (`veterinario_tratante`) REFERENCES `users`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'autorizaciones_sedacion');

        // Tabla citas (usada por Cita_model)
        $exec("CREATE TABLE IF NOT EXISTS `citas` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `mascota_id` INT UNSIGNED NULL,
            `usuario_id` INT UNSIGNED NULL,
            `fecha` DATETIME NULL,
            `estado` VARCHAR(20) NULL,
            `motivo` TEXT NULL,
            INDEX (`mascota_id`), INDEX (`usuario_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'citas');

        // Tabla activity_log (usada por Activity_model)
        $exec("CREATE TABLE IF NOT EXISTS `activity_log` (
            `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT UNSIGNED NOT NULL,
            `action` VARCHAR(100) NOT NULL,
            `description` TEXT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (`user_id`),
            CONSTRAINT `fk_activity_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;", 'activity_log');

        // Disparar creación automática de catálogos/tablas auxiliares
        $this->load->model('Especie_model'); // crea especies y razas y semilla
        $this->load->model('VacunaTipo_model'); // crea vacuna_tipos y semilla
        $this->load->model('DesparacitacionTipo_model'); // crea desparacitacion_tipos y semilla

        // Semillas de usuarios por rol (admin, recepcionista, veterinario)
        try {
            // Helper para insertar si no existe por email
            $ensureUser = function($email, $data) {
                $exists = $this->db->where('email', $email)->get('users')->row();
                if (!$exists) {
                    $this->db->insert('users', $data);
                }
            };

            // Administrador
            $ensureUser('admin@local.test', [
                'rut' => '11.111.111-1',
                'nombre' => 'Administrador',
                'email' => 'admin@local.test',
                'direccion' => 'N/A',
                'telefono' => 'N/A',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'administrador',
                'estado' => 'activo'
            ]);

            // Recepcionista
            $ensureUser('recepcionista@local.test', [
                'rut' => '22.222.222-2',
                'nombre' => 'Recepcionista',
                'email' => 'recepcionista@local.test',
                'direccion' => 'N/A',
                'telefono' => 'N/A',
                'password' => password_hash('recep123', PASSWORD_DEFAULT),
                'role' => 'recepcionista',
                'estado' => 'activo'
            ]);

            // Veterinario
            $ensureUser('veterinario@local.test', [
                'rut' => '33.333.333-3',
                'nombre' => 'Veterinario',
                'email' => 'veterinario@local.test',
                'direccion' => 'N/A',
                'telefono' => 'N/A',
                'password' => password_hash('vet123', PASSWORD_DEFAULT),
                'role' => 'veterinario',
                'estado' => 'activo'
            ]);
        } catch (Exception $e) {
            $errors[] = 'seed_users: ' . $e->getMessage();
        }

        $out = [
            'success' => true,
            'created_or_verified' => $created,
            'errors' => $errors,
            'message' => 'Inicialización de tablas ejecutada'
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($out));
    }
}