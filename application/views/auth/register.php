<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema Veterinario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fc;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .form-control {
            padding: 12px;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #4e73df;
            border: none;
            padding: 12px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
        }
        .alert {
            margin-bottom: 20px;
            padding: 15px;
        }
        .is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    </style>
</head>
<body>
    <div id="customAlert" class="custom-alert"></div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Registro de Usuario</h4>
                    </div>
                    <div class="card-body">
                        <!-- Agregar logo -->
                        <div class="text-center mb-4">
                            <img src="<?= base_url('assets/img/logo_mascotas.svg') ?>" alt="Logo" class="img-fluid" style="max-width: 150px;">
                        </div>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('index.php/auth/register') ?>" method="post">
                            <div class="mb-3">
                                <label for="rut" class="form-label">RUT</label>
                                <div class="position-relative">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="rut" name="rut" required 
                                               placeholder="Ej: 12.345.678-9">
                                        <button class="btn btn-outline-secondary" type="button" id="limpiarRut" style="width: 42px;">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="width: 42px;">
                                        <i class="bi bi-eye" style="font-size: 1.1rem;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" style="width: 42px;">
                                        <i class="bi bi-eye" style="font-size: 1.1rem;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>¿Ya tienes una cuenta? <a href="<?= base_url('index.php/auth') ?>">Inicia sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validaRut(rut) {    
            rut = rut.replace(/\./g, '').replace(/-/g, '');
            
            if (!/^[0-9kK]+$/.test(rut)) {
                return false;
            }
            
            let dv = rut.slice(-1);
            let numero = rut.slice(0, -1);
            
            if (isNaN(dv) && dv.toUpperCase() !== 'K') {
                return false;
            }
            
            let i = 2;
            let suma = 0;
            for (let digit of numero.split('').reverse()) {
                if (i === 8) i = 2;
                suma += digit * i;
                i++;
            }
            let dvr = 11 - (suma % 11);
            
            if (dvr === 11) dvr = 0;
            if (dvr === 10) dvr = 'K';
            
            return dvr.toString() === dv.toUpperCase();
        }

        document.getElementById('rut').addEventListener('input', function(e) {
            let value = e.target.value;
            
            value = value.replace(/k/g, 'K');
            
            if (value.includes('K') && value.indexOf('K') !== value.length - 1) {
                value = value.replace(/K/g, '');
            }
            
            value = value.replace(/[^0-9K]/g, '');
            
            if (value.length > 9) {
                value = value.slice(0, 9);
            }
            
            if (value.length > 0) {
                let numero = value.slice(0, -1);
                let dv = value.slice(-1);
                
                numero = numero.replace(/\./g, '').replace(/-/g, '');
                
                if (dv !== 'K' && isNaN(dv)) {
                    value = numero;
                }
                
                if (numero.length > 3) {
                    numero = numero.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
                
                value = numero + (value.length > 1 ? '-' : '') + dv;
            }
            
            e.target.value = value;
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const rutInput = document.getElementById('rut');
            const rut = rutInput.value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            let hasError = false;
            
            function showError(message) {
                const alertDiv = document.getElementById('customAlert');
                alertDiv.textContent = message;
                alertDiv.style.display = 'block';
                
                setTimeout(() => {
                    alertDiv.style.display = 'none';
                }, 3000);
            }
            
            if (!validaRut(rut)) {
                e.preventDefault();
                showError('El RUT ingresado no es válido');
                rutInput.focus();
                hasError = true;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showError('Las contraseñas no coinciden');
                
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('confirm_password').classList.add('is-invalid');
                
                hasError = true;
                
                setTimeout(() => {
                    document.getElementById('password').classList.remove('is-invalid');
                    document.getElementById('confirm_password').classList.remove('is-invalid');
                }, 3000);
            }
            
            if (hasError) {
                e.preventDefault();
            }
        });

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

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            togglePasswordVisibility('confirm_password', 'toggleConfirmPassword');
        });
    </script>
    <style>
        .custom-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            border-radius: 8px;
            background-color: #dc3545;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
            text-align: center;
        }
    
        @keyframes slideIn {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }
    </style>
</body>
</html>
