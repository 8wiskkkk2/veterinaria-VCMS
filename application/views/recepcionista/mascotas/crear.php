<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3><?= $titulo ?></h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/guardar_mascota') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre de la Mascota</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="especie" class="form-label">Especie</label>
                        <input type="text" class="form-control" id="especie" name="especie" list="lista-especies" placeholder="Escriba para buscar..." required>
                        <input type="hidden" id="especie_id" name="especie_id">
                        <datalist id="lista-especies"></datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="raza" class="form-label">Raza</label>
                        <select class="form-select" id="raza" name="raza" required disabled>
                            <option value="">Seleccione especie primero</option>
                        </select>
                        <input type="hidden" id="raza_id" name="raza_id">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="">Seleccione</option>
                            <option value="Macho">Macho</option>
                            <option value="Hembra">Hembra</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edad_aproximada" class="form-label">Edad Aproximada (años)</label>
                        <input type="number" class="form-control" id="edad_aproximada" name="edad_aproximada" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="peso" class="form-label">Peso (kg)</label>
                        <input type="number" step="0.1" class="form-control" id="peso" name="peso" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="estado_reproductivo" class="form-label">Estado Reproductivo</label>
                        <select class="form-select" id="estado_reproductivo" name="estado_reproductivo" required>
                            <option value="no esterilizado">No Esterilizado</option>
                            <option value="esterilizado">Esterilizado</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="buscar_propietario" class="form-label">Buscar Propietario</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="buscar_propietario" 
                                   placeholder="Escriba el nombre del propietario">
                            <input type="hidden" id="usuario_id" name="usuario_id" required>
                        </div>
                        <div id="resultados_busqueda" class="position-absolute bg-white border rounded shadow-sm" style="z-index: 1000; width: 100%; display: none; max-height: 200px; overflow-y: auto;"></div>
                        <div id="propietario_seleccionado" class="form-text mt-2"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alergias_conocidas" class="form-label">Alergias Conocidas</label>
                    <textarea class="form-control" id="alergias_conocidas" name="alergias_conocidas" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('recepcionista/mascotas') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Mascota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let timeoutId;

document.getElementById('buscar_propietario').addEventListener('input', function(e) {
    clearTimeout(timeoutId);
    const busqueda = e.target.value.trim();
    const resultadosDiv = document.getElementById('resultados_busqueda');
    
    if(busqueda.length < 2) {
        resultadosDiv.style.display = 'none';
        return;
    }

    timeoutId = setTimeout(() => {
        fetch(`<?= base_url('recepcionista/buscar_propietario_nombre') ?>/${encodeURIComponent(busqueda)}`)
            .then(response => response.json())
            .then(data => {
                if(data.success && data.usuarios.length > 0) {
                    resultadosDiv.innerHTML = data.usuarios.map(usuario => `
                        <div class="p-2 cursor-pointer hover-bg-light propietario-item" 
                             data-id="${usuario.id}" 
                             data-nombre="${usuario.nombre}">
                            ${usuario.nombre} - ${usuario.rut}
                        </div>
                    `).join('');
                    resultadosDiv.style.display = 'block';

                    // Agregar eventos click a los resultados
                    document.querySelectorAll('.propietario-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const id = this.dataset.id;
                            const nombre = this.dataset.nombre;
                            document.getElementById('usuario_id').value = id;
                            document.getElementById('buscar_propietario').value = nombre;
                            document.getElementById('propietario_seleccionado').innerHTML = 
                                `<div class="text-success">Propietario seleccionado: ${nombre}</div>`;
                            resultadosDiv.style.display = 'none';
                        });
                    });
                } else {
                    resultadosDiv.innerHTML = '<div class="p-2">No se encontraron resultados</div>';
                    resultadosDiv.style.display = 'block';
                }
            })
            .catch(error => {
                resultadosDiv.innerHTML = '<div class="p-2 text-danger">Error al buscar propietarios</div>';
                resultadosDiv.style.display = 'block';
            });
    }, 300);
});

// Cerrar resultados cuando se hace clic fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('#buscar_propietario') && !e.target.closest('#resultados_busqueda')) {
        document.getElementById('resultados_busqueda').style.display = 'none';
    }
});

// --- Autocompletar Especie y Raza ---
const especieInput = document.getElementById('especie');
const especieIdInput = document.getElementById('especie_id');
const listaEspecies = document.getElementById('lista-especies');

const razaSelect = document.getElementById('raza');
const razaIdInput = document.getElementById('raza_id');

let especieTimer;
especieInput.addEventListener('input', function(e) {
    clearTimeout(especieTimer);
    const term = e.target.value.trim();
    especieIdInput.value = '';
    if (term.length < 1) { listaEspecies.innerHTML = ''; return; }
    especieTimer = setTimeout(() => {
        fetch(`<?= base_url('recepcionista/buscar_especies') ?>?term=${encodeURIComponent(term)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(items => {
                listaEspecies.innerHTML = '';
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.nombre;
                    option.dataset.id = item.id;
                    listaEspecies.appendChild(option);
                });
            })
            .catch(() => { /* silencio */ });
    }, 250);
});

// Cuando se sale del campo, si coincide con una opción, fijar ID
especieInput.addEventListener('change', function() {
    const val = especieInput.value.trim().toLowerCase();
    let matchedId = '';
    listaEspecies.querySelectorAll('option').forEach(opt => {
        if (opt.value.toLowerCase() === val) { matchedId = opt.dataset.id; }
    });
    especieIdInput.value = matchedId;
    // Al elegir especie, limpiar raza y cargar opciones
    razaSelect.innerHTML = '<option value="">Cargando razas...</option>';
    razaSelect.disabled = true;
    razaIdInput.value = '';
    if (matchedId) { cargarRazas(matchedId); }
});

function cargarRazas(especieId) {
    fetch(`<?= base_url('recepcionista/buscar_razas') ?>?especie_id=${encodeURIComponent(especieId)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(r => r.json())
        .then(items => {
            if (!items || items.length === 0) {
                razaSelect.innerHTML = '<option value="">Sin razas registradas</option>';
                razaSelect.disabled = true;
                return;
            }
            razaSelect.innerHTML = '<option value="">Seleccione raza</option>';
            items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.nombre; // mantenemos compatibilidad guardando nombre
                opt.textContent = item.nombre;
                opt.dataset.id = item.id;
                razaSelect.appendChild(opt);
            });
            razaSelect.disabled = false;
        })
        .catch(() => { /* silencio */ });
}

razaSelect.addEventListener('change', function() {
    const selected = razaSelect.options[razaSelect.selectedIndex];
    razaIdInput.value = selected ? (selected.dataset.id || '') : '';
});

// Validación del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    if(!document.getElementById('usuario_id').value) {
        e.preventDefault();
        alert('Por favor, seleccione un propietario válido');
    }
    // Opcional: advertir si no se capturó ID de especie/raza
    // No bloqueamos envío para mantener compatibilidad con nombres libres
});
</script>

<style>
.input-group {
    width: 100%;
    max-width: 100%;
    position: relative;
}

#resultados_busqueda {
    position: absolute;
    width: 100%;
    max-width: 100%;
    margin-top: 2px;
    border: 1px solid #ced4da;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    z-index: 1000;
    left: 0;
    right: 0;
}

.propietario-item {
    padding: 4px 8px;
    cursor: pointer;
    transition: background-color 0.2s;
    font-size: 0.813rem;
    border-bottom: 1px solid #eee;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.propietario-item:hover {
    background-color: #f8f9fa;
}

.propietario-item:last-child {
    border-bottom: none;
}

#propietario_seleccionado {
    font-size: 0.813rem;
    margin-top: 4px;
    color: #28a745;
}

.col-md-4 {
    position: relative;
}
.propietario-item:hover {
    background-color: #f8f9fa;
}

.propietario-item:last-child {
    border-bottom: none;
}

#propietario_seleccionado {
    font-size: 0.875rem;
    margin-top: 4px;
    color: #28a745;
}
</style>

