<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">
                    <i class="fas fa-shopping-cart me-3 text-primary"></i>Mi Carrito
                </h1>
                <div>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-modern">
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
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">Agrega algunos productos deliciosos para comenzar tu pedido</p>
                        <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg btn-modern">
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Productos en tu carrito
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($carrito as $item): ?>
                            <div class="card mb-3 order-card" style="border-left-color: #007bff;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <?php if (!empty($item['imagen'])): ?>
                                                <img src="<?= base_url('public/' . $item['imagen']) ?>" class="img-fluid rounded product-img" alt="<?= esc($item['nombre']) ?>">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                                    <i class="fas fa-utensils fa-2x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <h6 class="mb-1"><?= esc($item['nombre']) ?></h6>
                                            <p class="text-muted mb-0 small">
                                                <?php if ($item['tipo'] === 'combo'): ?>
                                                    <i class="fas fa-box me-1 text-success"></i>Combo
                                                <?php else: ?>
                                                    <i class="fas fa-utensils me-1 text-primary"></i>Producto
                                                <?php endif; ?>
                                            </p>
                                            <?php if (!empty($item['descripcion'])): ?>
                                                <small class="text-muted"><?= esc($item['descripcion']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" onclick="cambiarCantidad(<?= $item['id'] ?>, <?= $item['tipo'] ?>, -1)">-</button>
                                                <input type="number" class="form-control text-center" value="<?= $item['cantidad'] ?>" min="1" style="width: 60px;" readonly>
                                                <button class="btn btn-outline-secondary" onclick="cambiarCantidad(<?= $item['id'] ?>, '<?= $item['tipo'] ?>', 1)">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="fw-bold text-success">$<?= number_format($item['precio'], 0, ',', '.') ?></span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="fw-bold">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <a href="<?= base_url('carrito/eliminar/' . $item['tipo'] . '/' . $item['id']) ?>" 
                                               class="btn btn-outline-danger btn-sm btn-modern" 
                                               onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
                               class="btn btn-outline-danger btn-modern" 
                               onclick="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                                <i class="fas fa-trash me-2"></i>Vaciar Carrito
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-primary btn-modern">
                                <i class="fas fa-plus me-2"></i>Agregar Más Productos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen del pedido -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Resumen del Pedido
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
                            <a href="<?= base_url('checkout/formulario') ?>" class="btn btn-primary btn-lg btn-modern">
                                <i class="fas fa-credit-card me-2"></i>Confirmar Pedido
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                El tiempo estimado de entrega es de 30-45 minutos
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function cambiarCantidad(id, tipo, cambio) {
    // Obtener la cantidad actual del input
    const input = event.target.parentNode.querySelector('input');
    const cantidadActual = parseInt(input.value);
    const nuevaCantidad = cantidadActual + cambio;
    
    if (nuevaCantidad < 1) {
        alert('La cantidad mínima es 1');
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
            location.reload();
        } else if (data) {
            alert('Error al actualizar cantidad: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload(); // Recargar en caso de error
    });
}

// Animación de hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.order-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script> 