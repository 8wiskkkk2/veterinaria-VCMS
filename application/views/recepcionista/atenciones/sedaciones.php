<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorizaciones de Sedación - Veterinaria</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-syringe me-2"></i>Autorizaciones de Sedación
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabla-sedaciones" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Mascota</th>
                                <th>Propietario</th>
                                <th>Emergencia</th>
                                <th>Atendido por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($sedaciones) && !empty($sedaciones)): ?>
                                <?php foreach($sedaciones as $sedacion): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($sedacion->fecha)) ?></td>
                                        <td><?= $sedacion->nombre_mascota ?></td>
                                        <td><?= $sedacion->nombre_propietario ?></td>
                                        <td>
                                            <span class="badge <?= $sedacion->emergencia == 'si' ? 'bg-danger' : 'bg-success' ?>">
                                                <?= $sedacion->emergencia == 'si' ? 'Sí' : 'No' ?>
                                            </span>
                                        </td>
                                        <td><?= $sedacion->veterinario_tratante ? $sedacion->nombre_veterinario : 'No asignado' ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="generarPDF(<?= htmlspecialchars(json_encode($sedacion)) ?>)">
                                                    <i class="fas fa-file-pdf"></i> 
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="imprimirAutorizacion(<?= htmlspecialchars(json_encode($sedacion)) ?>)">
                                                    <i class="fas fa-print"></i> 
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabla-sedaciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
                },
                "order": [[0, "desc"]]
            });
        });

        function generarPDF(sedacion) {
            window.jsPDF = window.jspdf.jsPDF;
            const doc = new jsPDF();
            
            doc.setFont("helvetica");
            doc.setFontSize(16);
            
            doc.text("Autorización de Sedación", 105, 20, { align: "center" });
            
            doc.setFontSize(12);
            doc.text(`Fecha: ${new Date(sedacion.fecha).toLocaleDateString()}`, 20, 40);
            doc.text(`Mascota: ${sedacion.nombre_mascota}`, 20, 50);
            doc.text(`Propietario: ${sedacion.nombre_propietario}`, 20, 60);
            doc.text(`Motivo:`, 20, 70);
            
            const splitMotivo = doc.splitTextToSize(sedacion.motivo, 170);
            doc.text(splitMotivo, 20, 80);
            
            doc.line(20, 150, 90, 150);
            doc.line(120, 150, 190, 150);
            
            doc.text("Firma del Propietario", 35, 160);
            doc.text("Firma del Veterinario", 135, 160);
            
            doc.save(`autorizacion_sedacion_${sedacion.id}.pdf`);
        }

        function imprimirAutorizacion(sedacion) {
            const ventanaImpresion = window.open('', '_blank');
            
            const contenido = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Autorización de Sedación</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 40px; }
                        .titulo { text-align: center; font-size: 24px; margin-bottom: 30px; }
                        .info { margin-bottom: 20px; }
                        .consentimiento { margin: 20px 0; }
                        .consentimiento ul { padding-left: 20px; }
                        .consentimiento li { margin-bottom: 10px; }
                        .firmas { margin-top: 50px; display: flex; justify-content: space-between; }
                        .firma { text-align: center; width: 200px; }
                        .linea { border-top: 1px solid black; margin-bottom: 10px; }
                    </style>
                </head>
                <body>
                    <div class="titulo">Autorización de Sedación</div>
                    <div class="info">
                        <p><strong>Fecha:</strong> ${new Date(sedacion.fecha).toLocaleDateString()}</p>
                        <p><strong>Mascota:</strong> ${sedacion.nombre_mascota}</p>
                        <p><strong>Propietario:</strong> ${sedacion.nombre_propietario}</p>
                    
                    </div>
                    <div class="consentimiento">
                        <ul>
                            <li>1.- Por el presente documento autorizo a la Dr./Dra. de turno a realizar el procedimiento de cirugía de mi mascota antes individualizada.</li>
                            <li>2.- Declaro que el (los) médico (s) veterinario (s) tratante (s) me ha explicado e informado de los beneficios, complicaciones y riesgos que tiene el procedimiento. Además se me ha explicado que el procedimiento involucra riesgos generales y complicaciones que, a pesar de todas las medidas y cuidados efectuados por el equipo o profesional a cargo, puede ser inevitable.</li>
                            <li>3.- Así mismo estoy en conocimiento de que mi mascota será sometida a sedación y anestesia general, lo que puede estar asociado a complicaciones propias de la ejecución.</li>
                            <li>4.- Declaro que no he ocultado ningún tipo de información relevante al médico veterinario a cargo.</li>
                            <li>5.- Declaro estar al tanto que mi mascota no cuenta con exámenes previos como hemograma, perfil bioquímico, panel de coagulación ni ningún test de enfermedades contagiosas los cuales demuestren que mi mascota no presenta ninguna patología o condición previa que resulte peligrosa durante la cirugía.</li>
                            <li>6.- Declaro asumir mi total responsabilidad, cualquier inconveniente acontecido con mi mascota durante la cirugía como consecuencia de una complicación ocasionada por algún cuadro patológico no detectado por la no realización de estos exámenes. Por lo anterior eximo de toda responsabilidad al médico veterinario tratante y a la clínica veterinaria.</li>
                            <li>7.- Confirmo que he leído y aceptado todo lo anterior.</li>
                        </ul>
                    </div>
                    <div class="firmas">
                        <div class="firma">
                            <div class="linea"></div>
                            <p>Firma del Propietario</p>
                        </div>
                        <div class="firma">
                            <div class="linea"></div>
                            <p>Firma del Veterinario</p>
                        </div>
                    </div>
                </body>
                </html>
            `;
            
            ventanaImpresion.document.write(contenido);
            ventanaImpresion.document.close();
            
            // Esperar a que se cargue el contenido y luego imprimir
            ventanaImpresion.onload = function() {
                ventanaImpresion.print();
                ventanaImpresion.close();
            };
        }
    </script>
</body>
</html>