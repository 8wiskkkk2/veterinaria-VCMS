<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Desparacitación - Veterinaria</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
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
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">
                    <i class="fas fa-pills me-2"></i>Registrar Nueva Desparacitación
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('veterinario/guardar_desparacitacion') ?>" method="POST" id="form-desparacitacion" class="needs-validation" novalidate>
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
                            <label for="tratamiento" class="form-label">Tratamiento <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                <input type="text" class="form-control" id="tratamiento" name="tratamiento"
                                       placeholder="Ingrese el tratamiento" required>
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
                            <label for="fecha" class="form-label">Fecha de Tratamiento <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="proximo_tratamiento" class="form-label">Próximo Tratamiento <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                                <input type="date" class="form-control" id="proximo_tratamiento" name="proximo_tratamiento" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar Desparacitación
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
        let especieSeleccionada = null;
        let diasIntervaloActual = 0;
        
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

        $(document).on('click', '.mascota-item', function() {
            const id = $(this).data('id');
            const nombre = $(this).data('nombre');
            const peso = $(this).data('peso');
            especieSeleccionada = ($(this).data('especie') || '').toString().toLowerCase();
            
            $('#buscar_mascota').val(nombre);
            $('#mascota_id').val(id);
            if (peso !== undefined && peso !== null && peso !== '') {
                $('#peso').val(peso);
            }
            $('#mascota_seleccionada').html(
                `<span class="text-success"><i class="fas fa-check-circle me-1"></i>Mascota seleccionada: ${nombre}</span>`
            );
            $('#resultados_mascota').hide();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#buscar_mascota, #resultados_mascota').length) {
                $('#resultados_mascota').hide();
            }
        });
        // Autocomplete tratamientos según especie
        $('#tratamiento').autocomplete({
            minLength: 1,
            source: function(request, response) {
                if (!especieSeleccionada) {
                    response([]);
                    return;
                }
                $.ajax({
                    url: '<?= base_url("veterinario/buscar_tipos_desparacitacion") ?>',
                    type: 'GET',
                    dataType: 'json',
                    data: { term: request.term, especie: especieSeleccionada },
                    success: function(data) {
                        response(data || []);
                    },
                    error: function(xhr) {
                        console.error('Error buscando tratamientos:', xhr.responseText);
                        response([]);
                    }
                });
            },
            select: function(event, ui) {
                $('#tratamiento').val(ui.item.value);
                const dias = parseInt(ui.item.dias_intervalo || 0, 10);
                diasIntervaloActual = dias;
                if (dias > 0) {
                    // Calcular próximo tratamiento únicamente si hay fecha base
                    const fechaBaseStr = $('#fecha').val();
                    if (fechaBaseStr) {
                        const fechaBase = new Date(fechaBaseStr);
                        fechaBase.setDate(fechaBase.getDate() + dias);
                        const proximoISO = fechaBase.toISOString().slice(0,10);
                        $('#proximo_tratamiento').val(proximoISO);
                    }
                }
                return false; // evita que jQuery UI reemplace el valor
            }
        });

        // Recalcular próxima fecha si cambia la fecha base
        $('#fecha').on('change', function() {
            const dias = parseInt(diasIntervaloActual || 0, 10);
            const fStr = $(this).val();
            if (dias > 0 && fStr) {
                const f = new Date(fStr);
                f.setDate(f.getDate() + dias);
                $('#proximo_tratamiento').val(f.toISOString().slice(0,10));
            }
        });
    });
    </script>
</body>
</html>