<div class="container mt-5">
    <h1 class="mb-4">Listado de Viandas</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <a href="<?= base_url('admin/viandas/crear') ?>" class="btn btn-success mb-3">Agregar vianda</a>
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
                <?php foreach ($viandas as $vianda): ?>
                    <tr>
                        <td><?= esc($vianda['id']) ?></td>
                        <td><?= esc($vianda['nombre']) ?></td>
                        <td>$<?= number_format($vianda['precio'], 2) ?></td>
                        <td><?= $vianda['activo'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td>
                            <a href="<?= base_url('admin/viandas/editar/' . $vianda['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="<?= base_url('admin/viandas/eliminar/' . $vianda['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta vianda?')">Eliminar</a>
                            <a href="<?= base_url('admin/viandas/stock/' . $vianda['id']) ?>" class="btn btn-sm btn-warning">Stock</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 