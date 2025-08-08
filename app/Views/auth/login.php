<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
            <div class="card shadow login-card">
                <div class="card-header login-header">
                    <h4 class="mb-0 login-title">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger login-alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('login') ?>" class="login-form">
                        <div class="mb-3">
                            <label for="email" class="form-label login-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" 
                                   class="form-control login-input" 
                                   id="email" 
                                   name="email" 
                                   value="<?= set_value('email') ?>" 
                                   placeholder="tu@email.com"
                                   required
                                   inputmode="email"
                                   autocomplete="email">
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label login-label">
                                <i class="fas fa-lock me-2"></i>Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control login-input" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Tu contraseña"
                                   required
                                   autocomplete="current-password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary login-btn">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <small class="text-muted login-help">
                            <i class="fas fa-info-circle me-1"></i>
                            ¿No tienes cuenta? Contacta al administrador
                        </small>
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

/* Estilos para login */
.login-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(66, 129, 164, 0.15);
    transition: all 0.3s ease;
    overflow: hidden;
}

.login-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(66, 129, 164, 0.2);
}

.login-header {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    color: white;
    border-radius: 20px 20px 0 0 !important;
    border: none;
    padding: 1.5rem;
    text-align: center;
}

.login-title {
    font-weight: 600;
    margin-bottom: 0;
    font-size: 1.3rem;
}

.login-label {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.login-input {
    border-radius: 12px;
    border: 2px solid var(--light-color);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.login-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(66, 129, 164, 0.25);
    transform: scale(1.02);
}

.login-input::placeholder {
    color: #adb5bd;
    font-style: italic;
}

.login-btn {
    border-radius: 12px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border: none;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 1rem;
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 129, 164, 0.3);
    background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
}

.login-alert {
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    border-left: 4px solid var(--accent-red);
    color: #721c24;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.login-help {
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Responsive */
@media (max-width: 768px) {
    .login-card {
        margin: 0.5rem;
        border-radius: 15px;
    }
    
    .login-header {
        padding: 1rem;
        border-radius: 15px 15px 0 0 !important;
    }
    
    .login-title {
        font-size: 1.2rem;
    }
    
    .login-input {
        font-size: 0.95rem;
        padding: 0.6rem 0.875rem;
        border-radius: 10px;
    }
    
    .login-btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        border-radius: 10px;
    }
    
    .login-alert {
        padding: 0.75rem;
        border-radius: 10px;
    }
    
    .login-label {
        font-size: 0.9rem;
    }
    
    .login-help {
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .login-card {
        margin: 0.25rem;
        border-radius: 12px;
    }
    
    .login-header {
        padding: 0.75rem;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .login-title {
        font-size: 1.1rem;
    }
    
    .login-input {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }
    
    .login-btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    
    .login-alert {
        padding: 0.6rem;
        border-radius: 8px;
    }
    
    .login-label {
        font-size: 0.85rem;
    }
    
    .login-help {
        font-size: 0.8rem;
    }
}

/* Animación de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-card {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prevenir zoom en iOS
    const inputs = document.querySelectorAll('.login-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (window.innerWidth <= 768) {
                this.style.fontSize = '16px';
            }
        });
        
        input.addEventListener('blur', function() {
            if (window.innerWidth <= 768) {
                this.style.fontSize = '';
            }
        });
    });
    
    // Mejorar experiencia de formulario
    const form = document.querySelector('.login-form');
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Iniciando...';
        submitBtn.disabled = true;
        
        // Simular delay para mejor UX
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
});
</script> 