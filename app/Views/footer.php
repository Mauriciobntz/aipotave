<!-- Footer -->
<footer class="footer-public">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="mb-4">
                    <div class="footer-brand d-flex align-items-center mb-3">
                        <div class="footer-brand-icon me-3">
                            <i class="<?= get_logo_icon() ?>"></i>
                        </div>
                        <h3 class="footer-brand-text mb-0"><?= get_nombre_restaurante() ?></h3>
                    </div>
                    <p class="footer-text">
                        <?= get_slogan() ?>
                    </p>
                    <div class="social-links">
                        <a href="<?= get_facebook_url() ?>" class="social-link" title="Facebook" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="<?= get_instagram_url() ?>" class="social-link" title="Instagram" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="<?= get_twitter_url() ?>" class="social-link" title="Twitter" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="<?= get_whatsapp_url() ?>" class="social-link" title="WhatsApp" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <h5 class="footer-title mb-3">Enlaces Rápidos</h5>
                <ul class="footer-links">
                    <li class="footer-link-item">
                        <a href="<?= base_url('/') ?>" class="footer-link">
                            <i class="fas fa-chevron-right me-2"></i>Menú
                        </a>
                    </li>
                    <li class="footer-link-item">
                        <a href="<?= base_url('carrito') ?>" class="footer-link">
                            <i class="fas fa-chevron-right me-2"></i>Carrito
                        </a>
                    </li>
                    <li class="footer-link-item">
                        <a href="<?= base_url('pedido/seguimiento') ?>" class="footer-link">
                            <i class="fas fa-chevron-right me-2"></i>Seguimiento
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <h5 class="footer-title mb-3">Mi Cuenta</h5>
                <ul class="footer-links">
                    <?php if (session('logueado')): ?>
                        <li class="footer-link-item">
                            <a href="<?= base_url('perfil') ?>" class="footer-link">
                                <i class="fas fa-chevron-right me-2"></i>Mi Perfil
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="<?= base_url('pedidos') ?>" class="footer-link">
                                <i class="fas fa-chevron-right me-2"></i>Mis Pedidos
                            </a>
                        </li>
                        <li class="footer-link-item">
                            <a href="<?= base_url('logout') ?>" class="footer-link footer-link-danger">
                                <i class="fas fa-chevron-right me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="footer-link-item">
                            <a href="<?= base_url('login') ?>" class="footer-link">
                                <i class="fas fa-chevron-right me-2"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-4">
                <h5 class="footer-title mb-3">Contacto</h5>
                <ul class="footer-contact">
                    <li class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-info">
                            <span class="contact-label">Dirección</span>
                            <span class="contact-value"><?= get_direccion() ?></span>
                        </div>
                    </li>
                    <li class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-info">
                            <span class="contact-label">Teléfono</span>
                            <span class="contact-value"><?= get_telefono() ?></span>
                        </div>
                    </li>
                    <li class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info">
                            <span class="contact-label">Email</span>
                            <span class="contact-value"><?= get_email() ?></span>
                        </div>
                    </li>
                    <li class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-info">
                            <span class="contact-label">Horarios</span>
                            <span class="contact-value"><?= get_horarios() ?></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-divider"></div>
        
        <div class="row align-items-center footer-bottom">
            <div class="col-md-6 mb-3 mb-md-0">
                <p class="footer-copyright mb-0">
                    <small>&copy; <?= date('Y') ?> <?= get_copyright_text() ?></small>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-credits">
                    <small class="footer-heart-text">
                        <i class="fas fa-heart footer-heart me-1"></i>
                        Hecho con amor para nuestros clientes
                    </small>
                    <small class="footer-dev-text">
                        <?= get_desarrollador_text() ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Botón para volver arriba -->
<div class="back-to-top">
    <a href="#" class="back-to-top-btn">
        <i class="fas fa-arrow-up"></i>
    </a>
</div>

<!-- Botón flotante de WhatsApp -->
<a href="<?= get_whatsapp_url() ?>" class="whatsapp-float" target="_blank" title="Contactar por WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js para gráficos -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
<script>
// Fallback si Chart.js no se carga desde el primer CDN
if (typeof Chart === 'undefined') {
    console.log('Intentando cargar Chart.js desde CDN alternativo...');
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js';
    script.onload = function() {
        console.log('Chart.js cargado desde CDN alternativo');
    };
    script.onerror = function() {
        console.error('No se pudo cargar Chart.js desde ningún CDN');
    };
    document.head.appendChild(script);
}
</script>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?= env('GOOGLE_MAPS_API_KEY', '') ?>&libraries=geometry"></script>

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
/* Variables CSS con la paleta de colores */
:root {
    --primary-color: #4281A4;
    --secondary-color: #48A9A6;
    --accent-color: #D4B483;
    --light-color: #E4DFDA;
    --danger-color: #C1666B;
    --dark-color: #2c3e50;
    --white-color: #ffffff;
    --gradient-primary: linear-gradient(135deg, #4281A4 0%, #48A9A6 100%);
    --gradient-secondary: linear-gradient(135deg, #D4B483 0%, #E4DFDA 100%);
}

/* Footer principal */
.footer-public {
    background: var(--gradient-primary);
    color: var(--white-color);
    padding-top: 4rem;
    padding-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.footer-public::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

/* Brand del footer */
.footer-brand {
    display: flex;
    align-items: center;
}

.footer-brand-icon {
    width: 50px;
    height: 50px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white-color);
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(212, 180, 131, 0.3);
    transition: all 0.3s ease;
}

.footer-brand-icon:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 6px 16px rgba(212, 180, 131, 0.4);
}

.footer-brand-text {
    color: var(--white-color);
    font-weight: 700;
    font-size: 1.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Títulos del footer */
.footer-title {
    color: var(--white-color);
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.5rem;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: var(--accent-color);
    border-radius: 2px;
}

/* Texto del footer */
.footer-text {
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.7;
    font-size: 0.95rem;
}

/* Enlaces del footer */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-link-item {
    margin-bottom: 0.75rem;
}

.footer-link {
    color: rgba(255, 255, 255, 0.8) !important;
    text-decoration: none !important;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    border-radius: 6px;
    position: relative;
    overflow: hidden;
}

.footer-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: var(--accent-color);
    transition: width 0.3s ease;
    z-index: -1;
}

.footer-link:hover::before {
    width: 100%;
}

.footer-link:hover {
    color: var(--white-color) !important;
    transform: translateX(8px);
    padding-left: 0.75rem;
}

.footer-link i {
    transition: all 0.3s ease;
    color: var(--accent-color);
}

.footer-link:hover i {
    transform: rotate(90deg);
    color: var(--white-color);
}

.footer-link-danger {
    color: rgba(193, 102, 107, 0.8) !important;
}

.footer-link-danger:hover {
    color: var(--danger-color) !important;
}

/* Enlaces sociales */
.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.social-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-decoration: none !important;
}

.social-link:hover {
    color: var(--accent-color) !important;
    transform: translateY(-5px) scale(1.1);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 6px 20px rgba(212, 180, 131, 0.3);
}

/* Información de contacto */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.footer-contact-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.contact-icon {
    width: 40px;
    height: 40px;
    background: var(--accent-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white-color);
    font-size: 1rem;
    margin-right: 1rem;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(212, 180, 131, 0.3);
}

.contact-info {
    display: flex;
    flex-direction: column;
}

.contact-label {
    color: var(--accent-color);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.contact-value {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Divisor del footer */
.footer-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    margin: 3rem 0 2rem 0;
    border: none;
}

/* Footer bottom */
.footer-bottom {
    padding-top: 1rem;
}

.footer-copyright {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
}

.footer-credits {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.footer-heart-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.85rem;
}

.footer-dev-text {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.8rem;
}

.footer-heart {
    color: var(--danger-color);
    animation: heartbeat 2s infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Botón Back to Top */
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    display: none; /* Oculto por defecto */
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top-btn {
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    color: var(--white-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    border: 2px solid rgba(255, 255, 255, 0.2);
    font-size: 1.2rem;
}

.back-to-top-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 6px 25px rgba(66, 129, 164, 0.4);
    color: var(--white-color);
}

.back-to-top-btn:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}

/* Botón WhatsApp flotante */
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 100px; /* Ajustado para dejar espacio al carrito flotante */
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: var(--white-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
    z-index: 100;
    transition: all 0.3s ease;
    font-size: 1.5rem;
    text-decoration: none;
}

.whatsapp-float:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 6px 25px rgba(37, 211, 102, 0.4);
    color: var(--white-color);
}

/* Responsive */
@media (max-width: 768px) {
    .footer-public {
        padding-top: 3rem;
        padding-bottom: 1.5rem;
    }
    
    .footer-title {
        margin-bottom: 1rem;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .footer-contact-item {
        margin-bottom: 1rem;
    }
    
    .back-to-top {
        display: block; /* Mostrar en móviles */
        bottom: 160px; /* Misma distancia que los otros botones */
        right: 20px;
        width: 50px;
        height: 50px;
    }
    
    .back-to-top-btn {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
}

/* Ajuste para evitar superposición en móviles */
@media (max-width: 991.98px) {
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 1.3rem;
    }
    
    .back-to-top {
        display: block; /* Mostrar en tablets y móviles */
        bottom: 160px; /* Misma distancia que los otros botones */
        right: 20px;
        width: 50px;
        height: 50px;
    }
    
    .back-to-top-btn {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    /* Asegurar que el carrito móvil esté por encima */
    .mobile-cart-btn {
        z-index: 1051;
    }
    
    .whatsapp-float {
        z-index: 1049;
    }
    
    .back-to-top {
        z-index: 1048;
    }
}

/* Ocultar botón de subir en pantallas grandes */
@media (min-width: 992px) {
    .back-to-top {
        display: none !important;
    }
    
    /* Ajustar WhatsApp para pantallas grandes */
    .whatsapp-float {
        bottom: 30px;
        right: 100px; /* Espacio para el carrito flotante */
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}

/* Animaciones de entrada */
.footer-public [data-aos] {
    transition-duration: 1s;
}

/* Efectos de hover mejorados */
.footer-link-item {
    transition: all 0.3s ease;
}

.footer-link-item:hover {
    transform: translateX(5px);
}

/* Focus states para accesibilidad */
.footer-link:focus,
.back-to-top-btn:focus,
.whatsapp-float:focus {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
}
</style>
</body>
</html>