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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('/') ?>">
                    <i class="fas fa-utensils me-2 text-warning"></i>
                    <span class="brand-text">Mi Restaurante</span>
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
                            <a class="nav-link position-relative" href="<?= base_url('carrito') ?>" id="cartLink">
                                <i class="fas fa-shopping-cart me-1"></i>Carrito
                                <?php if (session('carrito') && count(session('carrito')) > 0): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        <?= count(session('carrito')) ?>
                                        <span class="visually-hidden">productos en el carrito</span>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('pedidos') ?>">
                                <i class="fas fa-history me-1"></i>Mis Pedidos
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Buscador de pedidos mejorado -->
                    <form class="d-flex me-3 tracking-form" action="<?= base_url('pedido/seguimiento') ?>" method="get" role="search">
                        <div class="input-group tracking-input-group">
                            <span class="input-group-text tracking-icon">
                                <i class="fas fa-qrcode"></i>
                            </span>
                            <input class="form-control tracking-input" 
                                   type="search" 
                                   name="codigo" 
                                   placeholder="Ingresa tu código de seguimiento..." 
                                   aria-label="Código de seguimiento" 
                                   required>
                            <button class="btn btn-primary tracking-btn" type="submit">
                                <i class="fas fa-search"></i>
                                <span class="d-none d-sm-inline ms-1">Rastrear</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Usuario y autenticación -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar me-2">
                                    <i class="fas fa-user-circle fa-lg"></i>
                                </div>
                                <div class="user-info">
                                    <div class="user-name"><?= esc(session('user_name') ?? 'Usuario') ?></div>
                                    <small class="text-muted user-role"><?= ucfirst(session('user_role')) ?></small>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('perfil') ?>">
                                        <i class="fas fa-user me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('pedidos') ?>">
                                        <i class="fas fa-history me-2"></i>Mis Pedidos
                                    </a>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="fas fa-utensils me-2 text-warning"></i>
                <span class="brand-text">Mi Restaurante</span>
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
                        <a class="nav-link position-relative" href="<?= base_url('carrito') ?>" id="cartLink">
                            <i class="fas fa-shopping-cart me-1"></i>Carrito
                            <?php if (session('carrito') && count(session('carrito')) > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= count(session('carrito')) ?>
                                    <span class="visually-hidden">productos en el carrito</span>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('catalogo') ?>">
                            <i class="fas fa-utensils me-1"></i>Menú
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('seguimiento') ?>">
                            <i class="fas fa-motorcycle me-1"></i>Seguir Pedido
                        </a>
                    </li>
                </ul>
                
                <!-- Buscador de pedidos -->
                <form class="d-flex me-3 search-form" action="<?= base_url('pedido/seguimiento') ?>" method="get" role="search">
                    <div class="input-group has-search">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search"></i></span>
                        <input class="form-control border-start-0" type="search" name="codigo" placeholder="Código de seguimiento..." aria-label="Código de seguimiento" required>
                    </div>
                </form>
                
                <!-- El navbar público ya no tiene botones de login/registro -->
            </div>
        </div>
    </nav>
    <?php
}
?>

<!-- Alertas de sesión -->
<div class="alert-container">
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show alert-modern animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">¡Éxito!</h6>
                    <p class="mb-0"><?= esc(session('success')) ?></p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show alert-modern animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">¡Error!</h6>
                    <p class="mb-0"><?= esc(session('error')) ?></p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show alert-modern animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">¡Advertencia!</h6>
                    <p class="mb-0"><?= esc(session('warning')) ?></p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show alert-modern animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3 fs-4"></i>
                <div>
                    <h6 class="alert-heading mb-1">Información</h6>
                    <p class="mb-0"><?= esc(session('info')) ?></p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>

<script>
// Animación para el icono del carrito
document.addEventListener('DOMContentLoaded', function() {
    const cartLink = document.getElementById('cartLink');
    if (cartLink) {
        cartLink.addEventListener('click', function() {
            this.classList.add('cart-animation');
            setTimeout(() => {
                this.classList.remove('cart-animation');
            }, 500);
        });
    }
    
    // Efecto de hover para el buscador de seguimiento
    const trackingForms = document.querySelectorAll('.tracking-form');
    trackingForms.forEach(form => {
        const input = form.querySelector('.tracking-input');
        const inputGroup = form.querySelector('.tracking-input-group');
        
        if (input && inputGroup) {
            input.addEventListener('focus', function() {
                inputGroup.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                inputGroup.classList.remove('focused');
            });
            
            // Efecto de typing
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('has-content');
                } else {
                    this.classList.remove('has-content');
                }
            });
        }
    });
    
    // Animación de entrada para el buscador
    const trackingForm = document.querySelector('.tracking-form');
    if (trackingForm) {
        trackingForm.style.opacity = '0';
        trackingForm.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            trackingForm.style.transition = 'all 0.6s ease-out';
            trackingForm.style.opacity = '1';
            trackingForm.style.transform = 'translateY(0)';
        }, 300);
    }
});
</script>