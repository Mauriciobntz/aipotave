<div class="container mt-5">
    <h1 class="mb-4">Stock de Vianda</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Vianda: <?= esc($vianda['nombre']) ?></h5>
            <form method="get" action="<?= base_url('admin/viandas/stock/' . $vianda['id']) ?>" class="row g-3 align-items-center mb-3">
                <div class="col-auto">
                    <label for="fecha" class="form-label">Fecha</label>
                </div>
                <div class="col-auto">
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?= esc($fecha) ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Ver</button>
                </div>
            </form>
            <form method="post" action="<?= base_url('admin/viandas/stock/' . $vianda['id']) . '?fecha=' . $fecha ?>">
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Stock para la fecha seleccionada</label>
                    <input type="number" min="0" class="form-control" id="cantidad" name="cantidad" value="<?= esc($stock ?? 0) ?>">
                </div>
                <button type="submit" class="btn btn-success">Actualizar stock</button>
                <a href="<?= base_url('admin/viandas/listar') ?>" class="btn btn-secondary ms-2">Volver al listado</a>
            </form>
        </div>
    </div>
</div> 