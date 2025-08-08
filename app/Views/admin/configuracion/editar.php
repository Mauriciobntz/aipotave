<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Editar Configuración
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/configuracion/actualizar/' . $configuracion['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="clave" class="form-label">
                                    <i class="fas fa-key me-1"></i>Clave
                                </label>
                                <input type="text" class="form-control" id="clave" name="clave" 
                                       value="<?= old('clave', $configuracion['clave']) ?>" required>
                                <div class="form-text">Identificador único de la configuración</div>
                            </div>

                            <div class="col-md-6">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Tipo
                                </label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="">Seleccionar tipo</option>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?= $tipo ?>" <?= (old('tipo', $configuracion['tipo']) === $tipo) ? 'selected' : '' ?>>
                                            <?= ucfirst($tipo) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="seccion" class="form-label">
                                    <i class="fas fa-folder me-1"></i>Sección
                                </label>
                                <select class="form-select" id="seccion" name="seccion" required>
                                    <option value="">Seleccionar sección</option>
                                    <?php foreach ($secciones as $seccion): ?>
                                        <option value="<?= $seccion ?>" <?= (old('seccion', $configuracion['seccion']) === $seccion) ? 'selected' : '' ?>>
                                            <?= ucfirst(str_replace('_', ' ', $seccion)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="activo" class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>Estado
                                </label>
                                <select class="form-select" id="activo" name="activo">
                                    <option value="1" <?= (old('activo', $configuracion['activo']) == 1) ? 'selected' : '' ?>>Activo</option>
                                    <option value="0" <?= (old('activo', $configuracion['activo']) == 0) ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="valor" class="form-label">
                                    <i class="fas fa-pen me-1"></i>Valor
                                </label>
                                <textarea class="form-control" id="valor" name="valor" rows="3" required><?= old('valor', $configuracion['valor']) ?></textarea>
                                <div class="form-text">Valor de la configuración</div>
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Descripción
                                </label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?= old('descripcion', $configuracion['descripcion']) ?></textarea>
                                <div class="form-text">Descripción opcional de la configuración</div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/configuracion') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Volver
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Actualizar Configuración
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
