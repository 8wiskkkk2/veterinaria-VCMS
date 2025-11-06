<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?= base_url('index.php/user/index') ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <h2><i class="bi bi-journal-medical"></i> Historial Médico</h2>
        <div></div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <!-- Vacunas -->
        <div class="col">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Vacunas</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($vacunas)): ?>
                        <p class="text-muted text-center mb-0">No hay registros de vacunas</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mobile-table" data-page-length="5">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Mascota</th>
                                        <th>Vacuna</th>
                                        <th>Próxima Dosis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($vacunas as $vacuna): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($vacuna->fecha)) ?></td>
                                            <td><?= $vacuna->nombre_mascota ?></td>
                                            <td><?= $vacuna->tipo_vacuna ?></td>
                                            <td><?= date('d/m/Y', strtotime($vacuna->proxima_dosis)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="d-md-none">
                                <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                    <button class="btn btn-sm btn-outline-primary prev-page" disabled><i class="bi bi-chevron-left"></i></button>
                                    <span class="page-info">Página <span class="current-page">1</span> de <span class="total-pages">1</span></span>
                                    <button class="btn btn-sm btn-outline-primary next-page"><i class="bi bi-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Desparasitaciones -->
        <div class="col">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-pills me-2"></i>Desparasitaciones</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($desparacitaciones)): ?>
                        <p class="text-muted text-center mb-0">No hay registros de desparasitaciones</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Mascota</th>
                                        <th>Tratamiento</th>
                                        <th>Próximo Tratamiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($desparacitaciones as $desparacitacion): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($desparacitacion->fecha)) ?></td>
                                            <td><?= $desparacitacion->nombre_mascota ?></td>
                                            <td><?= $desparacitacion->tratamiento ?></td>
                                            <td><?= date('d/m/Y', strtotime($desparacitacion->proximo_tratamiento)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Emergencias -->
        <div class="col">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-ambulance me-2"></i>Atenciones de Urgencia</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($emergencias)): ?>
                        <p class="text-muted text-center mb-0">No hay registros de emergencias</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Mascota</th>
                                        <th>Motivo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($emergencias as $emergencia): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($emergencia->fecha_registro)) ?></td>
                                            <td><?= $emergencia->nombre_mascota ?></td>
                                            <td><?= $emergencia->motivo_consulta ?></td>
                                            <td>
                                                <span class="badge bg-<?= $emergencia->estado == 'completada' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($emergencia->estado) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Autorizaciones -->
        <div class="col">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i>Autorizaciones</h5>
                </div>
                <div class="card-body">
                    <?php if(empty($autorizaciones)): ?>
                        <p class="text-muted text-center mb-0">No hay registros de autorizaciones</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Mascota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($autorizaciones as $autorizacion): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($autorizacion->fecha)) ?></td>
                                            <td><?= ucfirst($autorizacion->tipo) ?></td>
                                            <td><?= $autorizacion->nombre_mascota ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar fixed-bottom navbar-light bg-white shadow-lg d-block d-md-none">
    <div class="container-fluid justify-content-around">
        <a class="nav-link" href="<?= base_url('index.php/user') ?>">
            <i class="bi bi-house-door-fill"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/mascotas') ?>">
            <i class="fas fa-paw text-danger"></i>
        </a>
        <a class="nav-link active" href="<?= base_url('index.php/user/historial') ?>">
            <i class="bi bi-journal-medical text-success"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/mapa') ?>">
            <i class="bi bi-geo-alt-fill text-info"></i>
        </a>
        <a class="nav-link" href="<?= base_url('index.php/user/perfil') ?>">
            <i class="bi bi-person-fill text-primary"></i>
        </a>
    </div>
</nav>

<style>
    @media (max-width: 767px) {
        .btn-outline-primary {
            display: none;
        }
        .container {
            margin-bottom: 80px;
            padding-bottom: env(safe-area-inset-bottom);
        }
        .card {
            margin-bottom: 1rem;
        }
        .navbar.fixed-bottom {
            position: fixed !important;
            bottom: 0 !important;
            z-index: 1030;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('.mobile-table');
    
    tables.forEach(table => {
        const rows = Array.from(table.getElementsByTagName('tr')).slice(1); // Excluir header
        const pageSize = 5;
        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / pageSize);
        
        const paginationContainer = table.closest('.table-responsive').querySelector('.d-md-none');
        const prevButton = paginationContainer.querySelector('.prev-page');
        const nextButton = paginationContainer.querySelector('.next-page');
        const currentPageSpan = paginationContainer.querySelector('.current-page');
        const totalPagesSpan = paginationContainer.querySelector('.total-pages');
        
        function showPage(page) {
            const start = (page - 1) * pageSize;
            const end = start + pageSize;
            
            rows.forEach((row, index) => {
                row.classList.toggle('visible-row', index >= start && index < end);
            });
            
            currentPageSpan.textContent = page;
            totalPagesSpan.textContent = totalPages;
            prevButton.disabled = page === 1;
            nextButton.disabled = page === totalPages;
        }
        
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
        
        nextButton.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });
        
        showPage(1);
    });
});
</script>
<style>
    @media (max-width: 767px) {
        .mobile-table tr:not(.visible-row) {
            display: none;
        }
        
        .page-info {
            font-size: 0.9rem;
        }
    }
</style>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
