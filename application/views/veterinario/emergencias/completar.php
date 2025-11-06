<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Atención de Urgencia - Veterinaria</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            margin-bottom: 2rem;
        }
        .card-header {
            background-color: #dc3545;
            color: white;
            border-bottom: none;
            padding: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        textarea.form-control {
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="fas fa-ambulance me-2"></i>Completar Atención de Urgencia
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('veterinario/completar_emergencia/'.$emergencia->id) ?>" method="POST">
                    <!-- Información de la Mascota -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="border-bottom pb-2">Información de la Mascota</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" value="<?= $mascota->nombre ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Especie</label>
                                <input type="text" class="form-control" value="<?= $mascota->especie ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Raza</label>
                                <input type="text" class="form-control" value="<?= $mascota->raza ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de la Atención -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="border-bottom pb-2">Detalles de la Atención</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Motivo de Consulta</label>
                                <textarea class="form-control" readonly><?= $emergencia->motivo_consulta ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Nivel de Urgencia</label>
                                <input type="text" class="form-control" value="<?= ucfirst($emergencia->nivel_urgencia) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="anamnesis" class="form-label">Anamnesis</label>
                                <textarea class="form-control" id="anamnesis" name="anamnesis" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="diagnostico" class="form-label">Diagnóstico</label>
                                <textarea class="form-control" id="diagnostico" name="diagnostico" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="tratamiento" class="form-label">Tratamiento</label>
                                <textarea class="form-control" id="tratamiento" name="tratamiento" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="indicaciones" class="form-label">Indicaciones</label>
                                <textarea class="form-control" id="indicaciones" name="indicaciones" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('veterinario/emergencias') ?>" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Atención
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
