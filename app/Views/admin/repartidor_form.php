<div class="container mt-5">
    <h1 class="mb-4"><?= isset($repartidor) ? 'Editar Repartidor' : 'Agregar Repartidor' ?></h1>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($repartidor) ? base_url('admin/repartidores/actualizar/' . $repartidor['id']) : base_url('admin/repartidores/guardar') ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= set_value('nombre', $repartidor['nombre'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?= set_value('telefono', $repartidor['telefono'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $repartidor['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="vehiculo" class="form-label">Vehículo</label>
            <input type="text" class="form-control" id="vehiculo" name="vehiculo" value="<?= set_value('vehiculo', $repartidor['vehiculo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña <?= isset($repartidor) ? '(dejar vacío para no cambiar)' : '' ?></label>
            <input type="password" class="form-control" id="password" name="password" <?= isset($repartidor) ? '' : 'required' ?> autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= base_url('admin/repartidores/listar') ?>" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div> 