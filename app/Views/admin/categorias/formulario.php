<?= view('header', ['title' => isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría']) ?>
<?= view('navbar') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tag text-primary me-2"></i>
                        <?= isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= isset($categoria) ? base_url('admin/categorias/actualizar/' . $categoria['id']) : base_url('admin/categorias/guardar') ?>" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Categoría *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?= old('nombre', isset($categoria) ? $categoria['nombre'] : '') ?>" 
                                   required minlength="3" maxlength="50">
                            <div class="form-text">
                                El nombre debe tener entre 3 y 50 caracteres
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                      maxlength="255"><?= old('descripcion', isset($categoria) ? $categoria['descripcion'] : '') ?></textarea>
                            <div class="form-text">
                                Descripción opcional de la categoría (máximo 255 caracteres)
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                <?= isset($categoria) ? 'Actualizar Categoría' : 'Crear Categoría' ?>
                            </button>
                            <a href="<?= base_url('admin/categorias/listar') ?>" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Volver al Listado
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('footer') ?> 