<!-- Términos de Uso -->
<div class="container-fluid mt-5 pt-5 mb-5">
    <!-- Hero Section -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="fas fa-file-contract me-3"></i><?= $page_title ?>
            </h1>
            <p class="lead text-muted">Última actualización: <?= date('d/m/Y') ?></p>
            
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb justify-content-center">
                    <?php foreach ($breadcrumb as $item): ?>
                        <li class="breadcrumb-item <?= $item['url'] === '#' ? 'active' : '' ?>">
                            <?php if ($item['url'] !== '#'): ?>
                                <a href="<?= $item['url'] ?>" class="text-decoration-none"><?= $item['text'] ?></a>
                            <?php else: ?>
                                <?= $item['text'] ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Contenido de Términos de Uso -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-lg-5">
                    
                    <!-- Área de Cobertura -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-map-marker-alt me-2"></i>Área de Cobertura
                        </h2>
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Servicio Disponible
                            </h5>
                            <p class="mb-0">
                                Nuestro servicio de delivery está disponible exclusivamente en la <strong>Ciudad de Clorinda</strong>, 
                                provincia de Formosa, Argentina. Realizamos entregas en todos los barrios y zonas de la ciudad.
                            </p>
                        </div>
                        <p>
                            Para verificar si tu dirección está dentro de nuestra área de cobertura, 
                            puedes contactarnos a través de WhatsApp o llamarnos directamente.
                        </p>
                    </section>

                    <!-- Aceptación de Términos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-check-circle me-2"></i>Aceptación de Términos
                        </h2>
                        <p>
                            Al utilizar nuestro servicio de delivery, aceptas estos términos y condiciones en su totalidad. 
                            Si no estás de acuerdo con alguna parte de estos términos, no debes utilizar nuestro servicio.
                        </p>
                    </section>

                    <!-- Servicio de Delivery -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-truck me-2"></i>Servicio de Delivery
                        </h2>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <strong>Tiempo de entrega:</strong> Entre 30-60 minutos dependiendo de la distancia y demanda.
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                <strong>Costo de envío:</strong> Varía según la distancia dentro de Clorinda.
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                <strong>Formas de pago:</strong> Efectivo, tarjeta de débito/crédito, transferencia bancaria.
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <strong>Contacto:</strong> WhatsApp y teléfono para consultas y seguimiento.
                            </li>
                        </ul>
                    </section>

                    <!-- Pedidos y Cancelaciones -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-shopping-cart me-2"></i>Pedidos y Cancelaciones
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-success">Realización de Pedidos</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pedidos a través de nuestra plataforma web</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pedidos por WhatsApp</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pedidos por teléfono</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-warning">Cancelaciones</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Cancelaciones hasta 5 minutos posteriores a la confirmación del pedido</li>
                                    <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Comunicar por WhatsApp o teléfono</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Calidad y Reclamos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-star me-2"></i>Calidad y Reclamos
                        </h2>
                        <p>
                            Nos comprometemos a entregar productos de la más alta calidad. En caso de cualquier problema 
                            con tu pedido, contáctanos inmediatamente a través de WhatsApp o teléfono para resolverlo.
                        </p>
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Importante
                            </h6>
                            <p class="mb-0">
                                Revisa tu pedido al momento de recibirlo. Los reclamos deben realizarse dentro de los 
                                30 minutos posteriores a la entrega.
                            </p>
                        </div>
                    </section>

                    <!-- Privacidad y Datos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-shield-alt me-2"></i>Privacidad y Datos Personales
                        </h2>
                        <p>
                            Tus datos personales son tratados con la máxima confidencialidad y solo se utilizan 
                            para procesar tu pedido y mejorar nuestro servicio. Consulta nuestra 
                            <a href="<?= base_url('legal/privacidad') ?>" class="text-primary">Política de Privacidad</a> 
                            para más información.
                        </p>
                    </section>

                    <!-- Modificaciones -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-edit me-2"></i>Modificaciones de Términos
                        </h2>
                        <p>
                            Nos reservamos el derecho de modificar estos términos en cualquier momento. 
                            Los cambios serán notificados a través de nuestra plataforma web y redes sociales.
                        </p>
                    </section>

                    <!-- Contacto -->
                    <section class="mb-4">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-envelope me-2"></i>Contacto
                        </h2>
                        <p>
                            Si tienes alguna pregunta sobre estos términos, no dudes en contactarnos:
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fab fa-whatsapp text-success me-2"></i>
                                        <strong>WhatsApp:</strong> <?= get_whatsapp() ?>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <strong>Teléfono:</strong> <?= get_telefono() ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <strong>Dirección:</strong> <?= get_direccion() ?>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-info me-2"></i>
                                        <strong>Horarios:</strong> <?= get_horarios() ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <!-- Botón de regreso -->
            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Menú
                </a>
            </div>

        </div>
    </div>
</div>

<style>
/* Estilos consistentes con el resto del sitio - Colores más claros */
body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);
    min-height: 100vh;
}

.container-fluid {
    background: transparent;
}
.card {
    border-radius: 15px;
    border: none;
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 1);
}

.breadcrumb {
    background-color: rgba(255, 255, 255, 0.98);
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.breadcrumb-item a:hover {
    color: var(--accent-color);
}

.breadcrumb-item.active {
    color: #495057;
    font-weight: 600;
}

section {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding-bottom: 2rem;
    margin-bottom: 2rem;
}

section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.alert {
    border-radius: 15px;
    border: none;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    background: rgba(255, 255, 255, 0.9);
}

.alert-info {
    background: rgba(209, 236, 241, 0.9) !important;
    border-left: 4px solid #17a2b8;
}

.alert-warning {
    background: rgba(255, 243, 205, 0.9) !important;
    border-left: 4px solid #ffc107;
}

.alert-success {
    background: rgba(212, 237, 218, 0.9) !important;
    border-left: 4px solid #28a745;
}

.list-unstyled li {
    padding: 0.75rem 0;
    transition: all 0.3s ease;
    color: #495057;
}

.list-unstyled li:hover {
    transform: translateX(5px);
    color: #212529;
}

.list-unstyled li i {
    color: var(--primary-color);
    opacity: 0.8;
}

.list-unstyled li:hover i {
    opacity: 1;
}

.btn {
    border-radius: 25px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    background: var(--primary-color);
    border: none;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    background: var(--accent-color);
}

/* Títulos más claros */
h1, h2, h3, h4, h5, h6 {
    color: #2c3e50;
}

.text-primary {
    color: #2c3e50 !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Iconos más claros */
.fas, .fab {
    color: #495057;
}

.text-success {
    color: #28a745 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.text-danger {
    color: #dc3545 !important;
}

/* Animaciones AOS personalizadas */
[data-aos] {
    transition-duration: 1s;
}

/* Responsive */
@media (max-width: 768px) {
    .breadcrumb {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card {
        background: rgba(255, 255, 255, 1);
    }
}
</style>
