<?= view('header', ['title' => 'Dashboard de Estadísticas | Admin']) ?>
<?= view('navbar') ?>

<div class="container-fluid mt-4">
    <!-- Header del dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">
                        <i class="fas fa-chart-line me-3 text-primary"></i>Dashboard de Estadísticas
                    </h1>
                    <p class="text-muted mb-0">Análisis completo de ventas y rendimiento</p>
                </div>
                <div>
                    <button class="btn btn-success btn-modern me-2" onclick="exportarExcel()">
                        <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                    </button>
                    <button class="btn btn-outline-primary btn-modern" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas principales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card-counter primary">
                <i class="fa fa-dollar-sign"></i>
                <span class="count-numbers">$<?= number_format($ventas_totales, 0, ',', '.') ?></span>
                <span class="count-name">Ventas Totales</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter success">
                <i class="fa fa-shopping-cart"></i>
                <span class="count-numbers"><?= $total_pedidos ?></span>
                <span class="count-name">Total Pedidos</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter info">
                <i class="fa fa-chart-line"></i>
                <span class="count-numbers">$<?= number_format($ganancias_estimadas, 0, ',', '.') ?></span>
                <span class="count-name">Ganancias Estimadas</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-counter warning">
                <i class="fa fa-users"></i>
                <span class="count-numbers"><?= $clientes_unicos ?></span>
                <span class="count-name">Clientes Únicos</span>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select">
                        <option value="">Todos los productos</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id'] ?>" <?= ($producto_filtro == $producto['id']) ? 'selected' : '' ?>>
                                <?= esc($producto['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Repartidor</label>
                    <select name="repartidor_id" class="form-select">
                        <option value="">Todos los repartidores</option>
                        <?php foreach ($repartidores as $repartidor): ?>
                            <option value="<?= $repartidor['id'] ?>" <?= ($repartidor_filtro == $repartidor['id']) ? 'selected' : '' ?>>
                                <?= esc($repartidor['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-modern">
                        <i class="fas fa-search me-2"></i>Aplicar Filtros
                    </button>
                    <a href="<?= base_url('admin/estadisticas') ?>" class="btn btn-outline-secondary btn-modern ms-2">
                        <i class="fas fa-times me-2"></i>Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Ventas por Día</h5>
                </div>
                <div class="card-body">
                    <canvas id="ventasPorDiaChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Productos Más Vendidos</h5>
                </div>
                <div class="card-body">
                    <canvas id="productosChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de productos más vendidos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Top Productos Más Vendidos</h5>
                    <div>
                        <span class="badge bg-primary"><?= count($top_productos) ?> productos</span>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($top_productos)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay datos para mostrar</h5>
                            <p class="text-muted">Intenta ajustar los filtros de fecha</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th><i class="fas fa-hashtag me-2"></i>Posición</th>
                                        <th><i class="fas fa-utensils me-2"></i>Producto</th>
                                        <th><i class="fas fa-shopping-cart me-2"></i>Cantidad Vendida</th>
                                        <th><i class="fas fa-dollar-sign me-2"></i>Total Ventas</th>
                                        <th><i class="fas fa-percentage me-2"></i>Porcentaje</th>
                                        <th><i class="fas fa-chart-line me-2"></i>Tendencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($top_productos as $index => $producto): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary fs-6">#<?= $index + 1 ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($producto['imagen'])): ?>
                                                        <img src="<?= base_url('public/' . $producto['imagen']) ?>" class="product-img me-3" alt="<?= esc($producto['nombre']) ?>">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?= esc($producto['nombre']) ?></strong>
                                                        <br><small class="text-muted"><?= esc($producto['descripcion']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success"><?= $producto['cantidad_vendida'] ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">$<?= number_format($producto['total_ventas'], 0, ',', '.') ?></span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: <?= $producto['porcentaje'] ?>%" 
                                                         aria-valuenow="<?= $producto['porcentaje'] ?>" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        <?= number_format($producto['porcentaje'], 1) ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($producto['tendencia'] > 0): ?>
                                                    <span class="text-success">
                                                        <i class="fas fa-arrow-up me-1"></i><?= $producto['tendencia'] ?>%
                                                    </span>
                                                <?php elseif ($producto['tendencia'] < 0): ?>
                                                    <span class="text-danger">
                                                        <i class="fas fa-arrow-down me-1"></i><?= abs($producto['tendencia']) ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="fas fa-minus me-1"></i>0%
                                                    </span>
                                                <?php endif; ?>
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
    </div>

    <!-- Resumen de métricas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Resumen de Métricas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h4 class="text-primary"><?= $promedio_pedido ?></h4>
                                <small class="text-muted">Promedio por Pedido</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h4 class="text-success"><?= $pedidos_por_dia ?></h4>
                                <small class="text-muted">Pedidos por Día</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h4 class="text-info"><?= $productos_por_pedido ?></h4>
                                <small class="text-muted">Productos por Pedido</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <h4 class="text-warning"><?= $tiempo_entrega_promedio ?></h4>
                                <small class="text-muted">Tiempo Entrega (min)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Actividad Reciente</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <?php foreach ($actividad_reciente as $actividad): ?>
                            <div class="timeline-item mb-3">
                                <div class="d-flex">
                                    <div class="timeline-marker bg-primary rounded-circle me-3" style="width: 10px; height: 10px; margin-top: 5px;"></div>
                                    <div>
                                        <strong><?= esc($actividad['titulo']) ?></strong>
                                        <br><small class="text-muted"><?= $actividad['fecha'] ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de ventas por día
const ventasCtx = document.getElementById('ventasPorDiaChart').getContext('2d');
const ventasChart = new Chart(ventasCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($ventas_por_dia_labels) ?>,
        datasets: [{
            label: 'Ventas ($)',
            data: <?= json_encode($ventas_por_dia_data) ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Gráfico de productos más vendidos
const productosCtx = document.getElementById('productosChart').getContext('2d');
const productosChart = new Chart(productosCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($productos_labels) ?>,
        datasets: [{
            data: <?= json_encode($productos_data) ?>,
            backgroundColor: [
                '#007bff',
                '#28a745',
                '#ffc107',
                '#dc3545',
                '#17a2b8',
                '#6c757d',
                '#fd7e14',
                '#6f42c1'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function exportarExcel() {
    // Implementar exportación a Excel
    alert('Función de exportación a Excel - Implementar según necesidades');
}
</script>

<?= view('footer') ?> 