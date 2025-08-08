<div class="container-fluid mt-4 mb-5">
    <!-- Hero Section -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3 productos-hero-title">
                <i class="fas fa-utensils me-3"></i>Nuestro Menú
            </h1>
            <p class="lead text-muted productos-hero-subtitle">Descubre nuestros platos más populares y especialidades del día</p>
            

            
            <!-- Buscador -->
            <div class="col-md-6 mx-auto mb-1">
                <div class="input-group shadow-sm rounded-pill productos-buscador">
                    <span class="input-group-text bg-white border-0 rounded-pill-start productos-buscador-icon">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0 rounded-pill-end productos-buscador-input" id="searchInput" placeholder="Buscar productos..." autocomplete="off">
                    <button type="button" class="btn btn-outline-secondary border-0 rounded-pill-end" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

                <!-- Preload de imágenes críticas -->
                <link rel="preload" as="image" href="<?= base_url('public/uploads/productos/') ?>" type="image/webp">
                
                <!-- Carrusel de Filtros de Categorías -->
                <div class="categorias-filtros-container mt-4 mb-1">
                    <div class="categorias-filtros-wrapper">
                        <div class="categorias-filtros-scroll pt-1">
                            <?php if (!empty($categoriasConProductos)): ?>
                                <?php foreach ($categoriasConProductos as $categoria): ?>
                                    <?php if (!empty($categoria['productos'])): ?>
                                    <a href="#categoria-<?= $categoria['id'] ?>" class="categoria-filtro-btn">
                                        <?= esc($categoria['nombre']) ?>
                                    </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($combos)): ?>
                            <a href="#combos" class="categoria-filtro-btn">
                                <i class="fas fa-box me-2"></i>Combos
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Controles de navegación -->
                    <button class="categoria-filtro-nav categoria-filtro-prev" type="button">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="categoria-filtro-nav categoria-filtro-next" type="button">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

            


    <!-- Categorías con Productos -->
    <?php if (!empty($categoriasConProductos)): ?>
    <?php foreach ($categoriasConProductos as $categoria): ?>
    <?php if (!empty($categoria['productos'])): ?>
    <section class="row mb-5" id="categoria-<?= $categoria['id'] ?>" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 productos-seccion-titulo">
                    <i class="fas fa-tag me-2 text-primary"></i><?= esc($categoria['nombre']) ?>
                </h2>
                <span class="badge productos-contador rounded-pill"><?= count($categoria['productos']) ?> productos</span>
            </div>
        </div>
        <?php foreach ($categoria['productos'] as $index => $producto): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="<?= strtolower($categoria['nombre']) ?>" data-name="<?= strtolower(esc($producto['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm productos-card">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= base_url('public/' . $producto['imagen']) ?>" 
                             class="card-img-top product-img productos-img" 
                             alt="<?= esc($producto['nombre']) ?>" 
                             loading="<?= $index < 8 ? 'eager' : 'lazy' ?>"
                             decoding="async"
                             fetchpriority="<?= $index < 4 ? 'high' : 'auto' ?>"
                             width="300"
                             height="200">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center product-placeholder productos-img" 
                             style="width: 300px; height: 200px;">
                            <i class="fas fa-utensils fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary shadow-sm price-badge productos-precio-badge">$<?= number_format($producto['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <a href="<?= base_url('producto/' . $producto['id']) ?>" class="btn btn-sm btn-light shadow-sm rounded-circle view-btn productos-view-btn" title="Ver producto">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title product-title productos-titulo"><?= esc($producto['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1 product-description productos-descripcion"><?= esc($producto['descripcion']) ?></p>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto product-form productos-form">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-primary product-price productos-precio">$<?= number_format($producto['precio'], 0, ',', '.') ?></span>
                                <div class="d-flex align-items-center quantity-controls productos-cantidad-controls">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn productos-quantity-btn" onclick="cambiarCantidadTexto(this, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="cantidad-valor fw-bold mx-2 productos-cantidad-valor">1</span>
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn productos-quantity-btn" onclick="cambiarCantidadTexto(this, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-hover-effect w-100 add-cart-btn productos-add-btn">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Combos -->
    <?php if (!empty($combos)): ?>
    <section class="row mb-5" id="combos" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 productos-seccion-titulo">
                    <i class="fas fa-box me-2 text-success"></i>Combos Especiales
                </h2>
                <span class="badge productos-contador-combos rounded-pill"><?= count($combos) ?> productos</span>
            </div>
        </div>
        <?php foreach ($combos as $combo): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="combo" data-name="<?= strtolower(esc($combo['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm productos-card">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($combo['imagen'])): ?>
                        <img src="<?= base_url('public/' . $combo['imagen']) ?>" class="card-img-top product-img productos-img" alt="<?= esc($combo['nombre']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center product-placeholder productos-placeholder">
                            <i class="fas fa-box fa-3x text-success"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success shadow-sm price-badge productos-precio-badge-combos">$<?= number_format($combo['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-success text-white shadow-sm combo-badge productos-combo-badge">Combo</span>
                    </div>
                    <div class="position-absolute bottom-0 end-0 m-2">
                        <a href="<?= base_url('combo/' . $combo['id']) ?>" class="btn btn-sm btn-light shadow-sm rounded-circle view-btn productos-view-btn" title="Ver combo">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title product-title productos-titulo"><?= esc($combo['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1 product-description productos-descripcion"><?= esc($combo['descripcion']) ?></p>
                    <div class="mb-3">
                        <small class="text-muted productos-combo-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Incluye varios productos
                        </small>
                    </div>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto product-form productos-form">
                        <input type="hidden" name="tipo" value="combo">
                        <input type="hidden" name="id" value="<?= $combo['id'] ?>">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-primary product-price productos-precio">$<?= number_format($combo['precio'], 0, ',', '.') ?></span>
                                <div class="d-flex align-items-center quantity-controls productos-cantidad-controls">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn productos-quantity-btn" onclick="cambiarCantidadTexto(this, -1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="cantidad-valor fw-bold mx-2 productos-cantidad-valor">1</span>
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn productos-quantity-btn" onclick="cambiarCantidadTexto(this, 1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-hover-effect w-100 add-cart-btn productos-add-btn-combos">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <!-- Call to Action -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <div class="card bg-primary text-white shadow-lg productos-cta-card">
                <div class="card-body py-5">
                    <h3 class="mb-3 productos-cta-titulo">
                        <i class="fas fa-shopping-cart me-3"></i>¿Listo para ordenar?
                    </h3>
                    <p class="lead mb-4 productos-cta-subtitulo">Revisa tu carrito y completa tu pedido</p>
                    <a href="<?= base_url('carrito') ?>" class="btn btn-light btn-lg btn-hover-effect productos-cta-btn">
                        <i class="fas fa-shopping-cart me-2"></i>Ver Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para vista rápida -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="quickViewContent">
                <!-- Contenido cargado dinámicamente -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn btn-primary" id="addToCartFromModal">
                    <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarCantidadTexto(btn, cambio) {
    const container = btn.parentNode;
    const span = container.querySelector('.cantidad-valor');
    const input = container.querySelector('input[name="cantidad"]');
    let cantidad = parseInt(span.textContent);
    cantidad = isNaN(cantidad) ? 1 : cantidad;
    cantidad += cambio;
    if (cantidad < 1) cantidad = 1;
    span.textContent = cantidad;
    input.value = cantidad;
}

// Filtrado de productos
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar AOS (Animate On Scroll) solo en desktop
    if (window.innerWidth > 768) {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
    
    // Buscador de productos
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const productItems = document.querySelectorAll('.product-item');
            let visibleCount = 0;
            
            console.log('Searching for:', searchTerm);
            console.log('Total products found:', productItems.length);
            
            productItems.forEach(item => {
                const productName = item.getAttribute('data-name');
                const productDescription = item.querySelector('.product-description')?.textContent?.toLowerCase() || '';
                
                console.log('Product:', productName, 'Description:', productDescription);
                
                if (searchTerm === '' || 
                    productName.includes(searchTerm) || 
                    productDescription.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            console.log('Visible products:', visibleCount);
            
            // Mostrar mensaje si no hay resultados
            const noResultsMessage = document.getElementById('noResultsMessage');
            if (searchTerm !== '' && visibleCount === 0) {
                if (!noResultsMessage) {
                    const message = document.createElement('div');
                    message.id = 'noResultsMessage';
                    message.className = 'col-12 text-center mt-4';
                    message.innerHTML = `
                        <div class="alert alert-info">
                            <i class="fas fa-search me-2"></i>
                            No se encontraron productos que coincidan con "${searchTerm}"
                        </div>
                    `;
                    document.querySelector('.container-fluid').appendChild(message);
                } else {
                    noResultsMessage.style.display = 'block';
                    noResultsMessage.querySelector('.alert').innerHTML = `
                        <i class="fas fa-search me-2"></i>
                        No se encontraron productos que coincidan con "${searchTerm}"
                    `;
                }
            } else if (noResultsMessage) {
                noResultsMessage.style.display = 'none';
            }
        });
        
        // Limpiar búsqueda con Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.dispatchEvent(new Event('input'));
            }
        });
        
        // Botón de limpiar búsqueda
        const clearSearchBtn = document.getElementById('clearSearch');
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
            
            // Mostrar/ocultar botón de limpiar
            searchInput.addEventListener('input', function() {
                if (this.value.length > 0) {
                    clearSearchBtn.style.display = 'block';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
            });
        }
    }
    
    // Vista rápida de productos
    const quickViewButtons = document.querySelectorAll('.quick-view');
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productType = this.getAttribute('data-type');
            
            // Mostrar modal con spinner
            const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            quickViewModal.show();
            
            // Cargar contenido del producto
            fetch(`<?= base_url('producto/detalle/') ?>${productId}/${productType}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('quickViewContent').innerHTML = html;
                    
                    // Configurar botón de agregar al carrito
                    const addToCartBtn = document.getElementById('addToCartFromModal');
                    if (addToCartBtn) {
                        const form = document.querySelector('#quickViewContent form');
                        if (form) {
                            addToCartBtn.onclick = function() {
                                form.submit();
                            };
                        }
                    }
                })
                .catch(error => {
                    document.getElementById('quickViewContent').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error al cargar los detalles del producto.
                        </div>
                    `;
                });
        });
    });
    
    // Smooth scroll para los filtros de categoría
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
    
    // Efecto de hover para las cards de producto
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Efecto de hover para los botones de cantidad
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f0f0f0';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Mostrar notificación cuando se agrega un producto al carrito
    const addToCartForms = document.querySelectorAll('form[action="<?= base_url('carrito/agregar') ?>"]');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Agregando...';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Producto agregado al carrito', 'success');
                    
                    // Usar la función global para actualizar contadores
                    if (typeof window.updateCartCounters === 'function') {
                        window.updateCartCounters(data.cartCount);
                    } else {
                        // Fallback si la función no está disponible
                        const cartCount = document.querySelector('#cartLink .badge');
                        if (cartCount) {
                            cartCount.textContent = data.cartCount;
                        } else {
                            const cartLink = document.getElementById('cartLink');
                            if (cartLink) {
                                cartLink.innerHTML += `
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        ${data.cartCount}
                                        <span class="visually-hidden">productos en el carrito</span>
                                    </span>
                                `;
                            }
                        }
                    }
                } else {
                    showToast('Error: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                showToast('Error al agregar al carrito', 'danger');
            })
            .finally(() => {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        });
    });
});

function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.left = '20px';
        container.style.zIndex = '1100';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.alignItems = 'center';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type} border-0`;
    toast.role = 'alert';
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.marginBottom = '10px';
    toast.style.maxWidth = '90vw';
    toast.style.width = '100%';
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    document.getElementById('toastContainer').appendChild(toast);
    
    // Auto-ocultar después de 5 segundos
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Carrusel de filtros de categorías
function initCategoriasFiltros() {
    const scrollContainer = document.querySelector('.categorias-filtros-scroll');
    const prevBtn = document.querySelector('.categoria-filtro-prev');
    const nextBtn = document.querySelector('.categoria-filtro-next');
    
    if (!scrollContainer) return;
    
    // Solo inicializar botones en desktop
    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        // En móviles, solo configurar touch events
        setupTouchEvents(scrollContainer);
        return;
    }
    
    if (!prevBtn || !nextBtn) return;
    
    const scrollAmount = 200;
    let isScrolling = false;
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;
    
    // Función para actualizar visibilidad de botones
    function updateNavButtons() {
        const scrollLeft = scrollContainer.scrollLeft;
        const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
        
        prevBtn.style.opacity = scrollLeft > 0 ? '1' : '0.5';
        nextBtn.style.opacity = scrollLeft < maxScroll - 5 ? '1' : '0.5';
        
        // Agregar/remover clase para indicador de scroll
        if (scrollLeft < maxScroll - 5) {
            scrollContainer.classList.add('has-more');
        } else {
            scrollContainer.classList.remove('has-more');
        }
    }
    
    // Navegación con botones
    prevBtn.addEventListener('click', function() {
        if (isScrolling) return;
        isScrolling = true;
        
        scrollContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
        
        setTimeout(() => {
            isScrolling = false;
            updateNavButtons();
        }, 300);
    });
    
    nextBtn.addEventListener('click', function() {
        if (isScrolling) return;
        isScrolling = true;
        
        scrollContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
        
        setTimeout(() => {
            isScrolling = false;
            updateNavButtons();
        }, 300);
    });
    
    // Navegación con teclado
    scrollContainer.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextBtn.click();
        }
    });
    
    // Actualizar botones al hacer scroll
    scrollContainer.addEventListener('scroll', updateNavButtons);
    
    // Inicializar estado de botones
    updateNavButtons();
    
    // Auto-scroll automático
    let autoScrollTimer;
    let isAutoScrolling = false;
    
    function startAutoScroll() {
        if (isAutoScrolling) return;
        isAutoScrolling = true;
        
        autoScrollTimer = setInterval(() => {
            const scrollLeft = scrollContainer.scrollLeft;
            const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            
            if (scrollLeft >= maxScroll) {
                // Volver al inicio cuando llega al final
                scrollContainer.scrollTo({
                    left: 0,
                    behavior: 'smooth'
                });
            } else {
                // Avanzar un poco
                scrollContainer.scrollBy({
                    left: 2,
                    behavior: 'auto'
                });
            }
            
            updateNavButtons();
        }, 100); // Velocidad del auto-scroll (ajustable)
    }
    
    function stopAutoScroll() {
        isAutoScrolling = false;
        if (autoScrollTimer) {
            clearInterval(autoScrollTimer);
        }
    }
    
    // Pausar auto-scroll cuando el usuario interactúa
    scrollContainer.addEventListener('mouseenter', stopAutoScroll);
    scrollContainer.addEventListener('touchstart', stopAutoScroll);
    
    // Reanudar auto-scroll cuando el usuario deja de interactuar
    scrollContainer.addEventListener('mouseleave', startAutoScroll);
    scrollContainer.addEventListener('touchend', () => {
        setTimeout(startAutoScroll, 2000); // Reanudar después de 2 segundos
    });
    
    // Iniciar auto-scroll después de 3 segundos
    setTimeout(startAutoScroll, 3000);
    
    // Touch events para móviles
    setupTouchEvents(scrollContainer);
    
    // Mouse events para desktop
    scrollContainer.addEventListener('mousedown', function(e) {
        isDragging = true;
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
        scrollContainer.style.cursor = 'grabbing';
        scrollContainer.style.scrollBehavior = 'auto';
    });
    
    scrollContainer.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 2;
        scrollContainer.scrollLeft = scrollLeft - walk;
    });
    
    scrollContainer.addEventListener('mouseup', function() {
        isDragging = false;
        scrollContainer.style.cursor = 'grab';
        scrollContainer.style.scrollBehavior = 'smooth';
        updateNavButtons();
    });
    
    scrollContainer.addEventListener('mouseleave', function() {
        if (isDragging) {
            isDragging = false;
            scrollContainer.style.cursor = 'grab';
            scrollContainer.style.scrollBehavior = 'smooth';
            updateNavButtons();
        }
    });
    
    // Mouse events para desktop
    scrollContainer.addEventListener('mousedown', function(e) {
        isDragging = true;
        startX = e.pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
        scrollContainer.style.cursor = 'grabbing';
        scrollContainer.style.scrollBehavior = 'auto';
    });
    
    scrollContainer.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 2;
        scrollContainer.scrollLeft = scrollLeft - walk;
    });
    
    scrollContainer.addEventListener('mouseup', function() {
        isDragging = false;
        scrollContainer.style.cursor = 'grab';
        scrollContainer.style.scrollBehavior = 'smooth';
        updateNavButtons();
    });
    
    scrollContainer.addEventListener('mouseleave', function() {
        if (isDragging) {
            isDragging = false;
            scrollContainer.style.cursor = 'grab';
            scrollContainer.style.scrollBehavior = 'smooth';
            updateNavButtons();
        }
    });
    
    // Auto-scroll suave al hacer hover en los botones
    let autoScrollInterval;
    
    prevBtn.addEventListener('mouseenter', function() {
        autoScrollInterval = setInterval(() => {
            if (scrollContainer.scrollLeft > 0) {
                scrollContainer.scrollBy({ left: -10, behavior: 'auto' });
            }
        }, 50);
    });
    
    prevBtn.addEventListener('mouseleave', function() {
        clearInterval(autoScrollInterval);
    });
    
    nextBtn.addEventListener('mouseenter', function() {
        autoScrollInterval = setInterval(() => {
            const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            if (scrollContainer.scrollLeft < maxScroll) {
                scrollContainer.scrollBy({ left: 10, behavior: 'auto' });
            }
        }, 50);
    });
    
    nextBtn.addEventListener('mouseleave', function() {
        clearInterval(autoScrollInterval);
    });
    
    // Scroll suave al hacer clic en los filtros
    const filtroBtns = document.querySelectorAll('.categoria-filtro-btn');
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Prevenir clic si está arrastrando
            if (isDragging) {
                e.preventDefault();
                return;
            }
            
            // Remover clase active de todos los botones
            filtroBtns.forEach(b => b.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Efecto de feedback táctil
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Scroll suave a la sección correspondiente
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
        
        // Efecto de hover mejorado
        btn.addEventListener('mouseenter', function() {
            if (!isDragging) {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            }
        });
        
        btn.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active') && !isDragging) {
                this.style.transform = '';
            }
        });
    });
}

// Función para configurar touch events en móviles
function setupTouchEvents(scrollContainer) {
    let isDragging = false;
    let startX = 0;
    let scrollLeft = 0;
    
    scrollContainer.addEventListener('touchstart', function(e) {
        isDragging = true;
        startX = e.touches[0].pageX - scrollContainer.offsetLeft;
        scrollLeft = scrollContainer.scrollLeft;
        scrollContainer.style.scrollBehavior = 'auto';
    });
    
    scrollContainer.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.touches[0].pageX - scrollContainer.offsetLeft;
        const walk = (x - startX) * 2;
        scrollContainer.scrollLeft = scrollLeft - walk;
    });
    
    scrollContainer.addEventListener('touchend', function() {
        isDragging = false;
        scrollContainer.style.scrollBehavior = 'smooth';
    });
}

// Optimización de imágenes
function optimizeImages() {
    const images = document.querySelectorAll('.productos-img');
    
    // Intersection Observer para lazy loading
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        images.forEach(img => {
            if (img.loading === 'lazy') {
                imageObserver.observe(img);
            }
        });
    }
    
    // Precargar imágenes críticas
    const criticalImages = document.querySelectorAll('.productos-img[fetchpriority="high"]');
    criticalImages.forEach(img => {
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
        }
    });
    
    // Optimizar todas las imágenes
    images.forEach(img => {
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
        }
    });
}

// Inicializar carrusel de filtros cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initCategoriasFiltros();
    optimizeImages();
    
    // Manejar cambio de orientación del dispositivo
    window.addEventListener('resize', function() {
        // Reinicializar AOS si cambia de móvil a desktop
        if (window.innerWidth > 768) {
            if (typeof AOS !== 'undefined' && !AOS.isInitialized) {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });
            }
        }
    });
});
</script>

<style>
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para productos */
.productos-hero-title {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 3rem;
    text-shadow: 0 2px 4px rgba(66, 129, 164, 0.2);
}

.productos-hero-subtitle {
    color: #666;
    font-size: 1.2rem;
    font-weight: 500;
}

.productos-filtros {
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 15px;
    padding: 5px;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.1);
}

.productos-filtro-btn {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    padding: 12px 24px;
    border-radius: 10px;
    transition: all 0.3s ease;
    margin: 0 2px;
}

.productos-filtro-btn:hover,
.productos-filtro-btn.active {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

/* Responsive styles for mobile */
@media (max-width: 768px) {
    .productos-filtros {
        flex-direction: column;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .productos-filtro-btn {
        width: 100%;
        margin: 2px 0;
        padding: 10px 16px;
        font-size: 0.9rem;
        border-radius: 8px;
    }
    
    .productos-filtro-btn i {
        margin-right: 8px !important;
    }
}

@media (max-width: 576px) {
    .productos-filtros {
        max-width: 280px;
    }
    
    .productos-filtro-btn {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
}

.productos-buscador {
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.15) !important;
    transition: all 0.3s ease;
}

.productos-buscador:focus-within {
    box-shadow: 0 6px 25px rgba(66, 129, 164, 0.25) !important;
    transform: translateY(-2px);
}

/* Estilos para el carrusel de filtros de categorías */
.categorias-filtros-container {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 60px;
    touch-action: pan-y pinch-zoom;
}

.categorias-filtros-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    background: transparent;
    padding: 10px 0;
    box-shadow: none;
}

.categorias-filtros-scroll {
    display: flex;
    gap: 10px;
    padding: 0 15px;
    transition: transform 0.3s ease;
    overflow-x: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
    -webkit-overflow-scrolling: touch; /* iOS smooth scrolling */
    scroll-behavior: smooth;
    cursor: grab;
    justify-content: center;
    align-items: center;
}

.categorias-filtros-scroll:active {
    cursor: grabbing;
}

.categorias-filtros-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.categoria-filtro-btn {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 25px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    white-space: nowrap;
    min-width: fit-content;
    box-shadow: 0 2px 8px rgba(66, 129, 164, 0.1);
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    position: relative;
    overflow: hidden;
    text-align: center;
    justify-content: center;
}

.categoria-filtro-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s ease;
}

.categoria-filtro-btn:hover::before {
    left: 100%;
}

.categoria-filtro-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.3);
    text-decoration: none;
}

.categoria-filtro-btn:active {
    transform: translateY(0px) scale(0.98);
    box-shadow: 0 2px 8px rgba(66, 129, 164, 0.2);
}

.categoria-filtro-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 129, 164, 0.3);
}

.categoria-filtro-btn.active {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

/* Controles de navegación */
.categoria-filtro-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.95);
    color: var(--primary-color);
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 10;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    user-select: none;
    -webkit-tap-highlight-color: transparent;
}

.categoria-filtro-nav:hover {
    background: white;
    color: var(--primary-color);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    transform: translateY(-50%) scale(1.05);
}

.categoria-filtro-nav:active {
    transform: translateY(-50%) scale(0.95);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.categoria-filtro-nav:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 129, 164, 0.3);
}

.categoria-filtro-prev {
    left: 10px;
}

.categoria-filtro-next {
    right: 10px;
}

/* Indicador de scroll */
.categorias-filtros-scroll::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 30px;
    background: transparent;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.categorias-filtros-scroll.has-more::after {
    opacity: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .categorias-filtros-container {
        padding: 0 20px;
    }
    
    .categoria-filtro-btn {
        padding: 10px 16px;
        font-size: 0.9rem;
        min-width: 140px;
        max-width: 200px;
        white-space: normal;
        line-height: 1.2;
        height: auto;
        min-height: 44px;
        word-wrap: break-word;
        hyphens: auto;
    }
    
    /* Ocultar botones de navegación en móviles */
    .categoria-filtro-nav {
        display: none;
    }
}

/* Ocultar completamente el contenedor de categorías en móviles */
@media (max-width: 576px) {
    .categorias-filtros-container {
        display: none;
    }
}
}
    
    /* Desactivar efectos AOS en móviles para mejor rendimiento */
    [data-aos] {
        opacity: 1 !important;
        transform: none !important;
        animation: none !important;
        transition: none !important;
    }
    
    [data-aos-delay] {
        transition-delay: 0s !important;
    }
    
    [data-aos-duration] {
        transition-duration: 0s !important;
    }
}

@media (max-width: 576px) {
    .categorias-filtros-container {
        padding: 0 15px;
    }
    
    .categoria-filtro-btn {
        padding: 8px 12px;
        font-size: 0.8rem;
        min-width: 120px;
        max-width: 160px;
        white-space: normal;
        line-height: 1.1;
        height: auto;
        min-height: 40px;
        word-wrap: break-word;
        hyphens: auto;
    }
    
    /* Ocultar botones de navegación en móviles */
    .categoria-filtro-nav {
        display: none;
    }
}
    
    /* Optimizar para pantallas pequeñas */
    .categorias-filtros-scroll {
        gap: 6px;
        padding: 0 10px;
    }
    
    /* Desactivar completamente AOS en pantallas muy pequeñas */
    [data-aos] {
        opacity: 1 !important;
        transform: none !important;
        animation: none !important;
        transition: none !important;
    }
}

/* Pantallas muy pequeñas - optimizar para nombres largos */
@media (max-width: 480px) {
    .categorias-filtros-container {
        padding: 0 10px;
    }
    
    .categoria-filtro-btn {
        min-width: 100px;
        max-width: 140px;
        font-size: 0.75rem;
        padding: 6px 10px;
        line-height: 1.0;
        min-height: 36px;
    }
    
    .categorias-filtros-scroll {
        gap: 4px;
        padding: 0 8px;
    }
    
    /* Ocultar botones de navegación en móviles */
    .categoria-filtro-nav {
        display: none;
    }
}

.productos-buscador-input {
    border: none;
    padding: 15px 20px;
    font-size: 1.1rem;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
}

.productos-buscador-input:focus {
    outline: none;
    background: white;
}

.productos-buscador-icon {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: none;
    padding: 15px 20px;
}

#clearSearch {
    background: linear-gradient(135deg, #f8f9fa, var(--light-color));
    border: none;
    padding: 15px 20px;
    color: #6c757d;
    transition: all 0.3s ease;
}

#clearSearch:hover {
    background: linear-gradient(135deg, #e9ecef, #dee2e6);
    color: #495057;
    transform: scale(1.05);
}

#clearSearch:focus {
    box-shadow: none;
    outline: none;
}

/* Estilos específicos para móvil */
@media (max-width: 768px) {
    #clearSearch {
        padding: 12px 16px;
        font-size: 0.9rem;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 8px;
    }
    
    #clearSearch:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: scale(1.1);
    }
    
    #clearSearch i {
        font-size: 0.8rem;
    }
}

.productos-seccion-titulo {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 2rem;
    position: relative;
}

.productos-seccion-titulo::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border-radius: 2px;
}

.productos-contador,
.productos-contador-especiales,
.productos-contador-bebidas,
.productos-contador-combos {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    font-weight: 700;
    padding: 8px 16px;
    font-size: 0.9rem;
}

.productos-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.05), rgba(212, 180, 131, 0.05));
}

.productos-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.2);
}

.productos-img {
    height: 200px;
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease, opacity 0.3s ease;
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);
    opacity: 0;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

.productos-img.loaded {
    opacity: 1;
    animation: none;
    background: none;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.productos-card:hover .productos-img {
    transform: scale(1.05);
}

.productos-placeholder {
    height: 200px;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
}

.productos-precio-badge,
.productos-precio-badge-especiales,
.productos-precio-badge-bebidas,
.productos-precio-badge-combos {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    font-weight: 700;
    padding: 6px 12px;
    font-size: 0.85rem;
}

.productos-especial-badge,
.productos-combo-badge {
    background: linear-gradient(135deg, var(--warm-color), var(--accent-red));
    color: white;
    border: none;
    font-weight: 700;
    padding: 4px 8px;
    font-size: 0.75rem;
}

.productos-view-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    opacity: 0.8;
}

.productos-view-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    opacity: 1;
    transform: scale(1.1);
}

.productos-titulo {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    line-height: 1.3;
}

.productos-descripcion {
    color: #666;
    line-height: 1.4;
    font-size: 0.9rem;
}

.productos-precio {
    color: var(--accent-color);
    font-size: 1.3rem;
    font-weight: 800;
    min-width: 60px;
}

.productos-cantidad-controls {
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.productos-quantity-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    border-radius: 6px;
    font-size: 0.8rem;
}

.productos-quantity-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.05);
}

.productos-cantidad-valor {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.1rem;
    min-width: 32px;
    display: inline-block;
    text-align: center;
}

.productos-add-btn,
.productos-add-btn-especiales,
.productos-add-btn-bebidas,
.productos-add-btn-combos {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 8px 16px;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.2);
}

.productos-add-btn:hover,
.productos-add-btn-especiales:hover,
.productos-add-btn-bebidas:hover,
.productos-add-btn-combos:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
    color: white;
}



@media (max-width: 576px) {
    .productos-add-btn,
    .productos-add-btn-especiales,
    .productos-add-btn-bebidas,
    .productos-add-btn-combos {
        padding: 4px 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .productos-add-btn i,
    .productos-add-btn-especiales i,
    .productos-add-btn-bebidas i,
    .productos-add-btn-combos i {
        font-size: 0.75rem;
    }
}

.productos-combo-info {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.85rem;
}

.productos-cta-card {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.3);
}

.productos-cta-titulo {
    font-weight: 800;
    font-size: 2rem;
}

.productos-cta-subtitulo {
    font-size: 1.2rem;
    opacity: 0.9;
}

.productos-cta-btn {
    background: linear-gradient(135deg, white, #f8f9fa);
    border: none;
    color: var(--primary-color);
    font-weight: 700;
    padding: 12px 30px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.productos-cta-btn:hover {
    background: linear-gradient(135deg, #f8f9fa, white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    color: var(--primary-color);
}

/* Estilos existentes mejorados */
.product-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 12px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    border-color: rgba(0,0,0,0.2);
}

.product-img {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.product-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.price-badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

.special-badge, .combo-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.4rem 0.6rem;
    border-radius: 15px;
}

.view-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    opacity: 0.8;
}

.view-btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

.quantity-controls {
    min-width: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn {
    transition: all 0.2s ease;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 0.8rem;
}

.quantity-btn:hover {
    background-color: #f8f9fa !important;
    transform: scale(1.05);
}

.cantidad-valor {
    font-size: 1.1rem;
    min-width: 32px;
    display: inline-block;
    text-align: center;
    font-weight: 600;
}

.add-cart-btn {
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
}

.add-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
    line-height: 1.3;
}

.product-description {
    font-size: 0.9rem;
    line-height: 1.4;
    color: #6c757d;
    margin-bottom: 1rem;
}

.product-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #0d6efd;
    min-width: 60px;
}

.product-form {
    margin-top: auto;
}

.toast {
    transition: all 0.3s ease;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    max-width: 400px;
    width: 100%;
}

.toast.show {
    opacity: 1;
    transform: translateX(0);
}

.toast.hide {
    opacity: 0;
    transform: translateX(100%);
}

/* Responsive toast positioning */
@media (max-width: 768px) {
    #toastContainer {
        left: 10px !important;
        right: 10px !important;
        top: 10px !important;
        align-items: center !important;
    }
    
    .toast {
        max-width: calc(100vw - 20px) !important;
        width: 100% !important;
        margin: 0 auto 10px auto !important;
        border-radius: 12px !important;
        font-size: 0.9rem !important;
    }
    
    .toast .toast-body {
        padding: 12px 16px !important;
        text-align: center !important;
    }
    
    .toast .btn-close {
        margin-left: 8px !important;
    }
}

@media (max-width: 480px) {
    #toastContainer {
        left: 5px !important;
        right: 5px !important;
        top: 5px !important;
    }
    
    .toast {
        max-width: calc(100vw - 10px) !important;
        font-size: 0.85rem !important;
    }
    
    .toast .toast-body {
        padding: 10px 14px !important;
    }
}

.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: #fff;
    animation: spin 1s ease-in-out infinite;
    vertical-align: middle;
    margin-right: 8px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.btn-hover-effect {
    position: relative;
    overflow: hidden;
}

.btn-hover-effect::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-hover-effect:hover::before {
    left: 100%;
}

.product-item {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card:focus-within {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}

.quantity-btn:focus,
.add-cart-btn:focus,
.view-btn:focus {
    outline: 2px solid #0d6efd;
    outline-offset: 2px;
}

@media (max-width: 768px) {
    .product-card {
        margin-bottom: 1rem;
    }
    
    .quantity-controls {
        min-width: 100px;
    }
    
    .add-cart-btn {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
    }
    
    .product-price {
        font-size: 1.1rem;
    }
}
</style>