<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3><?= $titulo ?></h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('recepcionista/actualizar_usuario') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $usuario->id ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario->nombre ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->email ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= $usuario->telefono ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= $usuario->direccion ?>" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="<?= base_url('recepcionista/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>