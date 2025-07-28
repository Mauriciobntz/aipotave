<div class="container mt-5">
    <h1 class="mb-4">Asignar Repartidor</h1>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Pedido #<?= esc($pedido['id']) ?></h5>
            <p><strong>Dirección de entrega:</strong> <?= esc($pedido['direccion_entrega']) ?></p>
        </div>
    </div>

    <form method="post" action="<?= base_url('admin/pedidos/asignar-repartidor/' . $pedido['id']) ?>">
        <div class="mb-3">
            <label for="repartidor_id" class="form-label">Seleccionar repartidor</label>
            <select class="form-select" id="repartidor_id" name="repartidor_id" required>
                <option value="">-- Elegir repartidor --</option>
                <?php foreach ($repartidores as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= ($pedido['repartidor_id'] ?? null) == $r['id'] ? 'selected' : '' ?>><?= esc($r['nombre']) ?> (<?= esc($r['telefono']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Asignar repartidor</button>
        <a href="<?= base_url('admin/pedidos/' . $pedido['id']) ?>" class="btn btn-secondary ms-2">Volver al detalle</a>
    </form>
</div> 