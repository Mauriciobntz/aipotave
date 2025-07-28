<?= view('header', ['title' => 'Notificaciones']) ?>
<?= view('navbar') ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Notificaciones Enviadas
                    </h5>
                    <div class="btn-group" role="group">
                        <a href="<?= base_url('admin/notificaciones/estadisticas') ?>" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-bar me-1"></i>
                            Estadísticas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="get" class="d-flex gap-2">
                                <select name="tipo" class="form-select">
                                    <option value="">Todos los tipos</option>
                                    <option value="email" <?= $filtro_tipo === 'email' ? 'selected' : '' ?>>Email</option>
                                    <option value="whatsapp" <?= $filtro_tipo === 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                </select>
                                <select name="estado" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="pendiente" <?= $filtro_estado === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="enviado" <?= $filtro_estado === 'enviado' ? 'selected' : '' ?>>Enviado</option>
                                    <option value="fallido" <?= $filtro_estado === 'fallido' ? 'selected' : '' ?>>Fallido</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="<?= base_url('admin/notificaciones/listar') ?>" class="btn btn-outline-secondary">Limpiar</a>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de notificaciones -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Pedido</th>
                                    <th>Tipo</th>
                                    <th>Contenido</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($notificaciones)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay notificaciones registradas</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($notificaciones as $notificacion): ?>
                                        <tr>
                                            <td>
                                                <strong>#<?= $notificacion['pedido_id'] ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($notificacion['tipo'] === 'email'): ?>
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        Email
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">
                                                        <i class="fab fa-whatsapp me-1"></i>
                                                        WhatsApp
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 300px;" 
                                                      title="<?= htmlspecialchars($notificacion['contenido']) ?>">
                                                    <?= htmlspecialchars($notificacion['contenido']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $estado_class = [
                                                    'pendiente' => 'bg-warning',
                                                    'enviado' => 'bg-success',
                                                    'fallido' => 'bg-danger'
                                                ];
                                                $estado_icon = [
                                                    'pendiente' => 'clock',
                                                    'enviado' => 'check',
                                                    'fallido' => 'times'
                                                ];
                                                ?>
                                                <span class="badge <?= $estado_class[$notificacion['estado']] ?>">
                                                    <i class="fas fa-<?= $estado_icon[$notificacion['estado']] ?> me-1"></i>
                                                    <?= ucfirst($notificacion['estado']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($notificacion['fecha_envio'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/notificaciones/' . $notificacion['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($notificacion['estado'] === 'fallido'): ?>
                                                        <a href="<?= base_url('admin/notificaciones/reenviar/' . $notificacion['id']) ?>" 
                                                           class="btn btn-sm btn-outline-warning"
                                                           onclick="return confirm('¿Reenviar esta notificación?')">
                                                            <i class="fas fa-redo"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Estadísticas rápidas -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4><?= count($notificaciones) ?></h4>
                                    <p class="mb-0">Total</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($notificaciones, function($n) { return $n['estado'] === 'enviado'; })) ?></h4>
                                    <p class="mb-0">Enviadas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($notificaciones, function($n) { return $n['estado'] === 'pendiente'; })) ?></h4>
                                    <p class="mb-0">Pendientes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h4><?= count(array_filter($notificaciones, function($n) { return $n['estado'] === 'fallido'; })) ?></h4>
                                    <p class="mb-0">Fallidas</p>
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