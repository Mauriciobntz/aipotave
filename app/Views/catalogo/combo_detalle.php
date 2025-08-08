<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 combo-detalle-card">
                <div class="row g-0">
                    <!-- Columna de la imagen -->
                    <div class="col-12 col-md-5">
                        <?php if ($combo['imagen']): ?>
                            <img src="<?= base_url('public/' . $combo['imagen']) ?>" class="img-fluid rounded-start h-100 object-fit-cover combo-detalle-img" alt="<?= esc($combo['nombre']) ?>" style="min-height: 300px;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light h-100 combo-detalle-placeholder">
                                <i class="fas fa-box fa-5x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Columna de la información -->
                    <div class="col-12 col-md-7">
                        <div class="card-body p-4">
                            <!-- Encabezado -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="card-title mb-2 combo-detalle-title"><?= esc($combo['nombre']) ?></h1>
                                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mb-3">
                                        <div class="me-3 mb-2 mb-md-0">
                                            <span class="badge combo-detalle-categoria fs-6">
                                                <i class="fas fa-box me-1"></i>Combo
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary rounded-circle combo-detalle-close-btn">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            
                            <!-- Precio -->
                            <div class="mb-4">
                                <h2 class="text-primary fw-bold combo-detalle-precio">$<?= number_format($combo['precio'], 2) ?></h2>
                                <small class="text-success combo-detalle-disponible">
                                    <i class="fas fa-check-circle me-1"></i>Disponible
                                </small>
                            </div>
                            
                            <!-- Descripción -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 combo-detalle-section-title">Descripción</h5>
                                <p class="card-text combo-detalle-descripcion"><?= esc($combo['descripcion']) ?></p>
                            </div>
                            
                            <!-- Productos incluidos -->
                            <?php 
                            // Debug temporal
                            if (empty($productos)) {
                                echo '<div class="mb-4"><div class="alert alert-info">No hay productos asociados a este combo. Debug: ' . count($productos) . ' productos encontrados.</div></div>';
                            }
                            ?>
                            <?php if (!empty($productos)): ?>
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 combo-detalle-section-title">
                                    <i class="fas fa-list-ul me-2"></i>Productos incluidos
                                </h5>
                                
                                <!-- Lista compacta de productos -->
                                <div class="combo-productos-lista mb-3">
                                    <?php foreach ($productos as $producto): ?>
                                    <div class="combo-producto-item">
                                        <div class="d-flex align-items-center">
                                            <div class="combo-producto-imagen me-3">
                                                <?php if (!empty($producto['imagen'])): ?>
                                                    <img src="<?= base_url('public/' . $producto['imagen']) ?>" class="rounded" alt="<?= esc($producto['nombre']) ?>" style="width: 40px; height: 40px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-utensils text-muted" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 combo-producto-nombre"><?= esc($producto['nombre']) ?></h6>
                                                <small class="text-muted combo-producto-precio">$<?= number_format($producto['precio'], 2) ?></small>
                                            </div>
                                            <div class="combo-producto-cantidad">
                                                <?php if ($producto['cantidad'] > 1): ?>
                                                    <span class="badge bg-primary">x<?= $producto['cantidad'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">✓</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Información adicional -->
                                <div class="combo-info-adicional">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="combo-info-item">
                                                <i class="fas fa-calculator text-primary me-2"></i>
                                                <span class="fw-bold">Precio individual:</span>
                                                                                                 <span class="text-muted">$<?= number_format(array_sum(array_column($productos, 'precio')), 2) ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="combo-info-item">
                                                <i class="fas fa-piggy-bank text-success me-2"></i>
                                                <span class="fw-bold">Ahorro:</span>
                                                                                                 <span class="text-success">$<?= number_format(array_sum(array_column($productos, 'precio')) - $combo['precio'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Formulario para agregar al carrito -->
                            <div class="border-top pt-4 combo-detalle-form-section">
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="row g-3 align-items-center combo-detalle-form">
                                    <input type="hidden" name="id" value="<?= $combo['id'] ?>">
                                    <input type="hidden" name="tipo" value="combo">
                                    <div class="col-12 d-flex flex-column flex-md-row align-items-center mb-2 mb-md-0 justify-content-between">
                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                            <label class="form-label fw-bold me-3 mb-0 combo-detalle-cantidad-label">Cantidad</label>
                                            <button type="button" class="btn btn-outline-secondary quantity-btn combo-detalle-quantity-btn" onclick="cambiarCantidadTexto(this, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="cantidad-valor fw-bold mx-2 combo-detalle-cantidad-valor" style="font-size: 1.3rem; min-width: 32px; display: inline-block; text-align: center;">1</span>
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn combo-detalle-quantity-btn" onclick="cambiarCantidadTexto(this, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <span class="fw-bold text-success ms-md-3 mt-2 mt-md-0 text-md-end combo-detalle-subtotal" id="subtotalCombo">$<?= number_format($combo['precio'], 2) ?></span>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg btn-hover-effect w-100 combo-detalle-add-btn" id="btnAgregarCarritoCombo">
                                            <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Combos relacionados -->
            <div class="mt-5">
                <h3 class="mb-4 fw-bold combo-detalle-relacionados-title">Combos relacionados</h3>
                <div class="row">
                    <?php foreach ($combosRelacionados as $relacionado): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100 product-card shadow-sm combo-relacionado-card">
                            <div class="position-relative overflow-hidden">
                                <a href="<?= base_url('combo/' . $relacionado['id']) ?>">
                                    <?php if (!empty($relacionado['imagen'])): ?>
                                        <img src="<?= base_url('public/' . $relacionado['imagen']) ?>" class="card-img-top product-img combo-relacionado-img" alt="<?= esc($relacionado['nombre']) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center combo-relacionado-placeholder" style="height: 160px;">
                                            <i class="fas fa-box fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success shadow-sm combo-relacionado-precio">$<?= number_format($relacionado['precio'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title combo-relacionado-title">
                                    <a href="<?= base_url('combo/' . $relacionado['id']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($relacionado['nombre']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small combo-relacionado-descripcion"><?= esc(substr($relacionado['descripcion'], 0, 60)) ?>...</p>
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-3">
                                    <input type="hidden" name="tipo" value="combo">
                                    <input type="hidden" name="id" value="<?= $relacionado['id'] ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary w-100 combo-relacionado-add-btn">
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
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para combo detalle */
.combo-detalle-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.combo-detalle-img {
    object-fit: cover;
    transition: transform 0.3s ease;
}

.combo-detalle-img:hover {
    transform: scale(1.05);
}

.combo-detalle-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-radius: 0 0 0 20px;
}

.combo-detalle-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 2.2rem;
    line-height: 1.2;
}

.combo-detalle-categoria {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    padding: 8px 16px;
    font-weight: 600;
}

.combo-detalle-close-btn {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.combo-detalle-close-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
}

.combo-detalle-precio {
    color: var(--accent-color);
    font-size: 2.5rem;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(72, 169, 166, 0.2);
}

.combo-detalle-disponible {
    color: var(--accent-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.combo-detalle-section-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.3rem;
    border-bottom: 2px solid var(--light-color);
    padding-bottom: 8px;
}

.combo-detalle-descripcion {
    color: #555;
    line-height: 1.6;
    font-size: 1.05rem;
}

.combo-producto-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
}

.combo-producto-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.2);
}

.combo-producto-img {
    transition: transform 0.3s ease;
    border-radius: 8px;
}

.combo-producto-card:hover .combo-producto-img {
    transform: scale(1.1);
}

.combo-producto-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-radius: 8px;
}

.combo-producto-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 0.9rem;
    line-height: 1.3;
    margin-bottom: 0.5rem;
}

.combo-producto-precio {
    color: var(--accent-color);
    font-weight: 600;
    font-size: 0.8rem;
}

/* Nuevos estilos para la lista de productos del combo */
.combo-productos-lista {
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.05), rgba(212, 180, 131, 0.05));
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid var(--light-color);
}

.combo-producto-item {
    padding: 0.75rem;
    border-bottom: 1px solid rgba(228, 223, 218, 0.3);
    transition: all 0.3s ease;
}

.combo-producto-item:last-child {
    border-bottom: none;
}

.combo-producto-item:hover {
    background: rgba(228, 223, 218, 0.1);
    border-radius: 8px;
}

.combo-producto-nombre {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.combo-producto-cantidad {
    min-width: 40px;
    text-align: center;
}

.combo-info-adicional {
    background: linear-gradient(135deg, rgba(72, 169, 166, 0.05), rgba(66, 129, 164, 0.05));
    border-radius: 10px;
    padding: 1rem;
    margin-top: 1rem;
    border: 1px solid rgba(72, 169, 166, 0.2);
}

.combo-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.combo-info-item:last-child {
    margin-bottom: 0;
}

.combo-info-item i {
    font-size: 1rem;
    min-width: 20px;
}

.combo-detalle-quick-view {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.combo-detalle-quick-view:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
}

.combo-detalle-form-section {
    border-top: 2px solid var(--light-color) !important;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 0 0 20px 20px;
    margin: 0 -1.5rem -1.5rem -1.5rem;
    padding: 1.5rem;
}

.combo-detalle-cantidad-label {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
}

.combo-detalle-quantity-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    border-radius: 50%;
}

.combo-detalle-quantity-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
}

.combo-detalle-cantidad-valor {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.4rem;
}

.combo-detalle-subtotal {
    color: var(--accent-color);
    font-size: 1.3rem;
    font-weight: 800;
}

.combo-detalle-checkbox {
    width: 1.3em;
    height: 1.3em;
    border: 2px solid var(--primary-color);
    background-color: #fff;
    transition: all 0.3s ease;
}

.combo-detalle-checkbox:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.combo-detalle-checkbox-label {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.combo-detalle-notas {
    border: 2px solid var(--light-color);
    border-radius: 10px;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
}

.combo-detalle-notas:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(66, 129, 164, 0.25);
}

.combo-detalle-add-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.combo-detalle-add-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
    color: white;
}

.combo-detalle-relacionados-title {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.combo-detalle-relacionados-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border-radius: 2px;
}

.combo-relacionado-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.combo-relacionado-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.2);
}

.combo-relacionado-img {
    transition: transform 0.3s ease;
}

.combo-relacionado-card:hover .combo-relacionado-img {
    transform: scale(1.1);
}

.combo-relacionado-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
}

.combo-relacionado-precio {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    font-weight: 700;
    padding: 6px 12px;
    font-size: 0.9rem;
}

.combo-relacionado-title a {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.combo-relacionado-title a:hover {
    color: var(--accent-color);
}

.combo-relacionado-descripcion {
    color: #666;
    line-height: 1.4;
}

.combo-relacionado-add-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.2);
}

.combo-relacionado-add-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
    color: white;
}

/* Estilos existentes mejorados */
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

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input {
    width: 1.3em;
    height: 1.3em;
    border: 2px solid var(--primary-color);
    background-color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    .combo-detalle-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .combo-detalle-title {
        font-size: 1.8rem;
    }
    
    .combo-detalle-precio {
        font-size: 2rem;
    }
    
    .combo-detalle-section-title {
        font-size: 1.1rem;
    }
    
    .combo-detalle-descripcion {
        font-size: 1rem;
    }
    
    .combo-detalle-form-section {
        padding: 1rem;
        margin: 0 -1rem -1rem -1rem;
        border-radius: 0 0 15px 15px;
    }
    
    .combo-detalle-cantidad-label {
        font-size: 1rem;
    }
    
    .combo-detalle-quantity-btn {
        width: 35px;
        height: 35px;
    }
    
    .combo-detalle-cantidad-valor {
        font-size: 1.2rem;
    }
    
    .combo-detalle-subtotal {
        font-size: 1.1rem;
    }
    
    .combo-detalle-add-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .combo-detalle-relacionados-title {
        font-size: 1.5rem;
    }
    
    .combo-relacionado-title a {
        font-size: 1rem;
    }
    
    .combo-relacionado-add-btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    
    .combo-producto-title {
        font-size: 0.8rem;
    }
    
    .combo-producto-precio {
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .combo-detalle-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .combo-detalle-title {
        font-size: 1.5rem;
    }
    
    .combo-detalle-precio {
        font-size: 1.8rem;
    }
    
    .combo-detalle-section-title {
        font-size: 1rem;
    }
    
    .combo-detalle-descripcion {
        font-size: 0.9rem;
    }
    
    .combo-detalle-form-section {
        padding: 0.75rem;
        margin: 0 -0.75rem -0.75rem -0.75rem;
        border-radius: 0 0 12px 12px;
    }
    
    .combo-detalle-cantidad-label {
        font-size: 0.9rem;
    }
    
    .combo-detalle-quantity-btn {
        width: 30px;
        height: 30px;
    }
    
    .combo-detalle-cantidad-valor {
        font-size: 1.1rem;
    }
    
    .combo-detalle-subtotal {
        font-size: 1rem;
    }
    
    .combo-detalle-add-btn {
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .combo-detalle-relacionados-title {
        font-size: 1.3rem;
    }
    
    .combo-relacionado-title a {
        font-size: 0.9rem;
    }
    
    .combo-relacionado-add-btn {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
    }
    
    .combo-producto-title {
        font-size: 0.75rem;
    }
    
    .combo-producto-precio {
        font-size: 0.7rem;
    }
    
    /* Hide close button on mobile devices */
    .combo-detalle-close-btn {
        display: none !important;
    }
}
</style>