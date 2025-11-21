<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Especies y Razas</h3>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary">Volver</a>
        </div>
        <div class="card-body">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header"><h5>Especies</h5></div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('admin/especie/guardar') ?>" class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Nombre de Especie</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Conejo" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button class="btn btn-success w-100">Agregar Especie</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="searchEspecieInput" class="form-control" placeholder="Buscar...">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <select id="speciesPerPage" class="form-select w-auto d-inline-block">
                                        <option value="5">5 registros</option>
                                        <option value="10" selected>10 registros</option>
                                        <option value="15">15 registros</option>
                                        <option value="20">20 registros</option>
                                    </select>
                                </div>
                            </div>
                    <div class="table-responsive">
                        <table id="tabla-especies" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                        <button id="sortIdBtn" type="button" class="btn btn-link btn-sm p-0 ms-1 align-baseline" title="Ordenar por ID">
                                            <i id="sortIdIcon" class="fas fa-sort"></i>
                                        </button>
                                    </th>
                                    <th>
                                        Nombre
                                        <button id="sortNameBtn" type="button" class="btn btn-link btn-sm p-0 ms-1 align-baseline" title="Ordenar por Nombre">
                                            <i id="sortNameIcon" class="fas fa-sort"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($especies as $e): ?>
                                    <tr>
                                        <td><?= $e->id ?></td>
                                        <td><?= $e->nombre ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div id="speciesTableInfo" class="text-muted">
                                Mostrando <span id="speciesStartRecord">0</span> a <span id="speciesEndRecord">0</span> de <span id="speciesTotalRecords">0</span> registros
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Page navigation" class="float-md-end">
                                <ul id="speciesPagination" class="pagination pagination-sm"></ul>
                            </nav>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header"><h5>Razas</h5></div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('admin/raza/guardar') ?>" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre de Raza</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Especie</label>
                            <select name="especie_id" class="form-select" required>
                                <option value="" selected>Seleccione una especie</option>
                                <?php foreach($especies as $e): ?>
                                    <option value="<?= $e->id ?>"><?= $e->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-primary w-100">Agregar</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="searchRazaInput" class="form-control" placeholder="Buscar...">
                                        <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <select id="razaSpeciesFilter" class="form-select w-auto d-inline-block me-2">
                                        <option value="">Todas las especies</option>
                                        <?php foreach($especies as $e): ?>
                                            <option value="<?= $e->id ?>"><?= $e->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tabla-razas" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Especie</th>
                                            <th>Raza</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($razas as $r): ?>
                                            <?php $espNombre = ''; foreach($especies as $e){ if($e->id == $r->especie_id){ $espNombre = $e->nombre; break; } } ?>
                                            <tr>
                                                <td><?= $r->id ?></td>
                                                <td data-especie-id="<?= (int)$r->especie_id ?>"><?= $espNombre ?></td>
                                                <td><?= $r->nombre ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div id="razaTableInfo" class="text-muted">Mostrando <span id="razaStartRecord">0</span> a <span id="razaEndRecord">0</span> de <span id="razaTotalRecords">0</span> registros</div>
                                </div>
                                <div class="col-md-6">
                                    <nav aria-label="Page navigation" class="float-md-end">
                                        <ul id="razaPagination" class="pagination pagination-sm"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentPage = 1;
                let recordsPerPage = 10;
                let sortField = null; // 'id' | 'nombre'
                let sortDir = 'asc'; // 'asc' | 'desc'
                const table = document.getElementById('tabla-especies');
                const tbody = table.getElementsByTagName('tbody')[0];
                const originalRows = Array.from(tbody.getElementsByTagName('tr'));

                function filterTable() {
                    const searchText = document.getElementById('searchEspecieInput').value.toLowerCase();
                    const filteredRows = originalRows.filter(function(row) {
                        return row.textContent.toLowerCase().includes(searchText);
                    });
                    const sortedRows = sortRows(filteredRows);
                    displayRows(sortedRows);
                    updatePagination(sortedRows.length);
                }

                function displayRows(rowsToDisplay) {
                    const start = (currentPage - 1) * recordsPerPage;
                    const end = start + recordsPerPage;
                    const pageRows = rowsToDisplay.slice(start, end);
                    tbody.innerHTML = '';
                    pageRows.forEach(function(row) { tbody.appendChild(row); });
                    document.getElementById('speciesStartRecord').textContent = rowsToDisplay.length ? start + 1 : 0;
                    document.getElementById('speciesEndRecord').textContent = Math.min(end, rowsToDisplay.length);
                    document.getElementById('speciesTotalRecords').textContent = rowsToDisplay.length;
                }

                function updatePagination(filteredTotal) {
                    const totalPages = Math.ceil(filteredTotal / recordsPerPage) || 1;
                    const pagination = document.getElementById('speciesPagination');
                    pagination.innerHTML = '';
                    const prevLi = document.createElement('li');
                    prevLi.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
                    prevLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage - 1) + '">&laquo;</a>';
                    pagination.appendChild(prevLi);
                    for (let i = 1; i <= totalPages; i++) {
                        const li = document.createElement('li');
                        li.className = 'page-item ' + (currentPage === i ? 'active' : '');
                        li.innerHTML = '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>';
                        pagination.appendChild(li);
                    }
                    const nextLi = document.createElement('li');
                    nextLi.className = 'page-item ' + (currentPage === totalPages ? 'disabled' : '');
                    nextLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage + 1) + '">&raquo;</a>';
                    pagination.appendChild(nextLi);
                }

                function sortRows(rowsToSort) {
                    if (!sortField) return rowsToSort.slice();
                    const rowsCopy = rowsToSort.slice();
                    rowsCopy.sort(function(a, b) {
                        const aCells = a.getElementsByTagName('td');
                        const bCells = b.getElementsByTagName('td');
                        let cmp = 0;
                        if (sortField === 'id') {
                            const av = parseInt(aCells[0].textContent, 10) || 0;
                            const bv = parseInt(bCells[0].textContent, 10) || 0;
                            cmp = av - bv;
                        } else if (sortField === 'nombre') {
                            const av = (aCells[1].textContent || '').toLowerCase();
                            const bv = (bCells[1].textContent || '').toLowerCase();
                            if (av < bv) cmp = -1; else if (av > bv) cmp = 1; else cmp = 0;
                        }
                        return sortDir === 'asc' ? cmp : -cmp;
                    });
                    return rowsCopy;
                }

                function updateSortIcons() {
                    const idIcon = document.getElementById('sortIdIcon');
                    const nameIcon = document.getElementById('sortNameIcon');
                    idIcon.className = 'fas fa-sort';
                    nameIcon.className = 'fas fa-sort';
                    if (sortField === 'id') {
                        idIcon.className = sortDir === 'asc' ? 'fas fa-sort-numeric-up' : 'fas fa-sort-numeric-down';
                    } else if (sortField === 'nombre') {
                        nameIcon.className = sortDir === 'asc' ? 'fas fa-sort-alpha-up' : 'fas fa-sort-alpha-down';
                    }
                }

                document.getElementById('searchEspecieInput').addEventListener('input', function() {
                    currentPage = 1;
                    filterTable();
                });
                document.getElementById('speciesPerPage').addEventListener('change', function(e) {
                    recordsPerPage = parseInt(e.target.value, 10);
                    currentPage = 1;
                    filterTable();
                });
                document.getElementById('speciesPagination').addEventListener('click', function(e) {
                    if (e.target && e.target.matches('a.page-link')) {
                        e.preventDefault();
                        const newPage = parseInt(e.target.getAttribute('data-page'), 10);
                        if (newPage > 0) {
                            currentPage = newPage;
                            filterTable();
                        }
                    }
                });

                document.getElementById('sortIdBtn').addEventListener('click', function() {
                    if (sortField === 'id') {
                        sortDir = sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortField = 'id';
                        sortDir = 'asc';
                    }
                    updateSortIcons();
                    filterTable();
                });

                document.getElementById('sortNameBtn').addEventListener('click', function() {
                    if (sortField === 'nombre') {
                        sortDir = sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        sortField = 'nombre';
                        sortDir = 'asc';
                    }
                    updateSortIcons();
                    filterTable();
                });

                sortField = 'id';
                sortDir = 'asc';
                updateSortIcons();
                filterTable();
            });
            </script>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentPage = 1;
                let perPage = 5;
                const table = document.getElementById('tabla-razas');
                if (!table) return;
                const tbody = table.getElementsByTagName('tbody')[0];
                const originalRows = Array.from(tbody.getElementsByTagName('tr'));

                function apply() {
                    const q = document.getElementById('searchRazaInput').value.toLowerCase();
                    const filterId = document.getElementById('razaSpeciesFilter').value;
                    const filtered = originalRows.filter(function(row) {
                        const textMatch = row.textContent.toLowerCase().includes(q);
                        const especieCell = row.querySelector('td[data-especie-id]');
                        const especieId = especieCell ? especieCell.getAttribute('data-especie-id') : '';
                        const specieMatch = !filterId || (String(especieId) === String(filterId));
                        return textMatch && specieMatch;
                    });
                    const total = filtered.length;
                    const totalPages = Math.max(1, Math.ceil(total / perPage));
                    if (currentPage > totalPages) currentPage = totalPages;
                    const start = (currentPage - 1) * perPage;
                    const end = start + perPage;
                    const pageRows = filtered.slice(start, end);
                    tbody.innerHTML = '';
                    pageRows.forEach(function(r) { tbody.appendChild(r); });
                    document.getElementById('razaStartRecord').textContent = total ? start + 1 : 0;
                    document.getElementById('razaEndRecord').textContent = Math.min(end, total);
                    document.getElementById('razaTotalRecords').textContent = total;
                    const pagination = document.getElementById('razaPagination');
                    pagination.innerHTML = '';
                    const prevLi = document.createElement('li');
                    prevLi.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
                    prevLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage - 1) + '">&laquo;</a>';
                    pagination.appendChild(prevLi);
                    for (let i = 1; i <= totalPages; i++) {
                        const li = document.createElement('li');
                        li.className = 'page-item ' + (currentPage === i ? 'active' : '');
                        li.innerHTML = '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>';
                        pagination.appendChild(li);
                    }
                    const nextLi = document.createElement('li');
                    nextLi.className = 'page-item ' + (currentPage === totalPages ? 'disabled' : '');
                    nextLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage + 1) + '">&raquo;</a>';
                    pagination.appendChild(nextLi);
                }

                document.getElementById('searchRazaInput').addEventListener('input', function() { currentPage = 1; apply(); });
                document.getElementById('razaSpeciesFilter').addEventListener('change', function() { currentPage = 1; apply(); });
                // perPage fijo en 5
                document.getElementById('razaPagination').addEventListener('click', function(e) {
                    if (e.target && e.target.matches('a.page-link')) {
                        e.preventDefault();
                        const np = parseInt(e.target.getAttribute('data-page'), 10);
                        if (np > 0) { currentPage = np; apply(); }
                    }
                });

                apply();
            });
            </script>
        </div>
    </div>
</div>