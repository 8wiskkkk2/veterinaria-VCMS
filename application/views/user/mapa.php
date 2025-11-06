<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubicación - Veterinaria Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= base_url('index.php/user/index') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div></div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-primary">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Ubicación Veterinaria Municipal
                </h2>
                <!-- Mapa -->
                <div class="ratio ratio-16x9 mb-4">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3190.8905801062385!2d-71.59295700000001!3d-35.840847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9665f56dc9b62523%3A0xc783cec2c7e61b0f!2sVeterinaria%20Municipal%20de%20Linares!5e0!3m2!1ses!2scl!4v1701893046168!5m2!1ses!2scl"
                        style="border:0; border-radius: 10px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="row g-4">
                    <!-- Información de Ubicación -->
                    <div class="col-md-6">
                        <div class="card h-100 bg-light border-0">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="fas fa-location-dot text-danger me-2"></i>
                                    Dirección
                                </h4>
                                <p class="mb-3">Av. Pdte. Ibáñez 560, Linares, Chile</p>
                                <a href="https://www.google.com/maps/place/Veterinaria+Municipal+de+Linares/@-35.840847,-71.592957,17z/data=!4m6!3m5!1s0x9665f56dc9b62523:0xc783cec2c7e61b0f!8m2!3d-35.840847!4d-71.592957!16s%2Fg%2F11rrjd34q_?entry=ttu" 
                                   class="btn btn-primary"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Ver en Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Horarios -->
                    <div class="col-md-6">
                        <div class="card h-100 bg-light border-0">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Horarios de Atención
                                </h4>
                                <div class="mb-3">
                                    <h6 class="fw-bold">Lunes a Viernes</h6>
                                    <p class="mb-1">Mañana: 8:30 - 13:00 hrs</p>
                                    <p class="mb-0">Tarde: 14:00 - 18:00 hrs</p>
                                </div>
                                <div>
                                    <h6 class="fw-bold">Sábado y Domingo</h6>
                                    <p class="mb-0 text-danger">Cerrado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Navbar for Mobile -->
    <nav class="navbar fixed-bottom navbar-light bg-white shadow-lg d-block d-md-none">
        <div class="container-fluid justify-content-around">
            <a class="nav-link" href="<?= base_url('index.php/user') ?>">
                <i class="bi bi-house-door-fill"></i>
            </a>
            <a class="nav-link" href="<?= base_url('index.php/user/mascotas') ?>">
                <i class="fas fa-paw text-danger"></i>
            </a>
            <a class="nav-link" href="<?= base_url('index.php/user/historial') ?>">
                <i class="bi bi-journal-medical text-success"></i>
            </a>
            <a class="nav-link active" href="<?= base_url('index.php/user/mapa') ?>">
                <i class="bi bi-geo-alt-fill text-info"></i>
            </a>
            <a class="nav-link" href="<?= base_url('index.php/user/perfil') ?>">
                <i class="bi bi-person-fill text-primary"></i>
            </a>
        </div>
    </nav>

    <style>
    body {
        background-color: #f8f9fc;
        padding-top: 20px;
    }
    
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .ratio iframe {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    @media (max-width: 767px) {
        .btn-outline-primary {
            display: none;
        }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

