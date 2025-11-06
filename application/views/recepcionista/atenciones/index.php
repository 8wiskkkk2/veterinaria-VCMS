<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>

    <style>
        .card {
            transition: all 0.3s ease;
            background-color: white !important;
            border: 1px solid #dee2e6;
        }
        
        .card-hover-danger:hover {
            background-color: #dc3545 !important;
            color: white !important;
        }
        
        .card-hover-warning:hover {
            background-color: #ffc107 !important;
            color: black !important;
        }
        
        .card-hover-dark:hover {
            background-color: #212529 !important;
            color: white !important;
        }
        
        .card-hover-primary:hover {
            background-color: #0d6efd !important;
            color: white !important;
        }
        
        .card-hover-success:hover {
            background-color: #198754 !important;
            color: white !important;
        }

        .card-text, .card-title {
            color: #333;
        }

        .card:hover .card-text, 
        .card:hover .card-title {
            color: inherit;
        }

        .fa-2x {
            color: #666;
        }

        .card:hover .fa-2x {
            color: inherit;
        }
    </style>

    <div class="container mt-4">
        <!-- Tarjetas de Historial -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="<?= base_url('recepcionista/atenciones_urgencias') ?>" class="text-decoration-none">
                    <div class="card h-100 card-hover-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Urgencias</h5>
                                    <p class="card-text">Historial de casos que requirieron atención inmediata</p>
                                </div>
                                <i class="fas fa-ambulance fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 mb-3">
                <a href="<?= base_url('recepcionista/atenciones/sedaciones') ?>" class="text-decoration-none">
                    <div class="card h-100 card-hover-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Sedaciones</h5>
                                    <p class="card-text">Registro de procedimientos con sedación realizados</p>
                                </div>
                                <i class="fas fa-syringe fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 mb-3">
                <a href="<?= base_url('recepcionista/atenciones_eutanasias') ?>" class="text-decoration-none">
                    <div class="card h-100 card-hover-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Eutanasias</h5>
                                    <p class="card-text">Historial de procedimientos de eutanasia humanitaria</p>
                                </div>
                                <i class="fas fa-heart-broken fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 mb-3">
                <a href="<?= base_url('recepcionista/atenciones/citas') ?>" class="text-decoration-none">
                    <div class="card h-100 card-hover-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Citas</h5>
                                    <p class="card-text">Registro completo de citas médicas programadas</p>
                                </div>
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12 mb-3">
                <a href="<?= base_url('recepcionista/atenciones/cirugias') ?>" class="text-decoration-none">
                    <div class="card h-100 card-hover-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Cirugías</h5>
                                    <p class="card-text">Historial de procedimientos quirúrgicos realizados</p>
                                </div>
                                <i class="fas fa-cut fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


    <!-- Scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var tabla = $('#tablaAtenciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });

            $('#tipoAtencion').change(function() {
                var tipo = $(this).val();
                // Realizar la petición AJAX según el tipo seleccionado
                $.ajax({
                    url: '<?= base_url('recepcionista/obtener_atenciones') ?>',
                    type: 'POST',
                    data: { tipo: tipo },
                    success: function(response) {
                        tabla.clear();
                        tabla.rows.add(JSON.parse(response));
                        tabla.draw();
                    },
                    error: function(error) {
                        console.error('Error al cargar los datos:', error);
                    }
                });
            });

            // Trigger inicial para cargar todas las atenciones
            $('#tipoAtencion').trigger('change');

            // Función para actualizar los contadores
            function actualizarContadores() {
                $.ajax({
                    url: '<?= base_url('recepcionista/obtener_contadores') ?>',
                    type: 'GET',
                    success: function(response) {
                        const contadores = JSON.parse(response);
                        $('#contadorUrgencias').text(contadores.urgencias);
                        $('#contadorSedaciones').text(contadores.sedaciones);
                        $('#contadorEutanasias').text(contadores.eutanasias);
                        $('#contadorCitas').text(contadores.citas);
                        $('#contadorCirugias').text(contadores.cirugias);
                    },
                    error: function(error) {
                        console.error('Error al obtener contadores:', error);
                    }
                });
            }

            // Actualizar contadores al cargar la página
            actualizarContadores();

            // Actualizar contadores cada 5 minutos
            setInterval(actualizarContadores, 300000);
        });
    </script>

    <!-- Scripts de inicialización de DataTables -->
    <script>
        $(document).ready(function() {
            $('#tabla-atenciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [[4, "desc"]], // Ordenar por fecha de manera descendente
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
</body>
</html>