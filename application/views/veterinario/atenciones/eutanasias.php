<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorizaciones de Eutanasia - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-heartbeat me-2"></i>Autorizaciones de Eutanasia
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <select id="entriesPerPage" class="form-select w-auto d-inline-block">
                            <option value="5">5 registros</option>
                            <option value="10" selected>10 registros</option>
                            <option value="25">25 registros</option>
                            <option value="50">50 registros</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabla-eutanasias" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha Ingreso</th>
                                <th>Mascota</th>
                                <th>Propietario</th>
                                <th>Motivo</th>
                                <th>Atendido por</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($autorizaciones) && !empty($autorizaciones)): ?>
                                <?php foreach($autorizaciones as $autorizacion): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($autorizacion->fecha)) ?></td>
                                        <td><?= $autorizacion->nombre_mascota ?></td>
                                        <td><?= $autorizacion->nombre_propietario ?></td>
                                        <td><?= $autorizacion->motivo ?></td>
                                        <td><?= isset($autorizacion->nombre_veterinario) ? $autorizacion->nombre_veterinario : 'No asignado' ?></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                Ingresado
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-danger btn-sm" onclick='generarPDF(<?= json_encode($autorizacion) ?>'>
                                                    <i class="fas fa-file-pdf"></i> 
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="imprimirAutorizacion(<?= htmlspecialchars(json_encode($autorizacion)) ?>)">
                                                    <i class="fas fa-print"></i> 
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay autorizaciones de eutanasia registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div id="tableInfo" class="text-muted">
                            Mostrando <span id="startIndex">0</span> a <span id="endIndex">0</span> de <span id="totalEntries">0</span> registros
                        </div>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation" class="float-end">
                            <ul class="pagination" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('#tabla-eutanasias');
            const searchInput = document.querySelector('#searchInput');
            const entriesPerPage = document.querySelector('#entriesPerPage');
            const tableInfo = document.querySelector('#tableInfo');
            const startIndex = document.querySelector('#startIndex');
            const endIndex = document.querySelector('#endIndex');
            const totalEntries = document.querySelector('#totalEntries');
            const pagination = document.querySelector('#pagination');

            let currentPage = 1;
            let rows = Array.from(table.querySelectorAll('tbody tr'));

            function displayTableData() {
                const perPage = parseInt(entriesPerPage.value);
                const searchTerm = searchInput.value.toLowerCase();

                // Filtrar filas según término de búsqueda
                const filteredRows = rows.filter(row => {
                    return Array.from(row.cells).some(cell => 
                        cell.textContent.toLowerCase().includes(searchTerm)
                    );
                });

                // Calcular páginas
                const totalFilteredRows = filteredRows.length;
                const totalPages = Math.ceil(totalFilteredRows / perPage);
                currentPage = Math.min(currentPage, totalPages || 1);

                // Mostrar información de registros
                const start = (currentPage - 1) * perPage;
                const end = Math.min(start + perPage, totalFilteredRows);
                startIndex.textContent = totalFilteredRows ? start + 1 : 0;
                endIndex.textContent = end;
                totalEntries.textContent = totalFilteredRows;

                // Mostrar filas de la página actual
                const tbody = table.querySelector('tbody');
                tbody.innerHTML = '';
                if (totalFilteredRows === 0) {
                    const noDataRow = document.createElement('tr');
                    noDataRow.innerHTML = '<td colspan="6" class="text-center">No se encontraron registros</td>';
                    tbody.appendChild(noDataRow);
                } else {
                    filteredRows.slice(start, end).forEach(row => tbody.appendChild(row.cloneNode(true)));
                }

                // Actualizar paginación
                updatePagination(totalPages);
            }

            function updatePagination(totalPages) {
                pagination.innerHTML = '';
                if (totalPages > 1) {
                    // Botón Anterior
                    const prevBtn = createPaginationButton('Anterior', currentPage > 1);
                    prevBtn.addEventListener('click', () => {
                        if (currentPage > 1) {
                            currentPage--;
                            displayTableData();
                        }
                    });
                    pagination.appendChild(prevBtn);

                    // Números de página
                    for (let i = 1; i <= totalPages; i++) {
                        const pageBtn = createPaginationButton(i, true, i === currentPage);
                        pageBtn.addEventListener('click', () => {
                            currentPage = i;
                            displayTableData();
                        });
                        pagination.appendChild(pageBtn);
                    }

                    // Botón Siguiente
                    const nextBtn = createPaginationButton('Siguiente', currentPage < totalPages);
                    nextBtn.addEventListener('click', () => {
                        if (currentPage < totalPages) {
                            currentPage++;
                            displayTableData();
                        }
                    });
                    pagination.appendChild(nextBtn);
                }
            }

            function createPaginationButton(text, enabled, active = false) {
                const li = document.createElement('li');
                li.className = `page-item ${!enabled ? 'disabled' : ''} ${active ? 'active' : ''}`;
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = text;
                li.appendChild(a);
                return li;
            }

            // Event listeners
            searchInput.addEventListener('input', () => {
                currentPage = 1;
                displayTableData();
            });

            entriesPerPage.addEventListener('change', () => {
                currentPage = 1;
                displayTableData();
            });

            // Inicializar tabla
            displayTableData();
        });

        function generarPDF(autorizacion) {
            // Implementar la generación del PDF
            console.log('Generando PDF para:', autorizacion);
        }

        function imprimirAutorizacion(autorizacion) {
            // Implementar la impresión
            console.log('Imprimiendo autorización:', autorizacion);
        }
    </script>
</body>
</html>