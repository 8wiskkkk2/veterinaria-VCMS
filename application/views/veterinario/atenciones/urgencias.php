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
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>Atenciones de Urgencia Atendidas</h3>
            </div>
            <div class="card-body">
                <!-- Controles de búsqueda y paginación -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <select id="recordsPerPage" class="form-select w-auto d-inline-block">
                            <option value="5">5 registros</option>
                            <option value="10" selected>10 registros</option>
                            <option value="15">15 registros</option>
                            <option value="20">20 registros</option>
                        </select>
                    </div>
                </div>

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
                                                    <a href="<?= base_url('veterinario/ver_emergencia/'.$emergencia->id) ?>" 
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

                <!-- Información de registros y paginación -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div id="tableInfo" class="text-muted">
                            Mostrando <span id="startRecord">0</span> a <span id="endRecord">0</span> de <span id="totalRecords">0</span> registros
                        </div>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation" class="float-md-end">
                            <ul id="pagination" class="pagination pagination-sm">
                                <!-- La paginación se generará dinámicamente -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let recordsPerPage = 10;
            const table = $('#tabla-urgencias');
            const tbody = table.find('tbody');
            const rows = tbody.find('tr').toArray();
            const totalRows = rows.length;

            function filterTable() {
                const searchText = $('#searchInput').val().toLowerCase();
                const filteredRows = rows.filter(row => {
                    const text = $(row).text().toLowerCase();
                    return text.includes(searchText);
                });

                displayRows(filteredRows);
                updatePagination(filteredRows.length);
            }

            function displayRows(rowsToDisplay) {
                const start = (currentPage - 1) * recordsPerPage;
                const end = start + recordsPerPage;
                const pageRows = rowsToDisplay.slice(start, end);

                tbody.empty();
                pageRows.forEach(row => tbody.append(row));

                // Actualizar información de registros
                $('#startRecord').text(rowsToDisplay.length ? start + 1 : 0);
                $('#endRecord').text(Math.min(end, rowsToDisplay.length));
                $('#totalRecords').text(rowsToDisplay.length);
            }

            function updatePagination(filteredTotal) {
                const totalPages = Math.ceil(filteredTotal / recordsPerPage);
                const pagination = $('#pagination');
                pagination.empty();

                // Botón Anterior
                pagination.append(`
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                    </li>
                `);

                // Páginas numeradas
                for (let i = 1; i <= totalPages; i++) {
                    pagination.append(`
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Botón Siguiente
                pagination.append(`
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                    </li>
                `);
            }

            // Event Listeners
            $('#searchInput').on('input', function() {
                currentPage = 1;
                filterTable();
            });

            $('#recordsPerPage').on('change', function() {
                recordsPerPage = parseInt($(this).val());
                currentPage = 1;
                filterTable();
            });

            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault();
                const newPage = parseInt($(this).data('page'));
                if (newPage > 0) {
                    currentPage = newPage;
                    filterTable();
                }
            });

            // Inicialización
            filterTable();
        });
    </script>
</body>
</html>