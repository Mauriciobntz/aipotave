<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow text-center">
                <div class="card-body py-5">
                    <i class="fas fa-search fa-3x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">Pedido no encontrado</h4>
                    <p class="text-muted mb-4">
                        No pudimos encontrar un pedido con el código: <strong><?= esc($codigo) ?></strong>
                    </p>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Posibles razones:</h6>
                        <ul class="text-start mb-0">
                            <li>El código ingresado es incorrecto</li>
                            <li>El pedido aún no ha sido procesado</li>
                            <li>El pedido fue cancelado</li>
                            <li>El código ha expirado</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <a href="<?= base_url('seguimiento') ?>" class="btn btn-primary me-2">
                            <i class="fas fa-search me-2"></i>Buscar otro pedido
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Volver al inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.alert {
    border-radius: 10px;
    border: none;
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
}
</style> 