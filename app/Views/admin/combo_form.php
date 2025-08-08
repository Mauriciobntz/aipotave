¿<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-primary">
                        <i class="fas fa-box me-2"></i>
                        <?= isset($combo) ? 'Editar Combo' : 'Nuevo Combo' ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <?= isset($combo) ? 'Modifica la información del combo' : 'Crea un nuevo combo para tu menú' ?>
                    </p>
                </div>
                <div>
                    <a href="<?= base_url('admin/combos/listar') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Alert Messages -->
    <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
    <?php endif; ?>

            <form method="post" action="<?= isset($combo) ? base_url('admin/combos/actualizar/' . $combo['id']) : base_url('admin/combos/guardar') ?>" enctype="multipart/form-data">
                <div class="row">
                    <!-- Left Column - Basic Info -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Información Básica
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
        <div class="mb-3">
                                            <label for="nombre" class="form-label fw-bold">
                                                <i class="fas fa-tag me-1"></i>Nombre del Combo
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-lg <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   value="<?= set_value('nombre', $combo['nombre'] ?? '') ?>" 
                                                   placeholder="Ej: Combo Clásico"
                                                   required>
                                            <?php if (session('errors.nombre')): ?>
                                                <div class="invalid-feedback"><?= esc(session('errors.nombre')) ?></div>
                                            <?php endif; ?>
                                        </div>
        </div>
                                    <div class="col-md-4">
        <div class="mb-3">
                                            <label for="precio" class="form-label fw-bold">
                                                <i class="fas fa-dollar-sign me-1"></i>Precio
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text">$</span>
                                                <input type="number" 
                                                       step="0.01" 
                                                       class="form-control <?= session('errors.precio') ? 'is-invalid' : '' ?>" 
                                                       id="precio" 
                                                       name="precio" 
                                                       value="<?= set_value('precio', $combo['precio'] ?? '') ?>" 
                                                       placeholder="0.00"
                                                       required>
                                            </div>
                                            <?php if (session('errors.precio')): ?>
                                                <div class="invalid-feedback"><?= esc(session('errors.precio')) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
        </div>

        <div class="mb-3">
                                    <label for="descripcion" class="form-label fw-bold">
                                        <i class="fas fa-align-left me-1"></i>Descripción
                                    </label>
                                    <textarea class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                                              id="descripcion" 
                                              name="descripcion" 
                                              rows="3"
                                              placeholder="Describe qué incluye este combo..."><?= set_value('descripcion', $combo['descripcion'] ?? '') ?></textarea>
                                    <?php if (session('errors.descripcion')): ?>
                                        <div class="invalid-feedback"><?= esc(session('errors.descripcion')) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Products Section -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-utensils me-2"></i>Productos del Combo
                                </h5>
        </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Instrucciones:</strong> Selecciona los productos que incluirá este combo y especifica la cantidad de cada uno.
        </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                                        <label class="form-check-label" for="selectAll"></label>
                                                    </div>
                                                </th>
                        <th>Producto</th>
                                                <th style="width: 120px;">Cantidad</th>
                                                <th style="width: 100px;">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                                            <tr class="producto-row">
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input producto-check" 
                                                               type="checkbox" 
                                                               id="producto_<?= $producto['id'] ?>"
                                                               data-producto-id="<?= $producto['id'] ?>"
                                                               <?= isset($productos_en_combo[$producto['id']]) && $productos_en_combo[$producto['id']] > 0 ? 'checked' : '' ?>>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php if (!empty($producto['imagen'])): ?>
                                                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                                                 alt="<?= esc($producto['nombre']) ?>" 
                                                                 class="rounded me-3" 
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                                 style="width: 40px; height: 40px;">
                                                                <i class="fas fa-utensils text-muted"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <strong><?= esc($producto['nombre']) ?></strong>
                                                            <br><small class="text-muted"><?= esc($producto['descripcion']) ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                           min="0" 
                                                           class="form-control cantidad-input" 
                                                           name="productos[<?= $producto['id'] ?>]" 
                                                           value="<?= esc($productos_en_combo[$producto['id']] ?? 0) ?>"
                                                           style="width: 80px;"
                                                           <?= isset($productos_en_combo[$producto['id']]) && $productos_en_combo[$producto['id']] > 0 ? '' : 'disabled' ?>>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">$<?= number_format($producto['precio'], 0, ',', '.') ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Image & Actions -->
                    <div class="col-lg-4">
                        <!-- Image Section -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-image me-2"></i>Imagen del Combo
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold">
                                        Imagen <?= !isset($combo) ? '<span class="text-danger">*</span>' : '' ?>
                                    </label>
                                    <div class="upload-area" id="uploadArea">
                                        <input type="file" 
                                               class="form-control <?= session('errors.imagen') ? 'is-invalid' : '' ?>" 
                                               id="imagen" 
                                               name="imagen" 
                                               accept="image/jpg,image/jpeg,image/png,image/webp"
                                               style="display: none;">
                                        <div class="upload-placeholder text-center p-4 border-2 border-dashed border-secondary rounded">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <p class="mb-2"><strong>Haz clic para seleccionar una imagen</strong></p>
                                            <p class="text-muted small mb-0">Formatos: JPG, JPEG, PNG, WEBP (máx 2MB)</p>
                                        </div>
                                    </div>
                                    <?php if (session('errors.imagen')): ?>
                                        <div class="invalid-feedback d-block"><?= esc(session('errors.imagen')) ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Preview de la imagen -->
                                <div class="mt-3" id="image-preview-container" style="display: none;">
                                    <h6 class="fw-bold">Vista Previa:</h6>
                                    <div class="position-relative">
                                        <img id="image-preview" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removeImage">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div id="image-dimensions" class="text-muted small mt-2"></div>
                                </div>

                                <!-- Imagen actual (solo en edición) -->
                                <?php if (isset($combo) && !empty($combo['imagen'])): ?>
                                <div class="mt-3">
                                    <h6 class="fw-bold">Imagen Actual:</h6>
                                    <div class="position-relative">
                                        <img src="<?= base_url('public/' . $combo['imagen']) ?>" 
                                             alt="Imagen actual" 
                                             class="img-fluid rounded shadow-sm">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-calculator me-2"></i>Resumen
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h4 class="text-primary mb-1" id="totalProductos">0</h4>
                                            <small class="text-muted">Productos</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="text-success mb-1" id="totalPrecio">$0</h4>
                                        <small class="text-muted">Valor Total</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>
                                        <?= isset($combo) ? 'Actualizar Combo' : 'Crear Combo' ?>
                                    </button>
                                    <a href="<?= base_url('admin/combos/listar') ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </form>
</div> 
    </div>
</div>

<style>
.upload-area {
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-area:hover .upload-placeholder {
    border-color: #0d6efd !important;
    background-color: #f8f9fa;
}

.upload-placeholder {
    transition: all 0.3s ease;
}

.producto-row {
    transition: background-color 0.2s ease;
}

.producto-row:hover {
    background-color: #f8f9fa;
}

.cantidad-input:disabled {
    background-color: #e9ecef;
    opacity: 0.6;
}

.form-control-lg {
    font-size: 1.1rem;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1.1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image upload functionality
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imagen');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const dimensionsDiv = document.getElementById('image-dimensions');
    const removeImageBtn = document.getElementById('removeImage');

    // Upload area click
    uploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    // File selection
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                
                // Get image dimensions
                const img = new Image();
                img.onload = function() {
                    dimensionsDiv.textContent = `Dimensiones: ${this.width} x ${this.height} píxeles`;
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.style.display = 'none';
        });
    }

    // Product selection functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const productoCheckboxes = document.querySelectorAll('.producto-check');
    const cantidadInputs = document.querySelectorAll('.cantidad-input');

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        productoCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            const cantidadInput = checkbox.closest('tr').querySelector('.cantidad-input');
            if (this.checked) {
                cantidadInput.disabled = false;
                cantidadInput.value = cantidadInput.value || 1;
            } else {
                cantidadInput.disabled = true;
                cantidadInput.value = 0;
            }
        });
        updateSummary();
    });

    // Individual product selection
    productoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const cantidadInput = this.closest('tr').querySelector('.cantidad-input');
            if (this.checked) {
                cantidadInput.disabled = false;
                cantidadInput.value = cantidadInput.value || 1;
            } else {
                cantidadInput.disabled = true;
                cantidadInput.value = 0;
            }
            updateSelectAllState();
            updateSummary();
        });
    });

    // Quantity input changes
    cantidadInputs.forEach(input => {
        input.addEventListener('change', updateSummary);
    });

    function updateSelectAllState() {
        const checkedBoxes = document.querySelectorAll('.producto-check:checked');
        const totalBoxes = productoCheckboxes.length;
        selectAllCheckbox.checked = checkedBoxes.length === totalBoxes;
        selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
    }

    function updateSummary() {
        let totalProductos = 0;
        let totalPrecio = 0;

        productoCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const cantidadInput = checkbox.closest('tr').querySelector('.cantidad-input');
                const cantidad = parseInt(cantidadInput.value) || 0;
                const precioElement = checkbox.closest('tr').querySelector('.badge');
                const precio = parseFloat(precioElement.textContent.replace('$', '').replace('.', '')) || 0;
                
                totalProductos += cantidad;
                totalPrecio += precio * cantidad;
            }
        });

        document.getElementById('totalProductos').textContent = totalProductos;
        document.getElementById('totalPrecio').textContent = '$' + totalPrecio.toLocaleString();
    }

    // Initialize summary
    updateSummary();
    updateSelectAllState();
});
</script> 