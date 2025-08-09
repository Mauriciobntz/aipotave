<!-- Política de Privacidad -->
<div class="container-fluid mt-5 pt-5 mb-5">
    <!-- Hero Section -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="fas fa-shield-alt me-3"></i><?= $page_title ?>
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

            <!-- Contenido de Política de Privacidad -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-lg-5">
                    
                    <!-- Introducción -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-shield-alt me-2"></i>Introducción
                        </h2>
                        <p>
                            En <?= get_nombre_restaurante() ?>, nos comprometemos a proteger tu privacidad y tus datos personales. 
                            Esta política describe cómo recopilamos, utilizamos y protegemos tu información cuando utilizas 
                            nuestro servicio de delivery en la Ciudad de Clorinda.
                        </p>
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Compromiso con la Privacidad
                            </h6>
                            <p class="mb-0">
                                Tu privacidad es importante para nosotros. Nos esforzamos por ser transparentes sobre 
                                cómo manejamos tu información personal.
                            </p>
                        </div>
                    </section>

                    <!-- Información que Recopilamos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-database me-2"></i>Información que Recopilamos
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-success">Información Personal</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-user text-success me-2"></i>Nombre y apellido</li>
                                    <li class="mb-2"><i class="fas fa-phone text-success me-2"></i>Número de teléfono</li>
                                    <li class="mb-2"><i class="fas fa-envelope text-success me-2"></i>Dirección de email</li>
                                    <li class="mb-2"><i class="fas fa-map-marker-alt text-success me-2"></i>Dirección de entrega</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-info">Información del Pedido</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-shopping-cart text-info me-2"></i>Productos solicitados</li>
                                    <li class="mb-2"><i class="fas fa-clock text-info me-2"></i>Horarios de entrega</li>
                                    <li class="mb-2"><i class="fas fa-credit-card text-info me-2"></i>Método de pago</li>
                                    <li class="mb-2"><i class="fas fa-comment text-info me-2"></i>Comentarios especiales</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Cómo Utilizamos tu Información -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-cogs me-2"></i>Cómo Utilizamos tu Información
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary">Procesamiento de Pedidos</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Procesar y entregar tu pedido</li>
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Comunicarnos contigo sobre el estado</li>
                                    <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Resolver problemas o consultas</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-warning">Mejora del Servicio</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-chart-line text-warning me-2"></i>Analizar preferencias de clientes</li>
                                    <li class="mb-2"><i class="fas fa-star text-warning me-2"></i>Mejorar la calidad del servicio</li>
                                    <li class="mb-2"><i class="fas fa-bell text-warning me-2"></i>Enviar ofertas especiales (con consentimiento)</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Compartir Información -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-share-alt me-2"></i>Compartir Información
                        </h2>
                        <p>
                            <strong>No vendemos, alquilamos o compartimos tu información personal</strong> con terceros, 
                            excepto en las siguientes situaciones:
                        </p>
                        <div class="alert alert-warning">
                            <h6 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Excepciones
                            </h6>
                            <ul class="mb-0">
                                <li>Con tu consentimiento explícito</li>
                                <li>Para cumplir con obligaciones legales</li>
                                <li>Para proteger nuestros derechos y seguridad</li>
                                <li>Con proveedores de servicios de pago (solo información necesaria)</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Seguridad de Datos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-lock me-2"></i>Seguridad de Datos
                        </h2>
                        <p>
                            Implementamos medidas de seguridad técnicas y organizativas para proteger tu información:
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-success">Medidas de Seguridad</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-shield-alt text-success me-2"></i>Encriptación de datos sensibles</li>
                                    <li class="mb-2"><i class="fas fa-user-shield text-success me-2"></i>Acceso restringido al personal</li>
                                    <li class="mb-2"><i class="fas fa-database text-success me-2"></i>Copias de seguridad seguras</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-info">Protección Continua</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-sync text-info me-2"></i>Actualizaciones de seguridad</li>
                                    <li class="mb-2"><i class="fas fa-eye text-info me-2"></i>Monitoreo de accesos</li>
                                    <li class="mb-2"><i class="fas fa-trash text-info me-2"></i>Eliminación segura de datos</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Tus Derechos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-user-check me-2"></i>Tus Derechos
                        </h2>
                        <p>
                            Tienes derecho a:
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="fas fa-eye text-primary me-2"></i>
                                        <strong>Acceso:</strong> Solicitar información sobre tus datos
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-edit text-primary me-2"></i>
                                        <strong>Rectificación:</strong> Corregir datos inexactos
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-trash text-primary me-2"></i>
                                        <strong>Eliminación:</strong> Solicitar la eliminación de tus datos
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="fas fa-ban text-primary me-2"></i>
                                        <strong>Oposición:</strong> Oponerte al procesamiento
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-download text-primary me-2"></i>
                                        <strong>Portabilidad:</strong> Recibir tus datos en formato digital
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-times text-primary me-2"></i>
                                        <strong>Retiro:</strong> Retirar el consentimiento en cualquier momento
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <!-- Cookies y Tecnologías -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-cookie-bite me-2"></i>Cookies y Tecnologías
                        </h2>
                        <p>
                            Utilizamos cookies y tecnologías similares para mejorar tu experiencia en nuestro sitio web:
                        </p>
                        <div class="alert alert-light">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>Tipos de Cookies
                            </h6>
                            <ul class="mb-0">
                                <li><strong>Esenciales:</strong> Necesarias para el funcionamiento del sitio</li>
                                <li><strong>Funcionales:</strong> Mejoran la experiencia del usuario</li>
                                <li><strong>Analíticas:</strong> Nos ayudan a entender el uso del sitio</li>
                            </ul>
                        </div>
                    </section>

                    <!-- Retención de Datos -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-calendar-alt me-2"></i>Retención de Datos
                        </h2>
                        <p>
                            Conservamos tu información personal solo durante el tiempo necesario para:
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-clock text-primary me-2"></i>Procesar y completar tu pedido</li>
                            <li class="mb-2"><i class="fas fa-chart-bar text-primary me-2"></i>Cumplir con obligaciones legales</li>
                            <li class="mb-2"><i class="fas fa-shield-alt text-primary me-2"></i>Resolver disputas o reclamaciones</li>
                            <li class="mb-2"><i class="fas fa-cog text-primary me-2"></i>Mejorar nuestros servicios</li>
                        </ul>
                        <div class="alert alert-info">
                            <strong>Nota:</strong> Los datos se eliminan automáticamente después del período de retención 
                            o cuando ya no son necesarios para los fines especificados.
                        </div>
                    </section>

                    <!-- Cambios en la Política -->
                    <section class="mb-5">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-edit me-2"></i>Cambios en la Política
                        </h2>
                        <p>
                            Podemos actualizar esta política de privacidad ocasionalmente. Te notificaremos sobre 
                            cualquier cambio significativo a través de:
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-globe text-primary me-2"></i>Nuestro sitio web</li>
                            <li class="mb-2"><i class="fas fa-envelope text-primary me-2"></i>Email (si nos proporcionaste uno)</li>
                            <li class="mb-2"><i class="fab fa-whatsapp text-primary me-2"></i>WhatsApp</li>
                        </ul>
                    </section>

                    <!-- Contacto para Privacidad -->
                    <section class="mb-4">
                        <h2 class="h3 text-primary mb-4">
                            <i class="fas fa-envelope me-2"></i>Contacto para Privacidad
                        </h2>
                        <p>
                            Si tienes preguntas sobre esta política de privacidad o quieres ejercer tus derechos, 
                            contáctanos:
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
                        <div class="alert alert-success mt-3">
                            <h6 class="alert-heading">
                                <i class="fas fa-check-circle me-2"></i>Respuesta Garantizada
                            </h6>
                            <p class="mb-0">
                                Responderemos a todas las consultas relacionadas con privacidad dentro de los 30 días hábiles.
                            </p>
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
}

.breadcrumb-item a:hover {
    color: var(--accent-color);
}

.breadcrumb-item.active {
    color: #6c757d;
}

section {
    border-bottom: 1px solid rgba(233, 236, 239, 0.5);
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
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.list-unstyled li {
    padding: 0.75rem 0;
    transition: all 0.3s ease;
}

.list-unstyled li:hover {
    transform: translateX(5px);
}

.btn {
    border-radius: 25px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
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
}
</style>
