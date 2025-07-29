<!-- Footer -->
<footer class="footer-public bg-gradient-to-bottom">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="mb-4">
                    <h3 class="d-flex align-items-center mb-3">
                        <i class="fas fa-utensils me-2 footer-icon"></i>
                        <span class="brand-text">Mi Restaurante</span>
                    </h3>
                    <p class="footer-text">
                        Ofrecemos los mejores platos con ingredientes frescos y de la más alta calidad. 
                        Tu satisfacción es nuestra prioridad.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <h5 class="footer-title mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= base_url('/') ?>" class="footer-link d-flex align-items-center">
                            <i class="fas fa-chevron-right me-2 footer-icon small"></i>Inicio
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('menu') ?>" class="footer-link d-flex align-items-center">
                            <i class="fas fa-chevron-right me-2 footer-icon small"></i>Menú
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('carrito') ?>" class="footer-link d-flex align-items-center">
                            <i class="fas fa-chevron-right me-2 footer-icon small"></i>Carrito
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('pedido/seguimiento') ?>" class="footer-link d-flex align-items-center">
                            <i class="fas fa-chevron-right me-2 footer-icon small"></i>Seguimiento
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= base_url('contacto') ?>" class="footer-link d-flex align-items-center">
                            <i class="fas fa-chevron-right me-2 footer-icon small"></i>Contacto
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <h5 class="footer-title mb-3">Mi Cuenta</h5>
                <ul class="list-unstyled">
                    <?php if (session('logueado')): ?>
                        <li class="mb-2">
                            <a href="<?= base_url('perfil') ?>" class="footer-link d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 footer-icon small"></i>Mi Perfil
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('pedidos') ?>" class="footer-link d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 footer-icon small"></i>Mis Pedidos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('logout') ?>" class="footer-link d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 footer-icon small"></i>Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="mb-2">
                            <a href="<?= base_url('login') ?>" class="footer-link d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 footer-icon small"></i>Iniciar Sesión
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('registro') ?>" class="footer-link d-flex align-items-center">
                                <i class="fas fa-chevron-right me-2 footer-icon small"></i>Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-4">
                <h5 class="footer-title mb-3">Contacto</h5>
                <ul class="list-unstyled footer-contact">
                    <li class="mb-3 d-flex">
                        <i class="fas fa-map-marker-alt me-3 mt-1 footer-icon"></i>
                        <span class="footer-text">Av. Principal 123, Ciudad</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="fas fa-phone me-3 mt-1 footer-icon"></i>
                        <span class="footer-text">+1 234 567 8900</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="fas fa-envelope me-3 mt-1 footer-icon"></i>
                        <span class="footer-text">info@mirestaurante.com</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <i class="fas fa-clock me-3 mt-1 footer-icon"></i>
                        <span class="footer-text">Lun-Dom: 11:00 - 23:00</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="footer-divider my-4">
        
        <div class="row align-items-center">
            <div class="col-md-6 mb-3 mb-md-0">
                <p class="mb-0 footer-text">
                    <small>&copy; <?= date('Y') ?> Mi Restaurante. Todos los derechos reservados.</small>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="footer-text d-block">
                    <i class="fas fa-heart footer-heart me-1"></i>
                    Hecho con amor para nuestros clientes
                </small>
                <small class="footer-text">
                    Max Clorinda - Sistema de Delivery
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Botón de WhatsApp flotante -->
<div class="whatsapp-float">
    <a href="https://wa.me/5491122334455" target="_blank" class="d-flex align-items-center justify-content-center">
        <i class="fab fa-whatsapp fs-3"></i>
    </a>
</div>

<!-- Botón para volver arriba -->
<div class="back-to-top">
    <a href="#" class="d-flex align-items-center justify-content-center">
        <i class="fas fa-arrow-up"></i>
    </a>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS (Animate On Scroll) -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Scripts adicionales -->
<script>
// Inicializar AOS
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Botón para volver arriba
    const backToTopButton = document.querySelector('.back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Popover initialization
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});
</script>

<style>
/* Estilos base del footer (se aplican solo si no hay data-page="public") */
.footer-public {
    background: #343a40;
    color: white;
    padding-top: 3rem;
    padding-bottom: 2rem;
}

.footer-title {
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.footer-text {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
}

.footer-icon {
    color: #ffc107;
    transition: all 0.3s ease;
}

.footer-link {
    color: rgba(255, 255, 255, 0.8) !important;
    text-decoration: none !important;
    transition: all 0.3s ease;
}

.footer-link:hover {
    color: #ffc107 !important;
    transform: translateX(5px);
}

.social-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.social-link:hover {
    color: #ffc107 !important;
    transform: translateY(-3px) scale(1.1);
}

.footer-divider {
    border-color: rgba(255, 255, 255, 0.2);
}

.footer-heart {
    color: #dc3545;
    animation: heartbeat 2s infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Botones flotantes */
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
    z-index: 100;
    transition: all 0.3s ease;
}

.whatsapp-float:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 6px 25px rgba(37, 211, 102, 0.4);
    color: white;
}

.back-to-top {
    position: fixed;
    bottom: 90px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: #343a40;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    z-index: 100;
    transition: all 0.3s ease;
    opacity: 0;
    visibility: hidden;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-public {
        padding-top: 2rem;
        padding-bottom: 1.5rem;
    }
    
    .footer-title {
        margin-bottom: 1rem;
    }
    
    .social-link {
        font-size: 1.3rem;
    }
}

/* Animaciones para los enlaces del footer */
.list-unstyled li a {
    display: inline-block;
}

.list-unstyled li a i {
    transition: all 0.3s ease;
}

.list-unstyled li a:hover i {
    transform: rotate(90deg);
}
</style>
</body>
</html>