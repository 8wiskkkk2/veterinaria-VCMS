<?php $this->load->view('veterinario/templates/navbar'); ?>

<div class="container mt-4">
    <h2 class="mb-4">Panel Veterinario</h2>
    <div id="mensaje-bienvenida" class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">¡Bienvenido, <?= $this->session->userdata('nombre') ?>!</h4>
        <p class="mb-0">Has iniciado sesión como veterinario en el sistema de la Veterinaria Municipal.</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-ambulance fa-3x text-danger mb-3"></i>
                    <h5 class="card-title">Urgencias Pendientes</h5>
                    <p class="card-text text-muted">
                        <span id="urgencias-count" class="badge bg-danger"><?= count(array_filter($emergencias, function($e) { return $e->estado == 'pendiente'; })) ?></span> atenciones pendientes
                    </p>
                    <a href="<?= base_url('veterinario/emergencias') ?>" class="btn btn-danger">
                        <i class="fas fa-heartbeat me-2"></i>Ver Urgencias
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-syringe fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Registro de Vacunas</h5>
                    <p class="card-text text-muted">Registra nuevas vacunas para las mascotas</p>
                    <a href="<?= base_url('veterinario/vacunas') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ver Registros
                    </a>
                </div>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-pills fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Desparacitaciones</h5>
                    <p class="card-text text-muted">Gestiona los registros de desparacitación</p>
                    <a href="<?= base_url('veterinario/desparacitaciones') ?>" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Ver Registros
                    </a>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
$(document).ready(function() {
    function actualizarDatos() {
        $.get('<?= base_url("veterinario/get_urgencias_pendientes_veterinario") ?>', function(data) {
            $('#urgencias-count').text(data.count);
        });

        $.get('<?= base_url("veterinario/get_total_mascotas_veterinario") ?>', function(data) {
            $('#mascotas-count').text(data.count);
        });

        tabla.ajax.reload(null, false);
    }

    var tabla = $('#tablaUrgencias').DataTable({
        "ajax": {
            "url": '<?= base_url("veterinario/get_urgencias_tabla_veterinario") ?>',
            "dataSrc": "data"
        },
        "columns": [
            {
                "data": "fecha",
                "render": function(data) {
                    return moment(data).format('DD/MM/YYYY');
                }
            },
            {
                "data": "fecha",
                "render": function(data) {
                    return moment(data).format('HH:mm');
                }
            },
            {"data": "nombre_mascota"},
            {"data": "nombre_propietario"},
            {"data": "descripcion"},
            {
                "data": null,
                "render": function() {
                    return '<span class="badge bg-warning text-dark">Pendiente</span>';
                }
            },
            {
                "data": "id",
                "render": function(data) {
                    return `
                        <a href="<?= base_url('veterinario/urgencias/atender/') ?>${data}" class="btn btn-primary btn-sm">
                            <i class="fas fa-stethoscope"></i>
                        </a>
                        <a href="<?= base_url('veterinario/urgencias/ver/') ?>${data}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                    `;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "order": [[0, "desc"], [1, "desc"]]
    });

    actualizarDatos();
    setInterval(actualizarDatos, 10000);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var mensajeBienvenida = document.getElementById('mensaje-bienvenida');
        if (mensajeBienvenida) {
            mensajeBienvenida.classList.remove('show');
            setTimeout(function() {
                mensajeBienvenida.style.display = 'none';
            }, 150); 
        }
    }, 3000); 
});
</script>