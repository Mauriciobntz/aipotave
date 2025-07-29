<div class="container-fluid mt-5 pt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0 display-5 fw-bold">
                    <i class="fas fa-shopping-cart me-3 text-primary"></i>Mi Carrito
                </h1>
                <div>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-hover-effect">
                        <i class="fas fa-arrow-left me-2"></i>Seguir Comprando
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($carrito)): ?>
        <!-- Carrito vacío -->
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="empty-cart-icon mb-4">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                            <div class="cart-cross animate__animated animate__fadeIn"></div>
                        </div>
                        <h3 class="text-muted mb-3">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">Agrega algunos productos deliciosos para comenzar tu pedido</p>
                        <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg btn-hover-effect">
                            <i class="fas fa-utensils me-2"></i>Ver Menú
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Lista de productos -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-list me-2 text-primary"></i>Productos en tu carrito (<?= count($carrito) ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($carrito as $item): ?>
                            <div class="card mb-3 cart-item-card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <?php if (!empty($item['imagen'])): ?>
                                                <img src="<?= base_url('public/' . $item['imagen']) ?>" class="img-fluid rounded product-img" alt="<?= esc($item['nombre']) ?>">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px; width: 80px;">
                                                    <i class="fas fa-utensils fa-2x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1 fw-bold"><?= esc($item['nombre']) ?></h6>
                                            <p class="text-muted mb-0 small">
                                                <?php if ($item['tipo'] === 'combo'): ?>
                                                    <span class="badge bg-success me-1"><i class="fas fa-box me-1"></i>Combo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary me-1"><i class="fas fa-utensils me-1"></i>Producto</span>
                                                <?php endif; ?>
                                            </p>
                                            <?php if (!empty($item['descripcion'])): ?>
                                                <small class="text-muted d-block mt-1"><?= esc($item['descripcion']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control text-center" value="<?= $item['cantidad'] ?>" min="1" style="width: 60px;" readonly>
                                                <button class="btn btn-outline-secondary quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="fw-bold text-success">$<?= number_format($item['precio'], 0, ',', '.') ?></span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <a href="<?= base_url('carrito/eliminar/' . $item['tipo'] . '/' . $item['id']) ?>" 
                                               class="btn btn-outline-danger btn-sm btn-hover-effect" 
                                               onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')"
                                               data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="fw-bold">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Acciones del carrito -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('carrito/vaciar') ?>" 
                               class="btn btn-outline-danger btn-hover-effect" 
                               onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                                <i class="fas fa-trash me-2"></i>Vaciar Carrito
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-hover-effect">
                                <i class="fas fa-plus me-2"></i>Agregar Más Productos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-receipt me-2 text-primary"></i>Resumen del Pedido
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted">Subtotal:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold">$<?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted">Envío:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold text-success">$<?= number_format($envio, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted">Descuento:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold text-danger">$0</span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <span class="fw-bold fs-5">Total:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold fs-5 text-primary">$<?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('checkout/formulario') ?>" class="btn btn-primary btn-lg btn-hover-effect">
                                <i class="fas fa-credit-card me-2"></i>Continuar al Pago
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>El tiempo estimado de entrega es de 30-45 minutos</small>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-shield-alt me-2"></i>
                                <small>Compra segura con encriptación SSL</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function cambiarCantidad(id, tipo, cambio) {
    // Mostrar spinner de carga
    const btn = event.target;
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<span class="loading-spinner"></span>';
    btn.disabled = true;
    
    // Obtener la cantidad actual del input
    const input = btn.parentNode.parentNode.querySelector('input');
    const cantidadActual = parseInt(input.value);
    const nuevaCantidad = cantidadActual + cambio;
    
    if (nuevaCantidad < 1) {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        showToast('La cantidad mínima es 1', 'warning');
        return;
    }
    
    const formData = new FormData();
    formData.append('id', id);
    formData.append('tipo', tipo);
    formData.append('cantidad', nuevaCantidad);
    
    fetch('<?= base_url('carrito/actualizar-cantidad') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
        } else {
            return response.json();
        }
    })
    .then(data => {
        if (data && data.success) {
            // Actualizar el input con la nueva cantidad
            input.value = nuevaCantidad;
            
            // Actualizar el subtotal del producto
            const precioUnitario = parseFloat(data.precio);
            const subtotalProducto = precioUnitario * nuevaCantidad;
            const subtotalElement = btn.closest('.row').querySelectorAll('span.fw-bold')[1];
            if (subtotalElement) {
                subtotalElement.textContent = '$' + subtotalProducto.toLocaleString('es-AR');
            }
            // Actualizar los totales en el resumen
            const resumenSubtotal = document.querySelector('.resumen-subtotal');
            if (resumenSubtotal) {
                resumenSubtotal.textContent = '$' + data.subtotal.toLocaleString('es-AR');
            }
            const resumenTotal = document.querySelector('.resumen-total');
            if (resumenTotal) {
                resumenTotal.textContent = '$' + data.total.toLocaleString('es-AR');
            }
            // Mostrar notificación
            showToast('Cantidad actualizada', 'success');
        } else if (data) {
            showToast('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error al actualizar la cantidad', 'danger');
    })
    .finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
    });
}

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

// Animación de hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Efecto de hover para las cards de producto
    const cards = document.querySelectorAll('.cart-item-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<style>
.empty-cart-icon {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.cart-cross {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    transform: translate(-50%, -50%);
}

.cart-cross:before, .cart-cross:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 4px;
    background-color: #ff6b6b;
    border-radius: 2px;
}

.cart-cross:before {
    transform: translate(-50%, -50%) rotate(45deg);
}

.cart-cross:after {
    transform: translate(-50%, -50%) rotate(-45deg);
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
</style>