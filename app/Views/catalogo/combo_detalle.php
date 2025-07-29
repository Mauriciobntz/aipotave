<div class="container mt-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 border-success border-3">
                <div class="row g-0">
                    <!-- Columna de la imagen -->
                    <div class="col-md-5">
                        <?php if ($combo['imagen']): ?>
                            <img src="<?= esc($combo['imagen']) ?>" class="img-fluid rounded-start h-100 object-fit-cover" alt="<?= esc($combo['nombre']) ?>" style="min-height: 400px;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light h-100">
                                <i class="fas fa-box fa-5x text-success"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Columna de la información -->
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <!-- Encabezado -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="card-title mb-2"><?= esc($combo['nombre']) ?></h1>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <span class="badge bg-success fs-6">Combo</span>
                                        </div>
                                        <div class="star-rating">
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star text-warning"></i>
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                            <small class="text-muted ms-2">(18 reseñas)</small>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary rounded-circle">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            
                            <!-- Precio y ahorro -->
                            <div class="mb-4">
                                <h2 class="text-success fw-bold">$<?= number_format($combo['precio'], 2) ?></h2>
                                <?php if ($combo['ahorro'] > 0): ?>
                                    <small class="text-danger">
                                        <i class="fas fa-tag me-1"></i>Ahorras $<?= number_format($combo['ahorro'], 2) ?> (<?= round(($combo['ahorro'] / ($combo['precio'] + $combo['ahorro'])) * 100) ?>%)
                                    </small>
                                <?php endif; ?>
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>Disponible
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Descripción -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">Descripción</h5>
                                <p class="card-text"><?= esc($combo['descripcion']) ?></p>
                            </div>
                            
                            <!-- Productos incluidos -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-box-open me-2 text-success"></i>Contenido del Combo
                                </h5>
                                <div class="row g-3">
                                    <?php foreach ($productos as $prod): ?>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <?php if (!empty($prod['imagen'])): ?>
                                                        <img src="<?= base_url('public/' . $prod['imagen']) ?>" class="rounded me-3" width="60" height="60" alt="<?= esc($prod['nombre']) ?>">
                                                    <?php else: ?>
                                                        <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-1"><?= esc($prod['nombre']) ?></h6>
                                                        <small class="text-muted">x<?= esc($prod['cantidad']) ?></small>
                                                        <div class="mt-1">
                                                            <small class="text-success fw-bold">$<?= number_format($prod['precio'], 2) ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Formulario para agregar al carrito -->
                            <div class="border-top pt-4">
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="row g-3 align-items-center">
                                    <input type="hidden" name="id" value="<?= $combo['id'] ?>">
                                    <input type="hidden" name="tipo" value="combo">
                                    
                                    <div class="col-md-3">
                                        <label for="cantidad" class="form-label fw-bold">Cantidad</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="cantidad" value="1" min="1" class="form-control text-center" id="cantidad">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(this, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-success btn-lg w-100 btn-hover-effect">
                                            <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito - $<?= number_format($combo['precio'], 2) ?>
                                        </button>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="notasCheck">
                                            <label class="form-check-label" for="notasCheck">
                                                ¿Alguna instrucción especial? (sin picante, sin gluten, etc.)
                                            </label>
                                        </div>
                                        <textarea class="form-control mt-2 d-none" id="notasTextarea" rows="2" placeholder="Ej: Sin mayonesa, bien cocido..."></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Combos relacionados -->
            <div class="mt-5">
                <h3 class="mb-4 fw-bold">Otros combos que te pueden gustar</h3>
                <div class="row">
                    <?php foreach ($combosRelacionados as $relacionado): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 product-card shadow-sm">
                            <div class="position-relative overflow-hidden">
                                <a href="<?= base_url('combo/' . $relacionado['id']) ?>">
                                    <?php if (!empty($relacionado['imagen'])): ?>
                                        <img src="<?= esc($relacionado['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($relacionado['nombre']) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                            <i class="fas fa-box fa-3x text-success"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success shadow-sm">$<?= number_format($relacionado['precio'], 0, ',', '.') ?></span>
                                </div>
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-success text-white shadow-sm">Combo</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?= base_url('combo/' . $relacionado['id']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($relacionado['nombre']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small"><?= esc(substr($relacionado['descripcion'], 0, 60)) ?>...</p>
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-3">
                                    <input type="hidden" name="tipo" value="combo">
                                    <input type="hidden" name="id" value="<?= $relacionado['id'] ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                        <i class="fas fa-cart-plus me-1"></i>Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Función para cambiar cantidad
function cambiarCantidad(button, cambio) {
    const input = button.parentNode.querySelector('input');
    const nuevoValor = parseInt(input.value) + cambio;
    if (nuevoValor >= 1) {
        input.value = nuevoValor;
    }
}

// Mostrar/ocultar textarea de notas
document.addEventListener('DOMContentLoaded', function() {
    const notasCheck = document.getElementById('notasCheck');
    const notasTextarea = document.getElementById('notasTextarea');
    
    if (notasCheck && notasTextarea) {
        notasCheck.addEventListener('change', function() {
            if (this.checked) {
                notasTextarea.classList.remove('d-none');
            } else {
                notasTextarea.classList.add('d-none');
            }
        });
    }
    
    // Efecto de hover para las cards de producto relacionado
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
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
    
    // Mostrar notificación cuando se agrega al carrito
    const addToCartForm = document.querySelector('form[action="<?= base_url('carrito/agregar') ?>"]');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
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
                    showToast('Combo agregado al carrito', 'success');
                    
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
    }
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
.object-fit-cover {
    object-fit: cover;
}

.star-rating {
    display: flex;
    align-items: center;
}

.quantity-btn {
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background-color: #f0f0f0 !important;
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

.toast {
    transition: all 0.3s ease;
}

.toast.show {
    opacity: 1;
}

.toast.hide {
    opacity: 0;
}

.product-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.product-card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
}
</style>