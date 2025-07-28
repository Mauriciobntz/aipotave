<div class="container-fluid mt-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-primary mb-3">
                <i class="fas fa-utensils me-3"></i>Nuestro Menú
            </h1>
            <p class="lead text-muted">Descubre nuestros platos más populares y especialidades del día</p>
        </div>
    </div>

    <!-- Comidas -->
    <?php if (!empty($comidas)): ?>
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-hamburger me-2 text-warning"></i>Platos Principales
            </h2>
        </div>
        <?php foreach ($comidas as $comida): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 product-card order-card" style="border-left-color: #ffc107;">
                <div class="position-relative">
                    <?php if (!empty($comida['imagen'])): ?>
                        <img src="<?= base_url('public/' . $comida['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($comida['nombre']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-utensils fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success">$<?= number_format($comida['precio'], 0, ',', '.') ?></span>
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
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, -1)">-</button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, 1)">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-modern">
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
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-star me-2 text-warning"></i>Especiales del Día
            </h2>
        </div>
        <?php foreach ($viandas as $vianda): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 product-card order-card" style="border-left-color: #dc3545;">
                <div class="position-relative">
                    <?php if (!empty($vianda['imagen'])): ?>
                        <img src="<?= base_url('public/' . $vianda['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($vianda['nombre']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-star fa-3x text-warning"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-danger">$<?= number_format($vianda['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-warning text-dark">Especial</span>
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
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, -1)">-</button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, 1)">+</button>
                            </div>
                            <button type="submit" class="btn btn-danger btn-modern">
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
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-glass-whiskey me-2 text-info"></i>Bebidas
            </h2>
        </div>
        <?php foreach ($bebidas as $bebida): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 product-card order-card" style="border-left-color: #17a2b8;">
                <div class="position-relative">
                    <?php if (!empty($bebida['imagen'])): ?>
                        <img src="<?= base_url('public/' . $bebida['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($bebida['nombre']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-glass-whiskey fa-3x text-info"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-info">$<?= number_format($bebida['precio'], 0, ',', '.') ?></span>
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
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, -1)">-</button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, 1)">+</button>
                            </div>
                            <button type="submit" class="btn btn-info btn-modern">
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
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-box me-2 text-success"></i>Combos Especiales
            </h2>
        </div>
        <?php foreach ($combos as $combo): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 product-card order-card" style="border-left-color: #28a745;">
                <div class="position-relative">
                    <?php if (!empty($combo['imagen'])): ?>
                        <img src="<?= esc($combo['imagen']) ?>" class="card-img-top product-img" alt="<?= esc($combo['nombre']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-box fa-3x text-success"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-success">$<?= number_format($combo['precio'], 0, ',', '.') ?></span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-success">Combo</span>
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
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, -1)">-</button>
                                <input type="number" name="cantidad" value="1" min="1" class="form-control text-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(this, 1)">+</button>
                            </div>
                            <button type="submit" class="btn btn-success btn-modern">
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
    <div class="row mt-5">
        <div class="col-12 text-center">
            <div class="card bg-primary text-white">
                <div class="card-body py-5">
                    <h3 class="mb-3">
                        <i class="fas fa-shopping-cart me-3"></i>¿Listo para ordenar?
                    </h3>
                    <p class="lead mb-4">Revisa tu carrito y completa tu pedido</p>
                    <a href="<?= base_url('carrito') ?>" class="btn btn-light btn-lg btn-modern">
                        <i class="fas fa-shopping-cart me-2"></i>Ver Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function cambiarCantidad(button, cambio) {
    const input = button.parentNode.querySelector('input');
    const nuevoValor = parseInt(input.value) + cambio;
    if (nuevoValor >= 1) {
        input.value = nuevoValor;
    }
}

// Animación de hover para las cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.product-card');
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