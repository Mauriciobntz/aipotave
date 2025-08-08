<div class="container mt-5">
    <h1 class="mb-4">Detalle de Pedido</h1>

    <?php if (session('success')): ?>
        <div class="alert alert-success"><?= esc(session('success')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Pedido #<?= esc($pedido['id']) ?></h5>
            <p><strong>Fecha:</strong> <?= esc($pedido['fecha']) ?></p>
            <p><strong>Cliente:</strong> <?= esc($pedido['nombre']) ?></p>
            <?php if (!empty($pedido['correo_electronico'])): ?>
                <p><strong>Email:</strong> <?= esc($pedido['correo_electronico']) ?></p>
            <?php endif; ?>
            <?php if (!empty($pedido['celular'])): ?>
                <p><strong>Teléfono:</strong> <?= esc($pedido['celular']) ?></p>
            <?php endif; ?>
            <p><strong>Estado actual:</strong> <span class="badge bg-info text-dark text-uppercase"><?= esc($pedido['estado']) ?></span></p>
            <p><strong>Dirección de entrega:</strong> <?= esc($pedido['direccion_entrega']) ?></p>
            <p><strong>Subtotal productos:</strong> $<?= number_format($pedido['total'] - ($pedido['costo_envio'] ?? 0), 2) ?></p>
            <p><strong>Costo de envío:</strong> $<?= number_format($pedido['costo_envio'] ?? 0, 2) ?></p>
            <p><strong>Total:</strong> $<?= number_format($pedido['total'], 2) ?></p>
            <p><strong>Método de pago:</strong> <?= ucfirst(esc($pedido['metodo_pago'])) ?></p>
            <?php if (!empty($pedido['observaciones'])): ?>
                <p><strong>Observaciones:</strong> <?= esc($pedido['observaciones']) ?></p>
            <?php endif; ?>
            <?php if (!empty($pedido['codigo_seguimiento'])): ?>
                <p><strong>Código de seguimiento:</strong> <code><?= esc($pedido['codigo_seguimiento']) ?></code></p>
            <?php endif; ?>
        </div>
    </div>

    <h4>Detalle del pedido</h4>
    <div class="table-responsive mb-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto/Combo</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotalProductos = 0; ?>
                <?php foreach ($detalles as $item): ?>
                    <?php 
                    $nombre = '';
                    if (!empty($item['producto_nombre'])) {
                        $nombre = $item['producto_nombre'];
                    } elseif (!empty($item['combo_nombre'])) {
                        $nombre = $item['combo_nombre'];
                    } else {
                        $nombre = $item['producto_id'] ? 'Producto #' . $item['producto_id'] : 'Combo #' . $item['combo_id'];
                    }
                    ?>
                    <?php $subtotal = $item['precio_unitario'] * $item['cantidad']; $subtotalProductos += $subtotal; ?>
                    <tr>
                        <td><?= esc($nombre) ?></td>
                        <td><?= esc($item['cantidad']) ?></td>
                        <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Subtotal productos:</th>
                    <th>$<?= number_format($subtotalProductos, 2) ?></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-end">Costo de envío:</th>
                    <th>$<?= number_format($pedido['costo_envio'] ?? 0, 2) ?></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>$<?= number_format($pedido['total'], 2) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <h4>Cambiar estado del pedido</h4>
    <form method="post" action="<?= base_url('admin/pedidos/' . $pedido['id']) ?>">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <select name="estado" class="form-select">
                    <?php foreach ([
                        'pendiente' => 'Pendiente',
                        'confirmado' => 'Confirmado',
                        'en_preparacion' => 'En preparación',
                        'listo' => 'Listo',
                        'en_camino' => 'En camino',
                        'entregado' => 'Entregado',
                        'cancelado' => 'Cancelado'
                    ] as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($pedido['estado'] === $key) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Guardar estado</button>
            </div>
        </div>
    </form>
    <a href="<?= base_url('admin/panel') ?>" class="btn btn-secondary mt-4">Volver al listado</a>
</div> 