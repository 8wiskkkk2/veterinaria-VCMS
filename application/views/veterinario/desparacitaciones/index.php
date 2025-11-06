<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Desparacitaciones - Veterinaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Gestión de Desparacitaciones</h3>
                <a href="<?= base_url('veterinario/crear_desparacitacion') ?>" class="btn btn-light">Nueva Desparacitación</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 position-relative">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                        <button type="button" id="clearSearch" class="btn btn-link position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table id="tabla-desparacitaciones" class="table table-striped table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>Fecha</th>
                                <th>Mascota</th>
                                <th>Peso</th>
                                <th>Propietario</th>
                                <th>Tratamiento</th>
                                <th>Próximo Tratamiento</th>
                                <th>Veterinario</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <?php foreach($desparacitaciones as $desparacitacion): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($desparacitacion->fecha)) ?></td>
                                <td><?= $desparacitacion->nombre_mascota ?></td>
                                <td><?= $desparacitacion->peso ?> kg</td>
                                <td><?= $desparacitacion->nombre_propietario ?></td>
                                <td><?= $desparacitacion->tratamiento ?></td>
                                <td><?= date('d/m/Y', strtotime($desparacitacion->proximo_tratamiento)) ?></td>
                                <td><?= $desparacitacion->nombre_veterinario ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
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
            
            filteredRows = rows;
            showPage(1);
            updatePagination();
            
            function filterTable(searchTerm) {
                filteredRows = rows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(searchTerm.toLowerCase());
                });
                showPage(1);
                updatePagination();
            }

            function showPage(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                
                rows.forEach(row => row.style.display = 'none');
                
                filteredRows.slice(start, end).forEach(row => row.style.display = '');
                
                document.getElementById('showing').textContent = Math.min(end, filteredRows.length);
                document.getElementById('total').textContent = filteredRows.length;
            }

            function updatePagination() {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                const pagination = document.getElementById('pagination');
                pagination.innerHTML = '';
                
                if (totalPages > 1) {
                    const prevLi = document.createElement('li');
                    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                    prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
                    prevLi.onclick = () => currentPage > 1 && showPage(currentPage - 1);
                    pagination.appendChild(prevLi);
                }
                
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    li.onclick = () => showPage(i);
                    pagination.appendChild(li);
                }
                
                if (totalPages > 1) {
                    const nextLi = document.createElement('li');
                    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                    nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
                    nextLi.onclick = () => currentPage < totalPages && showPage(currentPage + 1);
                    pagination.appendChild(nextLi);
                }
            }

            document.getElementById('searchInput').addEventListener('input', function(e) {
                const searchTerm = e.target.value;
                document.getElementById('clearSearch').style.display = searchTerm ? 'block' : 'none';
                filterTable(searchTerm);
            });

            document.getElementById('clearSearch').addEventListener('click', function() {
                document.getElementById('searchInput').value = '';
                this.style.display = 'none';
                filterTable('');
            });
        });
    </script>
</body>
</html>