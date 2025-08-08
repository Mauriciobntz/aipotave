<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tags me-2"></i>Gestión de Categorías</h1>
        <a href="<?= base_url('admin/categorias/agregar') ?>" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Categoría
        </a>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Lista de Categorías</h5>
        </div>
        <div class="card-body">
            <?php if (empty($categorias)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay categorías registradas</h5>
                    <p class="text-muted">Comienza agregando tu primera categoría.</p>
                    <a href="<?= base_url('admin/categorias/agregar') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Categoría
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Orden</th>
                                <th>Productos Activos</th>
                                <th>Subcategorías</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><strong>#<?= $categoria['id'] ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fas fa-tag fa-lg"></i>
                                            </div>
                                            <div>
                                                <strong><?= esc($categoria['nombre']) ?></strong>
                                                <?php if (!empty($categoria['descripcion'])): ?>
                                                    <br><small class="text-muted"><?= esc($categoria['descripcion']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $categoria['orden'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?= $categoria['productos_count'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= $categoria['subcategorias_count'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <?php if ($categoria['activo']): ?>
                                            <span class="badge bg-success">Activa</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactiva</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/categorias/editar/' . $categoria['id']) ?>" 
                                               class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/categorias/eliminar/' . $categoria['id']) ?>" 
                                               class="btn btn-sm btn-danger" title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría? Esta acción no se puede deshacer.')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
        </a>
    </div>
</div> 