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
        <nav class="navbar navbar-expand-lg navbar-custom shadow-lg fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('/') ?>">
                    <div class="brand-icon me-2">
                        <i class="<?= get_logo_icon() ?>"></i>
                    </div>
                    <span class="brand-text"><?= get_nombre_restaurante() ?></span>
                </a>
                
                <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="<?= base_url('/') ?>">
                                <i class="fas fa-home me-2"></i>Menú
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="<?= base_url('carrito') ?>" id="cartLink">
                                <i class="fas fa-shopping-cart me-2"></i>Carrito
                            </a>
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
    <nav class="navbar navbar-expand-lg navbar-custom shadow-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= base_url('/') ?>">
                <div class="brand-icon me-2">
                    <i class="<?= get_logo_icon() ?>"></i>
                </div>
                <span class="brand-text"><?= get_nombre_restaurante() ?></span>
            </a>
            
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= base_url('/') ?>">
                            <i class="fas fa-home me-2"></i>Menú
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="<?= base_url('carrito') ?>" id="cartLink">
                                <i class="fas fa-shopping-cart me-2"></i>Carrito
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="<?= base_url('seguimiento') ?>">
                                <i class="fas fa-motorcycle me-2"></i>Seguir Pedido
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

<!-- Ícono de carrito siempre visible en móviles y pantallas grandes -->
<a href="<?= base_url('carrito') ?>" id="cartLinkMobile" class="btn btn-primary-custom position-fixed mobile-cart-btn">
    <i class="fas fa-shopping-cart"></i>
    <?php if (session('carrito') && count(session('carrito')) > 0): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge-mobile">
            <?= count(session('carrito')) ?>
            <span class="visually-hidden">productos en el carrito</span>
        </span>
    <?php endif; ?>
</a>

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
    
    // Función para actualizar contadores del carrito
    window.updateCartCounters = function(newCount) {
        // Actualizar badge del carrito móvil
        const cartBadgeMobile = document.querySelector('.cart-badge-mobile');
        if (cartBadgeMobile) {
            if (newCount > 0) {
                cartBadgeMobile.textContent = newCount;
                cartBadgeMobile.style.display = 'block';
            } else {
                cartBadgeMobile.style.display = 'none';
            }
        }
        
        // Si no existe el badge móvil, crearlo
        const mobileCartBtn = document.getElementById('cartLinkMobile');
        if (mobileCartBtn && newCount > 0) {
            let existingBadge = mobileCartBtn.querySelector('.cart-badge-mobile');
            if (!existingBadge) {
                existingBadge = document.createElement('span');
                existingBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge-mobile';
                existingBadge.innerHTML = `${newCount}<span class="visually-hidden">productos en el carrito</span>`;
                mobileCartBtn.appendChild(existingBadge);
            } else {
                existingBadge.textContent = newCount;
            }
        }
    };
});
</script>

<style>
/* Variables CSS con la paleta de colores */
:root {
    --primary-color: #4281A4;
    --secondary-color: #48A9A6;
    --accent-color: #D4B483;
    --light-color: #E4DFDA;
    --danger-color: #C1666B;
    --dark-color: #2c3e50;
    --white-color: #ffffff;
    --shadow-color: rgba(66, 129, 164, 0.1);
    --gradient-primary: linear-gradient(135deg, #4281A4 0%, #48A9A6 100%);
    --gradient-secondary: linear-gradient(135deg, #D4B483 0%, #E4DFDA 100%);
}

/* Navbar principal */
.navbar-custom {
    background: var(--gradient-primary);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.75rem 0;
    transition: all 0.3s ease;
}

.navbar-custom.scrolled {
    background: rgba(66, 129, 164, 0.95);
    backdrop-filter: blur(15px);
}

/* Brand/Logo */
.brand-icon {
    width: 40px;
    height: 40px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white-color);
    font-size: 1.2rem;
    box-shadow: 0 2px 8px rgba(212, 180, 131, 0.3);
    transition: all 0.3s ease;
}

.brand-icon:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 4px 12px rgba(212, 180, 131, 0.4);
}

.brand-text {
    color: var(--white-color);
    font-weight: 700;
    font-size: 1.3rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Enlaces de navegación */
.nav-link-custom {
    color: var(--white-color) !important;
    font-weight: 500;
    padding: 0.75rem 1rem !important;
    border-radius: 8px;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-link-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.nav-link-custom:hover::before {
    left: 100%;
}

.nav-link-custom:hover {
    color: var(--accent-color) !important;
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.nav-link-custom.active {
    background: rgba(255, 255, 255, 0.2);
    color: var(--accent-color) !important;
}

/* Badge del carrito móvil */
.cart-badge-mobile {
    background: var(--danger-color);
    color: var(--white-color);
    font-size: 0.65rem;
    font-weight: 600;
    padding: 0.15rem 0.4rem;
    border: 2px solid var(--white-color);
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    z-index: 10;
    line-height: 1;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transform: translate(25%, -25%);
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Toggle button */
.custom-toggler {
    border: none;
    padding: 0.5rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.custom-toggler:hover {
    background: rgba(255, 255, 255, 0.2);
}

.custom-toggler:focus {
    box-shadow: 0 0 0 0.2rem rgba(212, 180, 131, 0.25);
}

/* Usuario dropdown */
.user-dropdown {
    color: var(--white-color) !important;
    padding: 0.5rem 1rem !important;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.user-dropdown:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--accent-color) !important;
}

.user-avatar {
    width: 35px;
    height: 35px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white-color);
    font-size: 1.1rem;
    box-shadow: 0 2px 6px rgba(212, 180, 131, 0.3);
}

.user-name {
    color: var(--white-color);
    font-weight: 600;
    font-size: 0.9rem;
    line-height: 1.2;
}

.user-role {
    color: var(--light-color);
    font-size: 0.75rem;
    font-weight: 400;
}

/* Dropdown menu */
.dropdown-menu-custom {
    background: var(--white-color);
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(66, 129, 164, 0.15);
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    backdrop-filter: blur(10px);
}

.dropdown-item-custom {
    color: var(--dark-color);
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 0;
}

.dropdown-item-custom:hover {
    background: var(--light-color);
    color: var(--primary-color);
    transform: translateX(5px);
}

.logout-item {
    color: var(--danger-color);
}

.logout-item:hover {
    background: rgba(193, 102, 107, 0.1);
    color: var(--danger-color);
}

.custom-divider {
    border-color: var(--light-color);
    margin: 0.5rem 0;
}

/* Botones de autenticación */
.auth-buttons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-outline-custom {
    color: var(--white-color);
    border: 2px solid var(--white-color);
    background: transparent;
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.btn-outline-custom:hover {
    color: var(--primary-color);
    background: var(--white-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

.btn-primary-custom {
    background: var(--accent-color);
    color: var(--white-color);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(212, 180, 131, 0.3);
}

.btn-primary-custom:hover {
    background: var(--danger-color);
    color: var(--white-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(193, 102, 107, 0.4);
}

/* Carrito flotante - visible en móviles y pantallas grandes */
.mobile-cart-btn {
    bottom: 90px; /* Misma distancia que WhatsApp en móviles */
    right: 20px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(66, 129, 164, 0.3);
    z-index: 1050;
    transition: all 0.3s ease;
    position: relative;
    font-size: 1.2rem;
}

.mobile-cart-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
}

/* Alertas mejoradas */
.alert-modern {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.alert-container {
    position: fixed;
    top: 100px;
    right: 20px;
    z-index: 1060;
    max-width: 400px;
}

/* Animaciones */
.cart-animation {
    animation: cartBounce 0.5s ease-in-out;
}

@keyframes cartBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Responsive */
@media (max-width: 991.98px) {
    .navbar-custom {
        padding: 0.5rem 0;
    }
    
    .nav-link-custom {
        padding: 0.75rem 1rem !important;
        margin: 0.25rem 0;
    }
    
    .auth-buttons {
        margin-top: 1rem;
        justify-content: center;
    }
    
    .user-dropdown {
        justify-content: center;
        margin-top: 1rem;
    }
}

@media (min-width: 992px) {
    #cartLinkMobile { 
        display: flex !important; 
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        font-size: 1.4rem;
    }
}

/* Scroll effect */
.navbar-custom.scrolled {
    background: rgba(66, 129, 164, 0.95);
    backdrop-filter: blur(15px);
}

/* Focus states para accesibilidad */
.nav-link-custom:focus,
.btn-outline-custom:focus,
.btn-primary-custom:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}
</style>