<style>
    .banner {
        background: linear-gradient(135deg, #2359fc 0%, #1d4ed8 100%);
        padding: 2rem 1rem;
        border-radius: 0 0 25px 25px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .banner h2 {
        color: white;
        margin: 0;
        font-size: 1.75rem;
        text-align: center;
    }

    .banner .bi-calendar {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        display: block;
    }


        .card-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 2rem;
        }

        .card-title {
            color: #2359fc;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .coming-soon-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: none;
        }

        .coming-soon-icon {
            font-size: 4rem;
            color: #2359fc;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 767px) {
            .btn-outline-primary {
                display: none;
            }

            .coming-soon-card {
                margin: 0;
            }

            .container {
                padding-bottom: 4rem;
            }

            .card-container {
                margin: 1rem -0.5rem;
                border-radius: 10px;
            }
        }
    </style>

    <div class="container mt-4">
        <a href="<?= base_url('index.php/user/index') ?>" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <div class="card-container">
            <h2 class="card-title">Mis Citas</h2>
            <div class="coming-soon-card">
                <i class="bi bi-clock coming-soon-icon"></i>
                <h3 class="mb-3">Próximamente</h3>
                <p class="text-muted mb-0">
                    Estamos trabajando para traerte la mejor experiencia en la gestión de tus citas veterinarias.
                    Esta función estará disponible muy pronto.
                </p>
            </div>
        </div>
    </div>

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
            <a class="nav-link" href="<?= base_url('index.php/user/mapa') ?>">
                <i class="bi bi-geo-alt-fill text-info"></i>
            </a>
            <a class="nav-link" href="<?= base_url('index.php/user/perfil') ?>">
                <i class="bi bi-person-fill text-primary"></i>
            </a>
        </div>
    </nav>

