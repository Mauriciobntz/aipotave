<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-<?= $slide ? 'edit' : 'plus' ?> me-2"></i>
                        <?= $slide ? 'Editar Slide' : 'Crear Nuevo Slide' ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= $slide ? base_url('admin/slides/actualizar/' . $slide['id']) : base_url('admin/slides/guardar') ?>" 
                          method="post" 
                          enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Título *
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="titulo" 
                                           name="titulo" 
                                           value="<?= old('titulo', $slide['titulo'] ?? '') ?>" 
                                           required 
                                           maxlength="100"
                                           placeholder="Título del slide">
                                    <div class="form-text">Máximo 100 caracteres</div>
                                </div>

                                <div class="mb-3">
                                    <label for="subtitulo" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Subtítulo
                                    </label>
                                    <textarea class="form-control" 
                                              id="subtitulo" 
                                              name="subtitulo" 
                                              rows="3" 
                                              maxlength="255"
                                              placeholder="Subtítulo o descripción del slide"><?= old('subtitulo', $slide['subtitulo'] ?? '') ?></textarea>
                                    <div class="form-text">Máximo 255 caracteres</div>
                                </div>

                                <div class="mb-3">
                                    <label for="link_destino" class="form-label">
                                        <i class="fas fa-link me-1"></i>Enlace de Destino
                                    </label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="link_destino" 
                                           name="link_destino" 
                                           value="<?= old('link_destino', $slide['link_destino'] ?? '') ?>" 
                                           maxlength="255"
                                           placeholder="https://ejemplo.com">
                                    <div class="form-text">URL a la que llevará el slide al hacer clic</div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="orden" class="form-label">
                                                <i class="fas fa-sort-numeric-up me-1"></i>Orden
                                            </label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="orden" 
                                                   name="orden" 
                                                   value="<?= old('orden', $slide['orden'] ?? '') ?>" 
                                                   min="1"
                                                   placeholder="Orden de aparición">
                                            <div class="form-text">Número que determina el orden de aparición</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="fas fa-toggle-on me-1"></i>Estado
                                            </label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="activo" 
                                                       name="activo" 
                                                       value="1"
                                                       <?= old('activo', $slide['activo'] ?? 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="activo">
                                                    Slide activo
                                                </label>
                                            </div>
                                            <div class="form-text">Los slides inactivos no se mostrarán en el carrusel</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label">
                                        <i class="fas fa-image me-1"></i>Imagen <?= $slide ? '' : '*' ?>
                                    </label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="imagen" 
                                           name="imagen" 
                                           accept="image/*"
                                           <?= $slide ? '' : 'required' ?>>
                                    <div class="form-text">
                                        Formatos: JPG, PNG, GIF. Máximo 2MB. 
                                        <?= $slide ? 'Deja vacío para mantener la imagen actual' : '' ?>
                                    </div>
                                </div>

                                <?php if ($slide && !empty($slide['imagen'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Imagen Actual</label>
                                    <div class="border rounded p-2 text-center">
                                        <img src="<?= base_url('public/' . $slide['imagen']) ?>" 
                                             alt="<?= esc($slide['titulo']) ?>" 
                                             class="img-fluid" 
                                             style="max-height: 200px; object-fit: cover;">
                                        <div class="mt-2">
                                            <small class="text-muted"><?= basename($slide['imagen']) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-1"></i>Recomendaciones
                                        </h6>
                                        <ul class="card-text small mb-0">
                                            <li>Imagen recomendada: 1200x400px</li>
                                            <li>Formato: JPG o PNG</li>
                                            <li>Tamaño máximo: 2MB</li>
                                            <li>Usa imágenes de alta calidad</li>
                                            <li>Mantén el texto legible</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/slides') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-<?= $slide ? 'save' : 'plus' ?> me-2"></i>
                                <?= $slide ? 'Actualizar Slide' : 'Crear Slide' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Vista previa de imagen
document.getElementById('imagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Crear o actualizar vista previa
            let preview = document.getElementById('image-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'image-preview';
                preview.className = 'mb-3';
                document.getElementById('imagen').parentNode.appendChild(preview);
            }
            
            preview.innerHTML = `
                <label class="form-label">Vista Previa</label>
                <div class="border rounded p-2 text-center">
                    <img src="${e.target.result}" alt="Vista previa" class="img-fluid" style="max-height: 200px; object-fit: cover;">
                    <div class="mt-2">
                        <small class="text-muted">${file.name}</small>
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Validación de formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const titulo = document.getElementById('titulo').value.trim();
    const imagen = document.getElementById('imagen').files[0];
    
    if (!titulo) {
        e.preventDefault();
        alert('El título es obligatorio');
        return;
    }
    
    if (!<?= $slide ? 'true' : 'false' ?> && !imagen) {
        e.preventDefault();
        alert('La imagen es obligatoria para nuevos slides');
        return;
    }
    
    if (imagen && imagen.size > 2 * 1024 * 1024) {
        e.preventDefault();
        alert('La imagen no puede ser mayor a 2MB');
        return;
    }
});
</script>

<style>
/* Estilos para ocupar todo el ancho */
.container-fluid {
    padding: 0;
    margin: 0;
    width: 100%;
}

.row {
    margin: 0;
}

.col-12 {
    padding: 0;
}

.card {
    border-radius: 0;
    margin: 0;
    min-height: calc(100vh - 200px);
}

.card-header {
    background: linear-gradient(135deg, #4281A4 0%, #48A9A6 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

/* Formulario mejorado */
.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4281A4;
    box-shadow: 0 0 0 0.2rem rgba(66, 129, 164, 0.25);
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

/* Botones mejorados */
.btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #4281A4 0%, #48A9A6 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2c3e50 0%, #4281A4 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

/* Card de recomendaciones */
.card.bg-light {
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Imágenes */
.img-fluid {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
}
</style> 