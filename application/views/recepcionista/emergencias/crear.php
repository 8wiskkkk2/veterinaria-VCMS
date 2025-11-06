<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Atención de Urgencia - Veterinaria</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background-color: #dc3545;
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            padding: 0.3rem 0.5rem;
            font-size: 0.9rem;
        }

        textarea.form-control {
            min-height: 60px;
            height: 60px !important;
        }

        .card-body {
            padding: 0.8rem;
        }

        .mb-3 {
            margin-bottom: 0.5rem !important;
        }

        .mb-4 {
            margin-bottom: 0.8rem !important;
        }

        .form-label {
            margin-bottom: 0.2rem;
            font-size: 0.9rem;
        }

        .border-bottom.border-dark {
            height: 60px !important;
        }

        @media print {
            .no-print,
            .btn,
            #resultados_propietarios,
            #resultados_mascotas,
            .d-flex.justify-content-end,
            .veterinaria-title,
            .veterinaria-municipal,
            .card-header {  
                display: none !important;
            }
            .veterinaria-municipal {
                display: none !important;
            }

            .ms-3 {
                display: block !important;
            }

            .form-label.text-white {
                color: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            * {
                font-family: Arial, sans-serif !important;
            }

            .card-body > div {
                page-break-inside: avoid !important;
            }

            .fas.fa-paw {
                color: #dc3545 !important;
                display: block !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        .cursor-pointer {
        cursor: pointer;
    }
    
    .cursor-pointer:hover {
        background-color: #f8f9fa;
    }
    
    #resultados_propietarios {
        margin-top: 2px;
    }
    
    .propietario-item {
        transition: background-color 0.2s;
    }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div id="contenido-imprimible">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-ambulance me-2"></i>Nueva Atención de Urgencia
                        </h3>
                        <div class="d-flex align-items-center">
                            <button onclick="exportarPDF()" class="btn btn-danger me-2 no-print">
                                <i class="fas fa-file-pdf"></i> Generar PDF
                            </button>
                            <button onclick="window.print()" class="btn btn-light me-2 no-print">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                            <div class="d-flex justify-content-end mb-4">
                            <div class="text-end">
                                <label class="form-label">Fecha de Ingreso:</label>
                                <div class="fw-bold"><?= date('d/m/Y') ?></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('recepcionista/guardar_emergencia') ?>" method="POST">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Información del Propietario</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="buscar_propietario" class="form-label">Nombre y Rut de Propietario</label>
                                    <input type="text" class="form-control" id="buscar_propietario" placeholder="Buscar Por Nombre o Rut del Propietario">
                                    <div id="resultados_propietarios" class="list-group mt-2"></div>
                                </div>
                                <input type="hidden" name="id_propietario" id="id_propietario">
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="telefono_propietario" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono_propietario" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="direccion_propietario" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_propietario" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Información de la Mascota</h5>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="buscar_mascota" class="form-label">Buscar Mascota</label>
                                    <input type="text" class="form-control" id="buscar_mascota" placeholder="Ingrese nombre de la mascota">
                                    <div id="resultados_mascotas" class="list-group mt-2"></div>
                                </div>
                                <input type="hidden" id="id_mascota" name="id_mascota">
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="especie_mascota" class="form-label">Especie</label>
                                    <input type="text" class="form-control" id="especie_mascota" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="raza_mascota" class="form-label">Raza</label>
                                    <input type="text" class="form-control" id="raza_mascota" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edad_mascota" class="form-label">Edad</label>
                                    <input type="text" class="form-control" id="edad_mascota" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sexo_mascota" class="form-label">Sexo</label>
                                    <input type="text" class="form-control" id="sexo_mascota" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="color_mascota" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="color_mascota" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="border-bottom pb-2">Detalles de la Atención de Urgencia</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="motivo_consulta" class="form-label">Motivo de Consulta</label>
                                    <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nivel_urgencia" class="form-label">Nivel de Urgencia</label>
                                    <select class="form-control" id="nivel_urgencia" name="nivel_urgencia" required>
                                        <option value="">Seleccione nivel de urgencia</option>
                                        <option value="baja">Baja</option>
                                        <option value="media">Media</option>
                                        <option value="alta">Alta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="anamnesis" class="form-label">Anamnesis</label>
                                    <textarea class="form-control" id="anamnesis" name="anamnesis" rows="2" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                                    <textarea class="form-control" id="diagnostico" name="diagnostico" rows="2" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="tratamiento" class="form-label">Tratamiento</label>
                                    <textarea class="form-control" id="tratamiento" name="tratamiento" rows="2" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="indicaciones" class="form-label">Indicaciones</label>
                                    <textarea class="form-control" id="indicaciones" name="indicaciones" rows="2"readonly ></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="2" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="border-bottom border-dark"></div>
                                    <div class="text-center mt-2">
                                        <small>Firma Propietario <span id="nombre_firma_propietario"></span></small><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="border-bottom border-dark"></div>
                                    <div class="text-center mt-2">                                        <small>Firma Veterinario</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Atención
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let timeoutId;
            
            $('#buscar_propietario').on('input', function() {
                clearTimeout(timeoutId);
                const query = $(this).val().trim();
                
                if(query.length >= 2) {
                    timeoutId = setTimeout(function() {
                        $.ajax({
                            url: '<?= base_url('recepcionista/buscar_propietarios') ?>',
                            method: 'POST',
                            data: { query: query },
                            success: function(response) {
                                try {
                                    const propietarios = JSON.parse(response);
                                    let html = '';
                                    
                                    if(propietarios.length > 0) {
                                        propietarios.forEach(function(propietario) {
                                            // Modificamos la forma en que se muestra y filtra la información
                                            const nombreCompleto = propietario.nombre.toLowerCase();
                                            const rut = propietario.rut.toLowerCase();
                                            const searchQuery = query.toLowerCase();
                                            
                                            if(nombreCompleto.includes(searchQuery) || rut.includes(searchQuery)) {
                                                html += `<div class="list-group-item list-group-item-action cursor-pointer propietario-item" 
                                                        data-rut="${propietario.rut}" 
                                                        data-nombre="${propietario.nombre}"
                                                        data-direccion="${propietario.direccion}"
                                                        data-telefono="${propietario.telefono}">
                                                        ${propietario.nombre} - ${propietario.rut}
                                                    </div>`;
                                            }
                                        });
                                    }
                                    
                                    $('#resultados_propietarios').html(html);
                                    $('#resultados_propietarios').show();
                                } catch(e) {
                                    console.error('Error al parsear la respuesta:', e);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la petición AJAX:', error);
                            }
                        });
                    }, 300);
                } else {
                    $('#resultados_propietarios').hide();
                }
            });

            $(document).on('click', '#resultados_propietarios .list-group-item-action', function() {
                const id = $(this).data('id');
                const nombre = $(this).data('nombre');
                const rut = $(this).data('rut');
                const telefono = $(this).data('telefono');
                const direccion = $(this).data('direccion');

                $('#id_propietario').val(id);
                $('#buscar_propietario').val(nombre + ' - ' + rut);
                $('#rut_propietario').val(rut);
                $('#telefono_propietario').val(telefono);
                $('#direccion_propietario').val(direccion);
                $('#nombre_firma_propietario').text(nombre);
                $('#resultados_propietarios').hide();
            });
        });

    $('#buscar_mascota').on('input', function() {
        clearTimeout(timeoutId);
        const query = $(this).val().trim();
        
        if(query.length >= 2) {
            timeoutId = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url('recepcionista/buscar_mascotas') ?>',
                    method: 'POST',
                    data: { query: query },
                    success: function(response) {
                        try {
                            const mascotas = JSON.parse(response);
                            let html = '';
                            
                            if(mascotas.length > 0) {
                                mascotas.forEach(function(mascota) {
                                    html += `<div class="list-group-item list-group-item-action" 
                                            data-id="${mascota.id}"
                                            data-nombre="${mascota.nombre}"
                                            data-especie="${mascota.especie}"
                                            data-raza="${mascota.raza}"
                                            data-edad="${mascota.edad_aproximada}"
                                            data-sexo="${mascota.sexo}"
                                            data-color="${mascota.color}"
                                            style="cursor: pointer;">
                                            ${mascota.nombre} - ${mascota.sexo} - ${mascota.color} - ${mascota.nombre_propietario} (${mascota.rut_propietario})
                                        </div>`;
                                });
                            } else {
                                html = '<div class="list-group-item">No se encontraron resultados</div>';
                            }
                            
                            $('#resultados_mascotas').html(html).show();
                        } catch(e) {
                            console.error('Error al procesar la respuesta:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX:', error);
                    }
                });
            }, 300);
        } else {
            $('#resultados_mascotas').hide();
        }
    });

    $(document).on('click', '#resultados_mascotas .list-group-item-action', function() {
        const mascota = {
            id: $(this).data('id'),
            nombre: $(this).data('nombre'),
            especie: $(this).data('especie'),
            raza: $(this).data('raza'),
            edad: $(this).data('edad'),
            sexo: $(this).data('sexo'),
            color: $(this).data('color')
        };
    
        $('#id_mascota').val(mascota.id);
        $('#buscar_mascota').val(mascota.nombre);
        $('#especie_mascota').val(mascota.especie);
        $('#raza_mascota').val(mascota.raza);
        $('#edad_mascota').val(mascota.edad);
        $('#sexo_mascota').val(mascota.sexo);
        $('#color_mascota').val(mascota.color);
        
        $('#resultados_mascotas').hide();
    });

    $('form').on('submit', function(e) {
        if (!$('#id_mascota').val()) {
            e.preventDefault();
            alert('Debe seleccionar una mascota');
            return false;
        }
        
        if (!$('#nivel_urgencia').val()) {
            e.preventDefault();
            alert('Debe seleccionar un nivel de urgencia');
            return false;
        }
        
        const formData = $(this).serializeArray();
        console.log('Datos del formulario:', formData);
    });

    let timeoutId;

    $('#buscar_mascota').on('input', function() {
        clearTimeout(timeoutId);
        const query = $(this).val().trim();
        
        if(query.length >= 2) {
            timeoutId = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url('recepcionista/buscar_mascotas') ?>',
                    method: 'POST',
                    data: { query: query },
                    success: function(response) {
                        try {
                            const mascotas = JSON.parse(response);
                            let html = '';
                            
                            if(mascotas.length > 0) {
                                mascotas.forEach(function(mascota) {
                                    html += `<div class="list-group-item list-group-item-action" 
                                            data-id="${mascota.id}"
                                            data-nombre="${mascota.nombre}"
                                            data-especie="${mascota.especie}"
                                            data-raza="${mascota.raza}"
                                            data-edad="${mascota.edad_aproximada}"
                                            data-sexo="${mascota.sexo}"
                                            data-color="${mascota.color}"
                                            style="cursor: pointer;">
                                            ${mascota.nombre} -  ${mascota.rut_propietario}
                                        </div>`;
                                });
                            } else {
                                html = '<div class="list-group-item">No se encontraron resultados</div>';
                            }
                            
                            $('#resultados_mascotas').html(html).show();
                        } catch(e) {
                            console.error('Error al procesar la respuesta:', e);
                            $('#resultados_mascotas').html('<div class="list-group-item text-danger">Error al procesar los resultados</div>').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX:', error);
                        $('#resultados_mascotas').html('<div class="list-group-item text-danger">Error en la búsqueda</div>').show();
                    }
                });
            }, 300);
        } else {
            $('#resultados_mascotas').hide();
        }
    });

    $(document).on('click', '#resultados_mascotas .list-group-item-action', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const especie = $(this).data('especie');
        const raza = $(this).data('raza');
        const edad = $(this).data('edad');
        const sexo = $(this).data('sexo');
        const color = $(this).data('color');

        $('#id_mascota').val(id);
        $('#buscar_mascota').val(nombre);
        $('#nombre_mascota').val(nombre);
        $('#especie_mascota').val(especie);
        $('#raza_mascota').val(raza);
        $('#edad_mascota').val(edad);
        $('#sexo_mascota').val(sexo);
        $('#color_mascota').val(color);
        
        $('#resultados_mascotas').hide();
    });
    $(document).ready(function() {
    $('#formulario_emergencia').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= base_url('recepcionista/guardar_emergencia') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if(result.success) {
                        window.location.href = '<?= base_url('recepcionista/emergencias') ?>?success=true';
                    } else {
                        alert('Error al guardar la emergencia: ' + result.message);
                    }
                } catch(e) {
                    alert('Error al procesar la respuesta del servidor');
                }
            },
            error: function() {
                alert('Error al conectar con el servidor');
            }
        });
    });
});
        function exportarPDF() {
        const element = document.getElementById('contenido-imprimible');
        const opt = {
            margin: [10, 10, 10, 10],
            filename: 'atencion-urgencia.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 2,
                useCORS: true,
                letterRendering: true
            },
            jsPDF: { 
                unit: 'mm',
                format: 'letter',
                orientation: 'portrait'
            },
            pagebreak: { mode: 'avoid-all' }
        };

        const printStyles = document.createElement('style');
        printStyles.textContent = `
            .no-print,
            .btn,
            #resultados_propietarios,
            #resultados_mascotas,
            .d-flex.justify-content-end,
            .card-header {
                display: none !important;
            }
            
            .form-control {
                padding: 0.2rem 0.4rem !important;
                font-size: 10pt !important;
                line-height: 1.1 !important;
                border: 1px solid #000 !important;
            }

            textarea.form-control {
                height: 50px !important;
                min-height: 50px !important;
            }

            .card-body {
                padding: 0.6rem !important;
            }

            .mb-3 {
                margin-bottom: 0.3rem !important;
            }

            .mb-4 {
                margin-bottom: 0.6rem !important;
            }

            * {
                font-family: Arial, sans-serif !important;
            }
        `;
        
        element.appendChild(printStyles);

        html2pdf()
            .set(opt)
            .from(element)
            .save()
            .then(() => {
                element.removeChild(printStyles);
            })
            .catch(error => {
                console.error('Error al generar el PDF:', error);
                element.removeChild(printStyles);
            });
    }
    </script>

</html>

