<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2><?= $titulo ?></h2>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <a href="<?= base_url('recepcionista/crear_usuario') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nuevo Usuario
                    </a>
                </div>

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
                    <table id="tabla-usuarios" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($usuarios)): ?>
                                <?php foreach($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario->nombre ?></td>
                                        <td><?= $usuario->email ?></td>
                                        <td><?= $usuario->telefono ?></td>
                                        <td><?= $usuario->direccion ?></td>
                                        <td>
                                            <a href="<?= base_url('recepcionista/editar_usuario/' . $usuario->id) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay usuarios registrados</td>
                                </tr>
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
            const table = $('#tabla-usuarios');
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
</div>
