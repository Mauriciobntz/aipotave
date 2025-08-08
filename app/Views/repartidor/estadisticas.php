<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-chart-bar me-2 text-warning"></i>Estadísticas de Repartidor
    </h1>

    <!-- Filtros de fecha -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="<?= $fecha_inicio ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control" value="<?= $fecha_fin ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <a href="<?= base_url('repartidor/estadisticas') ?>" class="btn btn-outline-secondary ms-2">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Resumen de Entregas</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($estadisticas)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Cantidad</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = array_sum(array_column($estadisticas, 'cantidad'));
                                    foreach ($estadisticas as $estado => $datos): 
                                        $porcentaje = $total > 0 ? round(($datos['cantidad'] / $total) * 100, 1) : 0;
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-<?= $datos['color'] ?? 'secondary' ?>">
                                                    <?= ucfirst($estado) ?>
                                                </span>
                                            </td>
                                            <td><?= $datos['cantidad'] ?></td>
                                            <td><?= $porcentaje ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-info">
                                        <td><strong>Total</strong></td>
                                        <td><strong><?= $total ?></strong></td>
                                        <td><strong>100%</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay datos para mostrar</h5>
                            <p class="text-muted">Selecciona un rango de fechas para ver las estadísticas.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Métricas de Rendimiento</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-primary"><?= $entregas_hoy ?? '0' ?></h3>
                                <small class="text-muted">Entregas completadas hoy</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success"><?= $tiempo_promedio_entrega ?? '0' ?> min</h3>
                            <small class="text-muted">Tiempo promedio de entrega</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-info"><?= $entregas_semana ?? '0' ?></h3>
                                <small class="text-muted">Entregas esta semana</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-warning"><?= $total_entregas ?? '0' ?></h3>
                            <small class="text-muted">Total de entregas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 