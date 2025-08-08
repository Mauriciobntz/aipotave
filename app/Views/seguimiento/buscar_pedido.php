<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow buscar-pedido-card">
                <div class="card-header buscar-pedido-header">
                    <h4 class="mb-0 buscar-pedido-title">
                        <i class="fas fa-search me-2"></i>Seguir mi Pedido
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-motorcycle fa-3x buscar-pedido-icon mb-3"></i>
                        <h5 class="buscar-pedido-subtitle">¿Dónde está mi pedido?</h5>
                        <p class="text-muted">Ingresa el código de tu pedido para seguir su ubicación en tiempo real</p>
                    </div>

                    <form action="<?= base_url('seguimiento') ?>" method="get" id="form-seguimiento">
                        <div class="mb-3">
                            <label for="codigo_pedido" class="form-label buscar-pedido-label">
                                <i class="fas fa-barcode me-2"></i>Código del Pedido
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg text-center buscar-pedido-input" 
                                   id="codigo_pedido" 
                                   name="codigo_seguimiento" 
                                   placeholder="Ej: PED123456"
                                   required
                                   autocomplete="off"
                                   inputmode="text"
                                   autocapitalize="characters">
                            <div class="form-text buscar-pedido-help">
                                <i class="fas fa-info-circle me-1"></i>
                                El código te fue enviado por WhatsApp o email
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg buscar-pedido-btn">
                                <i class="fas fa-search me-2"></i>Buscar Pedido
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <div class="buscar-pedido-info-box">
                            <h6 class="buscar-pedido-info-title"><i class="fas fa-lightbulb me-2"></i>¿No tienes el código?</h6>
                            <ul class="mb-0 buscar-pedido-info-list">
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
/* Variables de color para consistencia */
:root {
    --primary-color: #4281A4;
    --accent-color: #48A9A6;
    --light-color: #E4DFDA;
    --warm-color: #D4B483;
    --accent-red: #C1666B;
}

/* Estilos para buscar pedido */
.buscar-pedido-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.buscar-pedido-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(66, 129, 164, 0.2);
}

.buscar-pedido-header {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    border-radius: 20px 20px 0 0 !important;
    border: none;
    padding: 1.5rem;
}

.buscar-pedido-title {
    font-weight: 600;
    margin-bottom: 0;
}

.buscar-pedido-icon {
    color: var(--primary-color);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.buscar-pedido-subtitle {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.buscar-pedido-label {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.buscar-pedido-input {
    border-radius: 15px;
    border: 2px solid var(--light-color);
    transition: all 0.3s ease;
    font-size: 1.1rem;
    padding: 1rem 1.5rem;
}

.buscar-pedido-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(66, 129, 164, 0.25);
    transform: scale(1.02);
}

.buscar-pedido-help {
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.buscar-pedido-btn {
    border-radius: 15px;
    padding: 1rem 2rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.buscar-pedido-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
}

.buscar-pedido-info-box {
    border-radius: 15px;
    border: none;
    background: linear-gradient(135deg, var(--light-color), #f8f9fa);
    border-left: 4px solid var(--accent-color);
    padding: 1.25rem;
    box-shadow: 0 2px 10px rgba(66, 129, 164, 0.1);
    transition: all 0.3s ease;
}

.buscar-pedido-info-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(66, 129, 164, 0.15);
}

.buscar-pedido-info-title {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.buscar-pedido-info-list {
    color: #555;
    padding-left: 1.5rem;
}

.buscar-pedido-info-list li {
    margin-bottom: 0.5rem;
    position: relative;
}

.buscar-pedido-info-list li:before {
    content: "•";
    color: var(--accent-color);
    font-weight: bold;
    position: absolute;
    left: -1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .buscar-pedido-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .buscar-pedido-header {
        padding: 1rem;
        border-radius: 15px 15px 0 0 !important;
    }
    
    .buscar-pedido-title {
        font-size: 1.2rem;
    }
    
    .buscar-pedido-icon {
        font-size: 2.5rem !important;
    }
    
    .buscar-pedido-subtitle {
        font-size: 1.1rem;
    }
    
    .buscar-pedido-input {
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
    }
    
    .buscar-pedido-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 12px;
    }
    
    .buscar-pedido-info-box {
        padding: 1rem;
        border-radius: 12px;
    }
    
    .buscar-pedido-info-title {
        font-size: 1rem;
    }
    
    .buscar-pedido-info-list {
        padding-left: 1rem;
    }
    
    .buscar-pedido-info-list li {
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }
}

@media (max-width: 576px) {
    .buscar-pedido-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .buscar-pedido-header {
        padding: 0.75rem;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .buscar-pedido-title {
        font-size: 1.1rem;
    }
    
    .buscar-pedido-icon {
        font-size: 2rem !important;
    }
    
    .buscar-pedido-subtitle {
        font-size: 1rem;
    }
    
    .buscar-pedido-input {
        font-size: 0.9rem;
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
    }
    
    .buscar-pedido-btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 10px;
    }
    
    .buscar-pedido-info-box {
        padding: 0.75rem;
        border-radius: 10px;
    }
    
    .buscar-pedido-info-title {
        font-size: 0.9rem;
    }
    
    .buscar-pedido-info-list {
        padding-left: 0.8rem;
    }
    
    .buscar-pedido-info-list li {
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }
    
    .buscar-pedido-info-list li:before {
        left: -0.8rem;
    }
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
    
    // Mejorar experiencia móvil
    const input = document.getElementById('codigo_pedido');
    input.addEventListener('input', function() {
        // Convertir a mayúsculas automáticamente
        this.value = this.value.toUpperCase();
    });
    
    // Prevenir zoom en iOS
    input.addEventListener('focus', function() {
        if (window.innerWidth <= 768) {
            this.style.fontSize = '16px';
        }
    });
    

});
</script> 