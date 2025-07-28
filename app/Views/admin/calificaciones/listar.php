<?= view('header', ['title' => 'Calificaciones']) ?>
<?= view('navbar') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star text-warning me-2"></i>
                        Calificaciones de Clientes
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Estadísticas generales -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3><?= number_format($promedio, 1) ?></h3>
                                    <p class="mb-0">Promedio General</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3><?= count($calificaciones) ?></h3>
                                    <p class="mb-0">Total de Calificaciones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h3><?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] >= 4; })) ?></h3>
                                    <p class="mb-0">Calificaciones Positivas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de calificaciones -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Puntuación</th>
                                    <th>Comentario</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($calificaciones)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay calificaciones registradas</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($calificaciones as $calificacion): ?>
                                        <tr>
                                            <td>
                                                <strong>#<?= $calificacion['codigo_seguimiento'] ?></strong>
                                            </td>
                                            <td><?= $calificacion['cliente_nombre'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star <?= $i <= $calificacion['puntuacion'] ? 'text-warning' : 'text-muted' ?>"></i>
                                                    <?php endfor; ?>
                                                    <span class="ms-2">(<?= $calificacion['puntuacion'] ?>/5)</span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($calificacion['comentario'])): ?>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                                          title="<?= htmlspecialchars($calificacion['comentario']) ?>">
                                                        <?= htmlspecialchars($calificacion['comentario']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Sin comentario</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($calificacion['fecha'])) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/calificaciones/' . $calificacion['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Gráfico de distribución de calificaciones -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Distribución de Calificaciones</h6>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($estadisticas as $estadistica): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star <?= $i <= $estadistica['puntuacion'] ? 'text-warning' : 'text-muted' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <div class="progress flex-grow-1 mx-3" style="height: 20px;">
                                                <?php 
                                                $porcentaje = count($calificaciones) > 0 ? 
                                                    ($estadistica['cantidad'] / count($calificaciones)) * 100 : 0;
                                                ?>
                                                <div class="progress-bar bg-warning" style="width: <?= $porcentaje ?>%">
                                                    <?= $estadistica['cantidad'] ?>
                                                </div>
                                            </div>
                                            <small class="text-muted"><?= $estadistica['cantidad'] ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Resumen</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <strong>Excelente (5 estrellas):</strong> 
                                            <?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] == 5; })) ?>
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <strong>Muy bueno (4 estrellas):</strong> 
                                            <?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] == 4; })) ?>
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <strong>Bueno (3 estrellas):</strong> 
                                            <?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] == 3; })) ?>
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <strong>Regular (2 estrellas):</strong> 
                                            <?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] == 2; })) ?>
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            <strong>Malo (1 estrella):</strong> 
                                            <?= count(array_filter($calificaciones, function($c) { return $c['puntuacion'] == 1; })) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('footer') ?> 