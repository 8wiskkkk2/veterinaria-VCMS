<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('recepcionista') ?>">
            <i class="fas fa-paw me-2"></i>Veterinaria Municipal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('recepcionista/emergencias') ?>">
                        <i class="fas fa-ambulance me-1"></i>Emergencias
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('recepcionista/usuarios') ?>">
                        <i class="fas fa-users me-1"></i>Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('recepcionista/mascotas') ?>">
                        <i class="fas fa-dog me-1"></i>Mascotas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('recepcionista/atenciones') ?>">
                        <i class="fas fa-notes-medical me-1"></i>Historial de Atenciones
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link">
                        <i class="fas fa-user me-1"></i><?= $this->session->userdata('nombre') ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mensajes de alerta -->
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>