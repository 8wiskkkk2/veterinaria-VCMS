<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Crear Nuevo Usuario</h3>
                </div>
                <div class="card-body">
                    <div id="alert-container" class="alert alert-danger" style="display: none;"></div>
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('admin/crear_usuario') ?>" method="post">
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT *</label>
                            <input type="text" class="form-control <?= form_error('rut') ? 'is-invalid' : '' ?>" 
                                   id="rut" name="rut" required value="<?= set_value('rut') ?>">
                            <?php if(form_error('rut')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('rut') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control <?= form_error('nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" name="nombre" required value="<?= set_value('nombre') ?>">
                            <?php if(form_error('nombre')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('nombre') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                                   id="email" name="email" required value="<?= set_value('email') ?>">
                            <?php if(form_error('email')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('email') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección *</label>
                            <input type="text" class="form-control <?= form_error('direccion') ? 'is-invalid' : '' ?>" 
                                   id="direccion" name="direccion" required value="<?= set_value('direccion') ?>">
                            <?php if(form_error('direccion')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('direccion') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono *</label>
                            <input type="text" class="form-control <?= form_error('telefono') ? 'is-invalid' : '' ?>" 
                                   id="telefono" name="telefono" required value="<?= set_value('telefono') ?>">
                            <?php if(form_error('telefono')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('telefono') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                                   id="password" name="password" required>
                            <?php if(form_error('password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" 
                                   id="confirm_password" name="confirm_password" required>
                            <?php if(form_error('confirm_password')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('confirm_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="role">Rol *</label>
                            <select class="form-control <?= form_error('role') ? 'is-invalid' : '' ?>" 
                                    id="role" name="role" required>
                                <option value="usuario" <?= set_select('role', 'usuario') ?> class="text-primary">Usuario</option>
                                <option value="veterinario" <?= set_select('role', 'veterinario') ?> class="text-success">Veterinario</option>
                                <option value="recepcionista" <?= set_select('role', 'recepcionista') ?> class="text-info">Recepcionista</option>
                                <option value="administrador" <?= set_select('role', 'administrador') ?> class="text-danger">Administrador</option>
                            </select>
                            <?php if(form_error('role')): ?>
                                <div class="invalid-feedback">
                                    <?= form_error('role') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <style>
                            #role option[value="usuario"] { color: #0d6efd; }
                            #role option[value="veterinario"] { color: #198754; }
                            #role option[value="recepcionista"] { color: #0dcaf0; }
                            #role option[value="administrador"] { color: #dc3545; }
                        </style>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarAlerta(mensaje) {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.textContent = mensaje;
    alertContainer.style.display = 'block';
    
    setTimeout(() => {
        alertContainer.style.display = 'none';
    }, 3000);
}

document.getElementById('rut').addEventListener('input', function(e) {
    let value = e.target.value;
    
    value = value.replace(/[^0-9kK]/g, '');
    
    if (value.length > 9) {
        value = value.slice(0, 9);
    }
    
    value = value.replace(/k/g, 'K');
    
    if (value.indexOf('K') !== -1) {
        value = value.replace(/K/g, '');
        if (value.length > 0) {
            value += 'K';
        }
    }
    
    if (value.length > 0) {
        let formatted = '';
        let body = value;
        let dv = '';
        
        if (value.length > 1) {
            body = value.slice(0, -1);
            dv = value.slice(-1);
        } else {
            body = value;
            dv = '';
        }
        
        while (body.length > 3) {
            formatted = '.' + body.slice(-3) + formatted;
            body = body.slice(0, -3);
        }
        formatted = body + formatted;
        
        if (dv) {
            formatted += '-' + dv;
        }
        
        this.value = formatted;
    }
});

function validarRut(rut) {
    rut = rut.replace(/\./g, '').replace(/-/g, '');
    
    const dv = rut.slice(-1).toUpperCase();
    const rutCuerpo = rut.slice(0, -1);
    
    let suma = 0;
    let multiplicador = 2;
    
    for(let i = rutCuerpo.length - 1; i >= 0; i--) {
        suma += parseInt(rutCuerpo.charAt(i)) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
    
    const dvEsperado = 11 - (suma % 11);
    const dvCalculado = dvEsperado === 11 ? '0' : dvEsperado === 10 ? 'K' : dvEsperado.toString();
    
    return dvCalculado === dv;
}

document.getElementById('rut').addEventListener('blur', function() {
    if (!validarRut(this.value)) {
        mostrarAlerta('RUT inválido');
        this.classList.add('is-invalid');
        return;
    }
    
    $.ajax({
        url: '<?= base_url('admin/verificar_rut') ?>',
        type: 'POST',
        data: {rut: this.value},
        success: (response) => {
            var data = JSON.parse(response);
            if(data.exists) {
                mostrarAlerta('Este RUT ya está registrado en el sistema');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        },
        error: () => {
            mostrarAlerta('Error al verificar el RUT. Por favor, inténtelo de nuevo.');
            this.classList.add('is-invalid');
        }
    });
});

document.getElementById('email').addEventListener('blur', function() {
    if (!this.value) return;
    
    $.ajax({
        url: '<?= base_url('admin/verificar_email') ?>',
        type: 'POST',
        data: {email: this.value},
        success: (response) => {
            var data = JSON.parse(response);
            if(data.exists) {
                mostrarAlerta('Este correo electrónico ya está registrado en el sistema');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        },
        error: () => {
            mostrarAlerta('Error al verificar el correo electrónico. Por favor, inténtelo de nuevo.');
            this.classList.add('is-invalid');
        }
    });
});

document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.setCustomValidity('Las contraseñas no coinciden');
        this.classList.add('is-invalid');
    } else {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});
</script>