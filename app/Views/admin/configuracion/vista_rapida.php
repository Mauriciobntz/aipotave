

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>Configuración Rápida del Sitio
                    </h4>
                    <p class="text-muted mb-0">Edita las configuraciones más importantes del sitio</p>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="<?= base_url('admin/configuracion/actualizar-rapida') ?>">
                        <?= csrf_field() ?>
                        
                        <!-- Configuración General -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-cog me-2"></i>Configuración General
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre_restaurante" class="form-label">Nombre del Restaurante</label>
                                    <input type="text" class="form-control" id="nombre_restaurante" name="nombre_restaurante" 
                                           value="<?= esc(get_config('nombre_restaurante', 'Mi Restaurante')) ?>">
                                    <div class="form-text">Aparece en el navbar y footer</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo_icon" class="form-label">Ícono del Logo</label>
                                    <input type="text" class="form-control" id="logo_icon" name="logo_icon" 
                                           value="<?= esc(get_config('logo_icon', 'fas fa-utensils')) ?>">
                                    <div class="form-text">Clase CSS de FontAwesome (ej: fas fa-utensils)</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="slogan" class="form-label">Slogan/Descripción</label>
                                    <textarea class="form-control" id="slogan" name="slogan" rows="3"><?= esc(get_config('slogan', 'Ofrecemos los mejores platos con ingredientes frescos y de la más alta calidad.')) ?></textarea>
                                    <div class="form-text">Descripción que aparece en el footer</div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-address-book me-2"></i>Información de Contacto
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" 
                                           value="<?= esc(get_config('direccion', 'Av. Principal 123, Ciudad')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" 
                                           value="<?= esc(get_config('telefono', '+1 234 567 8900')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= esc(get_config('email', 'info@mirestaurante.com')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="horarios" class="form-label">Horarios</label>
                                    <input type="text" class="form-control" id="horarios" name="horarios" 
                                           value="<?= esc(get_config('horarios', 'Lun-Dom: 11:00 - 23:00')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" 
                                           value="<?= esc(get_config('whatsapp', '1234567890')) ?>">
                                    <div class="form-text">Solo el número (sin + ni espacios)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Redes Sociales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fab fa-facebook me-2"></i>Redes Sociales
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                           value="<?= esc(get_config('facebook_url', '#')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                           value="<?= esc(get_config('instagram_url', '#')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                           value="<?= esc(get_config('twitter_url', '#')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatsapp_url" class="form-label">WhatsApp URL</label>
                                    <input type="url" class="form-control" id="whatsapp_url" name="whatsapp_url" 
                                           value="<?= esc(get_config('whatsapp_url', 'https://wa.me/1234567890')) ?>">
                                    <div class="form-text">URL completa de WhatsApp</div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="fas fa-copyright me-2"></i>Footer
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="copyright_text" class="form-label">Texto de Copyright</label>
                                    <input type="text" class="form-control" id="copyright_text" name="copyright_text" 
                                           value="<?= esc(get_config('copyright_text', 'Mi Restaurante. Todos los derechos reservados.')) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="desarrollador_text" class="form-label">Texto del Desarrollador</label>
                                    <input type="text" class="form-control" id="desarrollador_text" name="desarrollador_text" 
                                           value="<?= esc(get_config('desarrollador_text', 'Max Clorinda - Sistema de Delivery')) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/configuracion') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Volver
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generar URL de WhatsApp cuando se cambie el número
document.getElementById('whatsapp').addEventListener('input', function() {
    const numero = this.value.replace(/\D/g, ''); // Solo números
    const whatsappUrl = document.getElementById('whatsapp_url');
    if (numero) {
        whatsappUrl.value = `https://wa.me/${numero}`;
    }
});

// Validación de formulario
document.querySelector('form').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre_restaurante').value.trim();
    if (!nombre) {
        e.preventDefault();
        alert('El nombre del restaurante es obligatorio');
        document.getElementById('nombre_restaurante').focus();
        return false;
    }
});
</script>

 