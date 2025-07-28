<?= view('header', ['title' => 'Gestión de Stock']) ?>
<?= view('navbar') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-boxes text-primary me-2"></i>
                        Control de Stock
                    </h5>
                    <div class="btn-group" role="group">
                        <a href="<?= base_url('admin/stock/estadisticas') ?>" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar me-1"></i>
                            Estadísticas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtro de fecha -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="get" class="d-flex gap-2">
                                <input type="date" name="fecha" value="<?= $fecha ?>" class="form-control">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="<?= base_url('admin/stock/listar') ?>" class="btn btn-outline-secondary">Hoy</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de stock -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Stock Disponible</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($stock)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay productos con stock registrado para esta fecha</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($stock as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($item['imagen'])): ?>
                                                        <img src="<?= base_url('uploads/' . $item['imagen']) ?>" 
                                                             alt="<?= $item['producto_nombre'] ?>" 
                                                             class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?= $item['producto_nombre'] ?></strong>
                                                        <?php if (!empty($item['descripcion'])): ?>
                                                            <br><small class="text-muted"><?= $item['descripcion'] ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $tipo_class = [
                                                    'comida' => 'bg-success',
                                                    'bebida' => 'bg-info',
                                                    'vianda' => 'bg-warning'
                                                ];
                                                ?>
                                                <span class="badge <?= $tipo_class[$item['tipo']] ?>">
                                                    <?= ucfirst($item['tipo']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= $item['cantidad'] ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $stock_actual = $item['cantidad'];
                                                if ($stock_actual <= 5): ?>
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Stock Bajo
                                                    </span>
                                                <?php elseif ($stock_actual <= 15): ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-exclamation-circle me-1"></i>
                                                        Stock Medio
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Stock OK
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/stock/actualizar/' . $item['producto_id'] . '?fecha=' . $fecha) ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Actualizar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Resumen de stock -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4><?= count($stock) ?></h4>
                                    <p class="mb-0">Total Productos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($stock, function($s) { return $s['cantidad'] > 15; })) ?></h4>
                                    <p class="mb-0">Stock OK</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($stock, function($s) { return $s['cantidad'] <= 15 && $s['cantidad'] > 5; })) ?></h4>
                                    <p class="mb-0">Stock Medio</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($stock, function($s) { return $s['cantidad'] <= 5; })) ?></h4>
                                    <p class="mb-0">Stock Bajo</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos con stock bajo -->
                    <?php 
                    $productos_stock_bajo = array_filter($stock, function($s) { return $s['cantidad'] <= 5; });
                    if (!empty($productos_stock_bajo)): 
                    ?>
                        <div class="alert alert-warning mt-4">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Productos con Stock Bajo</h6>
                            <div class="row">
                                <?php foreach ($productos_stock_bajo as $item): ?>
                                    <div class="col-md-4 mb-2">
                                        <strong><?= $item['producto_nombre'] ?></strong> - 
                                        Stock: <span class="text-danger"><?= $item['cantidad'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('footer') ?> 