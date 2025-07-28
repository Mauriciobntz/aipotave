<?= view('header', ['title' => 'Actualizar Stock']) ?>
<?= view('navbar') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Actualizar Stock
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Información del producto -->
                    <div class="mb-4">
                        <h6>Producto:</h6>
                        <div class="d-flex align-items-center">
                            <?php if (!empty($producto['imagen'])): ?>
<img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                                     alt="<?= $producto['nombre'] ?>" 
                                     class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <?php endif; ?>
                            <div>
                                <h5 class="mb-1"><?= $producto['nombre'] ?></h5>
                                <p class="text-muted mb-0"><?= $producto['descripcion'] ?></p>
                                <small class="text-muted">
                                    Tipo: <?= ucfirst($producto['tipo']) ?> | 
                                    Precio: $<?= number_format($producto['precio'], 2) ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/stock/guardar') ?>" method="post">
                        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                        <input type="hidden" name="fecha" value="<?= $fecha ?>">
                        
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad en Stock</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                   value="<?= $stock_actual ?>" min="0" required>
                            <div class="form-text">
                                Stock actual: <strong><?= $stock_actual ?></strong> unidades
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Guardar Stock
                            </button>
                            <a href="<?= base_url('admin/stock/listar?fecha=' . $fecha) ?>" 
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