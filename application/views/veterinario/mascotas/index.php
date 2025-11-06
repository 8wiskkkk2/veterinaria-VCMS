<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mascotas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Lista de Mascotas</h2>
        <div class="card">
            <div class="card-body">
                <!-- Barra de búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar mascota...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="tabla-mascotas" class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Especie</th>
                                <th>Raza</th>
                                <th>Color</th>
                                <th>Edad</th>
                                <th>Peso</th>
                                <th>Estado Reproductivo</th>
                                <th>Propietario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php if(!empty($mascotas)): ?>
                                <?php foreach($mascotas as $mascota): ?>
                                    <tr>
                                        <td><?= $mascota->nombre ?></td>
                                        <td><?= $mascota->especie ?></td>
                                        <td><?= $mascota->raza ?></td>
                                        <td><?= $mascota->color ?></td>
                                        <td><?= $mascota->edad_aproximada ?> años</td>
                                        <td><?= $mascota->peso ?> kg</td>
                                        <td><?= ucfirst($mascota->estado_reproductivo) ?></td>
                                        <td><?= $mascota->nombre_propietario ?></td>
                                        <td>
                                            <a href="<?= base_url('veterinario/editar_mascota/' . $mascota->id) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No hay mascotas registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p id="tableInfo" class="text-muted">Mostrando <span id="showing">0</span> de <span id="total">0</span> mascotas</p>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
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

            // Evento de búsqueda
            $('#searchInput').on('input', function() {
                filterTable(this.value);
            });
        });
    </script>
</body>
</html>