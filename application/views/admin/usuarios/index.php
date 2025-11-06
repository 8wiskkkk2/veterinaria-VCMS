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
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Usuarios Registrados</h3>
                <a href="<?= base_url('admin/crear_usuario') ?>" class="btn btn-primary">Nuevo Usuario</a>
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
                    <table id="tabla-usuarios" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>RUT</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($usuarios)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay usuarios registrados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?= $usuario->id ?></td>
                                        <td><?= $usuario->rut ?></td>
                                        <td><?= $usuario->nombre ?></td>
                                        <td><?= $usuario->email ?></td>
                                        <td>
                                            <?php
                                            $roleClass = '';
                                            switch($usuario->role) {
                                                case 'administrador':
                                                    $roleClass = 'bg-danger';
                                                    break;
                                                case 'veterinario':
                                                    $roleClass = 'bg-success';
                                                    break;
                                                case 'recepcionista':
                                                    $roleClass = 'bg-info';
                                                    break;
                                                default:
                                                    $roleClass = 'bg-primary';
                                            }
                                            ?>
                                            <span class="badge <?= $roleClass ?>">
                                                <?= ucfirst($usuario->role) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/editar_usuario/'.$usuario->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="confirmarEliminacion(<?= $usuario->id ?>, '<?= $usuario->nombre ?>')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
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

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro que desea eliminar el usuario <span id="nombreUsuario" class="fw-bold"></span>?
                    <p class="text-danger mt-2">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnEliminar" class="btn btn-danger">Eliminar</a>
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

            // Función para mostrar el modal de confirmación
            window.confirmarEliminacion = function(id, nombre) {
                document.getElementById('nombreUsuario').textContent = nombre;
                document.getElementById('btnEliminar').href = '<?= base_url('admin/eliminar_usuario/') ?>' + id;
                
                var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
                modal.show();
            };

            // Inicialización
            filterTable();
        });
    </script>
</body>
</html>

<!-- Solo mantener el script de búsqueda -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchUsuarios');
    const tabla = document.getElementById('tablaUsuarios');
    const filas = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    searchInput.addEventListener('keyup', function() {
        const termino = searchInput.value.toLowerCase();
        
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const celdas = fila.getElementsByTagName('td');
            let encontrado = false;
            
            for (let j = 0; j < celdas.length - 1; j++) { // Excluimos la columna de acciones
                const texto = celdas[j].textContent.toLowerCase();
                if (texto.indexOf(termino) > -1) {
                    encontrado = true;
                    break;
                }
            }
            
            if (encontrado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        }
    });
});
</script>