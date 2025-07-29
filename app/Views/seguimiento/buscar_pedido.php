<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-search me-2"></i>Seguir mi Pedido
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-motorcycle fa-3x text-primary mb-3"></i>
                        <h5>¿Dónde está mi pedido?</h5>
                        <p class="text-muted">Ingresa el código de tu pedido para seguir su ubicación en tiempo real</p>
                    </div>

                    <form action="<?= base_url('seguimiento') ?>" method="get" id="form-seguimiento">
                        <div class="mb-3">
                            <label for="codigo_pedido" class="form-label">
                                <i class="fas fa-barcode me-2"></i>Código del Pedido
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center" 
                                   id="codigo_pedido" 
                                   name="codigo_seguimiento" 
                                   placeholder="Ej: PED123456"
                                   required
                                   autocomplete="off">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                El código te fue enviado por WhatsApp o email
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Buscar Pedido
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-lightbulb me-2"></i>¿No tienes el código?</h6>
                            <ul class="mb-0">
                                <li>Revisa tu WhatsApp</li>
                                <li>Busca en tu email</li>
                                <li>Contacta a soporte al cliente</li>
                            </ul>
                        </div>
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

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-lg {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
}

.alert {
    border-radius: 10px;
    border: none;
}
</style>

<script>
document.getElementById('form-seguimiento').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const codigo = document.getElementById('codigo_pedido').value.trim();
    if (!codigo) {
        alert('Por favor ingresa el código del pedido');
        return;
    }
    
    // Redirigir a la página de seguimiento
    window.location.href = '<?= base_url('seguimiento/') ?>' + encodeURIComponent(codigo);
});

// Auto-focus en el input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('codigo_pedido').focus();
});
</script> 