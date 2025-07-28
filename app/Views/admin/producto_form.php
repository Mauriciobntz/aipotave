<?php
$errors = session('errors') ?? [];
?>
<div class="container mt-5">
    <h1 class="mb-4"><?= isset($producto) ? 'Editar Producto' : 'Agregar Producto' ?></h1>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($producto) ? base_url('admin/productos/actualizar/' . $producto['id']) : base_url('admin/productos/guardar') ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información del Producto</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>" 
                                           id="nombre" name="nombre" value="<?= old('nombre', $producto['nombre'] ?? '') ?>" required>
                                    <?php if (isset($errors['nombre'])): ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['nombre'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">Tipo *</label>
                                    <select class="form-select <?= isset($errors['tipo']) ? 'is-invalid' : '' ?>" id="tipo" name="tipo" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="comida" <?= set_select('tipo', 'comida', ($producto['tipo'] ?? '') === 'comida') ?>>Comida</option>
                                        <option value="bebida" <?= set_select('tipo', 'bebida', ($producto['tipo'] ?? '') === 'bebida') ?>>Bebida</option>
                                        <option value="vianda" <?= set_select('tipo', 'vianda', ($producto['tipo'] ?? '') === 'vianda') ?>>Vianda</option>
                                    </select>
                                    <?php if (isset($errors['tipo'])): ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['tipo'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria_id" class="form-label">Categoría</label>
                                    <select class="form-select" id="categoria_id" name="categoria_id">
                                        <option value="">Seleccionar categoría</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= $categoria['id'] ?>" <?= set_select('categoria_id', $categoria['id'], ($producto['categoria_id'] ?? '') == $categoria['id']) ?>>
                                                <?= esc($categoria['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subcategoria_id" class="form-label">Subcategoría</label>
                                    <select class="form-select" id="subcategoria_id" name="subcategoria_id">
                                        <option value="">Seleccionar subcategoría</option>
                                        <?php if (isset($subcategorias)): ?>
                                            <?php foreach ($subcategorias as $subcategoria): ?>
                                                <option value="<?= $subcategoria['id'] ?>" <?= set_select('subcategoria_id', $subcategoria['id'], ($producto['subcategoria_id'] ?? '') == $subcategoria['id']) ?>>
                                                    <?= esc($subcategoria['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>" 
                                      id="descripcion" name="descripcion" rows="3"><?= old('descripcion', $producto['descripcion'] ?? '') ?></textarea>
                            <?php if (isset($errors['descripcion'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['descripcion'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Precio *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control <?= isset($errors['precio']) ? 'is-invalid' : '' ?>" 
                                               id="precio" name="precio" value="<?= old('precio', $producto['precio'] ?? '') ?>" required>
                                    </div>
                                    <?php if (isset($errors['precio'])): ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['precio'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="activo" class="form-label">Estado</label>
                                    <select class="form-select" id="activo" name="activo">
                                        <option value="1" <?= set_select('activo', '1', ($producto['activo'] ?? '1') == '1') ?>>Activo</option>
                                        <option value="0" <?= set_select('activo', '0', ($producto['activo'] ?? '1') == '0') ?>>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-image me-2"></i>Imagen</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen <?= !isset($producto) ? '*' : '' ?></label>
                            <input type="file" class="form-control <?= isset($errors['imagen']) ? 'is-invalid' : '' ?>" 
                                   id="imagen" name="imagen" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <?php if (isset($errors['imagen'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['imagen'] ?>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted">Formatos aceptados: JPG, JPEG, PNG, WEBP (máx 2MB)</small>
                            <small class="text-muted d-block">Cualquier tamaño de imagen es aceptado</small>
                        </div>
                        
                        <!-- Preview de la imagen -->
                        <div class="mt-3" id="image-preview-container" style="display: none;">
                            <h6>Vista Previa:</h6>
                            <img id="image-preview" src="#" alt="Vista previa" class="img-thumbnail" style="max-height: 200px;">
                            <div id="image-dimensions" class="text-muted small mt-2"></div>
                        </div>

                        <!-- Imagen actual (solo en edición) -->
                        <?php if (isset($producto) && !empty($producto['imagen'])): ?>
                            <div class="mb-3">
                                <label class="form-label">Imagen actual</label>
                                <div class="text-center">
                                    <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                         alt="Imagen actual" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Acciones</h5>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-save me-2"></i><?= isset($producto) ? 'Actualizar' : 'Guardar' ?>
                        </button>
                        <a href="<?= base_url('admin/productos/listar') ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Cargar subcategorías cuando se selecciona una categoría
document.getElementById('categoria_id').addEventListener('change', function() {
    const categoriaId = this.value;
    const subcategoriaSelect = document.getElementById('subcategoria_id');
    
    // Limpiar subcategorías
    subcategoriaSelect.innerHTML = '<option value="">Seleccionar subcategoría</option>';
    
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

// Preview de imagen
document.getElementById('imagen').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview-container');
    const previewImg = document.getElementById('image-preview');
    const dimensionsInfo = document.getElementById('image-dimensions');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.style.display = 'block';
            previewImg.src = e.target.result;
            
            const tempImg = new Image();
            tempImg.src = e.target.result;
            tempImg.onload = function() {
                dimensionsInfo.textContent = `Dimensiones: ${this.width}×${this.height}px`;
            };
        };
        
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.style.display = 'none';
    }
});

// Validación del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    const tipo = document.getElementById('tipo').value;
    const precio = document.getElementById('precio').value;
    const imagen = document.getElementById('imagen').files[0];
    const isEdit = <?= isset($producto) ? 'true' : 'false' ?>;
    
    if (!nombre) {
        alert('El nombre del producto es obligatorio');
        e.preventDefault();
        return;
    }
    
    if (!tipo) {
        alert('Debe seleccionar un tipo de producto');
        e.preventDefault();
        return;
    }
    
    if (!precio || precio <= 0) {
        alert('El precio debe ser mayor a 0');
        e.preventDefault();
        return;
    }
    
    if (!isEdit && !imagen) {
        alert('La imagen es obligatoria para nuevos productos');
        e.preventDefault();
        return;
    }
});
</script> 