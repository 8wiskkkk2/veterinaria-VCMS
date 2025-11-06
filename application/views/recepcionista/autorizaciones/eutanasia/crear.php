<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorización para Eutanasia - Veterinaria</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .cursor-pointer:hover {
            background-color: #f8f9fa;
        }
        #resultados_mascota {
            position: absolute;
            z-index: 1000;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
        }
        .mascota-item {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }
        .mascota-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h3><i class="fas fa-heart-broken me-2"></i>Nueva Autorización para Eutanasia</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/autorizaciones/eutanasia/guardar') ?>" method="POST">
                <!-- Sección de Datos de la Mascota -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-paw me-2"></i>Datos del Paciente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="buscar_mascota" class="form-label">Nombre Mascota *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscar_mascota" 
                                           placeholder="Escriba el nombre de la mascota">
                                    <input type="hidden" id="mascota_id" name="mascota_id" required>
                                    <input type="hidden" id="usuario_id" name="usuario_id" required>
                                </div>
                                <div id="resultados_mascota" class="position-absolute bg-white border rounded shadow-sm" 
                                     style="z-index: 1000; width: 100%; display: none; max-height: 200px; overflow-y: auto;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Especie</label>
                                <input type="text" class="form-control" id="especie" readonly >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Raza</label>
                                <input type="text" class="form-control" id="raza" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Edad</label>
                                <input type="text" class="form-control" id="edad" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexo</label>
                                <input type="text" class="form-control" id="sexo" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-user me-2"></i>Datos del Propietario</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre_propietario" readonly>
                                <input type="hidden" name="nombre_propietario" id="hidden_nombre_propietario">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RUT</label>
                                <input type="text" class="form-control" id="rut_propietario" readonly>
                                <input type="hidden" name="rut_propietario" id="hidden_rut_propietario">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono_propietario" readonly>
                                <input type="hidden" name="telefono_propietario" id="hidden_telefono_propietario">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion_propietario" readonly>
                                <input type="hidden" name="direccion_propietario" id="hidden_direccion_propietario">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-clipboard-list me-2"></i>Detalle motivo del procedimiento de eutanasia</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="Motivo de la Eutanasia *" id="motivo" name="motivo" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
        
                            <div class="form-group mb-3">
                                <label for="veterinario_tratante" class="form-label">Veterinario Tratante *</label>
                                <select class="form-select" id="veterinario_tratante" name="veterinario_tratante" required>
                                    <option value="">Seleccione un veterinario</option>
                                    <?php foreach($veterinarios as $veterinario): ?>
                                        <option value="<?= $veterinario->id ?>"><?= $veterinario->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Consentimiento Informado</h5>
                    <p class="mb-0">Al marcar la siguiente casilla, confirmo que:</p>
                    <ul class="mb-0">
                        <li>1.- Por el presente documento autorizo realizar el procedimiento gratuito de eutanasia de mi mascota antes individualizada.</li>
                        <li>2.- Declaro que el (los) médico (s) veterinario (s) tratante (s) me ha explicado e informado de los beneficios, complicaciones y riesgos que tiene el procedimiento.</li>
                        <li>3.- Así mismo, declaro que no he ocultado ningún tipo de información relevante al médico veterinario a cargo.</li>
                        <li>4.- Consiento en la administración de los fármacos que el médico considere necesario.</li>
                        <li>5.- Confirmo que he leído y aceptado todo lo anterior.</li>
                    </ul>
                </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmar_eutanasia" name="confirmar_eutanasia" required>
                            <label class="form-check-label" for="confirmar_eutanasia">
                                Confirmo que he leído y acepto los términos del consentimiento informado
                            </label>                        
                        </div>
                        <input type="hidden" name="fecha" value="<?= date('Y-m-d H:i:s') ?>">
                    </div>
                </div>
               

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('recepcionista/autorizaciones') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save me-2"></i>Guardar Autorización
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Validación del formulario
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Validar mascota seleccionada
        if (!$('#mascota_id').val()) {
            alert('Por favor seleccione una mascota');
            isValid = false;
        }

        // Validar usuario_id
        if (!$('#usuario_id').val()) {
            alert('Error: No se ha seleccionado el propietario correctamente');
            isValid = false;
        }

        // Validar motivo
        if (!$('#motivo').val().trim()) {
            alert('Por favor ingrese el motivo de la eutanasia');
            isValid = false;
        }

        // Validar checkbox de confirmación
        if (!$('#confirmar_eutanasia').is(':checked')) {
            alert('Debe confirmar que ha leído y acepta los términos del consentimiento informado');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }

        // Agregar log antes del envío
        console.log('Datos a enviar:', {
            mascota_id: $('#mascota_id').val(),
            usuario_id: $('#usuario_id').val(),
            motivo: $('#motivo').val()
        });

        return isValid;
    });
    
    let timeoutId;
    
    $('#buscar_mascota').on('input', function() {
        clearTimeout(timeoutId);
        const query = $(this).val().trim();
        
        if(query.length >= 2) {
            timeoutId = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url('recepcionista/buscar_mascotas') ?>',
                    type: 'POST',
                    data: { query: query },
                    dataType: 'json',
                    success: function(response) {
                        let html = '';
                        if(response && response.length > 0) {
                            response.forEach(function(mascota) {
                                html += `<div class="mascota-item cursor-pointer" 
                                    data-id="${mascota.id}" 
                                    data-nombre="${mascota.nombre}"
                                    data-especie="${mascota.especie}"
                                    data-raza="${mascota.raza}"
                                    data-edad="${mascota.edad_aproximada}"
                                    data-sexo="${mascota.sexo}"
                                    data-propietario-id="${mascota.propietario_id}"
                                    data-propietario-nombre="${mascota.nombre_propietario}"
                                    data-propietario-rut="${mascota.rut_propietario}"
                                    data-propietario-telefono="${mascota.telefono_propietario || ''}"
                                    data-propietario-direccion="${mascota.direccion_propietario || ''}">
                                    ${mascota.nombre} - ${mascota.especie} (${mascota.nombre_propietario}) (${mascota.rut_propietario})
                                </div>`;
                            });
                        } else {
                            html = '<div class="p-2">No se encontraron resultados</div>';
                        }
                        $('#resultados_mascota').html(html).show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la búsqueda:', error);
                        $('#resultados_mascota').html('<div class="p-2">Error al buscar mascotas</div>').show();
                    }
                });
            }, 300);
        } else {
            $('#resultados_mascota').hide();
        }
    });

    $(document).on('click', '.mascota-item', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const especie = $(this).data('especie');
        const raza = $(this).data('raza');
        const edad = $(this).data('edad');
        const sexo = $(this).data('sexo');
        
        
        const propietarioId = $(this).data('propietario-id');
        if (!propietarioId) {
            console.error('Error: ID del propietario no definido');
            return;
        }
        
        $('#usuario_id').val(propietarioId);
        console.log('ID del propietario asignado:', propietarioId);
        
        const propietarioNombre = $(this).data('propietario-nombre');
        const propietarioRut = $(this).data('propietario-rut');
        const propietarioTelefono = $(this).data('propietario-telefono') || '';
        const propietarioDireccion = $(this).data('propietario-direccion') || '';
        
        // Para debugging
        console.log('ID de la mascota:', id);
        console.log('ID del propietario:', propietarioId);
        console.log('Nombre del propietario:', propietarioNombre);
        
        // Actualizar campos de la mascota
        $('#buscar_mascota').val(nombre);
        $('#mascota_id').val(id);
        $('#especie').val(especie);
        $('#raza').val(raza);
        $('#edad').val(edad);
        $('#sexo').val(sexo);

        // IMPORTANTE: Asignar el ID del propietario
        $('#usuario_id').val(propietarioId);

        // Actualizar campos del propietario
        $('#nombre_propietario').val(propietarioNombre);
        $('#rut_propietario').val(propietarioRut);
        $('#telefono_propietario').val(propietarioTelefono);
        $('#direccion_propietario').val(propietarioDireccion);

        // Actualizar campos ocultos del propietario
        $('#hidden_nombre_propietario').val(propietarioNombre);
        $('#hidden_rut_propietario').val(propietarioRut);
        $('#hidden_telefono_propietario').val(propietarioTelefono);
        $('#hidden_direccion_propietario').val(propietarioDireccion);

        $('#resultados_mascota').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscar_mascota, #resultados_mascota').length) {
            $('#resultados_mascota').hide();
        }
    });
});
</script>
</body>
</html>

