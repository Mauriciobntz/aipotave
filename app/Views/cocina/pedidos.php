<div class="container mt-5">
    <style>
        .bg-confirmado {
            background-color: #6f42c1 !important;
            color: white !important;
        }
        .badge.bg-confirmado {
            background-color: #6f42c1 !important;
        }
    </style>
    <h1 class="mb-4">
        <i class="fas fa-utensils me-2 text-warning"></i>Pedidos en Cocina
    </h1>

    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count(array_filter($pedidos, fn($p) => $p['estado'] == 'pendiente')) ?></h4>
                    <small>Pendientes</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count(array_filter($pedidos, fn($p) => $p['estado'] == 'confirmado')) ?></h4>
                    <small>Confirmados</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-dark">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count(array_filter($pedidos, fn($p) => $p['estado'] == 'en_preparacion')) ?></h4>
                    <small>En Preparación</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count(array_filter($pedidos, fn($p) => $p['estado'] == 'listo')) ?></h4>
                    <small>Listos</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count(array_filter($pedidos, fn($p) => $p['estado'] == 'en_camino')) ?></h4>
                    <small>En Camino</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <h4 class="mb-0"><?= count($pedidos) ?></h4>
                    <small>Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa de entregas -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Mapa de Entregas</h5>
        </div>
        <div class="card-body">
            <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        </div>
    </div>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" <?= ($estado_filtro == 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                        <option value="confirmado" <?= ($estado_filtro == 'confirmado') ? 'selected' : '' ?>>Confirmado</option>
                        <option value="en_preparacion" <?= ($estado_filtro == 'en_preparacion') ? 'selected' : '' ?>>En Preparación</option>
                        <option value="listo" <?= ($estado_filtro == 'listo') ? 'selected' : '' ?>>Listo</option>
                        <option value="en_camino" <?= ($estado_filtro == 'en_camino') ? 'selected' : '' ?>>En Camino</option>
                        <option value="entregado" <?= ($estado_filtro == 'entregado') ? 'selected' : '' ?>>Entregado</option>
                        <option value="cancelado" <?= ($estado_filtro == 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordenar por</label>
                    <select name="orden" class="form-select">
                        <option value="fecha_desc" <?= ($orden == 'fecha_desc') ? 'selected' : '' ?>>Más recientes</option>
                        <option value="fecha_asc" <?= ($orden == 'fecha_asc') ? 'selected' : '' ?>>Más antiguos</option>
                        <option value="prioridad" <?= ($orden == 'prioridad') ? 'selected' : '' ?>>Por prioridad</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                    <a href="<?= base_url('cocina/pedidos') ?>" class="btn btn-outline-secondary ms-2">Limpiar filtros</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td>
                            <strong>#<?= esc($pedido['id']) ?></strong>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['nombre'] ?? 'Pedido #' . $pedido['id']) ?></strong>
                                <?php if (!empty($pedido['codigo_seguimiento'])): ?>
                                    <br><small class="text-muted">Código: <?= esc($pedido['codigo_seguimiento']) ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= esc($pedido['nombre']) ?></strong>
                                <?php if (!empty($pedido['celular'])): ?>
                                    <br><small class="text-muted">
                                        <i class="fas fa-phone me-1"></i><?= esc($pedido['celular']) ?>
                                    </small>
                                <?php endif; ?>
                                <?php if (!empty($pedido['correo_electronico'])): ?>
                                    <br><small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?= esc($pedido['correo_electronico']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></strong>
                                <br><small class="text-muted"><?= date('H:i', strtotime($pedido['fecha'])) ?></small>
                            </div>
                        </td>
                        <td>
                            <?php 
                            $estadoClass = '';
                            $estadoText = '';
                            switch($pedido['estado']) {
                                case 'pendiente':
                                    $estadoClass = 'bg-warning text-dark';
                                    $estadoText = 'Pendiente';
                                    break;
                                case 'confirmado':
                                    $estadoClass = 'bg-primary';
                                    $estadoText = 'Confirmado';
                                    break;
                                case 'en_preparacion':
                                    $estadoClass = 'bg-info text-dark';
                                    $estadoText = 'En Preparación';
                                    break;
                                case 'listo':
                                    $estadoClass = 'bg-success';
                                    $estadoText = 'Listo';
                                    break;
                                case 'en_camino':
                                    $estadoClass = 'bg-primary';
                                    $estadoText = 'En Camino';
                                    break;
                                case 'entregado':
                                    $estadoClass = 'bg-success';
                                    $estadoText = 'Entregado';
                                    break;
                                case 'cancelado':
                                    $estadoClass = 'bg-danger';
                                    $estadoText = 'Cancelado';
                                    break;
                                default:
                                    $estadoClass = 'bg-secondary';
                                    $estadoText = ucfirst($pedido['estado']);
                            }
                            ?>
                            <span class="badge <?= $estadoClass ?> text-uppercase"><?= $estadoText ?></span>
                        </td>
                        <td>
                            <?php if (!empty($pedido['observaciones'])): ?>
                                <span class="text-muted"><?= esc(substr($pedido['observaciones'], 0, 50)) ?><?= strlen($pedido['observaciones']) > 50 ? '...' : '' ?></span>
                            <?php else: ?>
                                <span class="text-muted">Sin observaciones</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('cocina/pedidos/' . $pedido['id']) ?>" class="btn btn-sm btn-primary" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($pedido['estado'] == 'pendiente'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" title="Confirmar pedido" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'confirmado')">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info" title="Iniciar preparación" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'en_preparacion')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                <?php elseif ($pedido['estado'] == 'confirmado'): ?>
                                    <button type="button" class="btn btn-sm btn-info" title="Iniciar preparación" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'en_preparacion')">
                                        <i class="fas fa-play"></i>
                                    </button>
                                <?php elseif ($pedido['estado'] == 'en_preparacion'): ?>
                                    <button type="button" class="btn btn-sm btn-success" title="Marcar como listo" onclick="cambiarEstado(<?= $pedido['id'] ?>, 'listo')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                <?php elseif ($pedido['estado'] == 'listo'): ?>
                                    <button type="button" class="btn btn-sm btn-primary" title="Asignar repartidor" onclick="mostrarModalEstado(<?= $pedido['id'] ?>, 'listo')">
                                        <i class="fas fa-motorcycle"></i>
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-warning" title="Cambiar estado" onclick="mostrarModalEstado(<?= $pedido['id'] ?>, '<?= $pedido['estado'] ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($pedidos)): ?>
        <div class="text-center py-4">
            <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No hay pedidos pendientes</h5>
            <p class="text-muted">Todos los pedidos han sido procesados.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal para cambiar estado -->
<div class="modal fade" id="cambiarEstadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Cambiar Estado del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cambiarEstadoForm">
                    <input type="hidden" id="pedido_id_estado" name="pedido_id">
                    <div class="mb-3">
                        <label class="form-label">Nuevo Estado</label>
                        <select name="nuevo_estado" id="nuevo_estado_select" class="form-select" required onchange="toggleRepartidorSelect()">
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
                    
                    <!-- Selector de repartidor (se muestra solo cuando se selecciona "En Camino") -->
                    <div class="mb-3" id="repartidor_select_container" style="display: none;">
                        <label class="form-label">
                            <i class="fas fa-motorcycle me-1"></i>Seleccionar Repartidor
                        </label>
                        <select name="repartidor_id" id="repartidor_select" class="form-select">
                            <option value="">Cargando repartidores...</option>
                        </select>
                        <small class="text-muted">Selecciona el repartidor que entregará este pedido</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Agregar observaciones sobre el cambio de estado..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarCambioEstado()">
                    <i class="fas fa-check me-2"></i>Cambiar Estado
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales
let map;
let markers = [];
let googleMapsLoaded = false;

// Cargar Google Maps de manera asíncrona
function loadGoogleMaps() {
    if (typeof google !== 'undefined' && google.maps) {
        googleMapsLoaded = true;
        initMap();
        return;
    }

    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= config('GoogleMaps')->apiKey ?>&libraries=places&loading=async&callback=initGoogleMaps';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

// Callback para cuando Google Maps se carga
function initGoogleMaps() {
    console.log('Google Maps cargado correctamente');
    googleMapsLoaded = true;
    initMap();
}

// Función para mostrar mensajes
function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = '1100';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type} border-0`;
    toast.role = 'alert';
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.marginBottom = '10px';
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    document.getElementById('toastContainer').appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Función para cambiar estado
function cambiarEstado(pedidoId, nuevoEstado) {
    if (confirm('¿Estás seguro de cambiar el estado del pedido #' + pedidoId + ' a "' + nuevoEstado + '"?')) {
        // Mostrar indicador de carga
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Procesando...';
        btn.disabled = true;
        
        console.log('Enviando solicitud para pedido:', pedidoId, 'nuevo estado:', nuevoEstado);
        
        fetch('<?= base_url('cocina/pedidos/cambiar-estado/') ?>' + pedidoId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => {
            console.log('Respuesta recibida:', response.status, response.statusText);
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ' - ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            if (data.success) {
                showToast('Estado actualizado correctamente', 'success');
                setTimeout(() => {
                location.reload();
                }, 1000);
            } else {
                showToast('Error: ' + (data.message || 'Error desconocido'), 'danger');
                // Restaurar botón
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            showToast('Error al cambiar el estado del pedido: ' + error.message, 'danger');
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}

// Función para mostrar modal
function mostrarModalEstado(pedidoId, estadoActual) {
    document.getElementById('pedido_id_estado').value = pedidoId;
    document.getElementById('nuevo_estado_select').value = '';
    document.querySelector('textarea[name="observaciones"]').value = '';
    
    // Ocultar selector de repartidor por defecto
    document.getElementById('repartidor_select_container').style.display = 'none';
    
    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('cambiarEstadoModal')).show();
}

// Función para mostrar/ocultar selector de repartidor
function toggleRepartidorSelect() {
    const nuevoEstado = document.getElementById('nuevo_estado_select').value;
    const repartidorContainer = document.getElementById('repartidor_select_container');
    const repartidorSelect = document.getElementById('repartidor_select');
    
    if (nuevoEstado === 'en_camino') {
        repartidorContainer.style.display = 'block';
        cargarRepartidoresDisponibles();
    } else {
        repartidorContainer.style.display = 'none';
        repartidorSelect.innerHTML = '<option value="">Cargando repartidores...</option>';
    }
}

// Función para cargar repartidores disponibles
function cargarRepartidoresDisponibles() {
    const repartidorSelect = document.getElementById('repartidor_select');
    repartidorSelect.innerHTML = '<option value="">Cargando repartidores...</option>';
    
    console.log('🔍 Iniciando carga de repartidores...');
    
    // Usar los repartidores que vienen del servidor
    const repartidores = <?= json_encode($repartidores ?? []) ?>;
    
    console.log('📊 Repartidores disponibles:', repartidores);
    
    if (repartidores && repartidores.length > 0) {
        repartidorSelect.innerHTML = '<option value="">Selecciona un repartidor...</option>';
        repartidores.forEach(repartidor => {
            const option = document.createElement('option');
            option.value = repartidor.id;
            option.textContent = `${repartidor.nombre} (${repartidor.pedidos_en_camino} pedidos en camino)`;
            repartidorSelect.appendChild(option);
        });
        console.log('✅ Repartidores cargados exitosamente:', repartidores.length, 'repartidores');
    } else {
        console.warn('⚠️ No hay repartidores disponibles');
        repartidorSelect.innerHTML = '<option value="">No hay repartidores disponibles</option>';
        showToast('No hay repartidores disponibles', 'warning');
    }
}

// Función para confirmar cambio de estado
function confirmarCambioEstado() {
    const pedidoId = document.getElementById('pedido_id_estado').value;
    const nuevoEstado = document.getElementById('nuevo_estado_select').value;
    const observaciones = document.querySelector('textarea[name="observaciones"]').value;
    const repartidorId = document.getElementById('repartidor_select').value;
    
    if (!nuevoEstado) {
        showToast('Debe seleccionar un estado', 'warning');
        return;
    }
    
    // Si el estado es "en_camino", verificar que se seleccionó un repartidor
    if (nuevoEstado === 'en_camino' && !repartidorId) {
        showToast('Debe seleccionar un repartidor para cambiar a "En Camino"', 'warning');
        return;
    }
    
    // Mostrar indicador de carga
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Procesando...';
    btn.disabled = true;
    
    const datos = {
        estado: nuevoEstado,
        observaciones: observaciones
    };
    
    // Agregar repartidor_id si se seleccionó uno
    if (repartidorId) {
        datos.repartidor_id = repartidorId;
    }
    
    fetch('<?= base_url('cocina/pedidos/cambiar-estado/') ?>' + pedidoId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Estado actualizado correctamente', 'success');
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('cambiarEstadoModal')).hide();
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast('Error: ' + (data.message || 'Error desconocido'), 'danger');
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error al cambiar el estado del pedido', 'danger');
        // Restaurar botón
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// Función para ver pedido detalle
function verPedidoDetalle(pedidoId) {
    window.location.href = `<?= base_url('cocina/pedidos/') ?>${pedidoId}`;
}

// Función para obtener color de estado
function getEstadoColor(estado) {
    if (!estado) return 'secondary';
    
    switch(estado.toLowerCase()) {
        case 'pendiente': return 'warning';
        case 'confirmado': return 'confirmado';
        case 'en_preparacion': return 'info';
        case 'listo': return 'success';
        case 'en_camino': return 'primary';
        case 'entregado': return 'success';
        case 'cancelado': return 'danger';
        default: return 'secondary';
    }
}

// Función para inicializar mapa
function initMap() {
    console.log('Inicializando mapa de cocina...');
    
    if (!googleMapsLoaded || typeof google === 'undefined' || !google.maps) {
        console.log('Google Maps no está disponible aún, reintentando...');
        setTimeout(initMap, 1000);
        return;
    }
    
    try {
        // Centrar en Clorinda, Formosa
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -25.291388888889, lng: -57.718333333333 },
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });
        
        // Cargar pedidos en el mapa
        cargarPedidosEnMapa();
    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
        const mapDiv = document.getElementById('map');
        if (mapDiv) {
            mapDiv.innerHTML = '<div class="alert alert-warning">Error al cargar el mapa. Verifique la conexión a internet.</div>';
        }
    }
}

// Función para cargar pedidos en el mapa
function cargarPedidosEnMapa() {
    const pedidos = <?= json_encode($pedidos ?? []) ?>;
    
    console.log('Cargando pedidos en el mapa:', pedidos ? pedidos.length : 0, 'pedidos');
    
    if (!pedidos || pedidos.length === 0) {
        console.log('No hay pedidos para mostrar en el mapa');
        return;
    }
    
    pedidos.forEach((pedido, index) => {
        if (pedido.latitud && pedido.longitud) {
            // Determinar color del marcador según el estado
            let backgroundColor = '#dc3545';
            let title = 'Pendiente';
            
            if (pedido.estado === 'listo') {
                backgroundColor = '#28a745';
                title = 'Listo';
            } else if (pedido.estado === 'en_preparacion') {
                backgroundColor = '#ffc107';
                title = 'En Preparación';
            } else if (pedido.estado === 'confirmado') {
                backgroundColor = '#6f42c1';
                title = 'Confirmado';
            } else if (pedido.estado === 'en_camino') {
                backgroundColor = '#007bff';
                title = 'En Camino';
            } else if (pedido.estado === 'entregado') {
                backgroundColor = '#28a745';
                title = 'Entregado';
            } else if (pedido.estado === 'cancelado') {
                backgroundColor = '#dc3545';
                title = 'Cancelado';
            }
            
            // Crear el contenido del marcador
            const markerContent = document.createElement('div');
            markerContent.innerHTML = `
                <div style="
                    background-color: ${backgroundColor};
                    color: white;
                    padding: 8px 12px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: bold;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                    white-space: nowrap;
                    border: 2px solid white;
                ">
                    #${pedido.id || 'N/A'}
                </div>
            `;
            
            // Usar AdvancedMarkerElement (nueva API recomendada)
            let marker;
            try {
                if (typeof google.maps.marker?.AdvancedMarkerElement !== 'undefined') {
                    marker = new google.maps.marker.AdvancedMarkerElement({
                        position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                        map: map,
                        title: `Pedido #${pedido.id || 'N/A'} - ${title}`,
                        content: markerContent
                    });
                } else {
                    // Fallback para navegadores que no soportan AdvancedMarkerElement
                    marker = new google.maps.Marker({
                        position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                        map: map,
                        title: `Pedido #${pedido.id || 'N/A'} - ${title}`,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 8,
                            fillColor: backgroundColor,
                            fillOpacity: 1,
                            strokeColor: '#ffffff',
                            strokeWeight: 2
                        }
                    });
                }
            } catch (error) {
                console.warn('Error al crear marcador, usando fallback:', error);
                // Fallback final con marcador básico
                marker = new google.maps.Marker({
                    position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                    map: map,
                    title: `Pedido #${pedido.id || 'N/A'} - ${title}`,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: backgroundColor,
                        fillOpacity: 1,
                        strokeColor: '#ffffff',
                        strokeWeight: 2
                    }
                });
            }
            
            // Info window con detalles del pedido
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width: 250px;">
                        <h6><strong>Pedido #${pedido.id || 'N/A'}</strong></h6>
                        <p><strong>Cliente:</strong> ${pedido.nombre || 'No especificado'}</p>
                        <p><strong>Dirección:</strong> ${pedido.direccion_entrega || 'No especificada'}</p>
                        <p><strong>Estado:</strong> <span class="badge bg-${getEstadoColor(pedido.estado)}">${pedido.estado || 'N/A'}</span></p>
                        <p><strong>Fecha:</strong> ${new Date(pedido.fecha || '').toLocaleString()}</p>
                        <p><strong>Total:</strong> $${pedido.total || 0}</p>
                        <div class="mt-2">
                            <button onclick="mostrarModalEstado(${pedido.id || 0}, '${pedido.estado || ''}')" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Cambiar Estado
                            </button>
                            <button onclick="verPedidoDetalle(${pedido.id || 0})" class="btn btn-info btn-sm ms-1">
                                <i class="fas fa-eye me-1"></i>Ver Detalles
                            </button>
                        </div>
                    </div>
                `
            });
            
            // Agregar listener para el clic en el marcador
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
            
            markers.push(marker);
        }
    });
}

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    loadGoogleMaps();
});
</script> 