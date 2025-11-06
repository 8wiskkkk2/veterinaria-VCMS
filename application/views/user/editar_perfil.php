<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Veterinaria Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .container {
            padding-bottom: 80px; /* Agregar espacio para la barra de navegación */
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Agregar margen inferior */
        }
        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-hover-effect:hover {
            transform: translateY(-3px);
            transition: transform 0.3s;
        }
        .readonly-field {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        .btn-volver {
            margin-bottom: 15px;
            border-radius: 5px;
            padding: 6px 15px;
        }
        @media (max-width: 767px) {
            .btn-volver {
                display: none;
            }
            .container {
                padding-bottom: 100px; /* Aumentar el padding en móvil */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <a href="<?= base_url('user/perfil') ?>" class="btn btn-outline-primary btn-volver">
                    ← Volver
                </a>
                
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0 text-center">Editar Perfil</h3>
                    </div>
                    <div class="card-body">
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
                        
                        <form action="<?= base_url('user/actualizar_perfil') ?>" method="post">
                            <div class="mb-3">
                                <label for="rut" class="form-label fw-bold">RUT</label>
                                <input type="text" class="form-control readonly-field" id="rut" name="rut" value="<?= isset($usuario->rut) ? $usuario->rut : '' ?>" readonly>
                                <div class="form-text">El RUT no se puede modificar.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= isset($usuario->nombre) ? $usuario->nombre : '' ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= isset($usuario->email) ? $usuario->email : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-bold">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= isset($usuario->direccion) ? $usuario->direccion : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= isset($usuario->telefono) ? $usuario->telefono : '' ?>">
                            </div>
                            
                            <hr class="my-4">
                            <h5 class="mb-3">Cambiar Contraseña</h5>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-text">Deje en blanco si no desea cambiar la contraseña.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label fw-bold">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                                <a href="<?= base_url('user/perfil') ?>" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                        <!-- Custom Navbar for Mobile -->
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
        <a class="nav-link active" href="<?= base_url('index.php/user/perfil') ?>">
            <i class="bi bi-person-fill text-primary"></i>
        </a>
    </div>
</nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword && password !== '') {
                event.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    });
    </script>
</body>
</html>
