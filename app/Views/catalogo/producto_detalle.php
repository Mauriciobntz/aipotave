<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 producto-detalle-card">
                <div class="row g-0">
                    <!-- Columna de la imagen -->
                    <div class="col-12 col-md-5">
                        <?php if ($producto['imagen']): ?>
                            <img src="<?= base_url('public/' . $producto['imagen']) ?>" class="img-fluid rounded-start h-100 object-fit-cover producto-detalle-img" alt="<?= esc($producto['nombre']) ?>" style="min-height: 300px;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light h-100 producto-detalle-placeholder">
                                <i class="fas fa-utensils fa-5x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Columna de la información -->
                    <div class="col-12 col-md-7">
                        <div class="card-body p-4">
                            <!-- Encabezado -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="card-title mb-2 producto-detalle-title"><?= esc($producto['nombre']) ?></h1>

                                </div>
                                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary rounded-circle producto-detalle-close-btn">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            
                            <!-- Precio -->
                            <div class="mb-4">
                                <h2 class="text-primary fw-bold producto-detalle-precio">$<?= number_format($producto['precio'], 2) ?></h2>
                                <small class="text-success producto-detalle-disponible">
                                    <i class="fas fa-check-circle me-1"></i>Disponible
                                </small>
                            </div>
                            
                            <!-- Descripción -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 producto-detalle-section-title">Descripción</h5>
                                <p class="card-text producto-detalle-descripcion"><?= esc($producto['descripcion']) ?></p>
                            </div>
                            
                            <!-- Ingredientes -->
                            <?php if (!empty($producto['ingredientes'])): ?>
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 producto-detalle-section-title">Ingredientes</h5>
                                <ul class="list-group list-group-flush producto-detalle-ingredientes">
                                    <?php foreach (explode(',', $producto['ingredientes']) as $ingrediente): ?>
                                        <li class="list-group-item bg-transparent border-0 px-0 py-1 producto-detalle-ingrediente">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <?= trim($ingrediente) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Alergenos -->
                            <?php if (!empty($producto['alergenos'])): ?>
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3 producto-detalle-section-title">Alérgenos</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach (explode(',', $producto['alergenos']) as $alergeno): ?>
                                        <span class="badge producto-detalle-alergeno"><?= trim($alergeno) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            


                            <!-- Formulario para agregar al carrito -->
                            <div class="border-top pt-4 producto-detalle-form-section">
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="row g-3 align-items-center producto-detalle-form">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="tipo" value="producto">
                                    <div class="col-12 d-flex flex-column flex-md-row align-items-center mb-2 mb-md-0 justify-content-between">
                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                            <label class="form-label fw-bold me-3 mb-0 producto-detalle-cantidad-label">Cantidad</label>
                                            <button type="button" class="btn btn-outline-secondary quantity-btn producto-detalle-quantity-btn" onclick="cambiarCantidadTexto(this, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="cantidad-valor fw-bold mx-2 producto-detalle-cantidad-valor" style="font-size: 1.3rem; min-width: 32px; display: inline-block; text-align: center;">1</span>
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn producto-detalle-quantity-btn" onclick="cambiarCantidadTexto(this, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <span class="fw-bold text-success ms-md-3 mt-2 mt-md-0 text-md-end producto-detalle-subtotal" id="subtotalProducto">$<?= number_format($producto['precio'], 2) ?></span>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg btn-hover-effect w-100 producto-detalle-add-btn" id="btnAgregarCarrito">
                                            <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Productos relacionados -->
            <div class="mt-5">
                <h3 class="mb-4 fw-bold producto-detalle-relacionados-title">Productos relacionados</h3>
                <div class="row">
                    <?php foreach ($productosRelacionados as $relacionado): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card h-100 product-card shadow-sm producto-relacionado-card">
                            <div class="position-relative overflow-hidden">
                                <a href="<?= base_url('producto/' . $relacionado['id']) ?>">
                                    <?php if (!empty($relacionado['imagen'])): ?>
                                        <img src="<?= base_url('public/' . $relacionado['imagen']) ?>" class="card-img-top product-img producto-relacionado-img" alt="<?= esc($relacionado['nombre']) ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center producto-relacionado-placeholder" style="height: 160px;">
                                            <i class="fas fa-utensils fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success shadow-sm producto-relacionado-precio">$<?= number_format($relacionado['precio'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title producto-relacionado-title">
                                    <a href="<?= base_url('producto/' . $relacionado['id']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($relacionado['nombre']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small producto-relacionado-descripcion"><?= esc(substr($relacionado['descripcion'], 0, 60)) ?>...</p>
                                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-3">
                                    <input type="hidden" name="tipo" value="producto">
                                    <input type="hidden" name="id" value="<?= $relacionado['id'] ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary w-100 producto-relacionado-add-btn">
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

const precioUnitario = <?= json_encode($producto['precio']) ?>;
const precioTotalBtn = document.getElementById('precioTotalBtn');
const cantidadSpan = document.querySelector('.cantidad-valor');
function actualizarPrecioBtn() {
    const cantidad = parseInt(cantidadSpan.textContent) || 1;
    const total = precioUnitario * cantidad;
    if (document.getElementById('subtotalProducto')) {
        document.getElementById('subtotalProducto').textContent = '$' + total.toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
}

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
    actualizarPrecioBtn();
}

// Mostrar/ocultar textarea de notas
document.addEventListener('DOMContentLoaded', function() {
    actualizarPrecioBtn();
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
                    showToast('Producto agregado al carrito', 'success');
                    
                    // Actualizar contador del carrito en el navbar
                    const cartCount = document.querySelector('#cartLink .badge');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                    } else {
                        const cartLink = document.getElementById('cartLink');
                        if (cartLink) {
                            cartLink.innerHTML += `
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge-mobile">
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

/* Estilos para producto detalle */
.producto-detalle-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.producto-detalle-img {
    object-fit: cover;
    transition: transform 0.3s ease;
}

.producto-detalle-img:hover {
    transform: scale(1.05);
}

.producto-detalle-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-radius: 0 0 0 20px;
}

.producto-detalle-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 2.2rem;
    line-height: 1.2;
}

.producto-detalle-categoria {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    padding: 8px 16px;
    font-weight: 600;
}

.producto-detalle-close-btn {
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

.producto-detalle-close-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
}

.producto-detalle-precio {
    color: var(--accent-color);
    font-size: 2.5rem;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(72, 169, 166, 0.2);
}

.producto-detalle-disponible {
    color: var(--accent-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.producto-detalle-section-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.3rem;
    border-bottom: 2px solid var(--light-color);
    padding-bottom: 8px;
}

.producto-detalle-descripcion {
    color: #555;
    line-height: 1.6;
    font-size: 1.05rem;
}

.producto-detalle-ingredientes {
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 10px;
    padding: 15px;
}

.producto-detalle-ingrediente {
    color: #555;
    font-weight: 500;
    transition: all 0.3s ease;
}

.producto-detalle-ingrediente:hover {
    color: var(--primary-color);
    transform: translateX(5px);
}

.producto-detalle-alergeno {
    background: linear-gradient(135deg, var(--accent-red), #dc3545);
    color: white;
    border: none;
    padding: 6px 12px;
    font-weight: 600;
    font-size: 0.85rem;
}



.producto-detalle-form-section {
    border-top: 2px solid var(--light-color) !important;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 0 0 20px 20px;
    margin: 0 -1.5rem -1.5rem -1.5rem;
    padding: 1.5rem;
}

.producto-detalle-cantidad-label {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
}

.producto-detalle-quantity-btn {
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

.producto-detalle-quantity-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.1);
}

.producto-detalle-cantidad-valor {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.4rem;
}

.producto-detalle-subtotal {
    color: var(--accent-color);
    font-size: 1.3rem;
    font-weight: 800;
}

.producto-detalle-checkbox {
    width: 1.3em;
    height: 1.3em;
    border: 2px solid var(--primary-color);
    background-color: #fff;
    transition: all 0.3s ease;
}

.producto-detalle-checkbox:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.producto-detalle-checkbox-label {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.95rem;
}

.producto-detalle-notas {
    border: 2px solid var(--light-color);
    border-radius: 10px;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
}

.producto-detalle-notas:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(66, 129, 164, 0.25);
}

.producto-detalle-add-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.producto-detalle-add-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
    color: white;
}

.producto-detalle-relacionados-title {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.producto-detalle-relacionados-title::after {
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

.producto-relacionado-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.producto-relacionado-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.2);
}

.producto-relacionado-img {
    transition: transform 0.3s ease;
}

.producto-relacionado-card:hover .producto-relacionado-img {
    transform: scale(1.1);
}

.producto-relacionado-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
}

.producto-relacionado-precio {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    font-weight: 700;
    padding: 6px 12px;
    font-size: 0.9rem;
}

.producto-relacionado-title a {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.producto-relacionado-title a:hover {
    color: var(--accent-color);
}

.producto-relacionado-descripcion {
    color: #666;
    line-height: 1.4;
}

.producto-relacionado-add-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.2);
}

.producto-relacionado-add-btn:hover {
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
    .producto-detalle-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .producto-detalle-title {
        font-size: 1.8rem;
    }
    
    .producto-detalle-precio {
        font-size: 2rem;
    }
    
    .producto-detalle-section-title {
        font-size: 1.1rem;
    }
    
    .producto-detalle-descripcion {
        font-size: 1rem;
    }
    
    .producto-detalle-form-section {
        padding: 1rem;
        margin: 0 -1rem -1rem -1rem;
        border-radius: 0 0 15px 15px;
    }
    
    .producto-detalle-cantidad-label {
        font-size: 1rem;
    }
    
    .producto-detalle-quantity-btn {
        width: 35px;
        height: 35px;
    }
    
    .producto-detalle-cantidad-valor {
        font-size: 1.2rem;
    }
    
    .producto-detalle-subtotal {
        font-size: 1.1rem;
    }
    
    .producto-detalle-add-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .producto-detalle-relacionados-title {
        font-size: 1.5rem;
    }
    
    .producto-relacionado-title a {
        font-size: 1rem;
    }
    
    .producto-relacionado-add-btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 8px;
    }
}

@media (max-width: 576px) {
    .producto-detalle-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .producto-detalle-title {
        font-size: 1.5rem;
    }
    
    .producto-detalle-precio {
        font-size: 1.8rem;
    }
    
    .producto-detalle-section-title {
        font-size: 1rem;
    }
    
    .producto-detalle-descripcion {
        font-size: 0.9rem;
    }
    
    .producto-detalle-form-section {
        padding: 0.75rem;
        margin: 0 -0.75rem -0.75rem -0.75rem;
        border-radius: 0 0 12px 12px;
    }
    
    .producto-detalle-cantidad-label {
        font-size: 0.9rem;
    }
    
    .producto-detalle-quantity-btn {
        width: 30px;
        height: 30px;
    }
    
    .producto-detalle-cantidad-valor {
        font-size: 1.1rem;
    }
    
    .producto-detalle-subtotal {
        font-size: 1rem;
    }
    
    .producto-detalle-add-btn {
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .producto-detalle-relacionados-title {
        font-size: 1.3rem;
    }
    
    .producto-relacionado-title a {
        font-size: 0.9rem;
    }
    
    .producto-relacionado-add-btn {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
    }
    
    /* Hide close button on mobile devices */
    .producto-detalle-close-btn {
        display: none !important;
    }
}
</style>