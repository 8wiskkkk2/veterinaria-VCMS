<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h3><i class="fas fa-syringe me-2"></i>Nueva Autorización para Sedación</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/autorizaciones/sedacion/guardar') ?>" method="POST">
                <!-- Sección de datos del paciente -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-paw me-2"></i>Datos del paciente</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="mascota_nombre" class="form-label">Nombre de la mascota *</label>
                                    <input type="text" class="form-control" id="mascota_nombre" name="mascota_nombre" required>
                                    <input type="hidden" id="mascota_id" name="mascota_id">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="especie" class="form-label">Especie</label>
                                    <input type="text" class="form-control" id="especie" name="especie" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="edad" class="form-label">Edad</label>
                                    <input type="text" class="form-control" id="edad" name="edad" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="raza" class="form-label">Raza</label>
                                    <input type="text" class="form-control" id="raza" name="raza" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <input type="text" class="form-control" id="sexo" name="sexo" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" class="form-control" id="color" name="color" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de datos del dueño -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-user me-2"></i>Datos del dueño/tutor/responsable</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="propietario_nombre" class="form-label">Nombre completo</label>
                                    <input type="text" class="form-control" id="propietario_nombre" name="propietario_nombre" readonly>
                                    <input type="hidden" id="propietario_id" name="propietario_id">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="propietario_telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="propietario_telefono" name="propietario_telefono" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="propietario_rut" class="form-label">RUT</label>
                                    <input type="text" class="form-control" id="propietario_rut" name="propietario_rut" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="propietario_direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="propietario_direccion" name="propietario_direccion" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-syringe me-2"></i>Detalles de la Sedación</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="emergencia" class="form-label">¿Es una sedación de emergencia? *</label>
                            <select class="form-select" id="emergencia" name="emergencia" required>
                                <option value="">Seleccione una opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                <div class="form-group mb-3">
                    <label for="veterinario_tratante" class="form-label">Veterinario Tratante *</label>
                    <select class="form-select" id="veterinario_tratante" name="veterinario_tratante" required>
                        <option value="">Seleccione un veterinario</option>
                        <?php foreach($veterinarios as $veterinario): ?>
                            <option value="<?= $veterinario->id ?>"><?= $veterinario->nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
               
                
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Consentimiento Informado</h5>
                    <p class="mb-0">Al marcar la siguiente casilla, confirmo que:</p>
                    <ul class="mb-0">
                        <li>1.- Por el presente documento autorizo a la Dr./Dra. de turno a realizar el procedimiento de cirugía de mi mascota antes individualizada.</li>
                        <li>2.- Declaro que el (los) médico (s) veterinario (s) tratante (s) me ha explicado e informado de los beneficios, complicaciones y riesgos que tiene el procedimiento. Además se me ha explicado que el procedimiento involucra riesgos generales y complicaciones que, a pesar de todas las medidas y cuidados efectuados por el equipo o profesional a cargo, puede ser inevitable.</li>
                        <li>3.- Así mismo estoy en conocimiento de que mi mascota será sometida a sedación y anestesia general, lo que puede estar asociado a complicaciones propias de la ejecución.</li>
                        <li>4.- Declaro que no he ocultado ningún tipo de información relevante al médico veterinario a cargo.</li>
                        <li>5.- Declaro estar al tanto que mi mascota no cuenta con exámenes previos como hemograma, perfil bioquímico, panel de coagulación ni ningún test de enfermedades contagiosas los cuales demuestren que mi mascota no presenta ninguna patología o condición previa que resulte peligrosa durante la cirugía.</li>
                        <li>6.- Declaro asumir mi total responsabilidad, cualquier inconveniente acontecido con mi mascota durante la cirugía como consecuencia de una complicación ocasionada por algún cuadro patológico no detectado por la no realización de estos exámenes. Por lo anterior eximo de toda responsabilidad al médico veterinario tratante y a la clínica veterinaria.</li>
                        <li>7.- Confirmo que he leído y aceptado todo lo anterior.</li>
                    </ul>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmacion" name="confirmacion" required>
                    <label class="form-check-label" for="confirmacion">
                        Confirmo que he leído y acepto los términos del consentimiento informado
                    </label>
                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <!-- Agregar al inicio del archivo, después del container -->
                    <div class="container mt-4">
                        <a href="<?= base_url('recepcionista/autorizaciones') ?>" class="btn btn-secondary mb-3">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Guardar Autorización
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Agregar en el <head> del documento -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- Estilos para el autocompletado -->
<style>
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1000 !important;
}
</style>

<!-- Script para el autocompletado -->
<script>
$(document).ready(function() {
    $("#mascota_nombre").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= base_url('recepcionista/buscar_mascotas') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    query: request.term
                },
                success: function(data) {
                    var transformedData = data.map(function(item) {
                        return {
                            id: item.id,
                            nombre: item.nombre,
                            especie: item.especie,
                            raza: item.raza,
                            edad: item.edad_aproximada,
                            sexo: item.sexo,
                            color: item.color,
                            nombre_propietario: item.nombre_propietario,
                            rut_propietario: item.rut_propietario,
                            telefono_propietario: item.telefono_propietario,
                            direccion_propietario: item.direccion_propietario,
                            label: item.nombre + ' - ' + item.especie + ' (' + item.nombre_propietario + ')'
                        };
                    });
                    response(transformedData);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la búsqueda:", error);
                    response([]);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#mascota_id").val(ui.item.id);
            $("#mascota_nombre").val(ui.item.nombre);
            $("#especie").val(ui.item.especie);
            $("#raza").val(ui.item.raza);
            $("#edad").val(ui.item.edad);
            $("#sexo").val(ui.item.sexo);
            $("#color").val(ui.item.color);
            
            // Datos del propietario
            $("#propietario_nombre").val(ui.item.nombre_propietario);
            $("#propietario_rut").val(ui.item.rut_propietario);
            $("#propietario_telefono").val(ui.item.telefono_propietario);
            $("#propietario_direccion").val(ui.item.direccion_propietario);
            
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $('<li>')
            .append('<div>' + item.nombre + ' - ' + item.especie + ' (' + item.nombre_propietario + ')</div>')
            .appendTo(ul);
    };
});
</script>
