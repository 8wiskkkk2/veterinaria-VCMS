<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Tratamientos</h3>
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
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header"><h5>Tipos de Vacunas</h5></div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('admin/vacuna_tipo/guardar') ?>" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Intervalo (días)</label>
                                    <input type="number" name="dias_intervalo" min="0" class="form-control" placeholder="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Especie</label>
                                    <select name="especie" class="form-select">
                                        <option value="general">General</option>
                                        <?php foreach($especies as $e): ?>
                                            <option value="<?= strtolower($e->nombre) ?>"><?= $e->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary">Agregar Tipo de Vacuna</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="searchVacunaTipo" class="form-control" placeholder="Buscar...">
                                        <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <select id="vacunaTipoSpeciesFilter" class="form-select w-auto d-inline-block me-2">
                                        <option value="">Todas las especies</option>
                                        <option value="general">General</option>
                                        <?php foreach($especies as $e): ?>
                                            <option value="<?= strtolower($e->nombre) ?>"><?= $e->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select id="vacunaTipoPerPage" class="form-select w-auto d-inline-block">
                                        <option value="5" selected>5 registros</option>
                                        <option value="10">10 registros</option>
                                        <option value="15">15 registros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tabla-vacuna-tipos" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Especie</th>
                                            <th>Intervalo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($vacuna_tipos as $t): ?>
                                            <tr>
                                                <td><?= $t->nombre ?></td>
                                                <td data-especie="<?= $t->especie ? strtolower($t->especie) : 'general' ?>"><?= $t->especie ? ucfirst($t->especie) : 'General' ?></td>
                                                <td><?= (int)$t->dias_intervalo ?> días</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div id="vacunaTiposInfo" class="text-muted">Mostrando <span id="vacunaTiposStart">0</span> a <span id="vacunaTiposEnd">0</span> de <span id="vacunaTiposTotal">0</span> registros</div>
                                </div>
                                <div class="col-md-6">
                                    <nav class="float-md-end"><ul id="vacunaTiposPagination" class="pagination pagination-sm"></ul></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header"><h5>Tipos de Desparasitaciones</h5></div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('admin/desparacitacion_tipo/guardar') ?>" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Intervalo (días)</label>
                                    <input type="number" name="dias_intervalo" min="0" class="form-control" placeholder="0">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Especie</label>
                                    <select name="especie" class="form-select">
                                        <option value="general">General</option>
                                        <?php foreach($especies as $e): ?>
                                            <option value="<?= strtolower($e->nombre) ?>"><?= $e->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary">Agregar Tipo de Desparasitación</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="searchDesparaTipo" class="form-control" placeholder="Buscar...">
                                        <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <select id="desparaTipoSpeciesFilter" class="form-select w-auto d-inline-block me-2">
                                        <option value="">Todas las especies</option>
                                        <option value="general">General</option>
                                        <?php foreach($especies as $e): ?>
                                            <option value="<?= strtolower($e->nombre) ?>"><?= $e->nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select id="desparaTipoPerPage" class="form-select w-auto d-inline-block">
                                        <option value="5" selected>5 registros</option>
                                        <option value="10">10 registros</option>
                                        <option value="15">15 registros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tabla-despara-tipos" class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Especie</th>
                                            <th>Intervalo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($desparacitacion_tipos as $t): ?>
                                            <tr>
                                                <td><?= $t->nombre ?></td>
                                                <td data-especie="<?= $t->especie ? strtolower($t->especie) : 'general' ?>"><?= $t->especie ? ucfirst($t->especie) : 'General' ?></td>
                                                <td><?= (int)$t->dias_intervalo ?> días</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div id="desparaTiposInfo" class="text-muted">Mostrando <span id="desparaTiposStart">0</span> a <span id="desparaTiposEnd">0</span> de <span id="desparaTiposTotal">0</span> registros</div>
                                </div>
                                <div class="col-md-6">
                                    <nav class="float-md-end"><ul id="desparaTiposPagination" class="pagination pagination-sm"></ul></nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de especies removida: ahora existe una página dedicada en Admin → Especies -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupList(cfg) {
        let currentPage = 1;
        let perPage = parseInt(cfg.perPageSelect.value, 10) || 5;
        const originalRows = Array.from(cfg.tbody.getElementsByTagName('tr'));

        function apply() {
            const q = cfg.searchInput.value.toLowerCase();
            const sp = cfg.speciesFilter.value;
            const filtered = originalRows.filter(function(row) {
                const textMatch = row.textContent.toLowerCase().includes(q);
                const especieCell = row.querySelector('td[data-especie]');
                const especieVal = especieCell ? especieCell.getAttribute('data-especie') : '';
                const specieMatch = !sp || especieVal === sp;
                return textMatch && specieMatch;
            });
            const total = filtered.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageRows = filtered.slice(start, end);
            cfg.tbody.innerHTML = '';
            pageRows.forEach(function(r) { cfg.tbody.appendChild(r); });
            cfg.infoStart.textContent = total ? start + 1 : 0;
            cfg.infoEnd.textContent = Math.min(end, total);
            cfg.infoTotal.textContent = total;
            cfg.pagination.innerHTML = '';
            const prevLi = document.createElement('li');
            prevLi.className = 'page-item ' + (currentPage === 1 ? 'disabled' : '');
            prevLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage - 1) + '">&laquo;</a>';
            cfg.pagination.appendChild(prevLi);
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item ' + (currentPage === i ? 'active' : '');
                li.innerHTML = '<a class="page-link" href="#" data-page="' + i + '">' + i + '</a>';
                cfg.pagination.appendChild(li);
            }
            const nextLi = document.createElement('li');
            nextLi.className = 'page-item ' + (currentPage === totalPages ? 'disabled' : '');
            nextLi.innerHTML = '<a class="page-link" href="#" data-page="' + (currentPage + 1) + '">&raquo;</a>';
            cfg.pagination.appendChild(nextLi);
        }

        cfg.searchInput.addEventListener('input', function() { currentPage = 1; apply(); });
        cfg.speciesFilter.addEventListener('change', function() { currentPage = 1; apply(); });
        cfg.perPageSelect.addEventListener('change', function(e) { perPage = parseInt(e.target.value, 10); currentPage = 1; apply(); });
        cfg.pagination.addEventListener('click', function(e) {
            if (e.target && e.target.matches('a.page-link')) {
                e.preventDefault();
                const np = parseInt(e.target.getAttribute('data-page'), 10);
                if (np > 0) { currentPage = np; apply(); }
            }
        });
        apply();
    }

    setupList({
        table: document.getElementById('tabla-vacuna-tipos'),
        tbody: document.querySelector('#tabla-vacuna-tipos tbody'),
        searchInput: document.getElementById('searchVacunaTipo'),
        speciesFilter: document.getElementById('vacunaTipoSpeciesFilter'),
        perPageSelect: document.getElementById('vacunaTipoPerPage'),
        infoStart: document.getElementById('vacunaTiposStart'),
        infoEnd: document.getElementById('vacunaTiposEnd'),
        infoTotal: document.getElementById('vacunaTiposTotal'),
        pagination: document.getElementById('vacunaTiposPagination')
    });
    setupList({
        table: document.getElementById('tabla-despara-tipos'),
        tbody: document.querySelector('#tabla-despara-tipos tbody'),
        searchInput: document.getElementById('searchDesparaTipo'),
        speciesFilter: document.getElementById('desparaTipoSpeciesFilter'),
        perPageSelect: document.getElementById('desparaTipoPerPage'),
        infoStart: document.getElementById('desparaTiposStart'),
        infoEnd: document.getElementById('desparaTiposEnd'),
        infoTotal: document.getElementById('desparaTiposTotal'),
        pagination: document.getElementById('desparaTiposPagination')
    });
});
</script>