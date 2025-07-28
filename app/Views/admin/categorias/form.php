<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-<?= isset($categoria) ? 'edit' : 'plus' ?> me-2"></i>
                        <?= isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= isset($categoria) ? base_url('admin/categorias/actualizar/' . $categoria['id']) : base_url('admin/categorias/guardar') ?>">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nombre de la Categoría
                            </label>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= esc(isset($categoria) ? $categoria['nombre'] : (old('nombre') ?? '')) ?>" 
                                   required>
                            <?php if (session('errors.nombre')): ?>
                                <div class="invalid-feedback"><?= esc(session('errors.nombre')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Descripción
                            </label>
                            <textarea class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3"><?= esc(isset($categoria) ? $categoria['descripcion'] : (old('descripcion') ?? '')) ?></textarea>
                            <?php if (session('errors.descripcion')): ?>
                                <div class="invalid-feedback"><?= esc(session('errors.descripcion')) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo" 
                                       value="1" 
                                       <?= (isset($categoria) && $categoria['activo']) || (old('activo') == '1') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="activo">
                                    <i class="fas fa-check-circle me-2"></i>Categoría activa
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/categorias') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                <?= isset($categoria) ? 'Actualizar' : 'Guardar' ?> Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 