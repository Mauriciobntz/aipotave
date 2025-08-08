<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-images me-2"></i>Gestión de Slides
                    </h5>
                    <a href="<?= base_url('admin/slides/crear') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Slide
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($slides)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay slides configurados</h5>
                            <p class="text-muted">Crea tu primer slide para el carrusel principal</p>
                            <a href="<?= base_url('admin/slides/crear') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Primer Slide
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="50">#</th>
                                        <th width="100">Imagen</th>
                                        <th>Título</th>
                                        <th>Subtítulo</th>
                                        <th width="100">Orden</th>
                                        <th width="80">Estado</th>
                                        <th width="200">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="slides-tbody">
                                    <?php foreach ($slides as $slide): ?>
                                    <tr data-id="<?= $slide['id'] ?>">
                                        <td><?= $slide['id'] ?></td>
                                        <td>
                                            <?php if (!empty($slide['imagen'])): ?>
                                                <img src="<?= base_url('public/' . $slide['imagen']) ?>" 
                                                     alt="<?= esc($slide['titulo']) ?>" 
                                                     class="img-thumbnail" 
                                                     style="width: 60px; height: 40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= esc($slide['titulo']) ?></strong>
                                            <?php if (!empty($slide['link_destino'])): ?>
                                                <br><small class="text-muted">
                                                    <i class="fas fa-link me-1"></i><?= esc($slide['link_destino']) ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($slide['subtitulo'] ?? '') ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $slide['orden'] ?></span>
                                        </td>
                                        <td>
                                            <?php if ($slide['activo']): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactivo</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= base_url('admin/slides/editar/' . $slide['id']) ?>" 
                                                   class="btn btn-outline-primary" 
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <a href="<?= base_url('admin/slides/toggle-estado/' . $slide['id']) ?>" 
                                                   class="btn btn-outline-<?= $slide['activo'] ? 'warning' : 'success' ?>" 
                                                   title="<?= $slide['activo'] ? 'Desactivar' : 'Activar' ?>"
                                                   onclick="return confirm('¿Estás seguro?')">
                                                    <i class="fas fa-<?= $slide['activo'] ? 'eye-slash' : 'eye' ?>"></i>
                                                </a>
                                                
                                                <a href="<?= base_url('admin/slides/eliminar/' . $slide['id']) ?>" 
                                                   class="btn btn-outline-danger" 
                                                   title="Eliminar"
                                                   onclick="return confirm('¿Estás seguro de eliminar este slide?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-info" onclick="reordenarSlides()">
                                <i class="fas fa-sort me-2"></i>Guardar Orden
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Hacer la tabla ordenable
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('slides-tbody');
    if (tbody) {
        new Sortable(tbody, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                // Actualizar números de orden visualmente
                actualizarOrdenVisual();
            }
        });
    }
});

function actualizarOrdenVisual() {
    const filas = document.querySelectorAll('#slides-tbody tr');
    filas.forEach((fila, index) => {
        const ordenBadge = fila.querySelector('.badge');
        if (ordenBadge) {
            ordenBadge.textContent = index + 1;
        }
    });
}

function reordenarSlides() {
    const filas = document.querySelectorAll('#slides-tbody tr');
    const ordenes = {};
    
    filas.forEach((fila, index) => {
        const id = fila.dataset.id;
        ordenes[id] = index + 1;
    });

    fetch('<?= base_url('admin/slides/reordenar') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ ordenes: ordenes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarAlerta('Orden actualizado exitosamente', 'success');
        } else {
            mostrarAlerta('Error al actualizar el orden', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarAlerta('Error al actualizar el orden', 'danger');
    });
}

function mostrarAlerta(mensaje, tipo) {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo} alert-dismissible fade show`;
    alerta.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.card-body');
    container.insertBefore(alerta, container.firstChild);
    
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}
</script>

<style>
/* Estilos para ocupar todo el ancho */
.container-fluid {
    padding: 0;
    margin: 0;
    width: 100%;
}

.row {
    margin: 0;
}

.col-12 {
    padding: 0;
}

.card {
    border-radius: 0;
    margin: 0;
    min-height: calc(100vh - 200px);
}

.card-header {
    background: linear-gradient(135deg, #4281A4 0%, #48A9A6 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

/* Tabla responsiva */
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: #2c3e50;
    color: white;
    border: none;
    padding: 1rem;
    font-weight: 600;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

/* Estilos para drag and drop */
.sortable-ghost {
    opacity: 0.5;
    background-color: #f8f9fa !important;
}

.sortable-chosen {
    background-color: #e3f2fd !important;
}

.sortable-drag {
    background-color: #fff !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

#slides-tbody tr {
    cursor: move;
    transition: all 0.3s ease;
}

#slides-tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Botones mejorados */
.btn-group-sm .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
}

/* Badges mejorados */
.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

/* Imágenes de slides */
.img-thumbnail {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style> 