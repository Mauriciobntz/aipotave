<div class="container mt-5">
    <h1 class="mb-4">Listado de Repartidores</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <a href="<?= base_url('admin/panel') ?>" class="btn btn-info mb-3">Ir al panel admin</a>
    <a href="<?= base_url('admin/repartidores/crear') ?>" class="btn btn-success mb-3">Agregar repartidor</a>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Vehículo</th>
                    <th>Activo</th>
                    <th>Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repartidores as $r): ?>
                    <tr>
                        <td><?= esc($r['id']) ?></td>
                        <td><?= esc($r['nombre']) ?></td>
                        <td><?= esc($r['telefono']) ?></td>
                        <td><?= esc($r['email']) ?></td>
                        <td><?= esc($r['vehiculo']) ?></td>
                        <td><?= $r['activo'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td><?= $r['disponible'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td>
                            <a href="<?= base_url('admin/repartidores/editar/' . $r['id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                            <a href="<?= base_url('admin/repartidores/eliminar/' . $r['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este repartidor?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 