<div class="container mt-5 pt-5 mb-5">
<style>
/* Fondo claro para vista pública */
body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);
    min-height: 100vh;
}

.container-fluid {
    background: transparent;
}
</style>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 border-success border-3 checkout-exito-card animate__animated animate__fadeIn">
                <div class="card-body p-4 p-md-5 text-center">
                    <div class="mb-4">
                        <div class="success-icon animate__animated animate__bounceIn checkout-success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <h2 class="mb-3 fw-bold text-success checkout-exito-title">¡Pedido recibido!</h2>
                    <p class="lead mb-4 checkout-exito-subtitle">Gracias por tu compra.<br>Por favor, confirma tu pedido enviando un mensaje de WhatsApp.</p>

                    <?php
                    // Construir resumen de productos para WhatsApp sin emojis ni asteriscos
                    $productosMsg = '';
                    if (!empty($detalles)) {
                        foreach ($detalles as $item) {
                            $nombre = $item['producto_nombre'] ?? $item['combo_nombre'] ?? 'Producto';
                            $productosMsg .= $nombre . ' x' . $item['cantidad'] . ' → $' . number_format($item['precio_unitario'] * $item['cantidad'], 2) . "\n";
                        }
                    }

                    $totalMsg = isset($pedido['total']) ? '$' . number_format($pedido['total'], 2) : '';
                    $direccionMsg = $pedido['direccion_entrega'] ?? ($direccion ?? '');
                    $metodoPagoMsg = ucfirst($pedido['metodo_pago'] ?? ($metodo_pago ?? ''));
                    $obsMsg = $pedido['observaciones'] ?? '';

                    $mensajeWA =
                        "Confirmación de Pedido #{$codigo}\n\n" .
                        "Detalle del pedido:\n" . $productosMsg . "\n" .
                        "Total: {$totalMsg}\n" .
                        "Entrega en: {$direccionMsg}\n" .
                        "Pago: {$metodoPagoMsg}";

                    if ($obsMsg) {
                        $mensajeWA .= "\nObservaciones: {$obsMsg}";
                    }

                    $mensajeWA .= "\n\nSeguimiento: " . base_url("seguimiento/{$codigo}");
                    ?>
                    <?php if (isset($whatsapp) && $whatsapp): ?>
                    <div class="my-4 animate__animated animate__fadeInUp">
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsapp) ?>?text=<?= urlencode($mensajeWA) ?>"
                           target="_blank"
                           class="btn btn-success btn-lg btn-hover-effect w-100 w-md-auto mx-auto d-block checkout-whatsapp-btn"
                           style="max-width: 420px;">
                            <i class="fab fa-whatsapp me-2"></i>Confirmar por WhatsApp
                        </a>
                        <div class="text-muted mt-2 small checkout-whatsapp-help">Presiona el botón para confirmar tu pedido y recibir asistencia personalizada.</div>
                    </div>
                    <?php endif; ?>

                    <div class="row justify-content-center mb-4">
                        <div class="col-12 col-md-10">
                            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp checkout-resumen-card">
                                <div class="card-body p-3">
                                    <h5 class="mb-3 fw-bold checkout-resumen-title">
                                        <i class="fas fa-list-ul me-2"></i>Resumen del Pedido
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle mb-0 checkout-resumen-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="checkout-resumen-header">Producto</th>
                                                    <th class="text-center checkout-resumen-header">Cantidad</th>
                                                    <th class="text-end checkout-resumen-header">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (!empty($detalles)): 
                                                $subtotalProductos = 0;
                                                foreach ($detalles as $item): 
                                                    $subtotal = $item['precio_unitario'] * $item['cantidad'];
                                                    $subtotalProductos += $subtotal;
                                            ?>
                                                <tr class="checkout-resumen-row">
                                                    <td class="checkout-resumen-product"><?= esc($item['producto_nombre'] ?? $item['combo_nombre'] ?? 'Producto') ?></td>
                                                    <td class="text-center checkout-resumen-quantity">x<?= esc($item['cantidad']) ?></td>
                                                    <td class="text-end checkout-resumen-subtotal">$<?= number_format($subtotal, 2) ?></td>
                                                </tr>
                                            <?php endforeach; else: ?>
                                                <tr><td colspan="3" class="text-center text-muted">Sin detalles</td></tr>
                                            <?php endif; ?>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr class="checkout-resumen-subtotal">
                                                    <th colspan="2" class="text-end checkout-resumen-subtotal-label">Subtotal productos:</th>
                                                    <th class="text-end checkout-resumen-subtotal-value">$<?= number_format($subtotalProductos ?? 0, 2) ?></th>
                                                </tr>
                                                <tr class="checkout-resumen-envio">
                                                    <th colspan="2" class="text-end checkout-resumen-envio-label">Costo de envío:</th>
                                                    <th class="text-end checkout-resumen-envio-value">$<?= number_format($pedido['costo_envio'] ?? 0, 2) ?></th>
                                                </tr>
                                                <tr class="checkout-resumen-total">
                                                    <th colspan="2" class="text-end checkout-resumen-total-label">Total:</th>
                                                    <th class="text-end text-primary fs-5 checkout-resumen-total-value">$<?= isset($pedido['total']) ? number_format($pedido['total'], 2) : '0.00' ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="mt-3 text-start checkout-resumen-details">
                                        <div class="checkout-resumen-detail">
                                            <strong>Dirección:</strong> <?= esc($pedido['direccion_entrega'] ?? '') ?>
                                        </div>
                                        <div class="checkout-resumen-detail">
                                            <strong>Método de pago:</strong> <?= esc($pedido['metodo_pago'] ?? '') ?>
                                        </div>
                                        <?php if (!empty($pedido['observaciones'])): ?>
                                            <div class="checkout-resumen-detail">
                                                <strong>Observaciones:</strong> <?= esc($pedido['observaciones']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-4">
                        <div class="col-12 col-md-10">
                            <div class="card border-0 shadow-sm animate__animated animate__fadeInUp checkout-seguimiento-card">
                                <div class="card-body p-3">
                                    <h5 class="mb-3 fw-bold checkout-seguimiento-title">
                                        <i class="fas fa-motorcycle me-2"></i>Seguimiento del Pedido
                                    </h5>
                                    <p class="mb-3 checkout-seguimiento-text">
                                        Puedes seguir el estado de tu pedido en tiempo real usando el código de seguimiento:
                                    </p>
                                    <div class="checkout-seguimiento-actions">
                                        <div class="text-center mb-3">
                                            <span class="checkout-codigo-label d-block mb-2">Código de Seguimiento:</span>
                                            <span class="checkout-codigo-value"><?= esc($codigo) ?></span>
                                        </div>
                                        <div class="text-center">
                                            <a href="<?= base_url('seguimiento/' . $codigo) ?>" 
                                               class="btn btn-primary checkout-btn-seguimiento">
                                                <i class="fas fa-search me-2"></i>Seguir Pedido
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="animate__animated animate__fadeInUp">
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-primary checkout-btn-home">
                            <i class="fas fa-home me-2"></i>Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copiarCodigo() {
    const codigo = document.querySelector('.tracking-code').textContent;
    navigator.clipboard.writeText(codigo)
        .then(() => {
            const originalText = event.target.innerHTML;
            event.target.innerHTML = '<i class="fas fa-check me-2"></i>Copiado!';
            setTimeout(() => {
                event.target.innerHTML = originalText;
            }, 2000);
        })
        .catch(err => {
            console.error('Error al copiar: ', err);
            const originalText = event.target.innerHTML;
            event.target.innerHTML = '<i class="fas fa-times me-2"></i>Error';
            setTimeout(() => {
                event.target.innerHTML = originalText;
            }, 2000);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const successIcon = document.querySelector('.success-icon');
    if (successIcon) {
        setTimeout(() => {
            successIcon.classList.add('animate__tada');
        }, 1000);
    }
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

/* Estilos para checkout éxito */
.checkout-exito-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.checkout-exito-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(66, 129, 164, 0.2);
}

.checkout-success-icon {
    font-size: 4rem;
    color: #28a745;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.checkout-exito-title {
    color: #28a745;
    font-size: 2rem;
    font-weight: 700;
}

.checkout-exito-subtitle {
    color: var(--primary-color);
    font-size: 1.1rem;
    line-height: 1.6;
}

.checkout-whatsapp-btn {
    border-radius: 15px;
    padding: 1rem 2rem;
    font-weight: 600;
    background: linear-gradient(135deg, #25d366, #128c7e);
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
}

.checkout-whatsapp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    background: linear-gradient(135deg, #128c7e, #25d366);
    color: white;
}

.checkout-whatsapp-help {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.4;
}

.checkout-resumen-card {
    border-radius: 15px;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-left: 4px solid var(--accent-color);
}

.checkout-resumen-title {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.checkout-resumen-table {
    margin-bottom: 0;
}

.checkout-resumen-header {
    color: var(--primary-color);
    font-weight: 600;
    border-bottom: 2px solid var(--accent-color);
    padding: 0.75rem 0;
    font-size: 0.9rem;
}

.checkout-resumen-row {
    border-bottom: 1px solid rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.checkout-resumen-row:hover {
    background-color: rgba(66, 129, 164, 0.05);
}

.checkout-resumen-product {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.9rem;
}

.checkout-resumen-quantity {
    font-weight: 600;
    color: var(--accent-color);
    font-size: 0.9rem;
}

.checkout-resumen-subtotal {
    font-weight: 600;
    color: var(--accent-color);
    font-size: 0.9rem;
}

.checkout-resumen-total {
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-top: 2px solid var(--accent-color);
}

.checkout-resumen-total-label {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 1rem;
}

.checkout-resumen-total-value {
    color: var(--primary-color) !important;
    font-weight: 700;
    font-size: 1.1rem !important;
}

.checkout-resumen-details {
    background: rgba(66, 129, 164, 0.05);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.checkout-resumen-detail {
    margin-bottom: 0.5rem;
    color: var(--primary-color);
    font-size: 0.9rem;
}

.checkout-resumen-detail:last-child {
    margin-bottom: 0;
}

.checkout-resumen-detail strong {
    color: var(--accent-color);
    font-weight: 600;
}

.checkout-seguimiento-card {
    border-radius: 15px;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-left: 4px solid #28a745;
}

.checkout-seguimiento-title {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.checkout-seguimiento-text {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
}

.checkout-seguimiento-actions {
    padding: 1rem 0;
}

.checkout-codigo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.checkout-codigo-label {
    color: var(--primary-color);
    font-weight: 600;
    font-size: 0.9rem;
}

.checkout-codigo-value {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.2rem;
    letter-spacing: 2px;
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.3);
    display: inline-block;
    min-width: 120px;
}

.checkout-btn-seguimiento {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.checkout-btn-seguimiento:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
}

.checkout-btn-home {
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.checkout-btn-home:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-exito-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .checkout-exito-title {
        font-size: 1.5rem;
    }
    
    .checkout-exito-subtitle {
        font-size: 1rem;
    }
    
    .checkout-success-icon {
        font-size: 3rem;
    }
    
    .checkout-whatsapp-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .checkout-seguimiento-actions {
        padding: 0.5rem 0;
    }
    
    .checkout-codigo-value {
        font-size: 1rem;
        padding: 0.5rem 1rem;
        min-width: 100px;
        border-radius: 10px;
    }
    
    .checkout-btn-home {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 10px;
    }
    
    .checkout-resumen-table {
        font-size: 0.85rem;
    }
    
    .checkout-resumen-product,
    .checkout-resumen-quantity,
    .checkout-resumen-subtotal {
        font-size: 0.8rem;
    }
    
    .checkout-resumen-detail {
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .checkout-exito-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .checkout-exito-title {
        font-size: 1.3rem;
    }
    
    .checkout-exito-subtitle {
        font-size: 0.9rem;
    }
    
    .checkout-success-icon {
        font-size: 2.5rem;
    }
    
    .checkout-whatsapp-btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .checkout-codigo-value {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        min-width: 80px;
        border-radius: 8px;
        letter-spacing: 1px;
    }
    
    .checkout-btn-home {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    
    .checkout-resumen-table {
        font-size: 0.8rem;
    }
    
    .checkout-resumen-product,
    .checkout-resumen-quantity,
    .checkout-resumen-subtotal {
        font-size: 0.75rem;
    }
    
    .checkout-resumen-detail {
        font-size: 0.8rem;
    }
}
</style>