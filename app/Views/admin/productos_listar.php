<div class="container mt-5">
    <h1 class="mb-4">Listado de Productos</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <a href="<?= base_url('admin/panel') ?>" class="btn btn-info mb-3">Ir al panel admin</a>
    <a href="<?= base_url('admin/productos/agregar') ?>" class="btn btn-success mb-3">Agregar producto</a>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="comida" <?= ($tipo_filtro == 'comida') ? 'selected' : '' ?>>Comida</option>
                        <option value="bebida" <?= ($tipo_filtro == 'bebida') ? 'selected' : '' ?>>Bebida</option>
                        <option value="vianda" <?= ($tipo_filtro == 'vianda') ? 'selected' : '' ?>>Vianda</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" id="categoria_filtro">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= ($categoria_filtro == $categoria['id']) ? 'selected' : '' ?>>
                                <?= esc($categoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Subcategoría</label>
                    <select name="subcategoria_id" class="form-select" id="subcategoria_filtro">
                        <option value="">Todas las subcategorías</option>
                        <?php foreach ($subcategorias as $subcategoria): ?>
                            <option value="<?= $subcategoria['id'] ?>" <?= ($subcategoria_filtro == $subcategoria['id']) ? 'selected' : '' ?>>
                                <?= esc($subcategoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="activo" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" <?= ($activo_filtro === '1') ? 'selected' : '' ?>>Activos</option>
                        <option value="0" <?= ($activo_filtro === '0') ? 'selected' : '' ?>>Inactivos</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="<?= base_url('admin/productos/listar') ?>" class="btn btn-outline-secondary ms-2">Limpiar filtros</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Categoría</th>
                    <th>Subcategoría</th>
                    <th>Precio</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= esc($producto['id']) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if (!empty($producto['imagen'])): ?>
                                    <img src="<?= base_url('public/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <div class="me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f8f9fa; border-radius: 4px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <strong><?= esc($producto['nombre']) ?></strong>
                                    <?php if (!empty($producto['descripcion'])): ?>
                                        <br><small class="text-muted"><?= esc(substr($producto['descripcion'], 0, 50)) ?><?= strlen($producto['descripcion']) > 50 ? '...' : '' ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-<?= $producto['tipo'] == 'comida' ? 'success' : ($producto['tipo'] == 'bebida' ? 'info' : 'warning') ?>"><?= ucfirst(esc($producto['tipo'])) ?></span></td>
                        <td>
                            <?php 
                            // Color aleatorio para categoría basado en su ID
                            $categoria_colores = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                            $categoria_color = $categoria_colores[($producto['categoria_id'] ?? 0) % count($categoria_colores)];
                            ?>
                            <span class="badge bg-<?= $categoria_color ?> text-white">
                                <?= esc($producto['categoria_nombre'] ?? 'Sin categoría') ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            // Color aleatorio para subcategoría basado en su ID
                            $subcategoria_colores = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                            $subcategoria_color = $subcategoria_colores[($producto['subcategoria_id'] ?? 0) % count($subcategoria_colores)];
                            ?>
                            <span class="badge bg-<?= $subcategoria_color ?> text-white">
                                <?= esc($producto['subcategoria_nombre'] ?? 'Sin subcategoría') ?>
                            </span>
                        </td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= $producto['activo'] ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('admin/productos/editar/' . $producto['id']) ?>" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($producto['activo']): ?>
                                    <a href="<?= base_url('admin/productos/desactivar/' . $producto['id']) ?>" class="btn btn-sm btn-warning" title="Desactivar" onclick="return confirm('¿Desactivar este producto?')">
                                        <i class="fas fa-eye-slash"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('admin/productos/activar/' . $producto['id']) ?>" class="btn btn-sm btn-success" title="Activar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/productos/eliminar/' . $producto['id']) ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Eliminar este producto? Esta acción no se puede deshacer.')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($productos)): ?>
        <div class="text-center py-4">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No se encontraron productos</h5>
            <p class="text-muted">Intenta ajustar los filtros o agregar nuevos productos.</p>
        </div>
    <?php endif; ?>
</div>

<script>
// Cargar subcategorías cuando se selecciona una categoría
document.getElementById('categoria_filtro').addEventListener('change', function() {
    const categoriaId = this.value;
    const subcategoriaSelect = document.getElementById('subcategoria_filtro');
    
    // Limpiar subcategorías
    subcategoriaSelect.innerHTML = '<option value="">Todas las subcategorías</option>';
    
    if (categoriaId) {
        fetch('<?= base_url('admin/productos/subcategorias') ?>/' + categoriaId)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategoria => {
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre;
                    subcategoriaSelect.appendChild(option);
                });
            });
    }
});
</script> 