<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 mt-4">
                <?php if ($producto['imagen']): ?>
                    <img src="<?= base_url('public/' . $producto['imagen']) ?>" class="card-img-top" alt="<?= esc($producto['nombre']) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h2 class="card-title"><?= esc($producto['nombre']) ?></h2>
                    <h4 class="text-primary mb-3">$<?= number_format($producto['precio'], 2) ?></h4>
                    <p class="card-text"><?= esc($producto['descripcion']) ?></p>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary">Volver al menú</a>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="d-inline ms-2">
                        <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn btn-success">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 