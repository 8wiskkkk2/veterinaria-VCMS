<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Vacuna - Veterinaria</title>
    
    <!-- jQuery (debe ir primero) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery UI CSS y JS -->
    <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
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
                <h3 class="mb-0">
                    <i class="fas fa-syringe me-2"></i>Registrar Nueva Vacuna
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('veterinario/vacunas/guardar') ?>" method="POST" id="form-vacuna" class="needs-validation" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="buscar_mascota" class="form-label">Buscar Mascota <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="buscar_mascota" 
                                       placeholder="Escriba el nombre de la mascota" required>
                                <div class="invalid-feedback">Por favor, seleccione una mascota</div>
                            </div>
                            <input type="hidden" id="mascota_id" name="mascota_id" required>
                            <div id="resultados_mascota" class="position-absolute bg-white border rounded shadow-sm"></div>
                            <div id="mascota_seleccionada" class="form-text text-success mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="veterinario_id" class="form-label">Veterinario <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                <select class="form-select" id="veterinario_id" name="veterinario_id" required>
                                    <option value="">Seleccione un veterinario</option>
                                    <?php foreach($veterinarios as $veterinario): ?>
                                        <option value="<?= $veterinario->id ?>"><?= $veterinario->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor, seleccione un veterinario</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_vacuna" class="form-label">Tipo de Vacuna <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-syringe"></i></span>
                                <input type="text" class="form-control" id="tipo_vacuna" name="tipo_vacuna"
                                       placeholder="Ingrese el tipo de vacuna" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="peso" class="form-label">Peso (kg) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                <input type="number" step="0.01" class="form-control" id="peso" name="peso"
                                       placeholder="Ingrese el peso en kg" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_vacuna" class="form-label">Fecha de Vacuna <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" id="fecha_vacuna" name="fecha_vacuna" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="proxima_vacuna" class="form-label">Próxima Vacuna <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                                <input type="date" class="form-control" id="proxima_vacuna" name="proxima_vacuna" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Vacuna
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        let timeoutId;
        let vacunaIntervaloDias = null;
        
        $('#buscar_mascota').on('input', function() {
            clearTimeout(timeoutId);
            const query = $(this).val().trim();
            
            if(query.length >= 2) {
                timeoutId = setTimeout(function() {
                    $.ajax({
                        url: '<?= base_url("veterinario/buscar_mascotas") ?>',
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
                                        data-peso="${mascota.peso ?? ''}">
                                        ${mascota.nombre} - ${mascota.especie} (${mascota.nombre_propietario})
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

        let especieMascota = null;
        $(document).on('click', '.mascota-item', function() {
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            const peso = $(this).data('peso');
            const especie = $(this).data('especie');
            
            $('#buscar_mascota').val(nombre);
            $('#mascota_id').val(id);
            if (peso !== undefined && peso !== null && peso !== '') {
                $('#peso').val(peso);
            }
            especieMascota = especie ? String(especie).toLowerCase() : null;
            $('#mascota_seleccionada').html(
                `<span class="text-success"><i class="fas fa-check-circle me-1"></i>Mascota seleccionada: ${nombre}</span>`
            );
            $('#resultados_mascota').hide();
        });

        // Búsqueda de veterinarios
        $('#veterinario_search').on('input', function() {
            clearTimeout(timeoutId);
            const query = $(this).val().trim();
            
            if(query.length >= 2) {
                timeoutId = setTimeout(function() {
                    $.ajax({
                        url: '<?= base_url("veterinario/buscar_veterinarios") ?>',
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
                                        data-nombre="${vet.nombre} ${vet.apellido || ''}">
                                        ${vet.nombre} ${vet.apellido || ''}
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
                $('#veterinario_id').val('');
            }
        });

        $(document).on('click', '.veterinario-item', function() {
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            
            $('#veterinario_search').val(nombre);
            $('#veterinario_id').val(id);
            $('#veterinario-suggestions').hide();
            $('#veterinario-error').hide();
        });

        // Autocomplete de tipos de vacunas
        $('#tipo_vacuna').autocomplete({
            minLength: 1,
            source: function(request, response) {
                $.ajax({
                    url: '<?= base_url("veterinario/buscar_tipos_vacuna") ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: { term: request.term, especie: especieMascota },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // Guardar intervalo y recalcular próxima fecha si hay fecha seleccionada
                vacunaIntervaloDias = ui.item.dias_intervalo || null;
                calcularProximaFecha();
            }
        });

        // Al salir del campo, intentar obtener intervalo si no se seleccionó de la lista
        $('#tipo_vacuna').on('blur', function() {
            const nombre = $(this).val().trim();
            if (!vacunaIntervaloDias && nombre.length > 0) {
                $.ajax({
                    url: '<?= base_url("veterinario/vacuna_intervalo") ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: { nombre: nombre, especie: especieMascota },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(res) {
                        vacunaIntervaloDias = res && res.dias_intervalo ? res.dias_intervalo : null;
                        calcularProximaFecha();
                    }
                });
            }
        });

        // Recalcular próxima fecha cuando cambia la fecha de vacunación
        $('#fecha_vacuna').on('change', function() {
            calcularProximaFecha();
        });

        function calcularProximaFecha() {
            const fechaStr = $('#fecha_vacuna').val();
            if (!fechaStr || !vacunaIntervaloDias) return; // sin datos suficientes

            const fecha = new Date(fechaStr + 'T00:00:00');
            fecha.setDate(fecha.getDate() + parseInt(vacunaIntervaloDias, 10));
            const y = fecha.getFullYear();
            const m = String(fecha.getMonth() + 1).padStart(2, '0');
            const d = String(fecha.getDate()).padStart(2, '0');
            $('#proxima_vacuna').val(`${y}-${m}-${d}`);
        }

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#veterinario_search, #veterinario-suggestions').length) {
                $('#veterinario-suggestions').hide();
            }
            if (!$(e.target).closest('#buscar_mascota, #resultados_mascota').length) {
                $('#resultados_mascota').hide();
            }
        });
    });
    </script>
</body>
</html>