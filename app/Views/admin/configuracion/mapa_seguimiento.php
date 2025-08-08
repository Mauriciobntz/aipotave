<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-map-marked-alt me-2"></i>Configuración del Mapa de Seguimiento
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="<?= base_url('admin/configuracion/actualizar-mapa-seguimiento') ?>" method="post">
                                <!-- Estado del mapa de seguimiento -->
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-toggle-on me-2"></i>Estado del Mapa de Seguimiento
                                    </h5>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" 
                                               <?= ($configuracion['activo'] ? 'checked' : '') ?>>
                                        <label class="form-check-label" for="activo">
                                            <strong>Activar mapa de seguimiento</strong>
                                        </label>
                                    </div>
                                    <small class="text-muted">
                                        Cuando está desactivado, los clientes no verán el mapa de seguimiento en tiempo real del repartidor.
                                    </small>
                                </div>

                                <!-- Configuración de tiempo de actualización -->
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-clock me-2"></i>Tiempo de Actualización
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tiempo_actualizacion" class="form-label">Intervalo de actualización (segundos)</label>
                                            <input type="number" class="form-control" id="tiempo_actualizacion" name="tiempo_actualizacion" 
                                                   value="<?= esc($configuracion['tiempo_actualizacion']) ?>" min="10" max="300" step="5">
                                            <small class="text-muted">
                                                Tiempo entre actualizaciones de la ubicación del repartidor (10-300 segundos)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Configuración de visualización -->
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-eye me-2"></i>Opciones de Visualización
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="mostrar_ruta" name="mostrar_ruta" value="1" 
                                                       <?= ($configuracion['mostrar_ruta'] ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="mostrar_ruta">
                                                    <strong>Mostrar ruta del repartidor</strong>
                                                </label>
                                            </div>
                                            <small class="text-muted">
                                                Muestra la ruta que seguirá el repartidor desde su ubicación actual hasta el destino
                                            </small>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="zoom_default" class="form-label">Zoom por defecto</label>
                                            <input type="number" class="form-control" id="zoom_default" name="zoom_default" 
                                                   value="<?= esc($configuracion['zoom_default']) ?>" min="10" max="20" step="1">
                                            <small class="text-muted">
                                                Nivel de zoom inicial del mapa (10-20)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/configuracion') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Volver a Configuración
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Guardar Configuración
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Información
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <h6>¿Qué hace esta configuración?</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <strong>Estado:</strong> Activa o desactiva completamente el mapa de seguimiento
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-clock text-info me-2"></i>
                                            <strong>Tiempo de actualización:</strong> Frecuencia con que se actualiza la ubicación
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-route text-warning me-2"></i>
                                            <strong>Mostrar ruta:</strong> Visualiza la ruta que seguirá el repartidor
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-search text-primary me-2"></i>
                                            <strong>Zoom:</strong> Nivel de acercamiento inicial del mapa
                                        </li>
                                    </ul>
                                    
                                    <hr>
                                    
                                    <h6>Recomendaciones:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-1">
                                            <i class="fas fa-lightbulb text-warning me-2"></i>
                                            Tiempo de actualización: 30-60 segundos
                                        </li>
                                        <li class="mb-1">
                                            <i class="fas fa-lightbulb text-warning me-2"></i>
                                            Zoom: 15 para vista general
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
