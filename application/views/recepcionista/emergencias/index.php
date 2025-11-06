<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones de Urgencia - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

    <?php if ($this->session->flashdata('success')): ?>
        
    <?php endif; ?>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-ambulance me-2"></i>Atenciones de Urgencia</h3>
                <a href="<?= base_url('recepcionista/crear_emergencia') ?>" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i>Nueva Atención
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabla-emergencias" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Mascota</th>
                                <th>Especie</th>
                                <th>Nivel Urgencia</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($emergencias)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay atenciones de emergencia pendientes</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($emergencias as $emergencia): ?>
                                    <?php if($emergencia->estado == 'pendiente'): ?>
                                        <tr>
                                            <td><?= $emergencia->nombre_mascota ?></td>
                                            <td><?= $emergencia->especie ?></td>
                                            <td>
                                                <span class="badge <?php
                                                    switch(strtolower($emergencia->nivel_urgencia)) {
                                                        case 'alta':
                                                            echo 'bg-danger';
                                                            break;
                                                        case 'media':
                                                            echo 'bg-warning';
                                                            break;
                                                        case 'baja':
                                                            echo 'bg-success';
                                                            break;
                                                        default:
                                                            echo 'bg-secondary';
                                                    }
                                                ?>">
                                                    <?= ucfirst($emergencia->nivel_urgencia) ?>
                                                </span>
                                            </td>
                                            <td><?= $emergencia->motivo_consulta ?></td>
                                            <td>
                                                <span class="badge bg-warning">Pendiente</span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('recepcionista/ver_emergencia/'.$emergencia->id) ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#tabla-emergencias').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pageLength": 10,
                "order": [[2, "asc"]], // Ordenar por nivel de urgencia
                "responsive": true,
                "columnDefs": [{
                    "targets": 2,
                    "type": "string",
                    "render": function(data, type, row) {
                        if (type === 'sort') {
                            // Asignar valores numéricos para el ordenamiento (alta = 1, media = 2, baja = 3)
                            var nivel = data.toLowerCase();
                            if (nivel.includes('alta')) return 1;
                            if (nivel.includes('media')) return 2;
                            if (nivel.includes('baja')) return 3;
                            return 4;
                        }
                        return data;
                    }
                }]
            });
        });
    </script>
</body>
</html>