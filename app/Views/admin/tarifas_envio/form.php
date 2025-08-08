<?php
$isEditing = isset($tarifa);
$title = $isEditing ? 'Editar Tarifa Local de Envío' : 'Crear Tarifa Local de Envío';
$action = $isEditing ? base_url('admin/tarifas-envio/actualizar/' . $tarifa['id']) : base_url('admin/tarifas-envio/guardar');
$method = 'POST';

// Valores por defecto para crear
$nombre = old('nombre') ?? ($tarifa['nombre'] ?? '');
$distanciaMinima = old('distancia_minima') ?? ($tarifa['distancia_minima'] ?? '');
$distanciaMaxima = old('distancia_maxima') ?? ($tarifa['distancia_maxima'] ?? '');
$costo = old('costo') ?? ($tarifa['costo'] ?? '');
$descripcion = old('descripcion') ?? ($tarifa['descripcion'] ?? '');
$activo = old('activo') ?? ($tarifa['activo'] ?? 1);
$orden = old('orden') ?? ($tarifa['orden'] ?? ($siguienteOrden ?? 1));
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-<?= $isEditing ? 'edit' : 'plus' ?> me-2"></i><?= $title ?>
                    </h5>
                </div>
                
                <div class="card-body">
                    <form action="<?= $action ?>" method="<?= $method ?>" id="formTarifa">
                        <div class="row">
                                                         <!-- Nombre -->
                             <div class="col-12 mb-3">
                                 <label for="nombre" class="form-label">
                                     <i class="fas fa-tag me-1"></i>Nombre de la Tarifa Local *
                                 </label>
                                 <input type="text" 
                                        class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                        id="nombre" 
                                        name="nombre" 
                                        value="<?= esc($nombre) ?>" 
                                        required 
                                        placeholder="Ej: Envío Local (0-1 km), Envío Local (1-2 km)">
                                 <?php if (session('errors.nombre')): ?>
                                     <div class="invalid-feedback"><?= session('errors.nombre') ?></div>
                                 <?php endif; ?>
                                 <small class="text-muted">Nombre descriptivo para identificar la tarifa local</small>
                             </div>

                            <!-- Rango de Distancia -->
                            <div class="col-md-6 mb-3">
                                <label for="distancia_minima" class="form-label">
                                    <i class="fas fa-route me-1"></i>Distancia Mínima (km) *
                                </label>
                                <input type="number" 
                                       class="form-control <?= session('errors.distancia_minima') ? 'is-invalid' : '' ?>" 
                                       id="distancia_minima" 
                                       name="distancia_minima" 
                                       value="<?= esc($distanciaMinima) ?>" 
                                       step="0.1" 
                                       min="0" 
                                       required>
                                <?php if (session('errors.distancia_minima')): ?>
                                    <div class="invalid-feedback"><?= session('errors.distancia_minima') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="distancia_maxima" class="form-label">
                                    <i class="fas fa-route me-1"></i>Distancia Máxima (km) *
                                </label>
                                <input type="number" 
                                       class="form-control <?= session('errors.distancia_maxima') ? 'is-invalid' : '' ?>" 
                                       id="distancia_maxima" 
                                       name="distancia_maxima" 
                                       value="<?= esc($distanciaMaxima) ?>" 
                                       step="0.1" 
                                       min="0" 
                                       required>
                                <?php if (session('errors.distancia_maxima')): ?>
                                    <div class="invalid-feedback"><?= session('errors.distancia_maxima') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Costo -->
                            <div class="col-md-6 mb-3">
                                <label for="costo" class="form-label">
                                    <i class="fas fa-dollar-sign me-1"></i>Costo ($) *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           class="form-control <?= session('errors.costo') ? 'is-invalid' : '' ?>" 
                                           id="costo" 
                                           name="costo" 
                                           value="<?= esc($costo) ?>" 
                                           step="100" 
                                           min="0" 
                                           required>
                                </div>
                                <?php if (session('errors.costo')): ?>
                                    <div class="invalid-feedback"><?= session('errors.costo') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Orden -->
                            <div class="col-md-6 mb-3">
                                <label for="orden" class="form-label">
                                    <i class="fas fa-sort-numeric-up me-1"></i>Orden *
                                </label>
                                <input type="number" 
                                       class="form-control <?= session('errors.orden') ? 'is-invalid' : '' ?>" 
                                       id="orden" 
                                       name="orden" 
                                       value="<?= esc($orden) ?>" 
                                       min="1" 
                                       required>
                                <?php if (session('errors.orden')): ?>
                                    <div class="invalid-feedback"><?= session('errors.orden') ?></div>
                                <?php endif; ?>
                                <small class="text-muted">Orden de prioridad (1 = más alta)</small>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-info-circle me-1"></i>Descripción
                                </label>
                                <textarea class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" 
                                          id="descripcion" 
                                          name="descripcion" 
                                          rows="3" 
                                          placeholder="Descripción opcional de la tarifa"><?= esc($descripcion) ?></textarea>
                                <?php if (session('errors.descripcion')): ?>
                                    <div class="invalid-feedback"><?= session('errors.descripcion') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Estado -->
                            <div class="col-12 mb-3">
                                <label for="activo" class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>Estado *
                                </label>
                                <select class="form-select <?= session('errors.activo') ? 'is-invalid' : '' ?>" 
                                        id="activo" 
                                        name="activo" 
                                        required>
                                    <option value="1" <?= $activo == 1 ? 'selected' : '' ?>>Activo</option>
                                    <option value="0" <?= $activo == 0 ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                                <?php if (session('errors.activo')): ?>
                                    <div class="invalid-feedback"><?= session('errors.activo') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Vista previa del rango -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-eye me-1"></i>Vista Previa del Rango
                                        </h6>
                                        <div id="vistaPrevia" class="text-center">
                                            <span class="badge bg-info fs-6">
                                                <span id="rangoTexto">Ingresa las distancias para ver el rango</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/tarifas-envio') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Volver
                                    </a>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary me-2" onclick="validarFormulario()">
                                            <i class="fas fa-check me-1"></i>Validar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i><?= $isEditing ? 'Actualizar' : 'Crear' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Actualizar vista previa del rango
function actualizarVistaPrevia() {
    const min = parseFloat(document.getElementById('distancia_minima').value) || 0;
    const max = parseFloat(document.getElementById('distancia_maxima').value) || 0;
    const rangoTexto = document.getElementById('rangoTexto');
    
    if (min > 0 && max > 0) {
        if (max > min) {
            rangoTexto.textContent = `${min.toFixed(1)} - ${max.toFixed(1)} km`;
            document.getElementById('vistaPrevia').querySelector('.badge').className = 'badge bg-success fs-6';
        } else {
            rangoTexto.textContent = 'La distancia máxima debe ser mayor que la mínima';
            document.getElementById('vistaPrevia').querySelector('.badge').className = 'badge bg-danger fs-6';
        }
    } else {
        rangoTexto.textContent = 'Ingresa las distancias para ver el rango';
        document.getElementById('vistaPrevia').querySelector('.badge').className = 'badge bg-info fs-6';
    }
}

// Validar formulario
function validarFormulario() {
    const min = parseFloat(document.getElementById('distancia_minima').value) || 0;
    const max = parseFloat(document.getElementById('distancia_maxima').value) || 0;
    const costo = parseFloat(document.getElementById('costo').value) || 0;
    
    let errores = [];
    
    if (max <= min) {
        errores.push('La distancia máxima debe ser mayor que la distancia mínima');
    }
    
    if (costo < 0) {
        errores.push('El costo debe ser mayor o igual a 0');
    }
    
    if (errores.length > 0) {
        alert('Errores encontrados:\n' + errores.join('\n'));
    } else {
        alert('Formulario válido');
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar vista previa cuando cambien las distancias
    document.getElementById('distancia_minima').addEventListener('input', actualizarVistaPrevia);
    document.getElementById('distancia_maxima').addEventListener('input', actualizarVistaPrevia);
    
    // Actualizar vista previa inicial
    actualizarVistaPrevia();
    
    // Validar formulario antes de enviar
    document.getElementById('formTarifa').addEventListener('submit', function(e) {
        const min = parseFloat(document.getElementById('distancia_minima').value) || 0;
        const max = parseFloat(document.getElementById('distancia_maxima').value) || 0;
        
        if (max <= min) {
            e.preventDefault();
            alert('La distancia máxima debe ser mayor que la distancia mínima');
            return false;
        }
    });
});
</script>
