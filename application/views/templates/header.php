<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - Veterinaria Municipal' : 'Veterinaria Municipal' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .min-height-50 {
            min-height: 50px;
        }
    </style>
   
    <style>
        .profile-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 0 1rem 80px;
        }
    
        .profile-card {
            background: #fff;
            border-radius: 10px;
            border: none;
            margin-bottom: 2rem;
        }
    
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
    
        .profile-header h2 {
            font-size: 1.8rem;
            margin-bottom: 0;
        }
    
        .form-section {
            padding: 2rem;
        }
    
        .form-group {
            margin-bottom: 1.5rem;
        }
    
        .form-control {
            border-radius: 8px;
        }
    
        .buttons-container {
            margin-top: 2rem;
            text-align: center;
        }
    
        .btn-profile {
            min-width: 200px;
            margin: 0.5rem;
            padding: 0.75rem 1.5rem;
        }
    
        .card-header {
            text-align: center;
            padding: 1rem;
        }
    
        /* Ajustes para dispositivos móviles */
        @media (max-width: 768px) {
            .profile-container {
                margin: 1rem auto;
            }
            
            .form-section {
                padding: 1rem;
            }
    
            .btn-profile {
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
    
    <!-- Segundo bloque de estilos -->
    <style>
        /* Reset de estilos para el perfil */
        .profile-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 20px;
            background: #fff;
            position: relative;
            z-index: 1;
        }
    
        /* Eliminar estilos que puedan estar interfiriendo */
        .profile-container * {
            box-sizing: border-box;
        }
    
        .profile-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }
    
        .form-section {
            padding: 1.5rem;
        }
    
        .form-group {
            margin-bottom: 1.25rem;
        }
    
        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
    
        .buttons-container {
            text-align: center;
            padding-top: 1rem;
        }
    
        .btn-profile {
            min-width: 200px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }
    
        /* Asegurar que el navbar móvil no interfiera */
        .navbar.fixed-bottom {
            z-index: 1000;
        }
    
        /* Ajustes para dispositivos móviles */
        @media (max-width: 768px) {
            .profile-container {
                margin: 1rem auto;
                padding: 15px;
            }
    
            .form-section {
                padding: 1rem;
            }
    
            .btn-profile {
                width: 100%;
            }
        }
    </style>
    
    <!-- Tercer bloque de estilos -->
    <style>
        .sidebar {
            min-height: 100vh;
            background:rgb(16, 57, 180);
            color: white;
        }
        .activity-log {
            max-height: 600px;
            overflow-y: auto;
        }
        .activity-item {
            border-left: 3px solid #4e73df;
            margin-bottom: 10px;
            padding: 10px;
            background: #f8f9fa;
        }
        .menu-card {
            transition: transform 0.2s;
            height: 100%;
            min-height: 120px;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .menu-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .btn-outline-danger {
            background-color: #dc3545;
            color: white;
            border: 2px solid #dc3545;
            font-weight: 500;
            padding: 6px 16px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-outline-danger:hover {
            background-color: white;
            color: #dc3545;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
        }
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0.5rem 1rem;
        }
        .navbar-custom .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        .navbar-custom .btn-outline-danger {
            position: absolute;
            right: 1rem;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }
        @media (max-width: 992px) {
            .navbar-custom .btn-outline-danger {
                position: static;
                margin-left: auto;
            }
        }
        .navbar-custom .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1.5rem;
            margin: 0 auto;
        }
        .navbar-custom .nav-link {
            color: #4e73df;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            white-space: nowrap;
        }
        .mobile-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
        }
        .mobile-nav .nav-link {
            text-align: center;
            padding: 0.5rem;
        }
        .mobile-nav .nav-link i {
            font-size: 1.5rem;
        }
        @media (max-width: 768px) {
            .mobile-nav {
                display: flex;
            }
            .desktop-nav {
                display: none;
            }
        }
        .navbar-custom .nav-link:hover {
            color: #2e59d9;
        }
        .navbar-custom .nav-link.active {
            color: #dc3545;
        }
        .card {
            max-width: 900px;
            margin: 0 auto;
        }
        
        @media (min-width: 992px) {
            .card {
                max-width: 800px;
            }
            .ratio-16x9 {
                max-height: 400px;
            }
        }
        /* Estilos para las tarjetas del menú principal */
        .card {
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .card .card-title {
            font-size: 0.9rem;
            margin: 0;
            text-align: center;
            font-weight: 500;
        }
    </style>
    <style>
        body {
            padding-left: 50px; /* Compensar el ancho del footer lateral */
            background-color: #f8f9fa;
        }
        
        @media (max-width: 768px) {
            body {
                padding-left: 0;
                padding-bottom: 60px; /* Espacio para el footer móvil */
            }
        }
    
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
    <style>
        /* Estilos específicos para el perfil */
        .profile-wrapper {
            min-height: calc(100vh - 120px);
            padding-top: 2rem;
            background-color: #f8f9fa;
            margin-left: 50px; /* Compensar el menú lateral */
        }
    
        @media (max-width: 768px) {
            .profile-wrapper {
                margin-left: 0;
                padding-bottom: 80px; /* Espacio para el menú móvil */
            }
        }
    
        /* Ajustes para la tarjeta de perfil */
        .card {
            background: #ffffff;
            border-radius: 8px;
        }
    
        .table-responsive {
            margin: -0.5rem; /* Compensar el padding interno */
        }
    
        .table th {
            font-weight: 600;
            color: #495057;
        }
    
        .table td {
            color: #6c757d;
        }
    
        /* Eliminar conflictos con otros estilos */
        .profile-wrapper .card {
            height: auto;
        }
    
        .profile-wrapper .card-body {
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    <style>
        .profile-section {
            padding: 2rem 0;
            min-height: calc(100vh - 60px);
            background-color: #f8f9fa;
        }
    
        .profile-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            border: none;
        }
    
        .profile-card .card-header {
            border-radius: 10px 10px 0 0;
            padding: 1.5rem;
        }
    
        .profile-card .card-body {
            padding: 2rem;
        }
    
        .info-grid {
            display: grid;
            gap: 1.5rem;
        }
    
        .info-item {
            display: grid;
            grid-template-columns: 120px 1fr;
            align-items: center;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
    
        .info-item label {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }
    
        .info-item span {
            color: #6c757d;
        }
    
        .action-buttons {
            margin-top: 2rem;
        }
    
        .action-buttons .btn {
            padding: 0.75rem;
            font-weight: 500;
        }
    
        @media (max-width: 768px) {
            .profile-section {
                padding: 1rem;
            }
    
            .info-item {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
    
            .profile-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>
    <style>
        .profile-info {
            padding: 20px;
            margin-top: 20px;
        }

        .card {
            margin-top: 30px;
            background-color: #ffffff;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-body {
            padding: 2rem;
        }

        .row.mb-3 {
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fc;
        }

        .fw-bold {
            color: #4e73df;
        }

        @media (max-width: 768px) {
            .card {
                margin-top: 15px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .profile-info {
                padding: 10px;
            }
        }
    </style>
    