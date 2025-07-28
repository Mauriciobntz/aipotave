<?php
// Determinar qué navbar mostrar según el rol
if (session('logueado')) {
    $userRole = session('user_role');
    
    if ($userRole === 'admin') {
        echo view('navbar_admin');
    } elseif ($userRole === 'cocina') {
        echo view('navbar_cocina');
    } elseif ($userRole === 'repartidor') {
        echo view('navbar_repartidor');
    } else {
        // Navbar para usuarios logueados pero sin rol específico
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                    <i class="fas fa-utensils me-2 text-warning"></i>Mi Restaurante
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>">
                                <i class="fas fa-home me-1"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('carrito') ?>">
                                <i class="fas fa-shopping-cart me-1"></i>Carrito
                                <?php if (session('carrito') && count(session('carrito')) > 0): ?>
                                    <span class="badge bg-danger ms-1"><?= count(session('carrito')) ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Usuario y autenticación -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                <?= esc(session('user_name') ?? 'Usuario') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <span class="dropdown-item-text">
                                        <small class="text-muted">
                                            <i class="fas fa-user-tag me-2"></i><?= ucfirst(session('user_role')) ?>
                                        </small>
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
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
        <?php
    }
} else {
    // Navbar para usuarios no logueados
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
                <i class="fas fa-utensils me-2 text-warning"></i>Mi Restaurante
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/') ?>">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('carrito') ?>">
                            <i class="fas fa-shopping-cart me-1"></i>Carrito
                            <?php if (session('carrito') && count(session('carrito')) > 0): ?>
                                <span class="badge bg-danger ms-1"><?= count(session('carrito')) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                
                <!-- Buscador de pedidos -->
                <form class="d-flex me-3" action="<?= base_url('pedido/seguimiento') ?>" method="get" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" name="codigo" placeholder="Código de seguimiento..." aria-label="Código de seguimiento" required style="width: 200px;">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Usuario y autenticación -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('login') ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}
?>

<!-- Alertas de sesión -->
<?php if (session('success')): ?>
    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= esc(session('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session('error')): ?>
    <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i><?= esc(session('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session('warning')): ?>
    <div class="alert alert-warning alert-modern alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('warning')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session('info')): ?>
    <div class="alert alert-info alert-modern alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i><?= esc(session('info')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?> 