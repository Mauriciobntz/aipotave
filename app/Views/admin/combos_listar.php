<div class="container mt-5">
    <h1 class="mb-4">Listado de Combos</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <a href="<?= base_url('admin/combos/crear') ?>" class="btn btn-success mb-3">Agregar combo</a>
    <a href="<?= base_url('admin/panel') ?>" class="btn btn-info mb-3">Ir al panel admin</a>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($combos as $combo): ?>
                    <tr>
                        <td><?= esc($combo['id']) ?></td>
                        <td><?= esc($combo['nombre']) ?></td>
                        <td>$<?= number_format($combo['precio'], 2) ?></td>
                        <td><?= $combo['activo'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td>
                            <a href="<?= base_url('admin/combos/editar/' . $combo['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="<?= base_url('admin/combos/eliminar/' . $combo['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este combo?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 