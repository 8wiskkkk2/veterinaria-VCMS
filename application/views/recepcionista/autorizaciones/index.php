<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-file-signature me-2"></i>Autorizaciones</h2>
    <p class="text-muted mb-4">Seleccione el tipo de autorización que desea generar</p>

    <div class="row">
        <!-- Autorización para Eutanasia -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-heart-broken fa-3x text-danger"></i>
                    </div>
                    <h5 class="card-title">Autorización para Eutanasia</h5>
                    <p class="card-text">Generar documento de autorización para procedimiento de eutanasia</p>
                    <a href="<?= base_url('recepcionista/autorizaciones/eutanasia/crear') ?>" class="btn btn-danger">
                        <i class="fas fa-plus-circle me-2"></i>Nueva Autorización
                    </a>
                </div>
            </div>
        </div>

        <!-- Autorización para Cirugía -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-scissors fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Autorización para Cirugía</h5>
                    <p class="card-text">Generar documento de autorización para procedimiento quirúrgico</p>
                    <a href="<?= base_url('recepcionista/autorizaciones/cirugia/crear') ?>" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Nueva Autorización
                    </a>
                </div>
            </div>
        </div>

        <!-- Autorización para Sedación -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-syringe fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Autorización para Sedación</h5>
                    <p class="card-text">Generar documento de autorización para procedimiento con sedación</p>
                    <a href="<?= base_url('recepcionista/autorizaciones/sedacion/crear') ?>" class="btn btn-success">
                        <i class="fas fa-plus-circle me-2"></i>Nueva Autorización
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>