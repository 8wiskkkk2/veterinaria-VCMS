


<div class="container mt-4">
    <h2 class="text-center mb-4">Mis Mascotas</h2>
    
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <style>
        .btn-custom {
            color: #007bff;
            border: 1px solid #007bff;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-custom:hover {
            background-color: #007bff;
            color: #fff;
        }

        @media (max-width: 767px) {
            .btn-custom {
                display: none;
            }
        }

        .mascota-card {
            border: 2px solid #007bff;
            border-radius: 10px;
            overflow: visible;
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: auto;
            width: 100%; /* Cambiado de max-width a width */
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            display: flex; /* Añadido */
            flex-direction: column; /* Añadido */
            align-items: center; /* Añadido */
        }

        .mascota-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px; /* Reducido de 20px */
            padding: 15px; /* Reducido de 25px */
            width: 100%;
            order: 3;
            margin-top: 10px; /* Reducido de 20px */
        }

        @media (min-width: 768px) {
            .row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); /* Cambiado de 450px a 350px */
                gap: 25px; /* Reducido de 35px */
                margin: 0;
                padding: 15px; /* Reducido de 20px */
            }

            .col-md-4 {
                width: 100%;
                padding: 10px; /* Reducido de 15px */
                margin-bottom: 15px; /* Reducido de 20px */
            }
        }
        .mascota-header {
            background-color: transparent;
            color: #007bff;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            order: 2;
            margin-top: 10px;
        }

        .mascota-icon {
            font-size: 5rem; /* Icono más grande */
            color: #007bff;
            margin: 20px 0;
            order: 1;
        }

        .mascota-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .mascota-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 25px;
            width: 100%;
            order: 3;
            margin-top: 20px;
        }

        .info-item {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        @media (min-width: 768px) {
            .row {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
                gap: 35px;
                margin: 0;
                padding: 20px; /* Añadido padding */
            }

            .col-md-4 {
                width: 100%;
                padding: 15px; /* Añadido padding */
                margin-bottom: 20px;
            }
        }
    </style>

    <a href="<?= base_url('user/index') ?>" class="btn btn-custom mb-4">
        <i class="fas fa-arrow-left me-1"></i> Volver
    </a>

    <div class="row">
        <?php if(!empty($mascotas)): ?>
            <?php foreach($mascotas as $mascota): ?>
                <div class="col-md-4">
                    <div class="mascota-card">
                        <div class="mascota-header">
                            <h5 class="mb-0"><?= $mascota->nombre ?></h5>
                        </div>
                        <div class="text-center">
                            <?php
                            $especie = strtolower($mascota->especie);
                            if (strpos($especie, 'perro') !== false) {
                                echo '<i class="fas fa-dog mascota-icon"></i>';
                            } elseif (strpos($especie, 'gato') !== false) {
                                echo '<i class="fas fa-cat mascota-icon"></i>';
                            } else {
                                echo '<i class="fas fa-paw mascota-icon"></i>';
                            }
                            ?>
                        </div>
                        <div class="mascota-info">
                            <div class="info-item">
                                <span class="info-label">Especie</span>
                                <span class="info-value"><?= $mascota->especie ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Raza</span>
                                <span class="info-value"><?= $mascota->raza ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Color</span>
                                <span class="info-value"><?= $mascota->color ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Edad</span>
                                <span class="info-value"><?= $mascota->edad_aproximada ?> años</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Peso</span>
                                <span class="info-value"><?= $mascota->peso ?> kg</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alergias</span>
                                <span class="info-value"><?= $mascota->alergias_conocidas ?: 'Ninguna' ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Sexo</span>
                                <span class="info-value"><?= $mascota->sexo ?: 'No especificado' ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Estado reproductivo</span>
                                <span class="info-value"><?= $mascota->estado_reproductivo ?: 'No especificado' ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No tienes mascotas registradas
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<nav class="navbar fixed-bottom navbar-light bg-white shadow-lg d-block d-md-none">
    <div class="container-fluid justify-content-around">
        <a class="nav-link" href="<?= base_url('index.php/user') ?>">
            <i class="bi bi-house-door-fill"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/mascotas') ?>">
            <i class="fas fa-paw text-danger"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/historial') ?>">
            <i class="bi bi-journal-medical text-success"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/mapa') ?>">
            <i class="bi bi-geo-alt-fill text-info"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/perfil') ?>">
            <i class="bi bi-person-fill text-primary"></i>
        </a>
    </div>
</nav>