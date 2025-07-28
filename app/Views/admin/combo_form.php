<div class="container mt-5">
    <h1 class="mb-4"><?= isset($combo) ? 'Editar Combo' : 'Agregar Combo' ?></h1>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($combo) ? base_url('admin/combos/actualizar/' . $combo['id']) : base_url('admin/combos/guardar') ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= set_value('nombre', $combo['nombre'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?= set_value('descripcion', $combo['descripcion'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= set_value('precio', $combo['precio'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">URL de imagen</label>
            <input type="text" class="form-control" id="imagen" name="imagen" value="<?= set_value('imagen', $combo['imagen'] ?? '') ?>">
        </div>
        <h5 class="mt-4">Productos en el combo</h5>
        <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td style="width:120px">
                                <input type="number" min="0" class="form-control" name="productos[<?= $producto['id'] ?>]" value="<?= esc($productos_en_combo[$producto['id']] ?? 0) ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= base_url('admin/combos/listar') ?>" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div> 