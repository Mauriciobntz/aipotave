<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
            <i class="fas fa-utensils me-2 text-warning"></i>Panel Administrativo
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/panel') ?>">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pedidosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-list me-1"></i>Pedidos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="pedidosDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/panel') ?>">
                                <i class="fas fa-list me-2"></i>Gestión de Pedidos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/estadisticas') ?>">
                                <i class="fas fa-chart-line me-2"></i>Estadísticas
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-box me-1"></i>Productos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productosDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/productos/listar') ?>">
                                <i class="fas fa-box me-2"></i>Productos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/combos/listar') ?>">
                                <i class="fas fa-gift me-2"></i>Combos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/viandas/listar') ?>">
                                <i class="fas fa-star me-2"></i>Viandas
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="gestionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs me-1"></i>Gestión
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="gestionDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/categorias') ?>">
                                <i class="fas fa-tags me-2"></i>Categorías
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/subcategorias') ?>">
                                <i class="fas fa-tag me-2"></i>Subcategorías
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/repartidores/listar') ?>">
                                <i class="fas fa-motorcycle me-2"></i>Repartidores
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/notificaciones/listar') ?>">
                                <i class="fas fa-bell me-2"></i>Notificaciones
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/slides') ?>">
                                <i class="fas fa-images me-2"></i>Slides
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="configuracionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog me-1"></i>Configuración
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="configuracionDropdown">
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/configuracion') ?>">
                                <i class="fas fa-cogs me-2"></i>Configuración General
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/configuracion/punto-partida') ?>">
                                <i class="fas fa-map-marker-alt me-2"></i>Punto de Partida
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/configuracion/mapa-seguimiento') ?>">
                                <i class="fas fa-map-marked-alt me-2"></i>Mapa de Seguimiento
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/tarifas-envio') ?>">
                                <i class="fas fa-truck me-2"></i>Tarifas Locales de Envío
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('admin/configuracion/vista-rapida') ?>">
                                <i class="fas fa-eye me-2"></i>Vista Rápida
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <!-- Usuario y autenticación -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= esc(session('user_name') ?? 'Administrador') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">
                                    <i class="fas fa-user-tag me-2"></i>Administrador
                                </small>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/') ?>">
                                <i class="fas fa-home me-2"></i>Ir al Sitio
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> 