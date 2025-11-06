<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Recepción - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div id="mensaje-bienvenida" class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">¡Bienvenido, <?= $this->session->userdata('nombre') ?>!</h4>
            <p class="mb-0">Has iniciado sesión como recepcionista en el sistema de la Veterinaria Municipal.</p>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12 mb-4">
                <h2>Panel de Recepción</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-danger">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-ambulance fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title text-danger">Atención de Urgencia</h5>
                        <p class="card-text">Ingreso prioritario para casos que requieren atención inmediata</p>
                        <a href="<?= base_url('recepcionista/crear_emergencia') ?>" class="btn btn-danger">
                            <i class="fas fa-plus-circle me-2"></i>Ingresar Atención de Urgencia
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-plus fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Registro de Usuarios</h5>
                        <p class="card-text">Registra nuevos propietarios de mascotas</p>
                        <a href="<?= base_url('recepcionista/crear_usuario') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nuevo Usuario
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-paw fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Registro de Mascotas</h5>
                        <p class="card-text">Registra nuevas mascotas y propietarios</p>
                        <a href="<?= base_url('recepcionista/crear_mascota') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nueva Mascota
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-file-signature fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Autorizaciones</h5>
                        <p class="card-text">Gestiona las autorizaciones para procedimientos especiales</p>
                        <a href="<?= base_url('recepcionista/autorizaciones/seleccionar_tipo') ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Nueva Autorización
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hacer que las alertas desaparezcan automáticamente después de 3 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
</body>
</html>