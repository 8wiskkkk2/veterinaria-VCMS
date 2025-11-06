<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Agregar Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Mi Perfil - Veterinaria Municipal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color:rgb(255, 255, 255);  /* Mismo color de fondo que el panel de usuario */
            min-height: 100vh;
            display: flex;
            align-items: flex-start;  /* Cambiado de center a flex-start */
            justify-content: center;
            padding-top: 5rem;  /* Añadido padding superior */
        }

        .profile-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            top: -40px;
            left: 0;
            padding: 6px 16px;
            font-size: 14px;
        }

        @media (max-width: 767px) {
            .back-btn {
                display: none;
            }
        }

        .profile-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
            background-color: white;
        }

        .card-header h4 {
            margin: 0;
            color: #0d6efd;
        }

        .info-list {
            padding: 20px;
        }

        .info-row {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #0d6efd;
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .info-value {
            color: #666;
            font-size: 14px;
        }

        .card-footer {
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eee;
            background-color: white;
        }

        .btn-edit {
            padding: 8px 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <!-- Add this at the top of the content section -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    
        <a href="<?php echo base_url('index.php/user/index'); ?>" class="btn btn-outline-primary btn-sm back-btn">
            ← Volver
        </a>
        
        <div class="profile-card">
            <div class="card-header">
                <h4>Información Personal</h4>
            </div>
            
            <div class="info-list">
                <div class="info-row">
                    <div class="info-label">Rut:</div>
                    <div class="info-value"><?php echo isset($usuario->rut) ? $usuario->rut : '--------'; ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Nombre:</div>
                    <div class="info-value"><?php echo isset($usuario->nombre) ? $usuario->nombre : '--------'; ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo isset($usuario->email) ? $usuario->email : '--------'; ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value"><?php echo isset($usuario->telefono) ? $usuario->telefono : '--------'; ?></div>
                </div>

                <div class="info-row">
                    <div class="info-label">Dirección:</div>
                    <div class="info-value"><?php echo isset($usuario->direccion) ? $usuario->direccion : '--------'; ?></div>
                </div>
            </div>

            <div class="card-footer">
                <a href="<?php echo base_url('index.php/user/editar_perfil'); ?>" class="btn btn-primary btn-edit">
                    <i class="fas fa-edit"></i> Editar Perfil
                </a>
            </div>
        </div>
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
        <a class="nav-link active" href="<?= base_url('index.php/user/historial') ?>">
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
<!-- Agregar script de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>