<nav class="navbar navbar-expand-lg navbar-dark bg-warning mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="<?= base_url('repartidor/pedidos') ?>">
            <i class="fas fa-motorcycle me-2 text-dark"></i>Panel de Repartidor
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="<?= base_url('repartidor/pedidos') ?>">
                        <i class="fas fa-list me-1"></i>Mis Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="<?= base_url('repartidor/estadisticas') ?>">
                        <i class="fas fa-chart-bar me-1"></i>Estadísticas
                    </a>
                </li>
            </ul>
            
            <!-- Usuario y autenticación -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?= esc(session('user_name') ?? 'Repartidor') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">
                                    <i class="fas fa-user-tag me-2"></i>Repartidor
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