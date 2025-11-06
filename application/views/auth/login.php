<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria Municipal </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, rgb(35, 89, 252) 30%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            animation: gradientMove 15s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            border: none;
            box-shadow: 0 0 25px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
            background: rgba(252, 241, 212, 0.95);
            margin: 15px;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            min-height: auto;
        }

        .logo-section {
            background: #2c3e50;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .form-section {
            padding: 30px;
            background: #ffffff;
        }

        .logo-top {
            max-width: 200px;
            margin: 0;
            filter: brightness(0) invert(1);
        }

        .logo-bottom {
            max-width: 120px;
            margin-top: 15px;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .btn-primary {
            background-color: rgb(35, 89, 252);
            border: none;
            padding: 12px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-1px);
        }

        .invalid-tooltip {
            position: absolute;
            top: -25px;
            left: 0;
            z-index: 5;
            display: none;
            max-width: 100%;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            color: #fff;
            background-color: #dc3545;
            border-radius: 0.25rem;
        }

        @media (min-width: 768px) {
            .login-container {
                flex-direction: row;
                min-height: 600px;
            }

            .logo-section {
                flex: 0 0 45%;
                padding: 40px;
                border-radius: 15px 0 0 15px;
            }

            .form-section {
                flex: 0 0 55%;
                padding: 40px;
                border-radius: 0 15px 15px 0;
            }

            .logo-top {
                max-width: 250px;
            }

            .logo-bottom {
                max-width: 150px;
            }

            .card {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="login-container">
                        <div class="logo-section">
                            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="Logo Superior" class="logo-top">
                        </div>
                        <div class="form-section">
                            <div class="text-center mb-4">
                                <img src="<?= base_url('assets/img/logo_mascotas.svg') ?>" alt="Logo" class="img-fluid" style="max-width: 150px; margin-bottom: 20px;">
                                <h3>Veterinaria Municipal</h3>
                            </div>
                            
                            <?php if($this->session->flashdata('error') && $this->session->userdata('mostrar_error')): ?>
                                <div class="alert alert-danger" id="errorAlert">
                                    <?= $this->session->flashdata('error') ?>
                                    <p class="mt-2 mb-0">
                                        ¿Problemas con la contraseña? Contactar con el administrador
                                        <span class="d-none d-md-inline">(+56974333295)</span>
                                        <a href="tel:+56974333295" class="alert-link d-inline d-md-none">+56974333295</a>
                                    </p>
                                </div>
                                <?php $this->session->unset_userdata('mostrar_error'); ?>
                            <?php endif; ?>
                            
                            <?php if($this->session->flashdata('rut_no_encontrado')): ?>
                                <div class="alert alert-warning">
                                    El RUT ingresado es válido pero no está registrado en el sistema.
                                </div>
                            <?php endif; ?>
                            
                            <form action="<?= base_url('auth/login') ?>" method="post" id="loginForm">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo</label>
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="email" name="email" required 
                                                   placeholder="tu@correo.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Ingresar</button>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="mb-0">¿No tienes una cuenta? <a href="<?= base_url('index.php/auth/register') ?>" class="text-primary">Regístrate aquí</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Eliminado manejo de RUT. El login ahora usa correo.
        // Mantén solo el toggle de contraseña y lógica genérica.

        // Función de validación de RUT eliminada; no se requiere para login por correo.

        // Validación de RUT en el submit eliminada; login utiliza correo.

        
        function togglePasswordVisibility(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        document.getElementById('togglePassword').addEventListener('click', function() {
            togglePasswordVisibility('password', 'togglePassword');
        });

        // Botón limpiar RUT eliminado.
    
    document.addEventListener('DOMContentLoaded', function() {
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {

        }
    });
    
    </script>
</body>
</html>
