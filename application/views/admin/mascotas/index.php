<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Mascotas Registradas</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seleccionarPropietarioModal">
                    Nueva Mascota
                </button>
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
                    <table id="tabla-mascotas" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Especie</th>
                                <th>Raza</th>
                                <th>Propietario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($mascotas)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay mascotas registradas</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($mascotas as $mascota): ?>
                                    <tr>
                                        <td><?= $mascota->id ?></td>
                                        <td><?= $mascota->nombre ?></td>
                                        <td><?= $mascota->especie ?></td>
                                        <td><?= $mascota->raza ?></td>
                                        <td><?= $mascota->nombre_propietario ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/editar_mascota/'.$mascota->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="confirmarEliminacion(<?= $mascota->id ?>, '<?= $mascota->nombre ?>')">
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
                    ¿Está seguro que desea eliminar la mascota <span id="nombreMascota" class="fw-bold"></span>?
                    <p class="text-danger mt-2">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnEliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para seleccionar propietario -->
    <div class="modal fade" id="seleccionarPropietarioModal" tabindex="-1" aria-labelledby="seleccionarPropietarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seleccionarPropietarioModalLabel">Seleccionar Propietario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Seleccione el propietario para la nueva mascota:</p>
                    
                    <div class="mb-3">
                        <input type="text" id="buscarPropietario" class="form-control" placeholder="Buscar propietario...">
                    </div>
                    
                    <div class="list-group" id="listaPropietarios">
                        <?php foreach($propietarios as $propietario): ?>
                            <a href="<?= base_url('admin/crear_mascota/'.$propietario->id) ?>" class="list-group-item list-group-item-action">
                                <?= $propietario->nombre ?> (<?= $propietario->rut ?>)
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
            const table = $('#tabla-mascotas');
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
                document.getElementById('nombreMascota').textContent = nombre;
                document.getElementById('btnEliminar').href = '<?= base_url('admin/eliminar_mascota/') ?>' + id;
                
                var modal = new bootstrap.Modal(document.getElementById('eliminarModal'));
                modal.show();
            };

            // Búsqueda de propietarios
            $('#buscarPropietario').on('keyup', function() {
                const termino = $(this).val().toLowerCase();
                $('#listaPropietarios a').each(function() {
                    const texto = $(this).text().toLowerCase();
                    $(this).toggle(texto.indexOf(termino) > -1);
                });
            });

            // Inicialización
            filterTable();
        });
    </script>
</body>
</html>

<!-- Agregar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contar mascotas por tipo
    const mascotas = <?= json_encode($mascotas) ?>;
    const tiposMascota = {
        'perro': 0,
        'gato': 0,
        'otro': 0
    };
    
    // Contar cada tipo de mascota
    mascotas.forEach(mascota => {
        const especie = mascota.especie.toLowerCase();
        if (especie.includes('perro')) {
            tiposMascota.perro++;
        } else if (especie.includes('gato')) {
            tiposMascota.gato++;
        } else {
            tiposMascota.otro++;
        }
    });
    
    // Crear el gráfico de torta
    const ctx = document.getElementById('mascotasPorTipoChart').getContext('2d');
    const mascotasPorTipoChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Perros', 'Gatos', 'Otros'],
            datasets: [{
                label: 'Tipos de Mascotas',
                data: [tiposMascota.perro, tiposMascota.gato, tiposMascota.otro],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribución por Tipo de Mascota'
                }
            }
        }
    });
});
</script>

<!-- Modal para seleccionar propietario -->
<div class="modal fade" id="seleccionarPropietarioModal" tabindex="-1" aria-labelledby="seleccionarPropietarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seleccionarPropietarioModalLabel">Seleccionar Propietario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Seleccione el propietario para la nueva mascota:</p>
                
                <div class="mb-3">
                    <input type="text" id="buscarPropietario" class="form-control" placeholder="Buscar propietario...">
                </div>
                
                <div class="list-group" id="listaPropietarios">
                    <?php foreach($propietarios as $propietario): ?>
                        <a href="<?= base_url('admin/crear_mascota/'.$propietario->id) ?>" class="list-group-item list-group-item-action">
                            <?= $propietario->nombre ?> (<?= $propietario->rut ?>)
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para búsqueda de propietarios -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarPropietario = document.getElementById('buscarPropietario');
    const listaPropietarios = document.getElementById('listaPropietarios').getElementsByTagName('a');
    
    buscarPropietario.addEventListener('keyup', function() {
        const termino = buscarPropietario.value.toLowerCase();
        
        for (let i = 0; i < listaPropietarios.length; i++) {
            const texto = listaPropietarios[i].textContent.toLowerCase();
            if (texto.indexOf(termino) > -1) {
                listaPropietarios[i].style.display = '';
            } else {
                listaPropietarios[i].style.display = 'none';
            }
        }
    });
});
</script>