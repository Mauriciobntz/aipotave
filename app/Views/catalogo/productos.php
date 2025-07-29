<div class="container-fluid mt-5 pt-4">
    <!-- Hero Section -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="fas fa-utensils me-3"></i>Nuestro Menú
            </h1>
            <p class="lead text-muted">Descubre nuestros platos más populares y especialidades del día</p>
            
            <!-- Filtros de categoría -->
            <div class="d-flex justify-content-center mb-4">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <a href="#comidas" class="btn btn-outline-primary active">
                        <i class="fas fa-hamburger me-2"></i>Platos
                    </a>
                    <a href="#bebidas" class="btn btn-outline-primary">
                        <i class="fas fa-glass-whiskey me-2"></i>Bebidas
                    </a>
                    <a href="#combos" class="btn btn-outline-primary">
                        <i class="fas fa-box me-2"></i>Combos
                    </a>
                    <a href="#especiales" class="btn btn-outline-primary">
                        <i class="fas fa-star me-2"></i>Especiales
                    </a>
                </div>
            </div>
            
            <!-- Buscador -->
            <div class="col-md-6 mx-auto mb-4">
                <div class="input-group shadow-sm rounded-pill">
                    <span class="input-group-text bg-white border-0 rounded-pill-start">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-0 rounded-pill-end" id="searchInput" placeholder="Buscar productos...">
                </div>
            </div>
        </div>
    </div>

    <!-- Comidas -->
    <?php if (!empty($comidas)): ?>
    <div class="row mb-5" id="comidas" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-hamburger me-2 text-warning"></i>Platos Principales
                </h2>
                <span class="badge bg-primary rounded-pill"><?= count($comidas) ?> productos</span>
            </div>
        </div>
        <?php foreach ($comidas as $comida): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="comida" data-name="<?= strtolower(esc($comida['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($comida['imagen'])): ?>
                        <img src="<?= base_url('public/' . $comida['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($comida['nombre']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-utensils fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success shadow-sm">$<?= number_format($comida['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <button class="btn btn-sm btn-light shadow-sm rounded-circle quick-view" data-id="<?= $comida['id'] ?>" data-type="producto">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($comida['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?= esc($comida['descripcion']) ?></p>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="hidden" name="id" value="<?= $comida['id'] ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-hover-effect">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Viandas (Especiales del día) -->
    <?php if (!empty($viandas)): ?>
    <div class="row mb-5" id="especiales" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-star me-2 text-warning"></i>Especiales del Día
                </h2>
                <span class="badge bg-danger rounded-pill"><?= count($viandas) ?> productos</span>
            </div>
        </div>
        <?php foreach ($viandas as $vianda): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="especial" data-name="<?= strtolower(esc($vianda['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($vianda['imagen'])): ?>
                        <img src="<?= base_url('public/' . $vianda['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($vianda['nombre']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-star fa-3x text-warning"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-danger shadow-sm">$<?= number_format($vianda['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-warning text-dark shadow-sm">Especial</span>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-2">
                        <button class="btn btn-sm btn-light shadow-sm rounded-circle quick-view" data-id="<?= $vianda['id'] ?>" data-type="producto">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($vianda['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?= esc($vianda['descripcion']) ?></p>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="hidden" name="id" value="<?= $vianda['id'] ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-danger btn-hover-effect">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Bebidas -->
    <?php if (!empty($bebidas)): ?>
    <div class="row mb-5" id="bebidas" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-glass-whiskey me-2 text-info"></i>Bebidas
                </h2>
                <span class="badge bg-info rounded-pill"><?= count($bebidas) ?> productos</span>
            </div>
        </div>
        <?php foreach ($bebidas as $bebida): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="bebida" data-name="<?= strtolower(esc($bebida['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($bebida['imagen'])): ?>
                        <img src="<?= base_url('public/' . $bebida['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($bebida['nombre']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-glass-whiskey fa-3x text-info"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-info shadow-sm">$<?= number_format($bebida['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-2">
                        <button class="btn btn-sm btn-light shadow-sm rounded-circle quick-view" data-id="<?= $bebida['id'] ?>" data-type="producto">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($bebida['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?= esc($bebida['descripcion']) ?></p>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="hidden" name="id" value="<?= $bebida['id'] ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-info btn-hover-effect">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Combos -->
    <?php if (!empty($combos)): ?>
    <div class="row mb-5" id="combos" data-aos="fade-up">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-box me-2 text-success"></i>Combos Especiales
                </h2>
                <span class="badge bg-success rounded-pill"><?= count($combos) ?> productos</span>
            </div>
        </div>
        <?php foreach ($combos as $combo): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="combo" data-name="<?= strtolower(esc($combo['nombre'])) ?>">
            <div class="card h-100 product-card shadow-sm">
                <div class="position-relative overflow-hidden">
                    <?php if (!empty($combo['imagen'])): ?>
                        <img src="<?= esc($combo['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($combo['nombre']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-box fa-3x text-success"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success shadow-sm">$<?= number_format($combo['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-success text-white shadow-sm">Combo</span>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-2">
                        <button class="btn btn-sm btn-light shadow-sm rounded-circle quick-view" data-id="<?= $combo['id'] ?>" data-type="combo">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($combo['nombre']) ?></h5>
                    <p class="card-text text-muted flex-grow-1"><?= esc($combo['descripcion']) ?></p>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Incluye varios productos
                        </small>
                    </div>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-auto">
                        <input type="hidden" name="tipo" value="combo">
                        <input type="hidden" name="id" value="<?= $combo['id'] ?>">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success btn-hover-effect">
                                <i class="fas fa-cart-plus me-2"></i>Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Call to Action -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body py-5">
                    <h3 class="mb-3">
                        <i class="fas fa-shopping-cart me-3"></i>¿Listo para ordenar?
                    </h3>
                    <p class="lead mb-4">Revisa tu carrito y completa tu pedido</p>
                    <a href="<?= base_url('carrito') ?>" class="btn btn-light btn-lg btn-hover-effect">
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
// Función para cambiar cantidad en los inputs
function cambiarCantidad(button, cambio) {
    const input = button.parentNode.querySelector('input');
    const nuevoValor = parseInt(input.value) + cambio;
    if (nuevoValor >= 1) {
        input.value = nuevoValor;
    }
}

// Filtrado de productos
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Buscador de productos
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(item => {
                const productName = item.getAttribute('data-name');
                if (productName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
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
                    
                    // Actualizar contador del carrito en el navbar
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
        container.style.zIndex = '1100';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast show align-items-center text-white bg-${type} border-0`;
    toast.role = 'alert';
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.style.marginBottom = '10px';
    
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
</script>

<style>
.product-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.product-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.quantity-btn {
    transition: all 0.2s ease;
    width: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-btn:hover {
    background-color: #f0f0f0 !important;
}

.input-group-sm .form-control {
    padding: 0.25rem 0.5rem;
}

.quick-view {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toast {
    transition: all 0.3s ease;
}

.toast.show {
    opacity: 1;
}

.toast.hide {
    opacity: 0;
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

/* Efecto de hover para los botones de categoría */
.btn-group-toggle .btn {
    transition: all 0.3s ease;
}

.btn-group-toggle .btn:hover {
    background-color: #f8f9fa;
}

.btn-group-toggle .btn.active {
    background-color: #0d6efd;
    color: white;
}

/* Efecto para el buscador */
.input-group.has-search .form-control {
    padding-left: 0;
}

.input-group.has-search .input-group-text {
    background-color: transparent;
    border-right: none;
}

.input-group.has-search .form-control:focus {
    border-left: 1px solid #ced4da;
    padding-left: 12px;
}
</style>