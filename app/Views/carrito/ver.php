<div class="container-fluid mt-5 pt-5 mb-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <h1 class="mb-0 display-5 fw-bold carrito-titulo">
                    <i class="fas fa-shopping-cart me-3 text-primary"></i>Mi Carrito
                </h1>
                <div class="mt-3 mt-md-0">
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-hover-effect carrito-seguir-btn">
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
                <div class="card text-center py-5 border-0 shadow-sm carrito-vacio-card">
                    <div class="card-body">
                        <div class="empty-cart-icon mb-4 carrito-vacio-icon">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                            <div class="cart-cross animate__animated animate__fadeIn carrito-vacio-cruz"></div>
                        </div>
                        <h3 class="text-muted mb-3 carrito-vacio-titulo">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4 carrito-vacio-subtitulo">Agrega algunos productos deliciosos para comenzar tu pedido</p>
                        <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg btn-hover-effect carrito-vacio-btn">
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
                <div class="card shadow-sm carrito-lista-card">
                    <div class="card-header bg-white carrito-lista-header">
                        <h5 class="mb-0 fw-bold carrito-lista-titulo">
                            <i class="fas fa-list me-2 text-primary"></i>Productos en tu carrito (<?= count($carrito) ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($carrito as $item): ?>
                            <div class="card mb-3 cart-item-card border-0 shadow-sm carrito-item-card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <!-- Desktop Layout -->
                                        <div class="d-none d-md-block">
                                            <div class="row align-items-center">
                                                <!-- Imagen del producto -->
                                                <div class="col-2">
                                                    <?php if (!empty($item['imagen'])): ?>
                                                        <img src="<?= base_url('public/' . $item['imagen']) ?>" class="img-fluid rounded product-img carrito-item-img" alt="<?= esc($item['nombre']) ?>">
                                                    <?php else: ?>
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center carrito-item-placeholder" style="height: 80px; width: 80px;">
                                                            <i class="fas fa-utensils fa-2x text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Información del producto -->
                                                <div class="col-3">
                                                    <h6 class="mb-1 fw-bold carrito-item-nombre"><?= esc($item['nombre']) ?></h6>
                                                    <p class="text-muted mb-0 small carrito-item-tipo">
                                                        <?php if ($item['tipo'] === 'combo'): ?>
                                                            <span class="badge bg-success me-1 carrito-item-badge-combo"><i class="fas fa-box me-1"></i>Combo</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-primary me-1 carrito-item-badge-producto"><i class="fas fa-utensils me-1"></i>Producto</span>
                                                        <?php endif; ?>
                                                    </p>
                                                    <?php if (!empty($item['descripcion'])): ?>
                                                        <small class="text-muted d-block mt-1 carrito-item-descripcion"><?= esc($item['descripcion']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Precio unitario -->
                                                <div class="col-2 text-center">
                                                    <span class="fw-bold text-success carrito-item-precio-unitario">$<?= number_format($item['precio'], 0, ',', '.') ?></span>
                                                </div>
                                                
                                                <!-- Controles de cantidad -->
                                                <div class="col-2 text-center">
                                                    <div class="input-group input-group-sm justify-content-center carrito-cantidad-controls">
                                                        <button class="btn btn-outline-secondary quantity-btn carrito-quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', -1)">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <span class="form-control text-center carrito-cantidad-display" style="width: 60px; border: 2px solid var(--light-color); background: white; font-weight: 700; color: var(--primary-color);"><?= $item['cantidad'] ?></span>
                                                        <button class="btn btn-outline-secondary quantity-btn carrito-quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', 1)">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Subtotal -->
                                                <div class="col-2 text-center">
                                                    <span class="fw-bold carrito-item-subtotal">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
                                                </div>
                                                
                                                <!-- Botón eliminar -->
                                                <div class="col-1 text-center">
                                                    <a href="<?= base_url('carrito/eliminar/' . $item['tipo'] . '/' . $item['id']) ?>"
                                                       class="btn btn-link text-danger p-0 m-0 carrito-eliminar-btn"
                                                       onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')"
                                                       data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Mobile Layout - Nuevo diseño optimizado -->
                                        <div class="d-md-none">
                                            <div class="mobile-cart-item">
                                                <!-- Header: Imagen y Nombre -->
                                                <div class="mobile-cart-header">
                                                    <div class="mobile-cart-image">
                                                        <?php if (!empty($item['imagen'])): ?>
                                                            <img src="<?= base_url('public/' . $item['imagen']) ?>" class="img-fluid rounded" alt="<?= esc($item['nombre']) ?>">
                                                        <?php else: ?>
                                                            <div class="mobile-placeholder">
                                                                <i class="fas fa-utensils"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="mobile-cart-info">
                                                        <h6 class="mobile-cart-title"><?= esc($item['nombre']) ?></h6>
                                                        <div class="mobile-cart-badge">
                                                            <?php if ($item['tipo'] === 'combo'): ?>
                                                                <span class="badge bg-success"><i class="fas fa-box me-1"></i>Combo</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-primary"><i class="fas fa-utensils me-1"></i>Producto</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Precios -->
                                                <div class="mobile-cart-prices">
                                                    <div class="mobile-price-item">
                                                        <span class="mobile-price-label">Precio:</span>
                                                        <span class="mobile-price-value">$<?= number_format($item['precio'], 0, ',', '.') ?></span>
                                                    </div>
                                                    <div class="mobile-price-item">
                                                        <span class="mobile-price-label">Total:</span>
                                                        <span class="mobile-total-value">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Controles -->
                                                <div class="mobile-cart-controls">
                                                    <div class="mobile-quantity-controls">
                                                        <span class="mobile-quantity-label">Cantidad:</span>
                                                        <div class="mobile-quantity-buttons">
                                                            <button class="mobile-quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <span class="mobile-quantity-display"><?= $item['cantidad'] ?></span>
                                                            <button class="mobile-quantity-btn" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="mobile-action-controls">
                                                        <a href="<?= base_url('carrito/eliminar/' . $item['tipo'] . '/' . $item['id']) ?>"
                                                           class="mobile-delete-btn"
                                                           onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Eliminar</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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
                        <div class="d-flex flex-column flex-md-row justify-content-between carrito-acciones">
                            <a href="<?= base_url('carrito/vaciar') ?>" 
                               class="btn btn-outline-danger btn-hover-effect carrito-vaciar-btn mb-2 mb-md-0" 
                               onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                                <i class="fas fa-trash me-2"></i>Vaciar Carrito
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-hover-effect carrito-agregar-btn">
                                <i class="fas fa-plus me-2"></i>Agregar Más Productos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top carrito-resumen-card" style="top: 20px;">
                    <div class="card-header bg-white carrito-resumen-header">
                        <h5 class="mb-0 fw-bold carrito-resumen-titulo">
                            <i class="fas fa-receipt me-2 text-primary"></i>Resumen del Pedido
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <span class="text-muted carrito-resumen-label">Subtotal:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold resumen-subtotal carrito-resumen-subtotal">$<?= number_format($subtotal, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    El costo de envío se calculará al ingresar tu dirección
                                </small>
                            </div>
                        </div>
                        
                        <hr class="carrito-resumen-divider">
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <span class="fw-bold fs-5 carrito-resumen-total-label">Total:</span>
                            </div>
                            <div class="col-6 text-end">
                                <span class="fw-bold fs-5 text-primary resumen-total carrito-resumen-total">$<?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('checkout/formulario') ?>" class="btn btn-primary btn-lg btn-hover-effect carrito-continuar-btn">
                                <i class="fas fa-credit-card me-2"></i>Continuar con el Pedido
                            </a>
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
    
    // Obtener la cantidad actual del span (buscar tanto en desktop como en mobile)
    const span = btn.parentNode.parentNode.querySelector('.carrito-cantidad-display') || 
                 btn.parentNode.parentNode.querySelector('.mobile-quantity-display');
    const cantidadActual = parseInt(span.textContent);
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
            // Actualizar el span con la nueva cantidad
            span.textContent = nuevaCantidad;
            
            // Actualizar el subtotal del producto (buscar tanto en desktop como en mobile)
            const precioUnitario = parseFloat(data.precio);
            const subtotalProducto = precioUnitario * nuevaCantidad;
            
            // Buscar elementos de subtotal en desktop y mobile
            const subtotalElement = btn.closest('.row').querySelectorAll('span.fw-bold')[1] ||
                                  btn.closest('.mobile-cart-item').querySelector('.mobile-total-value');
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
            // Mostrar notificación usando la función existente
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

// Animación de hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Efecto de hover optimizado para las cards de producto
    const cards = document.querySelectorAll('.cart-item-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) translateZ(0)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) translateZ(0)';
        });
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

/* Optimización de animaciones para mejor rendimiento */
.cart-item-card {
    will-change: transform;
    transform: translateZ(0); /* Force hardware acceleration */
    backface-visibility: hidden;
    perspective: 1000px;
}

.carrito-vacio-cruz {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    transform: translate(-50%, -50%) translateZ(0); /* Force hardware acceleration */
    will-change: transform;
    backface-visibility: hidden;
}

/* Optimización de animaciones CSS */
.animate__animated {
    will-change: transform, opacity;
    backface-visibility: hidden;
    transform: translateZ(0);
}

         /* Reducir la duración de las animaciones para mejor respuesta */
         .animate__fadeIn {
             animation-duration: 0.3s !important; /* Reducir de 0.6s a 0.3s */
             animation-delay: 0.05s !important; /* Reducir el delay inicial de 0.1s a 0.05s */
         }

/* Optimizar la carga de animaciones */
@media (prefers-reduced-motion: reduce) {
    .animate__animated {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

         /* Optimizar transiciones hover */
         .carrito-item-card {
             transition: transform 0.1s cubic-bezier(0.4, 0, 0.2, 1);
             will-change: transform;
             transform: translateZ(0);
         }

/* Estilos para carrito */
.carrito-titulo {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 2.5rem;
    text-shadow: 0 2px 4px rgba(66, 129, 164, 0.2);
}

         .carrito-seguir-btn {
             background: linear-gradient(135deg, var(--light-color), #f8f9fa);
             border: 2px solid var(--primary-color);
             color: var(--primary-color);
             font-weight: 600;
             padding: 10px 20px;
             border-radius: 10px;
             transition: all 0.15s ease;
             will-change: transform;
             transform: translateZ(0);
         }

         .carrito-seguir-btn:hover {
             background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
             color: white;
             transform: translateY(-2px) translateZ(0);
             box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
         }

.carrito-vacio-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
}

.carrito-vacio-icon {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.carrito-vacio-cruz:before, .carrito-vacio-cruz:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, var(--accent-red), #ff6b6b);
    border-radius: 2px;
}

.carrito-vacio-cruz:before {
    transform: translate(-50%, -50%) rotate(45deg);
}

.carrito-vacio-cruz:after {
    transform: translate(-50%, -50%) rotate(-45deg);
}

.carrito-vacio-titulo {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.8rem;
}

.carrito-vacio-subtitulo {
    color: #666;
    font-size: 1.1rem;
    font-weight: 500;
}

.carrito-vacio-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 30px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.carrito-vacio-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
    color: white;
}

.carrito-lista-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    overflow: hidden;
}

.carrito-lista-header {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-bottom: 2px solid var(--primary-color);
}

.carrito-lista-titulo {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.3rem;
}

.carrito-item-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.05), rgba(212, 180, 131, 0.05));
}

.carrito-item-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.2);
}

.carrito-item-img {
    transition: transform 0.3s ease;
    border-radius: 8px;
}

.carrito-item-card:hover .carrito-item-img {
    transform: scale(1.05);
}

.carrito-item-placeholder {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-radius: 8px;
}

.carrito-item-nombre {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.1rem;
    line-height: 1.3;
}

.carrito-item-badge-combo {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    color: white;
    border: none;
    font-weight: 600;
    padding: 4px 8px;
    font-size: 0.8rem;
}

.carrito-item-badge-producto {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    border: none;
    font-weight: 600;
    padding: 4px 8px;
    font-size: 0.8rem;
}

.carrito-item-descripcion {
    color: #666;
    line-height: 1.4;
    font-size: 0.85rem;
}

.carrito-cantidad-controls {
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 8px;
    padding: 2px;
}

.carrito-quantity-btn {
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

.carrito-quantity-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: scale(1.05);
}

.carrito-cantidad-input {
    border: 2px solid var(--light-color);
    border-radius: 6px;
    transition: all 0.3s ease;
    background: white;
    font-weight: 700;
    color: var(--primary-color);
    text-align: center;
}

.carrito-cantidad-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(66, 129, 164, 0.25);
}

.carrito-cantidad-display {
    border: 2px solid var(--light-color);
    border-radius: 6px;
    background: white;
    font-weight: 700;
    color: var(--primary-color);
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 32px;
}

.carrito-item-precio-unitario {
    color: var(--accent-color);
    font-size: 1.1rem;
    font-weight: 700;
}

.carrito-item-subtotal {
    color: var(--primary-color);
    font-size: 1.2rem;
    font-weight: 800;
}

.carrito-eliminar-btn {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--accent-red);
    color: var(--accent-red);
    transition: all 0.3s ease;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carrito-eliminar-btn:hover {
    background: linear-gradient(135deg, var(--accent-red), #dc3545);
    color: white;
    transform: scale(1.1);
}

.carrito-acciones {
    background: linear-gradient(135deg, rgba(228, 223, 218, 0.1), rgba(212, 180, 131, 0.1));
    border-radius: 12px;
    padding: 15px;
}

.carrito-vaciar-btn {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--accent-red);
    color: var(--accent-red);
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.carrito-vaciar-btn:hover {
    background: linear-gradient(135deg, var(--accent-red), #dc3545);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(193, 102, 107, 0.3);
}

.carrito-agregar-btn {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.carrito-agregar-btn:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.carrito-resumen-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(66, 129, 164, 0.1);
    overflow: hidden;
}

.carrito-resumen-header {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-bottom: 2px solid var(--primary-color);
}

.carrito-resumen-titulo {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.3rem;
}

.carrito-resumen-label {
    color: #666;
    font-weight: 600;
    font-size: 1rem;
}

.carrito-resumen-subtotal {
    color: var(--accent-color);
    font-size: 1.1rem;
    font-weight: 700;
}

.carrito-resumen-divider {
    border-top: 2px solid var(--light-color);
    margin: 1rem 0;
}

.carrito-resumen-total-label {
    color: var(--primary-color);
    font-weight: 800;
}

.carrito-resumen-total {
    color: var(--accent-color);
    font-weight: 800;
    font-size: 1.5rem;
}

.carrito-continuar-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
}

.carrito-continuar-btn:hover {
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(66, 129, 164, 0.4);
    color: white;
}

/* Estilos existentes mejorados */
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

/* Responsive */
@media (max-width: 768px) {
    .carrito-titulo {
        font-size: 2rem;
    }
    
    .carrito-seguir-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
        border-radius: 8px;
    }
    
    .carrito-vacio-titulo {
        font-size: 1.5rem;
    }
    
    .carrito-vacio-subtitulo {
        font-size: 1rem;
    }
    
    .carrito-vacio-btn {
        padding: 10px 24px;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .carrito-lista-titulo {
        font-size: 1.1rem;
    }
    
    .carrito-item-nombre {
        font-size: 1rem;
    }
    
    .carrito-item-descripcion {
        font-size: 0.8rem;
    }
    
    .carrito-quantity-btn {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }
    
    .carrito-cantidad-input {
        font-size: 0.9rem;
    }
    
    .carrito-item-precio-unitario {
        font-size: 1rem;
    }
    
    .carrito-item-subtotal {
        font-size: 1.1rem;
    }
    
    .carrito-eliminar-btn {
        width: 32px;
        height: 32px;
    }
    
    .carrito-vaciar-btn,
    .carrito-agregar-btn {
        padding: 8px 16px;
        font-size: 0.9rem;
        border-radius: 8px;
    }
    
    .carrito-resumen-titulo {
        font-size: 1.1rem;
    }
    
    .carrito-resumen-label {
        font-size: 0.9rem;
    }
    
    .carrito-resumen-subtotal {
        font-size: 1rem;
    }
    
    .carrito-resumen-total {
        font-size: 1.3rem;
    }
    
    .carrito-continuar-btn {
        padding: 10px 20px;
        font-size: 0.9rem;
        border-radius: 12px;
    }
}

@media (max-width: 576px) {
    .carrito-titulo {
        font-size: 1.8rem;
    }
    
    .carrito-seguir-btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    
    .carrito-vacio-titulo {
        font-size: 1.3rem;
    }
    
    .carrito-vacio-subtitulo {
        font-size: 0.9rem;
    }
    
    .carrito-vacio-btn {
        padding: 8px 20px;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .carrito-lista-titulo {
        font-size: 1rem;
    }
    
    .carrito-item-nombre {
        font-size: 0.9rem;
    }
    
    .carrito-item-descripcion {
        font-size: 0.75rem;
    }
    
    .carrito-quantity-btn {
        width: 24px;
        height: 24px;
        font-size: 0.7rem;
    }
    
    .carrito-cantidad-input {
        font-size: 0.8rem;
    }
    
    .carrito-item-precio-unitario {
        font-size: 0.9rem;
    }
    
    .carrito-item-subtotal {
        font-size: 1rem;
    }
    
    .carrito-eliminar-btn {
        width: 28px;
        height: 28px;
    }
    
    .carrito-vaciar-btn,
    .carrito-agregar-btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    
    .carrito-resumen-titulo {
        font-size: 1rem;
    }
    
    .carrito-resumen-label {
        font-size: 0.85rem;
    }
    
    .carrito-resumen-subtotal {
        font-size: 0.9rem;
    }
    
    .carrito-resumen-total {
        font-size: 1.2rem;
    }
    
    .carrito-continuar-btn {
        padding: 8px 16px;
        font-size: 0.85rem;
        border-radius: 10px;
    }
}

/* Estilos específicos para móviles */
@media (max-width: 767.98px) {
    .carrito-item-card {
        margin-bottom: 1rem;
        border-radius: 15px;
    }
    
    .carrito-item-card .card-body {
        padding: 1rem;
    }
    
    .carrito-item-img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .carrito-item-placeholder {
        width: 100% !important;
        height: 80px !important;
        border-radius: 10px;
    }
    
    .carrito-item-nombre {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .carrito-item-tipo {
        margin-bottom: 0.5rem;
    }
    
    .carrito-item-descripcion {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    .carrito-cantidad-controls {
        margin: 0.5rem 0;
        justify-content: center;
    }
    
    .carrito-quantity-btn {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .carrito-cantidad-input {
        width: 70px !important;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .carrito-cantidad-display {
        width: 70px !important;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .carrito-item-precio-unitario,
    .carrito-item-subtotal {
        font-size: 1rem;
        display: block;
        margin-bottom: 0.25rem;
    }
    
    .carrito-eliminar-btn {
        width: 40px;
        height: 40px;
        margin: 0.5rem auto;
        display: block;
    }
    
    /* Mejorar espaciado en móviles */
    .carrito-item-card .row > div {
        margin-bottom: 0.5rem;
    }
    
    .carrito-item-card .row > div:last-child {
        margin-bottom: 0;
    }
    
    /* Etiquetas para móviles */
    .form-label.small.text-muted {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary-color) !important;
        margin-bottom: 0.25rem;
    }
}

        /* Estilos para el nuevo diseño móvil */
        .mobile-cart-item {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
        }

        .mobile-cart-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            gap: 12px;
        }

        .mobile-cart-image {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
        }

        .mobile-cart-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .mobile-placeholder {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 20px;
        }

        .mobile-cart-info {
            flex: 1;
            min-width: 0;
        }

        .mobile-cart-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 4px 0;
            color: #212529;
            line-height: 1.3;
        }

        .mobile-cart-badge {
            margin-top: 4px;
        }

        .mobile-cart-badge .badge {
            font-size: 11px;
            padding: 4px 8px;
        }

        .mobile-cart-prices {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .mobile-price-item {
            text-align: center;
            flex: 1;
        }

        .mobile-price-label {
            display: block;
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .mobile-price-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #28a745;
        }

        .mobile-total-value {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: #212529;
        }

        .mobile-cart-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .mobile-quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mobile-quantity-label {
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            white-space: nowrap;
        }

        .mobile-quantity-buttons {
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .mobile-quantity-btn {
            background: #f8f9fa;
            border: none;
            padding: 8px 12px;
            color: #495057;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mobile-quantity-btn:hover {
            background: #e9ecef;
            color: #212529;
        }

        .mobile-quantity-btn:active {
            background: #dee2e6;
        }

        .mobile-quantity-display {
            background: white;
            padding: 8px 12px;
            font-weight: 700;
            color: #495057;
            font-size: 14px;
            min-width: 40px;
            text-align: center;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }

        .mobile-action-controls {
            flex-shrink: 0;
        }

        .mobile-delete-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .mobile-delete-btn:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
        }

        .mobile-delete-btn:active {
            background: #bd2130;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .mobile-cart-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .mobile-quantity-controls {
                justify-content: center;
            }

            .mobile-action-controls {
                text-align: center;
            }

            .mobile-delete-btn {
                justify-content: center;
            }
        }

        @media (max-width: 360px) {
            .mobile-cart-header {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .mobile-cart-image {
                width: 80px;
                height: 80px;
            }

            .mobile-cart-prices {
                flex-direction: column;
                gap: 8px;
            }
        }
</style>