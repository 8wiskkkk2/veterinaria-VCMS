<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Emergencia - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <!-- Contenedor para imprimir -->
        <div id="contenido-imprimible">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-ambulance me-2"></i>Detalle de Atención de Urgencia
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2">Información de la Mascota</h5>
                            <p><strong>Nombre:</strong> <?= $emergencia->nombre_mascota ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2">Información de la Atención</h5>
                            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($emergencia->fecha_registro)) ?></p>
                            <p><strong>Nivel de Urgencia:</strong> 
                                <span class="badge <?= $emergencia->nivel_urgencia === 'alta' ? 'bg-danger' : 
                                    ($emergencia->nivel_urgencia === 'media' ? 'bg-warning' : 'bg-info') ?>">
                                    <?= ucfirst($emergencia->nivel_urgencia) ?>
                                </span>
                            </p>
                            <p><strong>Estado:</strong> 
                                <span class="badge <?= $emergencia->estado === 'atendido' ? 'bg-success' : 'bg-primary' ?>">
                                    <?= ucfirst($emergencia->estado) ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2">Detalles de la Atención</h5>
                            <p><strong>Motivo de Consulta:</strong></p>
                            <p class="ms-3"><?= $emergencia->motivo_consulta ?></p>
                            
                            <?php if($emergencia->anamnesis): ?>
                                <p><strong>Anamnesis:</strong></p>
                                <p class="ms-3"><?= $emergencia->anamnesis ?></p>
                            <?php endif; ?>
                            
                            <?php if($emergencia->diagnostico): ?>
                                <p><strong>Diagnóstico:</strong></p>
                                <p class="ms-3"><?= $emergencia->diagnostico ?></p>
                            <?php endif; ?>

                            <?php if($emergencia->tratamiento): ?>
                                <p><strong>Tratamiento:</strong></p>
                                <p class="ms-3"><?= $emergencia->tratamiento ?></p>
                            <?php endif; ?>

                            <?php if($emergencia->indicaciones): ?>
                                <p><strong>Indicaciones:</strong></p>
                                <p class="ms-3"><?= $emergencia->indicaciones ?></p>
                            <?php endif; ?>

                            <?php if($emergencia->observaciones): ?>
                                <p><strong>Observaciones:</strong></p>
                                <p class="ms-3"><?= $emergencia->observaciones ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <button onclick="imprimirEmergencia()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <button onclick="generarPDF()" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i>Generar PDF
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <script>
        function imprimirEmergencia() {
            const contenido = document.getElementById('contenido-imprimible').innerHTML;
            const ventanaImpresion = window.open('', '_blank');
            ventanaImpresion.document.write(`
                <html>
                    <head>
                        <title>Atención de Urgencia - Impresión</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            @page {
                                margin-top: -20mm;
                                margin-left: 0;
                                margin-right: 0;
                                margin-bottom: 0;
                                padding: 0;
                            }
                            @media print {
                                .mt-4 { display: none !important; }
                                .container { 
                                    max-width: 100% !important;
                                    width: 100% !important;
                                    margin-top: -160mm !important;
                                    padding: 0 !important;
                                }
                                .card {
                                    border: none !important;
                                    width: 100% !important;
                                    margin: 0 !important;
                                    padding-top: 0 !important;
                                    box-shadow: none !important;
                                }
                                .card-header {
                                    padding: 5px 15px !important;
                                    margin: 0 !important;
                                }
                                .card-body {
                                    padding: 15px !important;
                                    margin: 0 !important;
                                }
                                h3 {
                                    font-size: 24px !important;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                p {
                                    font-size: 16px !important;
                                    margin-bottom: 8px !important;
                                }
                                .row {
                                    margin: 10px 0 !important;
                                }
                                body {
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                * {
                                    margin-top: 0 !important;
                                    padding-top: 0 !important;
                                }
                                #contenido-imprimible {
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                            }
                            body {
                                padding: 0 !important;
                                margin: 0 !important;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            ${contenido}
                        </div>
                    </body>
                </html>
            `);
            ventanaImpresion.document.close();
            
            setTimeout(function() {
                ventanaImpresion.print();
                ventanaImpresion.close();
            }, 250);
        }

        function generarPDF() {
            const element = document.getElementById('contenido-imprimible');
            const opt = {
                margin: 1,
                filename: 'atencion-urgencia-<?= $emergencia->id ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>