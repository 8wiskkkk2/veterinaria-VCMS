<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vacunas - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Vacunas</h3>
                <a href="<?= base_url('veterinario/vacunas/crear') ?>" class="btn btn-success">Nueva Vacuna</a>
            </div>
            <div class="card-body">
                <!-- Barra de búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6 position-relative">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                        <button type="button" id="clearSearch" class="btn btn-link position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table id="tabla-vacunas" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Mascota</th>
                                <th>Peso</th>
                                <th>Propietario</th>
                                <th>Tipo de Vacuna</th>
                                <th>Próxima Dosis</th>
                                <th>Veterinario</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php foreach($vacunas as $vacuna): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($vacuna->fecha)) ?></td>
                                    <td><?= $vacuna->nombre_mascota ?></td>
                                    <td><?= $vacuna->peso ?> kg</td>
                                    <td><?= $vacuna->nombre_propietario ?></td>
                                    <td><?= $vacuna->tipo_vacuna ?></td>
                                    <td><?= date('d/m/Y', strtotime($vacuna->proxima_dosis)) ?></td>
                                    <td><?= $vacuna->nombre_veterinario ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p id="tableInfo" class="text-muted">Mostrando <span id="showing">0</span> de <span id="total">0</span> registros</p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end" id="pagination"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            const rowsPerPage = 10;
            let currentPage = 1;
            let filteredRows = [];
            const rows = Array.from(document.querySelectorAll('#tableBody tr'));
            
            // Función de búsqueda
            function filterTable(searchTerm) {
                filteredRows = rows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(searchTerm.toLowerCase());
                });
                showPage(1);
                updatePagination();
            }

            // Mostrar página específica
            function showPage(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                
                // Ocultar todas las filas
                rows.forEach(row => row.style.display = 'none');
                
                // Mostrar solo las filas de la página actual
                filteredRows.slice(start, end).forEach(row => row.style.display = '');
                
                // Actualizar información
                document.getElementById('showing').textContent = 
                    Math.min(filteredRows.length, end);
                document.getElementById('total').textContent = filteredRows.length;
            }

            // Actualizar paginación
            function updatePagination() {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';
                
                // Botón Anterior
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = '<a class="page-link" href="#">Anterior</a>';
                prevLi.onclick = () => currentPage > 1 && showPage(currentPage - 1);
                pagination.appendChild(prevLi);

                // Páginas numeradas
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    li.onclick = () => showPage(i);
                    pagination.appendChild(li);
                }

                // Botón Siguiente
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                nextLi.innerHTML = '<a class="page-link" href="#">Siguiente</a>';
                nextLi.onclick = () => currentPage < totalPages && showPage(currentPage + 1);
                pagination.appendChild(nextLi);
            }

            // Inicializar la tabla
            filteredRows = rows;
            showPage(1);
            updatePagination();

            // Evento de búsqueda y manejo del botón clear
            $('#searchInput').on('input', function() {
                const searchValue = this.value;
                filterTable(searchValue);
                
                // Mostrar u ocultar el botón clear
                $('#clearSearch').toggle(searchValue.length > 0);
            });

            // Evento para el botón clear
            $('#clearSearch').on('click', function() {
                $('#searchInput').val('').trigger('input');
            });
        });
    </script>
</body>
</html>