<div class="container mt-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 border-success border-3">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="success-icon animate__animated animate__bounceIn">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    
                    <h1 class="text-success mb-4 fw-bold animate__animated animate__fadeInUp">
                        ¡Pedido Confirmado!
                    </h1>
                    
                    <div class="alert alert-success animate__animated animate__fadeInUp">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fs-4"></i>
                            <div>
                                <h5 class="alert-heading mb-2">¡Gracias por tu compra!</h5>
                                <p class="mb-0">Hemos recibido tu pedido correctamente y está siendo procesado.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info animate__animated animate__fadeInUp">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-3 fs-4"></i>
                            <div>
                                <h5 class="alert-heading mb-2">Información importante</h5>
                                <p class="mb-2">
                                    Tu pedido ha sido recibido correctamente. El pago se realizará 
                                    <?php if ($metodo_pago === 'transferencia'): ?>
                                        <strong>por transferencia bancaria</strong>
                                    <?php elseif ($metodo_pago === 'tarjeta'): ?>
                                        <strong>con tarjeta</strong>
                                    <?php else: ?>
                                        <strong>en efectivo</strong>
                                    <?php endif; ?> 
                                    al momento de la entrega.
                                </p>
                                <?php if ($metodo_pago === 'transferencia'): ?>
                                    <div class="mt-3">
                                        <h6 class="mb-2">Datos para transferencia bancaria:</h6>
                                        <div class="bg-light p-3 rounded text-start">
                                            <div class="mb-2"><strong>CBU:</strong> 0000003100000000001234</div>
                                            <div class="mb-2"><strong>Alias:</strong> MI.RESTAURANTE.BANCO</div>
                                            <div class="mb-2"><strong>Titular:</strong> Mi Restaurante S.A.</div>
                                            <small class="text-muted">Por favor, envía el comprobante por WhatsApp.</small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="fas fa-barcode me-2"></i>Código de seguimiento
                            </h5>
                            <div class="display-4 fw-bold text-primary mb-3 tracking-code"><?= esc($codigo) ?></div>
                            <p class="text-muted">Guarda este código para consultar el estado de tu pedido en cualquier momento.</p>
                            
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button class="btn btn-outline-secondary" onclick="copiarCodigo()">
                                    <i class="fas fa-copy me-2"></i>Copiar Código
                                </button>
                                <a href="<?= base_url('pedido/seguimiento?codigo=' . urlencode($codigo)) ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-2"></i>Ver Estado
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning animate__animated animate__fadeInUp">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-3 fs-4"></i>
                            <div>
                                <h5 class="alert-heading mb-2">Tiempo estimado de entrega</h5>
                                <p class="mb-0">Tu pedido llegará en aproximadamente <strong>30-45 minutos</strong>.</p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (isset($whatsapp) && $whatsapp): ?>
                    <div class="mt-4 animate__animated animate__fadeInUp">
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsapp) ?>?text=Hola!%20Realic%C3%A9%20un%20pedido%20con%20c%C3%B3digo%20<?= urlencode($codigo) ?>" 
                           target="_blank" 
                           class="btn btn-success btn-lg btn-hover-effect">
                            <i class="fab fa-whatsapp me-2"></i>Contactar por WhatsApp
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="mt-4 animate__animated animate__fadeInUp">
                        <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg btn-hover-effect">
                            <i class="fas fa-utensils me-2"></i>Volver al Menú
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Copiar código de seguimiento al portapapeles
function copiarCodigo() {
    const codigo = document.querySelector('.tracking-code').textContent;
    navigator.clipboard.writeText(codigo)
        .then(() => {
            // Mostrar notificación de éxito
            const originalText = event.target.innerHTML;
            event.target.innerHTML = '<i class="fas fa-check me-2"></i>Copiado!';
            setTimeout(() => {
                event.target.innerHTML = originalText;
            }, 2000);
        })
        .catch(err => {
            console.error('Error al copiar: ', err);
            // Mostrar notificación de error
            const originalText = event.target.innerHTML;
            event.target.innerHTML = '<i class="fas fa-times me-2"></i>Error';
            setTimeout(() => {
                event.target.innerHTML = originalText;
            }, 2000);
        });
}

// Animación para el icono de éxito
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
.success-icon {
    font-size: 5rem;
    color: #28a745;
    display: inline-block;
}

.tracking-code {
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    display: inline-block;
}

.animate__animated {
    animation-duration: 1s;
}

/* Efecto de hover para los botones */
.btn-hover-effect {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-hover-effect:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.btn-hover-effect:after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.5);
    opacity: 0;
    border-radius: 100%;
    transform: scale(1, 1) translate(-50%);
    transform-origin: 50% 50%;
}

.btn-hover-effect:focus:after,
.btn-hover-effect:active:after {
    animation: ripple 1s ease-out;
}

@keyframes ripple {
    0% {
        transform: scale(0, 0);
        opacity: 0.5;
    }
    100% {
        transform: scale(20, 20);
        opacity: 0;
    }
}
</style>