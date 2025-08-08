<style>
/* Estilos modernos para el dashboard */
.dashboard-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.dashboard-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
}

.metric-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.metric-card.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.metric-card.warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.metric-card.info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.metric-card.success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.metric-card:hover::before {
    transform: translateX(100%);
}

.metric-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.metric-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.metric-label {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 500;
}

.alert-modern {
    border-radius: 15px;
    border: none;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.filters-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    overflow: hidden;
}

.filters-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    margin: 0;
}

.filters-body {
    padding: 2rem;
}

.form-control, .form-select {
    border-radius: 12px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.9);
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    transform: translateY(-2px);
}

.btn-modern {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.btn-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-modern:hover::before {
    left: 100%;
}

.btn-primary.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-primary.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.orders-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    overflow: hidden;
}

.orders-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    margin: 0;
}

.table-modern {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.table-modern thead th {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    border: none;
    padding: 1.2rem 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-modern tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.table-modern tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    transform: scale(1.01);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.table-modern tbody td {
    padding: 1.2rem 1rem;
    vertical-align: middle;
    border: none;
}

.badge-modern {
    border-radius: 20px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.estado-pendiente {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    color: #d63384;
}

.estado-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #0c5460;
}

.estado-preparing {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #856404;
}

.estado-warning {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #856404;
}

.estado-delivery {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #0c5460;
}

.estado-delivered {
    background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
    color: #155724;
}

.estado-cancelled {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    color: #721c24;
}

.btn-group-modern .btn {
    border-radius: 12px;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-group-modern .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.modal-modern .modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    overflow: hidden;
}

.modal-modern .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 1.5rem;
}

.modal-modern .modal-body {
    padding: 2rem;
}

.modal-modern .modal-footer {
    border: none;
    padding: 1.5rem;
    background: #f8f9fa;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 20px;
    margin: 2rem 0;
}

.empty-state i {
    font-size: 4rem;
    color: #667eea;
    margin-bottom: 1rem;
    opacity: 0.7;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem 0;
    }
    
    .metric-card {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
    }
}
</style>

<div class="dashboard-container">
    <div class="container-fluid">
        <!-- Header del Dashboard -->
        <div class="dashboard-header animate-fade-in-up">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold text-gradient mb-2">
                        <i class="fas fa-tachometer-alt me-3"></i>Panel de Administración
                    </h1>
                    <p class="lead text-muted mb-0">Gestiona todos los pedidos y monitorea el rendimiento en tiempo real</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="me-3">
                            <small class="text-muted">Última actualización</small>
                            <div class="fw-bold"><?= date('d/m/Y H:i') ?></div>
                        </div>
                        <button class="btn btn-outline-primary btn-modern" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Métricas rápidas -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card primary animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="metric-number"><?= $total_pedidos ?></div>
                            <div class="metric-label">Total Pedidos</div>
                        </div>
                        <div class="metric-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card warning animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="metric-number"><?= $pendientes ?></div>
                            <div class="metric-label">Pendientes</div>
                        </div>
                        <div class="metric-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card info animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="metric-number"><?= $en_preparacion ?></div>
                            <div class="metric-label">En Preparación</div>
                        </div>
                        <div class="metric-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="metric-card success animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="metric-number"><?= $entregados_hoy ?></div>
                            <div class="metric-label">Entregados Hoy</div>
                        </div>
                        <div class="metric-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas importantes -->
        <?php if ($pendientes > 0): ?>
        <div class="alert alert-warning alert-modern animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                <div>
                    <h5 class="alert-heading mb-1">¡Atención!</h5>
                    <p class="mb-0">Tienes <strong><?= $pendientes ?> pedidos pendientes</strong> que requieren tu atención inmediata.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($en_preparacion > 0): ?>
        <div class="alert alert-info alert-modern animate-fade-in-up" style="animation-delay: 0.6s;">
            <div class="d-flex align-items-center">
                <i class="fas fa-utensils me-3 fa-2x"></i>
                <div>
                    <h5 class="alert-heading mb-1">En Cocina</h5>
                    <p class="mb-0"><strong><?= $en_preparacion ?> pedidos</strong> están siendo preparados activamente.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Filtros avanzados -->
        <div class="filters-card animate-fade-in-up" style="animation-delay: 0.7s;">
            <h5 class="filters-header mb-0">
                <i class="fas fa-filter me-2"></i>Filtros Avanzados
            </h5>
            <div class="filters-body">
                <form method="get" class="row g-3">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-bold">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" <?= ($estado_filtro === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                            <option value="confirmado" <?= ($estado_filtro === 'confirmado') ? 'selected' : '' ?>>Confirmado</option>
                            <option value="en_preparacion" <?= ($estado_filtro === 'en_preparacion') ? 'selected' : '' ?>>En Preparación</option>
                            <option value="listo" <?= ($estado_filtro === 'listo') ? 'selected' : '' ?>>Listo</option>
                            <option value="en_camino" <?= ($estado_filtro === 'en_camino') ? 'selected' : '' ?>>En Camino</option>
                            <option value="entregado" <?= ($estado_filtro === 'entregado') ? 'selected' : '' ?>>Entregado</option>
                            <option value="cancelado" <?= ($estado_filtro === 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-bold">Método de Pago</label>
                        <select name="metodo" class="form-select">
                            <option value="">Todos los métodos</option>
                            <option value="efectivo" <?= ($metodo_filtro === 'efectivo') ? 'selected' : '' ?>>Efectivo</option>
                            <option value="tarjeta" <?= ($metodo_filtro === 'tarjeta') ? 'selected' : '' ?>>Tarjeta</option>
                            <option value="transferencia" <?= ($metodo_filtro === 'transferencia') ? 'selected' : '' ?>>Transferencia</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-bold">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?>">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-bold">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?>">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-bold">Buscar</label>
                        <input type="text" name="buscar" class="form-control" placeholder="Cliente, código..." value="<?= $buscar ?>">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-modern w-100">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de pedidos -->
        <div class="orders-card animate-fade-in-up" style="animation-delay: 0.8s;">
            <div class="orders-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Pedidos
                </h5>
                <div>
                    <span class="badge bg-light text-dark fs-6"><?= count($pedidos) ?> resultados</span>
                </div>
            </div>
            <div class="p-0">
                <?php if (empty($pedidos)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h4 class="text-muted mb-3">No hay pedidos que coincidan con los filtros</h4>
                        <p class="text-muted mb-4">Intenta ajustar los filtros o crear un nuevo pedido</p>
                        <button class="btn btn-primary btn-modern" onclick="location.reload()">
                            <i class="fas fa-refresh me-2"></i>Actualizar
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-modern table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                    <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                    <th><i class="fas fa-user me-2"></i>Cliente</th>
                                    <th><i class="fas fa-phone me-2"></i>Teléfono</th>
                                    <th><i class="fas fa-map-marker-alt me-2"></i>Dirección</th>
                                    <th><i class="fas fa-dollar-sign me-2"></i>Total</th>
                                    <th><i class="fas fa-credit-card me-2"></i>Pago</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                    <th><i class="fas fa-motorcycle me-2"></i>Repartidor</th>
                                    <th><i class="fas fa-comment me-2"></i>Observaciones</th>
                                    <th><i class="fas fa-cogs me-2"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-primary">#<?= $pedido['id'] ?></div>
                                            <small class="text-muted"><?= $pedido['codigo_seguimiento'] ?></small>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></div>
                                            <small class="text-muted"><?= date('H:i', strtotime($pedido['fecha'])) ?></small>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= esc($pedido['nombre']) ?></div>
                                            <?php if (!empty($pedido['correo_electronico'])): ?>
                                                <small class="text-muted"><?= esc($pedido['correo_electronico']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($pedido['celular'])): ?>
                                                <i class="fas fa-phone me-1 text-success"></i><?= esc($pedido['celular']) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin celular</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($pedido['direccion_entrega'])): ?>
                                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= esc($pedido['direccion_entrega']) ?>">
                                                    <?= esc($pedido['direccion_entrega']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">Sin dirección</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success fs-5">$<?= number_format($pedido['total'], 0, ',', '.') ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $metodo_colores = [
                                                'efectivo' => 'bg-success',
                                                'tarjeta' => 'bg-primary',
                                                'transferencia' => 'bg-info'
                                            ];
                                            $color = $metodo_colores[$pedido['metodo_pago']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge badge-modern <?= $color ?>"><?= ucfirst($pedido['metodo_pago']) ?></span>
                                        </td>
                                        <td>
                                            <?php
                                            $estado_colores = [
                                                'pendiente' => 'estado-pendiente',
                                                'confirmado' => 'estado-info',
                                                'en_preparacion' => 'estado-preparing',
                                                'listo' => 'estado-warning',
                                                'en_camino' => 'estado-delivery',
                                                'entregado' => 'estado-delivered',
                                                'cancelado' => 'estado-cancelled'
                                            ];
                                            $estado_clase = $estado_colores[$pedido['estado']] ?? 'estado-pendiente';
                                            ?>
                                            <span class="badge badge-modern <?= $estado_clase ?>"><?= ucfirst(str_replace('_', ' ', $pedido['estado'])) ?></span>
                                        </td>
                                        <td>
                                            <?php if (!empty($pedido['nombre_repartidor'])): ?>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user me-1 text-primary"></i>
                                                    <span class="fw-bold"><?= esc($pedido['nombre_repartidor']) ?></span>
                                                </div>
                                                <?php
                                                $rep = null;
                                                foreach ($repartidores as $r) {
                                                    if ($r['nombre'] === $pedido['nombre_repartidor']) {
                                                        $rep = $r;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <?php if ($rep && isset($rep['disponible'])): ?>
                                                    <span class="badge <?= $rep['disponible'] ? 'bg-success' : 'bg-secondary' ?> ms-1">
                                                        <?= $rep['disponible'] ? 'Disponible' : 'Ocupado' ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin asignar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($pedido['observaciones'])): ?>
                                                <span class="text-truncate d-inline-block" style="max-width: 150px;" title="<?= esc($pedido['observaciones']) ?>">
                                                    <?= esc(substr($pedido['observaciones'], 0, 50)) ?><?= strlen($pedido['observaciones']) > 50 ? '...' : '' ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">Sin observaciones</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-modern" role="group">
                                                <a href="<?= base_url('admin/pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if ($pedido['estado'] === 'listo' && empty($pedido['repartidor_id'])): ?>
                                                    <button class="btn btn-sm btn-outline-success" title="Asignar repartidor" onclick="asignarRepartidor(<?= $pedido['id'] ?>)">
                                                        <i class="fas fa-motorcycle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <?php if (in_array($pedido['estado'], ['pendiente', 'confirmado'])): ?>
                                                    <button class="btn btn-sm btn-outline-warning" title="Cambiar estado" onclick="cambiarEstado(<?= $pedido['id'] ?>)">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
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

<!-- Modal para asignar repartidor -->
<div class="modal fade modal-modern" id="asignarRepartidorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-motorcycle me-2"></i>Asignar Repartidor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="asignarRepartidorForm">
                    <input type="hidden" id="pedido_id" name="pedido_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Repartidor</label>
                        <select name="repartidor_id" class="form-select" required>
                            <option value="">Selecciona un repartidor...</option>
                            <?php foreach ($repartidores as $repartidor): ?>
                                <option value="<?= $repartidor['id'] ?>">
                                    <?= esc($repartidor['nombre']) ?> - <?= esc($repartidor['vehiculo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-modern" onclick="confirmarAsignacion()">
                    <i class="fas fa-check me-2"></i>Asignar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar estado -->
<div class="modal fade modal-modern" id="cambiarEstadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Cambiar Estado del Pedido
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cambiarEstadoForm">
                    <input type="hidden" id="pedido_id_estado" name="pedido_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nuevo Estado</label>
                        <select name="nuevo_estado" class="form-select" required>
                            <option value="">Selecciona un estado...</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="confirmado">Confirmado</option>
                            <option value="en_preparacion">En Preparación</option>
                            <option value="listo">Listo</option>
                            <option value="en_camino">En Camino</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-modern" onclick="confirmarCambioEstado()">
                    <i class="fas fa-check me-2"></i>Cambiar Estado
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Animaciones y efectos
document.addEventListener('DOMContentLoaded', function() {
    // Animar elementos al cargar
    const elements = document.querySelectorAll('.animate-fade-in-up');
    elements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
});

function asignarRepartidor(pedidoId) {
    document.getElementById('pedido_id').value = pedidoId;
    const modal = new bootstrap.Modal(document.getElementById('asignarRepartidorModal'));
    modal.show();
}

function confirmarAsignacion() {
    const form = document.getElementById('asignarRepartidorForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Mostrar loading
    submitBtn.innerHTML = '<span class="loading-spinner me-2"></span>Asignando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(form);
    
    fetch('<?= base_url('admin/asignar-repartidor') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar notificación de éxito
            showNotification('Repartidor asignado exitosamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Error al asignar repartidor: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al asignar repartidor', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

function cambiarEstado(pedidoId) {
    document.getElementById('pedido_id_estado').value = pedidoId;
    const modal = new bootstrap.Modal(document.getElementById('cambiarEstadoModal'));
    modal.show();
}

function confirmarCambioEstado() {
    const form = document.getElementById('cambiarEstadoForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Mostrar loading
    submitBtn.innerHTML = '<span class="loading-spinner me-2"></span>Cambiando...';
    submitBtn.disabled = true;
    
    const formData = new FormData(form);
    
    fetch('<?= base_url('admin/cambiar-estado') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar notificación de éxito
            showNotification('Estado cambiado exitosamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Error al cambiar estado: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error al cambiar estado', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Función para mostrar notificaciones
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Auto-refresh cada 30 segundos
setInterval(() => {
    // Solo actualizar si no hay modales abiertos
    if (!document.querySelector('.modal.show')) {
        location.reload();
    }
}, 30000);
</script>
