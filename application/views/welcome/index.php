<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .welcome-container {
            background: transparent;
        }
        .hero-section {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            position: relative;
            width: 100%;
        }
        .hero-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #fff;
        }
        .info-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1rem 0;
            border-left: 5px solid #4CAF50;
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-5px);
        }
        .btn-login {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border: none;
            padding: 10px 20px;
            font-size: 0.9rem;
            border-radius: 50px;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1000;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
            color: white;
        }
        .feature-icon {
            font-size: 2rem;
            color: #4CAF50;
            margin-bottom: 1rem;
        }
        .service-image {
            width: 80px;
            height: auto;
        }
        .contact-section {
            padding: 1rem;
        }
        
        /* Media Queries para Responsividad */
        @media (min-width: 576px) {
            .hero-section {
                padding: 2.5rem 1.5rem;
            }
            .hero-icon {
                font-size: 3.5rem;
            }
            .btn-login {
                padding: 12px 25px;
                font-size: 1rem;
                top: 20px;
                right: 20px;
            }
            .service-image {
                width: 100px;
            }
        }
        
        @media (min-width: 768px) {
            .hero-section {
                padding: 3rem 2rem;
            }
            .hero-icon {
                font-size: 4rem;
            }
            .info-card {
                padding: 2rem;
            }
            .feature-icon {
                font-size: 2.5rem;
            }
            .service-image {
                width: 120px;
            }
            .contact-section {
                padding: 2rem;
            }
        }
        
        @media (min-width: 992px) {
            .hero-section {
                padding: 4rem 2rem;
            }
            .info-card {
                padding: 2.5rem;
            }
        }
        
        @media (max-width: 767px) {
            .hero-section h1 {
                font-size: 2rem;
            }
            .hero-section .lead {
                font-size: 1rem;
            }
            .info-card h4 {
                font-size: 1.2rem;
            }
            .info-card ul li {
                font-size: 0.9rem;
            }
            .btn-login {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="welcome-container">
            <!-- Hero Section -->
            <div class="hero-section">
                <!-- Botón de Login en esquina superior derecha -->
                <a href="<?php echo base_url('welcome/login'); ?>" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Acceder
                </a>
                
                <i class="fas fa-paw hero-icon"></i>
                <h1 class="display-4 fw-bold mb-3">Veterinaria Municipal de Linares</h1>
                <p class="lead mb-0">Cuidando a tus mascotas con amor y profesionalismo</p>
            </div>

            <!-- Content Section -->
            <div class="container-fluid py-5 px-4">
                <!-- Prestaciones Section -->
                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="text-center fw-bold text-primary mb-4">
                            <i class="fas fa-medical-kit me-2"></i>PRESTACIONES
                        </h2>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="d-flex flex-column flex-md-row align-items-start">
                                <div class="me-md-3 mb-3 mb-md-0 text-center text-md-start">
                                    <img src="<?php echo base_url('assets/img/logo_mascotas.svg'); ?>" alt="Veterinarios" class="service-image">
                                </div>
                                <div>
                                    <h4 class="fw-bold text-primary mb-3">Servicios que Realizamos</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-paw text-success me-2"></i>Atención gratuita sin detención para habitantes de la comuna de Linares (certificado de residencia o boleta de algún servicio).</li>
                                        <li class="mb-2"><i class="fas fa-syringe text-success me-2"></i>Consultas veterinarias, aplicación de medicamentos y vacunas.</li>
                                        <li class="mb-2"><i class="fas fa-ambulance text-success me-2"></i>Cirugías menores ambulatorias que no requieran de rayos X, ecografías, tomografías, etc.</li>
                                        <li class="mb-2"><i class="fas fa-cut text-success me-2"></i>Esterilizaciones, castraciones.</li>
                                        <li class="mb-2"><i class="fas fa-tooth text-success me-2"></i>Cirugías menores ambulatorias que no requieran de rayos X, ecografías, tomografías, etc.</li>
                                        <li class="mb-2"><i class="fas fa-dog text-success me-2"></i>Atención para perros y gatos, no importa la raza.</li>
                                        <li class="mb-2"><i class="fas fa-briefcase-medical text-success me-2"></i>Trabajo con la comunidad en el plan tenencia responsable.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="d-flex flex-column flex-md-row align-items-start">
                                <div class="me-md-3 mb-3 mb-md-0 text-center text-md-start">
                                    <img src="<?php echo base_url('assets/img/logo_mascotas.svg'); ?>" alt="Restricciones" class="service-image">
                                </div>
                                <div>
                                    <h4 class="fw-bold text-danger mb-3">PRESTACIONES QUE NO SE REALIZAN</h4>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Atención para habitantes que no tengan residencia en la comuna de Linares.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Cirugías mayores que requieran rayos X, ecografía, tomografías, etc. (fracturas).</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Atención domiciliaria.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Traslado de mascotas con dueño.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Hospitalizaciones.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Pensión.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Corta de uñas de gatos.</li>
                                        <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Animales exóticos.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Agendamiento -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="text-center fw-bold text-primary mb-4">
                            <i class="fas fa-calendar-alt me-2"></i>COMO SOLICITO ATENCIÓN PARA MI MASCOTA
                        </h2>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card bg-light">
                            <h4 class="text-center fw-bold text-info mb-4">
                                <i class="fas fa-clipboard-list me-2"></i>ATENCIÓN GENERAL
                            </h4>
                            <div class="text-start">
                                 <p class="mb-3"><i class="fas fa-phone text-success me-2"></i><strong>Para recibir atención de tu mascota debes agendar una hora llamando al teléfono: 73 2 564788</strong></p>
                                 <p class="mb-3"><i class="fas fa-info-circle text-primary me-2"></i><strong>Indicando los mayores antecedentes de tu mascota y su dueño y si es control o por alguna enfermedad específica</strong></p>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card bg-warning text-dark">
                            <h4 class="text-center fw-bold text-danger mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>¿Y SI ME ENCUENTRO EN UNA URGENCIA CON MI MASCOTA?
                            </h4>
                            <div class="text-start">
                                 <p class="mb-3"><i class="fas fa-ambulance text-danger me-2"></i><strong>SI TE ENCUENTRAS EN UNA URGENCIA CON TU MASCOTA NO ES NECESARIO QUE AGENDES UNA HORA.</strong></p>
                                 <p class="mb-0"><i class="fas fa-clock text-danger me-2"></i><strong>TENEMOS ATENCIÓN DE URGENCIAS</strong></p>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="text-center fw-bold text-primary mb-4">
                            <i class="fas fa-phone me-2"></i>CONTACTANOS
                        </h2>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card bg-light">
                            <h4 class="text-center fw-bold text-info mb-4">
                                <i class="fas fa-phone-alt me-2"></i>Teléfonos de contacto
                            </h4>
                            <div class="text-center">
                                <p class="h5 text-primary mb-3">
                                    <i class="fas fa-phone text-success me-2"></i>073 - 2 564788
                                </p>
                            </div>
                        </div>
                        
                        <div class="info-card bg-success text-white mt-4">
                            <div class="text-center">
                                <p class="mb-2"><strong>DIRECCIÓN:</strong> Maipú #954.</p>
                                <p class="mb-2"><strong>Teléfonos:</strong> 073 2 564788</p>
                                <p class="mb-2"><strong>Correo electrónico:</strong> veterinariamunicipal@corporacionlinares.cl</p>
                                <p class="mb-0"><strong>CORPORACIONLINARES.CL ©</strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-card contact-section">
                            <h4 class="text-center fw-bold text-primary mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>Nuestra Ubicación
                            </h4>
                            <div class="text-center">
                                <div class="ratio ratio-16x9 mb-3">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12567.090036206268!2d-71.5911302482761!3d-35.85308728613527!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9665f55b836a80d3%3A0xaeddbead1e70d9da!2sMaip%C3%BA%20954%2C%203580000%20Linares%2C%20Maule!5e0!3m2!1ses!2scl!4v1757696182924!5m2!1ses!2scl" 
                                            style="border:0; border-radius: 10px;" 
                                            allowfullscreen="" 
                                            loading="lazy" 
                                            referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                                <p class="mt-3 text-muted">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <strong>Maipú #954, Linares, Región del Maule</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>