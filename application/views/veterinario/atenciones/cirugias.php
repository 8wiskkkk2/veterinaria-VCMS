<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones de Cirugías - Veterinaria</title>
    
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
                    <i class="fas fa-user-md me-2"></i>Atenciones de Cirugías
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
                    <table id="tabla-cirugias" class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Especie</th>
                                <th>Mascota</th>
                                <th>Propietario</th>
                                <th>Emergencia</th>
                                <th>Atendido por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($cirugias) && !empty($cirugias)): ?>
                                <?php foreach($cirugias as $cirugia): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($cirugia->fecha)) ?></td>
                                        <td><?= $cirugia->especie ?></td>
                                        <td><?= $cirugia->nombre_mascota ?></td>
                                        <td><?= $cirugia->nombre_propietario ?></td>
                                        <td>
                                            <span class="badge <?= $cirugia->emergencia ? 'bg-danger' : 'bg-success' ?>">
                                                <?= $cirugia->emergencia ? 'Sí' : 'No' ?>
                                            </span>
                                        </td>
                                        <td><?= $cirugia->veterinario_tratante ? $cirugia->nombre_veterinario : 'No asignado' ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="generarPDF(<?= htmlspecialchars(json_encode($cirugia)) ?>)">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="imprimirAutorizacion(<?= htmlspecialchars(json_encode($cirugia)) ?>)">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay cirugías registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6" id="tableInfo"></div>
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
        $(document).ready(function() {
            let currentPage = 1;
            let rowsPerPage = 10;
            const table = document.querySelector('#tabla-cirugias');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const searchInput = document.querySelector('#searchInput');
            const entriesPerPage = document.querySelector('#entriesPerPage');
            const pagination = document.querySelector('#pagination');
            const tableInfo = document.querySelector('#tableInfo');

            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                return rows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(searchTerm);
                });
            }

            function updateTable() {
                const filteredRows = filterRows();
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const paginatedRows = filteredRows.slice(start, end);

                tbody.innerHTML = '';
                paginatedRows.forEach(row => tbody.appendChild(row.cloneNode(true)));

                updatePagination(filteredRows.length);
                updateTableInfo(start, end, filteredRows.length);
            }

            function updatePagination(totalRows) {
                const pageCount = Math.ceil(totalRows / rowsPerPage);
                let paginationHTML = '';

                // Botón anterior
                paginationHTML += `
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                    </li>
                `;

                // Páginas numeradas
                for (let i = 1; i <= pageCount; i++) {
                    paginationHTML += `
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                // Botón siguiente
                paginationHTML += `
                    <li class="page-item ${currentPage === pageCount ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                    </li>
                `;

                pagination.innerHTML = paginationHTML;

                // Agregar event listeners a los botones de paginación
                pagination.querySelectorAll('.page-link').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        const newPage = parseInt(e.target.dataset.page);
                        if (newPage >= 1 && newPage <= pageCount) {
                            currentPage = newPage;
                            updateTable();
                        }
                    });
                });
            }

            function updateTableInfo(start, end, totalRows) {
                const filteredRows = filterRows();
                tableInfo.textContent = `Mostrando ${Math.min(start + 1, totalRows)} a ${Math.min(end, totalRows)} de ${totalRows} registros`;
            }

            // Event listeners
            searchInput.addEventListener('input', () => {
                currentPage = 1;
                updateTable();
            });

            entriesPerPage.addEventListener('change', () => {
                rowsPerPage = parseInt(entriesPerPage.value);
                currentPage = 1;
                updateTable();
            });

            // Inicializar tabla
            updateTable();
        });

        // Funciones para generar PDF e imprimir (implementar según necesidades)
        function generarPDF(cirugia) {
            console.log('Generando PDF para:', cirugia);
            // Implementar la generación del PDF
        }

        function imprimirAutorizacion(cirugia) {
            console.log('Imprimiendo autorización para:', cirugia);
            // Implementar la impresión
        }
    </script>
</body>
</html>