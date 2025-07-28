<div class="container mt-5">
    <h1 class="mb-4"><?= isset($vianda) ? 'Editar Vianda' : 'Agregar Vianda' ?></h1>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($vianda) ? base_url('admin/viandas/actualizar/' . $vianda['id']) : base_url('admin/viandas/guardar') ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= set_value('nombre', $vianda['nombre'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?= set_value('descripcion', $vianda['descripcion'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= set_value('precio', $vianda['precio'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">URL de imagen</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="<?= set_value('imagen', $vianda['imagen'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= base_url('admin/viandas/listar') ?>" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div> 