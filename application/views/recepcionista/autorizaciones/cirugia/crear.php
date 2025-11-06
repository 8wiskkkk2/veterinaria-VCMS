<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorización para Cirugía - Veterinaria</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
        <div class="card-header bg-primary text-white">
            <h3><i class="fas fa-hospital me-2"></i>Nueva Autorización para Cirugía</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/autorizaciones/cirugia/guardar') ?>" method="POST">
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
                                    <input type="text" class="form-control" id="buscar_mascota" placeholder="Escriba el nombre de la mascota">
                                    <input type="hidden" id="mascota_id" name="mascota_id" required>
                                    <input type="hidden" id="usuario_id" name="usuario_id" required>
                                </div>
                                <div id="resultados_mascota" class="position-absolute bg-white border rounded shadow-sm" 
                                     style="z-index: 1000; width: 100%; display: none; max-height: 200px; overflow-y: auto;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Especie</label>
                                <input type="text" class="form-control" id="especie" readonly>
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
                        <h5><i class="fas fa-syringe me-2"></i>Detalles de la Cirugía</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="emergencia" class="form-label">¿Es una cirugía de emergencia? *</label>
                            <select class="form-select" id="emergencia" name="emergencia" required>
                                <option value="">Seleccione una opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="veterinario_tratante" class="form-label">Veterinario Tratante *</label>
                            <select class="form-select" id="veterinario_tratante" name="veterinario_tratante" required>
                                <option value="">Seleccione un veterinario</option>
                                <?php foreach($veterinarios as $veterinario): ?>
                                    <option value="<?= $veterinario->id ?>">
                                        <?= $veterinario->nombre ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <script>
                        $(document).ready(function() {
                            let timeoutId;
                            
                            $('#veterinario_search').on('input', function() {
                                clearTimeout(timeoutId);
                                const query = $(this).val().trim();
                                
                                if(query.length >= 2) {
                                    timeoutId = setTimeout(function() {
                                        $.ajax({
                                            url: '<?= base_url("recepcionista/buscar_veterinarios") ?>',
                                            type: 'POST',
                                            data: { 
                                                term: query,
                                                <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                                            },
                                            dataType: 'json',
                                            success: function(response) {
                                                let html = '';
                                                if(response && response.length > 0) {
                                                    response.forEach(function(vet) {
                                                        html += `<div class="p-2 cursor-pointer veterinario-item" 
                                                            data-id="${vet.id}" 
                                                            data-nombre="${vet.nombre} ${vet.apellido}">
                                                            ${vet.nombre} ${vet.apellido}
                                                        </div>`;
                                                    });
                                                    $('#veterinario-suggestions').html(html).show();
                                                    $('#veterinario-error').hide();
                                                } else {
                                                    $('#veterinario-suggestions').hide();
                                                    $('#veterinario-error').show().css('display', 'block');
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error en la búsqueda:', error);
                                                $('#veterinario-suggestions').hide();
                                                $('#veterinario-error').text('Error al buscar veterinarios').show().css('display', 'block');
                                            }
                                        });
                                    }, 300);
                                } else {
                                    $('#veterinario-suggestions').hide();
                                    $('#veterinario-error').hide();
                                    $('#veterinario_tratante').val('');
                                }
                            });

                            $(document).on('click', '.veterinario-item', function() {
                                const id = $(this).data('id');
                                const nombre = $(this).data('nombre');
                                
                                $('#veterinario_search').val(nombre);
                                $('#veterinario_tratante').val(id);
                                $('#veterinario-suggestions').hide();
                                $('#veterinario-error').hide();
                            });

                            $(document).on('click', function(e) {
                                if (!$(e.target).closest('#veterinario_search, #veterinario-suggestions').length) {
                                    $('#veterinario-suggestions').hide();
                                }
                            });
                        });
                        </script>

                        <div class="alert alert-info" role="alert">
                            <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Consentimiento Informado</h5>
                            <p class="mb-0">Al marcar la siguiente casilla, confirmo que:</p>
                            <ul class="mb-0">
                                <li>1.- Por el presente documento autorizo a la Dr./Dra. de turno a realizar el procedimiento de cirugía de mi mascota antes individualizada.</li>
                                <li>2.- Declaro que el (los) médico (s) veterinario (s) tratante (s) me ha explicado e informado de los beneficios, complicaciones y riesgos que tiene el procedimiento. Además se me ha explicado que el procedimiento involucra riesgos generales y complicaciones que, a pesar de todas las medidas y cuidados efectuados por el equipo o profesional a cargo, puede ser inevitable.</li>
                                <li>3.- Así mismo estoy en conocimiento de que mi mascota será sometida a sedación y anestesia general, lo que puede estar asociado a complicaciones propias de la ejecución.</li>
                                <li>4.- Declaro que no he ocultado ningún tipo de información relevante al médico veterinario a cargo.</li>
                                <li>5.- Declaro estar al tanto que mi mascota no cuenta con exámenes previos como hemograma, perfil bioquímico, panel de coagulación ni ningún test de enfermedades contagiosas los cuales demuestren que mi mascota no presenta ninguna patología o condición previa que resulte peligrosa durante la cirugía.</li>
                                <li>6.- Declaro asumir mi total responsabilidad, cualquier inconveniente acontecido con mi mascota durante la cirugía como consecuencia de una complicación ocasionada por algún cuadro patológico no detectado por la no realización de estos exámenes. Por lo anterior eximo de toda responsabilidad al médico veterinario tratante y a la clínica veterinaria.</li>
                                <li>7.- Confirmo que he leído y aceptado todo lo anterior.</li>
                            </ul>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmacion" name="confirmacion" required>
                            <label class="form-check-label" for="confirmacion">
                                Confirmo que he leído y acepto los términos del consentimiento informado
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('recepcionista/autorizaciones') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
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

        // Validar campos requeridos
        if (!$('#procedimiento').val().trim()) {
            alert('Por favor ingrese el tipo de cirugía o intervención');
            isValid = false;
        }

        if (!$('#riesgos').val().trim()) {
            alert('Por favor ingrese los riesgos y complicaciones');
            isValid = false;
        }

        if (!$('#fecha_programada').val()) {
            alert('Por favor seleccione la fecha programada');
            isValid = false;
        }

        if (!$('#confirmar_cirugia').is(':checked')) {
            alert('Debe confirmar que ha leído y acepta los términos del consentimiento informado');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            return false;
        }

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
                                    data-propietario-id="${mascota.usuario_id}"
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
        
        // Actualizar campos de la mascota
        $('#buscar_mascota').val(nombre);
        $('#mascota_id').val(id);
        $('#especie').val(especie);
        $('#raza').val(raza);
        $('#edad').val(edad);
        $('#sexo').val(sexo);

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