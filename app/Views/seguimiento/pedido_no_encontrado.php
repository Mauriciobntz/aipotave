<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow text-center pedido-no-encontrado-card">
                <div class="card-body py-5">
                    <i class="fas fa-search fa-3x pedido-no-encontrado-icon mb-4"></i>
                    <h4 class="pedido-no-encontrado-title mb-3">Pedido no encontrado</h4>
                    <p class="pedido-no-encontrado-subtitle mb-4">
                        No pudimos encontrar un pedido con el código: <strong><?= esc($codigo) ?></strong>
                    </p>
                    
                    <div class="alert alert-warning pedido-no-encontrado-alert">
                        <h6 class="pedido-no-encontrado-alert-title"><i class="fas fa-exclamation-triangle me-2"></i>Posibles razones:</h6>
                        <ul class="text-start mb-0 pedido-no-encontrado-alert-list">
                            <li>El código ingresado es incorrecto</li>
                            <li>El pedido aún no ha sido procesado</li>
                            <li>El pedido fue cancelado</li>
                            <li>El código ha expirado</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4 pedido-no-encontrado-actions">
                        <a href="<?= base_url('seguimiento') ?>" class="btn btn-primary me-2 pedido-no-encontrado-btn">
                            <i class="fas fa-search me-2"></i>Buscar otro pedido
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary pedido-no-encontrado-btn-outline">
                            <i class="fas fa-home me-2"></i>Volver al inicio
                        </a>
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

/* Estilos para pedido no encontrado */
.pedido-no-encontrado-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.pedido-no-encontrado-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(66, 129, 164, 0.2);
}

.pedido-no-encontrado-icon {
    color: var(--accent-red);
    animation: shake 2s ease-in-out infinite;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.pedido-no-encontrado-title {
    color: var(--accent-red);
    font-weight: 600;
    font-size: 1.5rem;
}

.pedido-no-encontrado-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.6;
}

.pedido-no-encontrado-subtitle strong {
    color: var(--primary-color);
    font-weight: 600;
}

.pedido-no-encontrado-alert {
    border-radius: 15px;
    border: none;
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    border-left: 4px solid var(--warm-color);
    padding: 1.5rem;
    margin: 1.5rem 0;
}

.pedido-no-encontrado-alert-title {
    color: var(--accent-red);
    font-weight: 600;
    margin-bottom: 1rem;
}

.pedido-no-encontrado-alert-list {
    color: #856404;
    padding-left: 1.5rem;
}

.pedido-no-encontrado-alert-list li {
    margin-bottom: 0.75rem;
    position: relative;
    font-weight: 500;
}

.pedido-no-encontrado-alert-list li:before {
    content: "⚠";
    color: var(--warm-color);
    font-weight: bold;
    position: absolute;
    left: -1.5rem;
    font-size: 0.9rem;
}

.pedido-no-encontrado-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: center;
}

.pedido-no-encontrado-btn {
    border-radius: 15px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-width: 200px;
}

.pedido-no-encontrado-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
}

.pedido-no-encontrado-btn-outline {
    border-radius: 15px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border: 2px solid var(--light-color);
    color: var(--primary-color);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    min-width: 200px;
}

.pedido-no-encontrado-btn-outline:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .pedido-no-encontrado-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .pedido-no-encontrado-title {
        font-size: 1.3rem;
    }
    
    .pedido-no-encontrado-subtitle {
        font-size: 1rem;
    }
    
    .pedido-no-encontrado-icon {
        font-size: 2.5rem !important;
    }
    
    .pedido-no-encontrado-alert {
        padding: 1rem;
        border-radius: 12px;
        margin: 1rem 0;
    }
    
    .pedido-no-encontrado-alert-title {
        font-size: 1rem;
    }
    
    .pedido-no-encontrado-alert-list {
        padding-left: 1rem;
    }
    
    .pedido-no-encontrado-alert-list li {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .pedido-no-encontrado-alert-list li:before {
        left: -1rem;
        font-size: 0.8rem;
    }
    
    .pedido-no-encontrado-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .pedido-no-encontrado-btn,
    .pedido-no-encontrado-btn-outline {
        min-width: 180px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 12px;
    }
}

@media (max-width: 576px) {
    .pedido-no-encontrado-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .pedido-no-encontrado-title {
        font-size: 1.2rem;
    }
    
    .pedido-no-encontrado-subtitle {
        font-size: 0.9rem;
    }
    
    .pedido-no-encontrado-icon {
        font-size: 2rem !important;
    }
    
    .pedido-no-encontrado-alert {
        padding: 0.75rem;
        border-radius: 10px;
        margin: 0.75rem 0;
    }
    
    .pedido-no-encontrado-alert-title {
        font-size: 0.9rem;
    }
    
    .pedido-no-encontrado-alert-list {
        padding-left: 0.8rem;
    }
    
    .pedido-no-encontrado-alert-list li {
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
    }
    
    .pedido-no-encontrado-alert-list li:before {
        left: -0.8rem;
        font-size: 0.75rem;
    }
    
    .pedido-no-encontrado-actions {
        gap: 0.5rem;
    }
    
    .pedido-no-encontrado-btn,
    .pedido-no-encontrado-btn-outline {
        min-width: 160px;
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 10px;
    }
}

@media (min-width: 768px) {
    .pedido-no-encontrado-actions {
        flex-direction: row;
        justify-content: center;
    }
}
</style> 