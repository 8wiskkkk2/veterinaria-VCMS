<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2>Crear Nuevo Usuario</h2>
            <div id="alert-container" class="alert alert-danger" style="display: none;"></div>
            <form action="<?= base_url('recepcionista/guardar_usuario') ?>" method="POST">
                <div class="mb-3">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" class="form-control <?= form_error('rut') ? 'is-invalid' : '' ?>" 
                           id="rut" name="rut" value="<?= set_value('rut') ?>" required>
                    <?php if(form_error('rut')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('rut') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control <?= form_error('nombre') ? 'is-invalid' : '' ?>" 
                           id="nombre" name="nombre" value="<?= set_value('nombre') ?>" required>
                    <?php if(form_error('nombre')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('nombre') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                           id="email" name="email" value="<?= set_value('email') ?>" required>
                    <?php if(form_error('email')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('email') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control <?= form_error('telefono') ? 'is-invalid' : '' ?>" 
                           id="telefono" name="telefono" value="<?= set_value('telefono') ?>" required>
                    <?php if(form_error('telefono')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('telefono') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control <?= form_error('direccion') ? 'is-invalid' : '' ?>" 
                           id="direccion" name="direccion" value="<?= set_value('direccion') ?>" required>
                    <?php if(form_error('direccion')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('direccion') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                           id="password" name="password" required>
                    <?php if(form_error('password')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" 
                           id="confirm_password" name="confirm_password" required>
                    <?php if(form_error('confirm_password')): ?>
                        <div class="invalid-feedback">
                            <?= form_error('confirm_password') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                <a href="<?= base_url('recepcionista/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
            </form>
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

document.getElementById('rut').addEventListener('blur', function() {
    if (!validarRut(this.value)) {
        mostrarAlerta('RUT inválido');
        this.classList.add('is-invalid');
        $('button[type="submit"]').prop('disabled', true);
        return;
    }
    
    $.ajax({
        url: '<?= base_url('recepcionista/verificar_rut') ?>',
        type: 'POST',
        data: {rut: this.value},
        success: (response) => {
            var data = JSON.parse(response);
            if(data.exists) {
                mostrarAlerta('Este RUT ya está registrado en el sistema');
                this.classList.add('is-invalid');
                $('button[type="submit"]').prop('disabled', true);
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                verificarFormulario();
            }
        },
        error: () => {
            mostrarAlerta('Error al verificar el RUT. Por favor, inténtelo de nuevo.');
            this.classList.add('is-invalid');
            $('button[type="submit"]').prop('disabled', true);
        }
    });
});

document.getElementById('email').addEventListener('blur', function() {
    if (!this.value) return;
    
    $.ajax({
        url: '<?= base_url('recepcionista/verificar_email') ?>',
        type: 'POST',
        data: {email: this.value},
        success: (response) => {
            var data = JSON.parse(response);
            if(data.exists) {
                mostrarAlerta('Este correo electrónico ya está registrado en el sistema');
                this.classList.add('is-invalid');
                $('button[type="submit"]').prop('disabled', true);
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                verificarFormulario();
            }
        },
        error: () => {
            mostrarAlerta('Error al verificar el correo electrónico. Por favor, inténtelo de nuevo.');
            this.classList.add('is-invalid');
            $('button[type="submit"]').prop('disabled', true);
        }
    });
});
</script>
<script>
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
        this.classList.add('is-invalid');
        this.nextElementSibling.textContent = 'RUT inválido';
        this.nextElementSibling.style.display = 'block';
    } else {
        this.classList.remove('is-invalid');
        this.nextElementSibling.style.display = 'none';
    }
});

document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});
</script>