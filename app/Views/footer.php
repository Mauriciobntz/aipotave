    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="mb-3">
                        <i class="fas fa-utensils me-2 text-warning"></i>Mi Restaurante
                    </h5>
                    <p class="text-muted">
                        Ofrecemos los mejores platos con ingredientes frescos y de la más alta calidad. 
                        Tu satisfacción es nuestra prioridad.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="mb-3">Enlaces Rápidos</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= base_url('/') ?>" class="text-muted text-decoration-none">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('carrito') ?>" class="text-muted text-decoration-none">
                                <i class="fas fa-shopping-cart me-2"></i>Carrito
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?= base_url('pedido/seguimiento') ?>" class="text-muted text-decoration-none">
                                <i class="fas fa-search me-2"></i>Seguimiento de Pedidos
                            </a>
                        </li>
                        <?php if (session('logueado')): ?>
                            <li class="mb-2">
                                <a href="<?= base_url('logout') ?>" class="text-muted text-decoration-none">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="mb-2">
                                <a href="<?= base_url('login') ?>" class="text-muted text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="mb-3">Información de Contacto</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-warning"></i>
                            <span class="text-muted">Av. Principal 123, Ciudad</span>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2 text-warning"></i>
                            <span class="text-muted">+1 234 567 8900</span>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2 text-warning"></i>
                            <span class="text-muted">info@mirestaurante.com</span>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock me-2 text-warning"></i>
                            <span class="text-muted">Lun-Dom: 11:00 - 23:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">
                        <small>&copy; <?= date('Y') ?> Mi Restaurante. Todos los derechos reservados.</small>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        <i class="fas fa-heart text-danger me-1"></i>
                        Hecho con amor para nuestros clientes
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts adicionales -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
    </script>
</body>
</html> 