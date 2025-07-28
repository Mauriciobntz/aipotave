<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-box me-2 text-success"></i>Gestionar Productos
    </h1>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-select">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= ($categoria_filtro == $categoria['id']) ? 'selected' : '' ?>>
                                <?= esc($categoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="activo" <?= ($estado_filtro == 'activo') ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo" <?= ($estado_filtro == 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre o descripción..." value="<?= esc($busqueda) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <a href="<?= base_url('cocina/productos') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Limpiar filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de productos -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Productos (<?= count($productos) ?>)</h5>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-warning" onclick="mostrarModalDesactivarCategoria()">
                    <i class="fas fa-eye-slash me-1"></i>Desactivar Categoría
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="mostrarModalDesactivarSubcategoria()">
                    <i class="fas fa-eye-slash me-1"></i>Desactivar Subcategoría
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($productos)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No se encontraron productos</h5>
                    <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Subcategoría</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($producto['imagen'])): ?>
                                                <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                                     alt="<?= esc($producto['nombre']) ?>" 
                                                     class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            <?php else: ?>
                                                <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px; border-radius: 8px;">
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
                                        <?php if (!empty($producto['subcategoria_nombre'])): ?>
                                            <span class="badge bg-<?= $subcategoria_color ?> text-white">
                                                <?= esc($producto['subcategoria_nombre']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Sin subcategoría</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong>$<?= number_format($producto['precio'], 2) ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($producto['activo'] == 1): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if ($producto['activo'] == 1): ?>
                                                <button type="button" class="btn btn-sm btn-warning" 
                                                        onclick="cambiarEstadoProducto(<?= $producto['id'] ?>, 'desactivar')"
                                                        title="Desactivar producto">
                                                    <i class="fas fa-eye-slash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-success" 
                                                        onclick="cambiarEstadoProducto(<?= $producto['id'] ?>, 'activar')"
                                                        title="Activar producto">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php endif; ?>
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
</div>

<!-- Modal para desactivar categoría -->
<div class="modal fade" id="desactivarCategoriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye-slash me-2"></i>Desactivar Productos por Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="desactivarCategoriaForm">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Categoría</label>
                        <select name="categoria_id" id="categoria_desactivar" class="form-select" required>
                            <option value="">Selecciona una categoría...</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>"><?= esc($categoria['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Esta acción desactivará todos los productos de la categoría seleccionada.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="confirmarDesactivarCategoria()">
                    <i class="fas fa-eye-slash me-2"></i>Desactivar Categoría
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para desactivar subcategoría -->
<div class="modal fade" id="desactivarSubcategoriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye-slash me-2"></i>Desactivar Productos por Subcategoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="desactivarSubcategoriaForm">
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Subcategoría</label>
                        <select name="subcategoria_id" id="subcategoria_desactivar" class="form-select" required>
                            <option value="">Selecciona una subcategoría...</option>
                            <?php foreach ($subcategorias as $subcategoria): ?>
                                <option value="<?= $subcategoria['id'] ?>"><?= esc($subcategoria['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Advertencia:</strong> Esta acción desactivará todos los productos de la subcategoría seleccionada.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarDesactivarSubcategoria()">
                    <i class="fas fa-eye-slash me-2"></i>Desactivar Subcategoría
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarEstadoProducto(productoId, accion) {
    const mensaje = accion === 'activar' ? 
        '¿Estás seguro de activar este producto?' : 
        '¿Estás seguro de desactivar este producto?';
    
    if (confirm(mensaje)) {
        fetch('<?= base_url('cocina/productos/cambiar-estado/') ?>' + productoId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                accion: accion
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado del producto');
        });
    }
}

function mostrarModalDesactivarCategoria() {
    document.getElementById('categoria_desactivar').value = '';
    new bootstrap.Modal(document.getElementById('desactivarCategoriaModal')).show();
}

function mostrarModalDesactivarSubcategoria() {
    document.getElementById('subcategoria_desactivar').value = '';
    new bootstrap.Modal(document.getElementById('desactivarSubcategoriaModal')).show();
}

function confirmarDesactivarCategoria() {
    const categoriaId = document.getElementById('categoria_desactivar').value;
    
    if (!categoriaId) {
        alert('Por favor selecciona una categoría');
        return;
    }
    
    if (confirm('¿Estás seguro de desactivar todos los productos de esta categoría? Esta acción no se puede deshacer fácilmente.')) {
        fetch('<?= base_url('cocina/productos/desactivar-categoria/') ?>' + categoriaId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('desactivarCategoriaModal')).hide();
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desactivar los productos de la categoría');
        });
    }
}

function confirmarDesactivarSubcategoria() {
    const subcategoriaId = document.getElementById('subcategoria_desactivar').value;
    
    if (!subcategoriaId) {
        alert('Por favor selecciona una subcategoría');
        return;
    }
    
    if (confirm('¿Estás seguro de desactivar todos los productos de esta subcategoría? Esta acción no se puede deshacer fácilmente.')) {
        fetch('<?= base_url('cocina/productos/desactivar-subcategoria/') ?>' + subcategoriaId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('desactivarSubcategoriaModal')).hide();
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al desactivar los productos de la subcategoría');
        });
    }
}
</script> 