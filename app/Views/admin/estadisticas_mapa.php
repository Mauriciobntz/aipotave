<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas con Mapas - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .bg-confirmado {
            background-color: #6f42c1 !important;
            color: white !important;
        }
        .badge.bg-confirmado {
            background-color: #6f42c1 !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="fas fa-chart-line me-2 text-primary"></i>Estadísticas con Mapas
                </h1>
            </div>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Pedidos</h6>
                                <h3 class="mb-0"><?= $total_pedidos ?? 0 ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-shopping-bag fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Entregados</h6>
                                <h3 class="mb-0"><?= $pedidos_entregados ?? 0 ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">En Camino</h6>
                                <h3 class="mb-0"><?= $pedidos_en_camino ?? 0 ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-motorcycle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Ingresos</h6>
                                <h3 class="mb-0">$<?= number_format($ingresos_totales ?? 0, 0, ',', '.') ?></h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form method="get" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Período</label>
                                <select name="periodo" class="form-select" onchange="this.form.submit()">
                                    <option value="hoy" <?= ($periodo ?? '') == 'hoy' ? 'selected' : '' ?>>Hoy</option>
                                    <option value="semana" <?= ($periodo ?? '') == 'semana' ? 'selected' : '' ?>>Esta Semana</option>
                                    <option value="mes" <?= ($periodo ?? '') == 'mes' ? 'selected' : '' ?>>Este Mes</option>
                                    <option value="todos" <?= ($periodo ?? '') == 'todos' ? 'selected' : '' ?>>Todos</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Estado</label>
                                <select name="estado" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos los estados</option>
                                    <option value="entregado" <?= ($estado ?? '') == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                                    <option value="en_camino" <?= ($estado ?? '') == 'en_camino' ? 'selected' : '' ?>>En Camino</option>
                                    <option value="listo" <?= ($estado ?? '') == 'listo' ? 'selected' : '' ?>>Listo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha Desde</label>
                                <input type="date" name="fecha_desde" class="form-control" value="<?= $fecha_desde ?? '' ?>" onchange="this.form.submit()">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha Hasta</label>
                                <input type="date" name="fecha_hasta" class="form-control" value="<?= $fecha_hasta ?? '' ?>" onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mapas -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Mapa de Entregas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="map-container position-relative">
                            <div id="map" style="height: 500px; width: 100%;"></div>
                            <div class="legend">
                                <h6 class="mb-2"><strong>Leyenda</strong></h6>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #28a745;"></div>
                                    <span>Entregado</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #007bff;"></div>
                                    <span>En Camino</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #ffc107;"></div>
                                    <span>Listo</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #6f42c1;"></div>
                                    <span>Confirmado</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background-color: #dc3545;"></div>
                                    <span>Pendiente</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Estadísticas por Zona</h5>
                    </div>
                    <div class="card-body">
                        <div id="zonaStats">
                            <!-- Las estadísticas por zona se cargarán dinámicamente -->
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Tiempo Promedio</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary"><?= $tiempo_preparacion ?? '0' ?> min</h4>
                                <small class="text-muted">Preparación</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success"><?= $tiempo_entrega ?? '0' ?> min</h4>
                                <small class="text-muted">Entrega</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps -->
    <script>
    let map;
    let markers = [];
    let heatmap;
    let googleMapsLoaded = false;

    // Cargar Google Maps de manera asíncrona
    function loadGoogleMaps() {
        if (typeof google !== 'undefined' && google.maps) {
            googleMapsLoaded = true;
            initMap();
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?= config('GoogleMaps')->apiKey ?>&libraries=visualization,places&callback=initGoogleMaps';
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

    function initMap() {
        console.log('Inicializando mapa de estadísticas...');
        
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
            
            // Cargar datos en el mapa
            cargarDatosEnMapa();
            cargarEstadisticasZona();
        } catch (error) {
            console.error('Error al inicializar el mapa:', error);
            const mapDiv = document.getElementById('map');
            if (mapDiv) {
                mapDiv.innerHTML = '<div class="alert alert-warning">Error al cargar el mapa. Verifique la conexión a internet.</div>';
            }
        }
    }

    function cargarDatosEnMapa() {
        const pedidos = <?= json_encode($pedidos ?? []) ?>;
        const heatmapData = [];
        
        console.log('Cargando datos en el mapa:', pedidos ? pedidos.length : 0, 'pedidos');
        
        if (!pedidos || pedidos.length === 0) {
            console.log('No hay pedidos para mostrar en el mapa');
            return;
        }
        
        pedidos.forEach((pedido, index) => {
            if (pedido.latitud && pedido.longitud) {
                // Determinar color del marcador según el estado
                let iconUrl = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
                let title = 'Pendiente';
                
                if (pedido.estado === 'entregado') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/green-dot.png';
                    title = 'Entregado';
                } else if (pedido.estado === 'en_camino') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                    title = 'En Camino';
                } else if (pedido.estado === 'listo') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
                    title = 'Listo';
                } else if (pedido.estado === 'confirmado') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/purple-dot.png';
                    title = 'Confirmado';
                } else if (pedido.estado === 'en_preparacion') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/orange-dot.png';
                    title = 'En Preparación';
                } else if (pedido.estado === 'cancelado') {
                    iconUrl = 'https://maps.google.com/mapfiles/ms/icons/red-dot.png';
                    title = 'Cancelado';
                }
                
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(pedido.latitud), lng: parseFloat(pedido.longitud) },
                    map: map,
                    title: `Pedido #${pedido.id || 'N/A'} - ${title}`,
                    icon: {
                        url: iconUrl,
                        scaledSize: new google.maps.Size(32, 32)
                    }
                });
                
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
                            <p><strong>Tiempo:</strong> ${calcularTiempo(pedido.fecha, pedido.fecha_entrega)}</p>
                        </div>
                    `
                });
                
                marker.addListener('click', function() {
                    infoWindow.open(map, marker);
                });
                
                markers.push(marker);
                
                // Agregar punto para el heatmap
                heatmapData.push({
                    location: new google.maps.LatLng(parseFloat(pedido.latitud), parseFloat(pedido.longitud)),
                    weight: parseFloat(pedido.total || 0) // El peso se basa en el total del pedido
                });
            }
        });
        
        // Crear heatmap si hay datos
        if (heatmapData.length > 0 && typeof google.maps.visualization !== 'undefined') {
            try {
                heatmap = new google.maps.visualization.HeatmapLayer({
                    data: heatmapData,
                    map: map,
                    radius: 50,
                    opacity: 0.6
                });
            } catch (error) {
                console.error('Error al crear heatmap:', error);
            }
        }
    }

    function cargarEstadisticasZona() {
        const zonas = <?= json_encode($zonas ?? []) ?>;
        const zonaStatsDiv = document.getElementById('zonaStats');
        
        console.log('Cargando estadísticas por zona:', zonas);
        
        let html = '';
        if (zonas && zonas.length > 0) {
            zonas.forEach(zona => {
                const porcentaje = ((zona.total / <?= $total_pedidos ?? 1 ?>) * 100).toFixed(1);
                html += `
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><strong>${zona.zona || 'Zona no especificada'}</strong></span>
                            <span class="badge bg-primary">${zona.total || 0} pedidos</span>
                        </div>
                        <div class="progress mt-1" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: ${porcentaje}%" 
                                 aria-valuenow="${porcentaje}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">${porcentaje}% del total</small>
                    </div>
                `;
            });
        } else {
            html = '<div class="text-muted">No hay datos de zonas disponibles</div>';
        }
        
        zonaStatsDiv.innerHTML = html;
    }

    function getEstadoColor(estado) {
        if (!estado) return 'secondary';
        
        switch(estado.toLowerCase()) {
            case 'pendiente': return 'secondary';
            case 'confirmado': return 'confirmado';
            case 'en_preparacion': return 'warning';
            case 'listo': return 'warning';
            case 'en_camino': return 'primary';
            case 'entregado': return 'success';
            case 'cancelado': return 'danger';
            default: return 'secondary';
        }
    }

    function calcularTiempo(fechaInicio, fechaFin) {
        if (!fechaInicio || !fechaFin) return 'N/A';
        
        try {
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);
            
            if (isNaN(inicio.getTime()) || isNaN(fin.getTime())) {
                return 'N/A';
            }
            
            const diffMs = fin - inicio;
            const diffMins = Math.round(diffMs / 60000);
            
            if (diffMins < 60) {
                return `${diffMins} min`;
            } else {
                const horas = Math.floor(diffMins / 60);
                const minutos = diffMins % 60;
                return `${horas}h ${minutos}min`;
            }
        } catch (error) {
            console.error('Error al calcular tiempo:', error);
            return 'N/A';
        }
    }

    // Función para exportar datos
    function exportarDatos() {
        const pedidos = <?= json_encode($pedidos ?? []) ?>;
        let csv = 'ID,Cliente,Dirección,Estado,Total,Fecha\n';
        
        if (pedidos && pedidos.length > 0) {
            pedidos.forEach(pedido => {
                csv += `${pedido.id || ''},"${pedido.nombre || ''}","${pedido.direccion_entrega || ''}","${pedido.estado || ''}",${pedido.total || 0},"${pedido.fecha || ''}"\n`;
            });
        }
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'estadisticas_entregas.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    }

    // Llamar a initMap cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM cargado, verificando Google Maps...');
        
        // Esperar a que Google Maps se cargue completamente
        loadGoogleMaps(); // Usar la nueva función para cargar Google Maps
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 