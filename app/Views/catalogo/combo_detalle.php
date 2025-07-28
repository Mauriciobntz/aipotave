<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 mt-4 border-success">
                <?php if ($combo['imagen']): ?>
                    <img src="<?= esc($combo['imagen']) ?>" class="card-img-top" alt="<?= esc($combo['nombre']) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h2 class="card-title text-success"><?= esc($combo['nombre']) ?></h2>
                    <h4 class="text-success mb-3">$<?= number_format($combo['precio'], 2) ?></h4>
                    <p class="card-text"><?= esc($combo['descripcion']) ?></p>
                    <h5 class="mt-4">Incluye:</h5>
                    <ul class="list-group mb-3">
                        <?php foreach ($productos as $prod): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= esc($prod['nombre']) ?>
                                <span class="badge bg-primary rounded-pill">x<?= esc($prod['cantidad']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?= base_url('/') ?>" class="btn btn-secondary">Volver al menú</a>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="d-inline ms-2">
                        <input type="hidden" name="id" value="<?= $combo['id'] ?>">
                        <input type="hidden" name="tipo" value="combo">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn btn-warning">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 