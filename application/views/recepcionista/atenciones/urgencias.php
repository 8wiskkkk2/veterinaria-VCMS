<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgencias Atendidas - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>Atenciones de Urgencia Atendidas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabla-urgencias" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha Atención</th>
                                <th>Mascota</th>
                                <th>Especie</th>
                                <th>Estado</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($emergencias)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay atenciones de urgencia atendidas registradas</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($emergencias as $emergencia): ?>
                                    <?php if($emergencia->estado == 'atendido'): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($emergencia->fecha_registro)) ?></td>
                                            <td><?= $emergencia->nombre_mascota ?></td>
                                            <td><?= $emergencia->especie ?></td>
                                            <td>
                                                <span class="badge <?php
                                                    switch($emergencia->estado) {
                                                        case 'atendido':
                                                            echo 'bg-success';
                                                            break;
                                                        case 'pendiente':
                                                            echo 'bg-warning';
                                                            break;
                                                        default:
                                                            echo 'bg-secondary';
                                                    }
                                                ?>">
                                                    <?= ucfirst($emergencia->estado) ?>
                                                </span>
                                            </td>
                                            <td><?= $emergencia->motivo_consulta ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('recepcionista/ver_emergencia/'.$emergencia->id) ?>" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Ver Detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
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
            $('#tabla-urgencias').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pageLength": 10,
                "order": [[0, "desc"]], // Ordenar por fecha de atención
                "responsive": true
            });

            // Función para imprimir
            $('.imprimir-urgencia').click(function() {
                var id = $(this).data('id');
                var printWindow = window.open('<?= base_url('recepcionista/imprimir_urgencia/') ?>' + id, '_blank');
                printWindow.onload = function() {
                    printWindow.print();
                };
            });
        });
    </script>
</body>
</html>