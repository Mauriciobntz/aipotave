<div class="container text-center mt-5">
    <div class="text-center">
        <h1 class="text-success mb-4">
            <i class="fas fa-check-circle"></i> ¡Pedido Confirmado!
        </h1>
        
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle"></i> Información importante:</h5>
            <p class="mb-0">
                Tu pedido ha sido recibido correctamente. El pago se realizará <?= $metodo_pago === 'transferencia' ? 'por transferencia bancaria' : ($metodo_pago === 'tarjeta' ? 'con tarjeta' : 'en efectivo') ?> al momento de la entrega o por WhatsApp.
            </p>
        </div>
        <p class="mb-2"><strong>Código de seguimiento:</strong></p>
        <div class="display-4 mb-3"><?= esc($codigo) ?></div>
        <p>Guarda este código para consultar el estado de tu pedido.</p>
        <hr>
        <p class="fs-5 mb-2">
            <i class="fas fa-money-bill-wave me-2"></i>
            <strong>El pago se realiza por WhatsApp o al recibir el pedido.</strong>
        </p>
        <?php if (isset($metodo_pago) && $metodo_pago === 'transferencia'): ?>
            <div class="alert alert-info mt-3">
                <h5 class="mb-2">Datos para transferencia bancaria:</h5>
                <div class="mb-1"><strong>CBU:</strong> 0000003100000000001234</div>
                <div class="mb-1"><strong>Alias:</strong> MI.RESTAURANTE.BANCO</div>
                <div class="mb-1"><strong>Titular:</strong> Mi Restaurante S.A.</div>
                <small>Por favor, envía el comprobante por WhatsApp.</small>
            </div>
        <?php endif; ?>
        <?php if (isset($whatsapp) && $whatsapp): ?>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsapp) ?>?text=Hola!%20Realic%C3%A9%20un%20pedido%20con%20c%C3%B3digo%20<?= urlencode($codigo) ?>" target="_blank" class="btn btn-success mt-3">
                <i class="fab fa-whatsapp me-2"></i>Contactar por WhatsApp
            </a>
        <?php endif; ?>
        <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3 ms-2">Volver al menú principal</a>
    </div>
</div> 