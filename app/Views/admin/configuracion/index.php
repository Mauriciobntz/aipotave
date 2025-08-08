

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Configuración del Sitio
                    </h4>
                    <div>
                        <a href="<?= base_url('admin/configuracion/vista-rapida') ?>" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Vista Rápida
                        </a>
                        <a href="<?= base_url('admin/configuracion/mapa-seguimiento') ?>" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-map-marked-alt me-1"></i>Mapa de Seguimiento
                        </a>
                        <a href="<?= base_url('admin/configuracion/crear') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Nueva Configuración
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="seccion" class="form-label">Sección</label>
                                <select name="seccion" id="seccion" class="form-select">
                                    <option value="">Todas las secciones</option>
                                    <option value="general" <?= ($filtros['seccion'] === 'general') ? 'selected' : '' ?>>General</option>
                                    <option value="navbar" <?= ($filtros['seccion'] === 'navbar') ? 'selected' : '' ?>>Navbar</option>
                                    <option value="footer" <?= ($filtros['seccion'] === 'footer') ? 'selected' : '' ?>>Footer</option>
                                    <option value="contacto" <?= ($filtros['seccion'] === 'contacto') ? 'selected' : '' ?>>Contacto</option>
                                    <option value="redes_sociales" <?= ($filtros['seccion'] === 'redes_sociales') ? 'selected' : '' ?>>Redes Sociales</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select name="tipo" id="tipo" class="form-select">
                                    <option value="">Todos los tipos</option>
                                    <option value="texto" <?= ($filtros['tipo'] === 'texto') ? 'selected' : '' ?>>Texto</option>
                                    <option value="numero" <?= ($filtros['tipo'] === 'numero') ? 'selected' : '' ?>>Número</option>
                                    <option value="email" <?= ($filtros['tipo'] === 'email') ? 'selected' : '' ?>>Email</option>
                                    <option value="url" <?= ($filtros['tipo'] === 'url') ? 'selected' : '' ?>>URL</option>
                                    <option value="telefono" <?= ($filtros['tipo'] === 'telefono') ? 'selected' : '' ?>>Teléfono</option>
                                    <option value="direccion" <?= ($filtros['tipo'] === 'direccion') ? 'selected' : '' ?>>Dirección</option>
                                    <option value="horario" <?= ($filtros['tipo'] === 'horario') ? 'selected' : '' ?>>Horario</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="activo" class="form-label">Estado</label>
                                <select name="activo" id="activo" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="1" <?= ($filtros['activo'] === '1') ? 'selected' : '' ?>>Activo</option>
                                    <option value="0" <?= ($filtros['activo'] === '0') ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="buscar" class="form-label">Buscar</label>
                                <input type="text" name="buscar" id="buscar" class="form-control" 
                                       value="<?= esc($filtros['buscar'] ?? '') ?>" 
                                       placeholder="Clave, valor o descripción">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="<?= base_url('admin/configuracion') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de configuraciones -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Clave</th>
                                    <th>Valor</th>
                                    <th>Tipo</th>
                                    <th>Sección</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($configuraciones)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-info-circle text-muted me-2"></i>
                                            No se encontraron configuraciones
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($configuraciones as $config): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($config['clave']) ?></strong>
                                                <?php if ($config['descripcion']): ?>
                                                    <br><small class="text-muted"><?= esc($config['descripcion']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (strlen($config['valor']) > 50): ?>
                                                    <span title="<?= esc($config['valor']) ?>">
                                                        <?= esc(substr($config['valor'], 0, 50)) ?>...
                                                    </span>
                                                <?php else: ?>
                                                    <?= esc($config['valor']) ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= esc($config['tipo']) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?= esc($config['seccion']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($config['activo']): ?>
                                                    <span class="badge bg-success">Activo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactivo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= base_url('admin/configuracion/editar/' . $config['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/configuracion/toggle-estado/' . $config['id']) ?>" 
                                                       class="btn btn-outline-warning" title="Cambiar estado"
                                                       onclick="return confirm('¿Estás seguro de cambiar el estado?')">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/configuracion/eliminar/' . $config['id']) ?>" 
                                                       class="btn btn-outline-danger" title="Eliminar"
                                                       onclick="return confirm('¿Estás seguro de eliminar esta configuración?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php if ($pagination['total'] > 1): ?>
                        <nav aria-label="Paginación de configuraciones">
                            <ul class="pagination justify-content-center">
                                <?php if ($pagination['current'] > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('admin/configuracion?page=' . ($pagination['current'] - 1)) ?>">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $pagination['total']; $i++): ?>
                                    <li class="page-item <?= ($i == $pagination['current']) ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= base_url('admin/configuracion?page=' . $i) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagination['current'] < $pagination['total']): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= base_url('admin/configuracion?page=' . ($pagination['current'] + 1)) ?>">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                    <!-- Información de paginación -->
                    <div class="text-center text-muted">
                        <small>
                            Mostrando <?= count($configuraciones) ?> de <?= $pagination['totalRecords'] ?> configuraciones
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 