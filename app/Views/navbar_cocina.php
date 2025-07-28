<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('cocina/pedidos') ?>">
            <i class="fas fa-utensils me-2 text-warning"></i>Panel de Cocina
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cocina/pedidos') ?>">
                        <i class="fas fa-list me-1"></i>Pedidos Pendientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cocina/pantalla') ?>" target="_blank">
                        <i class="fas fa-tv me-1"></i>Pantalla de Cocina
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cocina/productos') ?>">
                        <i class="fas fa-box me-1"></i>Gestionar Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('cocina/estadisticas') ?>">
                        <i class="fas fa-chart-bar me-1"></i>Estadísticas
                    </a>
                </li>
            </ul>
            
            <!-- Usuario y autenticación -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= esc(session('user_name') ?? 'Cocina') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">
                                    <i class="fas fa-user-tag me-2"></i>Cocina
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