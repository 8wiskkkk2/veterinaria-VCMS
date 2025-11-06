<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3><?= $titulo ?></h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/actualizar_mascota') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $mascota->id ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre de la Mascota</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $mascota->nombre ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="especie" class="form-label">Especie</label>
                        <input type="text" class="form-control" id="especie" name="especie" value="<?= $mascota->especie ?>" list="lista-especies" placeholder="Escriba para buscar..." required>
                        <input type="hidden" id="especie_id" name="especie_id">
                        <datalist id="lista-especies"></datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="raza" class="form-label">Raza</label>
                        <select class="form-select" id="raza" name="raza" required>
                            <option value="<?= htmlspecialchars($mascota->raza, ENT_QUOTES) ?>" selected><?= htmlspecialchars($mascota->raza, ENT_QUOTES) ?></option>
                        </select>
                        <input type="hidden" id="raza_id" name="raza_id">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="color" name="color" value="<?= $mascota->color ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo" required>
                            <option value="Macho" <?= ($mascota->sexo == 'Macho') ? 'selected' : '' ?>>Macho</option>
                            <option value="Hembra" <?= ($mascota->sexo == 'Hembra') ? 'selected' : '' ?>>Hembra</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="edad_aproximada" class="form-label">Edad Aproximada (años)</label>
                    <input type="number" class="form-control" id="edad_aproximada" name="edad_aproximada" value="<?= $mascota->edad_aproximada ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="peso" class="form-label">Peso (kg)</label>
                    <input type="number" step="0.1" class="form-control" id="peso" name="peso" value="<?= $mascota->peso ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="estado_reproductivo" class="form-label">Estado Reproductivo</label>
                    <select class="form-select" id="estado_reproductivo" name="estado_reproductivo" required>
                        <option value="no esterilizado" <?= ($mascota->estado_reproductivo == 'no esterilizado') ? 'selected' : '' ?>>No Esterilizado</option>
                        <option value="esterilizado" <?= ($mascota->estado_reproductivo == 'esterilizado') ? 'selected' : '' ?>>Esterilizado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="usuario_id" class="form-label">Propietario</label>
                    <select class="form-select" id="usuario_id" name="usuario_id" required>
                        <?php foreach($propietarios as $propietario): ?>
                            <option value="<?= $propietario->id ?>" <?= ($propietario->id == $mascota->usuario_id) ? 'selected' : '' ?>>
                                <?= $propietario->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
                <div class="mb-3">
                    <label for="alergias_conocidas" class="form-label">Alergias Conocidas</label>
                    <textarea class="form-control" id="alergias_conocidas" name="alergias_conocidas" rows="3"><?= $mascota->alergias_conocidas ?></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('recepcionista/mascotas') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Actualizar Mascota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Autocompletar Especie y Raza (igual que en crear)
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
            .catch(() => {});
    }, 250);
});

especieInput.addEventListener('change', function() {
    const val = especieInput.value.trim().toLowerCase();
    let matchedId = '';
    listaEspecies.querySelectorAll('option').forEach(opt => {
        if (opt.value.toLowerCase() === val) { matchedId = opt.dataset.id; }
    });
    especieIdInput.value = matchedId;
    // Al elegir especie, cargar razas
    razaSelect.innerHTML = '<option value="">Cargando razas...</option>';
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
                return;
            }
            const currentValue = '<?= addslashes($mascota->raza) ?>'.toLowerCase();
            razaSelect.innerHTML = '<option value="">Seleccione raza</option>';
            items.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.nombre; // guardamos nombre
                opt.textContent = item.nombre;
                opt.dataset.id = item.id;
                if (item.nombre.toLowerCase() === currentValue) { opt.selected = true; }
                razaSelect.appendChild(opt);
            });
        })
        .catch(() => {});
}

razaSelect.addEventListener('change', function() {
    const selected = razaSelect.options[razaSelect.selectedIndex];
    razaIdInput.value = selected ? (selected.dataset.id || '') : '';
});

// Al cargar la página, si hay especie ya escrita, intenta cargar razas
document.addEventListener('DOMContentLoaded', function() {
    const val = especieInput.value.trim();
    if (val.length > 0) {
        // Dispara la carga para la especie actual
        especieInput.dispatchEvent(new Event('input'));
        setTimeout(() => especieInput.dispatchEvent(new Event('change')), 300);
    }
});
</script>