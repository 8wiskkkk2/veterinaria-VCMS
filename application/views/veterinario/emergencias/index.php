<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atenciones de Urgencia - Veterinaria</title>
    
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
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-ambulance me-2"></i>Atenciones de Urgencia</h3>
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
                    <table id="tabla-emergencias" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha Ingreso</th>
                                <th>Mascota</th>
                                <th>Especie</th>
                                <th>Nivel Urgencia</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($emergencias)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay atenciones de emergencia pendientes</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($emergencias as $emergencia): ?>
                                    <?php if($emergencia->estado == 'pendiente'): ?>
                                        <tr>
                                            <td data-order="<?= strtotime($emergencia->fecha_registro) ?>">
                                                <?= date('d/m/Y H:i', strtotime($emergencia->fecha_registro)) ?>
                                            </td>
                                            <td><?= $emergencia->nombre_mascota ?></td>
                                            <td><?= $emergencia->especie ?></td>
                                            <td>
                                                <span class="badge <?php
                                                    switch(strtolower($emergencia->nivel_urgencia)) {
                                                        case 'alta':
                                                            echo 'bg-danger';
                                                            break;
                                                        case 'media':
                                                            echo 'bg-warning';
                                                            break;
                                                        case 'baja':
                                                            echo 'bg-success';
                                                            break;
                                                        default:
                                                            echo 'bg-secondary';
                                                    }
                                                ?>">
                                                    <?= ucfirst($emergencia->nivel_urgencia) ?>
                                                </span>
                                            </td>
                                            <td><?= $emergencia->motivo_consulta ?></td>
                                            <td>
                                                <span class="badge bg-warning">Pendiente</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('veterinario/ver_emergencia/'.$emergencia->id) ?>" 
                                                       class="btn btn-sm btn-info" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('veterinario/completar_emergencia/'.$emergencia->id) ?>" 
                                                       class="btn btn-sm btn-primary" title="Completar">
                                                        <i class="fas fa-check-double"></i>
                                                    </a>
                                                    <a href="<?= base_url('veterinario/cambiar_estado_emergencia/'.$emergencia->id) ?>" 
                                                       class="btn btn-sm <?= ($emergencia->estado == 'pendiente') ? 'btn-success' : 'btn-warning' ?>" 
                                                       title="<?= ($emergencia->estado == 'pendiente') ? 'Marcar como Atendido' : 'Marcar como Pendiente' ?>">
                                                        <i class="fas <?= ($emergencia->estado == 'pendiente') ? 'fa-check' : 'fa-clock' ?>"></i>
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
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p id="tableInfo" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Table navigation" class="float-end">
                            <ul class="pagination mb-0" id="pagination"></ul>
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
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Eliminar o comentar las referencias a DataTables -->
    <script>
    $(document).ready(function() {
        let currentPage = 1;
        let entriesPerPage = 10;
        let filteredData = [];
        const table = document.querySelector('#tabla-emergencias');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
    
        function updateTable() {
            const startIndex = (currentPage - 1) * entriesPerPage;
            const endIndex = startIndex + entriesPerPage;
            const pageData = filteredData.slice(startIndex, endIndex);
    
            tbody.innerHTML = '';
    
            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="${table.querySelectorAll('th').length}" class="text-center">No se encontraron registros</td></tr>`;
            } else {
                pageData.forEach(row => tbody.appendChild(row));
            }
    
            updatePagination();
            updateTableInfo();
        }
    
        function updatePagination() {
            const totalPages = Math.ceil(filteredData.length / entriesPerPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
    
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
            prevLi.onclick = () => { if (currentPage > 1) { currentPage--; updateTable(); } };
            pagination.appendChild(prevLi);
    
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = () => { currentPage = i; updateTable(); };
                pagination.appendChild(li);
            }
    
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
            nextLi.onclick = () => { if (currentPage < totalPages) { currentPage++; updateTable(); } };
            pagination.appendChild(nextLi);
        }
    
        function updateTableInfo() {
            const startIndex = (currentPage - 1) * entriesPerPage + 1;
            const endIndex = Math.min(startIndex + entriesPerPage - 1, filteredData.length);
            const totalEntries = filteredData.length;
            document.getElementById('tableInfo').textContent = 
                `Mostrando ${startIndex} a ${endIndex} de ${totalEntries} registros`;
        }
    
        function filterTable(searchTerm) {
            searchTerm = searchTerm.toLowerCase();
            filteredData = rows.filter(row => {
                const text = row.textContent.toLowerCase();
                return text.includes(searchTerm);
            });
            currentPage = 1;
            updateTable();
        }
    
        document.getElementById('searchInput').addEventListener('input', (e) => {
            filterTable(e.target.value);
        });
    
        document.getElementById('entriesPerPage').addEventListener('change', (e) => {
            entriesPerPage = parseInt(e.target.value);
            currentPage = 1;
            updateTable();
        });
    
        filteredData = rows;
        updateTable();
    });
    </script>
</body>
</html>