<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2><?= $titulo ?></h2>
            <button class="btn btn-primary" disabled title="Función en desarrollo">
                <i class="fas fa-plus"></i> Nueva Cita
            </button>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <?= $mensaje_desarrollo ?>
            </div>
        </div>
    </div>
</div>