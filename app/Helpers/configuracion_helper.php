<?php

if (!function_exists('get_config')) {
    /**
     * Obtiene el valor de una configuración
     */
    function get_config($clave, $default = null)
    {
        $configModel = new \App\Models\ConfiguracionModel();
        return $configModel->getValor($clave, $default);
    }
}

if (!function_exists('get_config_seccion')) {
    /**
     * Obtiene todas las configuraciones de una sección
     */
    function get_config_seccion($seccion)
    {
        $configModel = new \App\Models\ConfiguracionModel();
        return $configModel->getPorSeccion($seccion);
    }
}

if (!function_exists('get_nombre_restaurante')) {
    /**
     * Obtiene el nombre del restaurante
     */
    function get_nombre_restaurante()
    {
        return get_config('nombre_restaurante', 'Mi Restaurante');
    }
}

if (!function_exists('get_slogan')) {
    /**
     * Obtiene el slogan del restaurante
     */
    function get_slogan()
    {
        return get_config('slogan', 'Ofrecemos los mejores platos con ingredientes frescos y de la más alta calidad.');
    }
}

if (!function_exists('get_logo_icon')) {
    /**
     * Obtiene el ícono del logo
     */
    function get_logo_icon()
    {
        return get_config('logo_icon', 'fas fa-utensils');
    }
}

if (!function_exists('get_contacto_info')) {
    /**
     * Obtiene la información de contacto
     */
    function get_contacto_info()
    {
        $configModel = new \App\Models\ConfiguracionModel();
        $contactos = $configModel->getContacto();
        $info = [];
        
        foreach ($contactos as $contacto) {
            $info[$contacto['clave']] = $contacto['valor'];
        }
        
        return $info;
    }
}

if (!function_exists('get_redes_sociales')) {
    /**
     * Obtiene las redes sociales
     */
    function get_redes_sociales()
    {
        $configModel = new \App\Models\ConfiguracionModel();
        $redes = $configModel->getRedesSociales();
        $info = [];
        
        foreach ($redes as $red) {
            $info[$red['clave']] = $red['valor'];
        }
        
        return $info;
    }
}

if (!function_exists('get_footer_info')) {
    /**
     * Obtiene la información del footer
     */
    function get_footer_info()
    {
        $configModel = new \App\Models\ConfiguracionModel();
        $footer = $configModel->getFooter();
        $info = [];
        
        foreach ($footer as $item) {
            $info[$item['clave']] = $item['valor'];
        }
        
        return $info;
    }
}

if (!function_exists('get_copyright_text')) {
    /**
     * Obtiene el texto de copyright
     */
    function get_copyright_text()
    {
        $footer = get_footer_info();
        return isset($footer['copyright_text']) ? $footer['copyright_text'] : 'Mi Restaurante. Todos los derechos reservados.';
    }
}

if (!function_exists('get_desarrollador_text')) {
    /**
     * Obtiene el texto del desarrollador
     */
    function get_desarrollador_text()
    {
        $footer = get_footer_info();
        return isset($footer['desarrollador_text']) ? $footer['desarrollador_text'] : 'Max Clorinda - Sistema de Delivery';
    }
}

if (!function_exists('get_direccion')) {
    /**
     * Obtiene la dirección del restaurante
     */
    function get_direccion()
    {
        return get_config('direccion', 'Av. Principal 123, Ciudad');
    }
}

if (!function_exists('get_telefono')) {
    /**
     * Obtiene el teléfono del restaurante
     */
    function get_telefono()
    {
        return get_config('telefono', '+1 234 567 8900');
    }
}

if (!function_exists('get_email')) {
    /**
     * Obtiene el email del restaurante
     */
    function get_email()
    {
        return get_config('email', 'info@mirestaurante.com');
    }
}

if (!function_exists('get_horarios')) {
    /**
     * Obtiene los horarios del restaurante
     */
    function get_horarios()
    {
        return get_config('horarios', 'Lun-Dom: 11:00 - 23:00');
    }
}

if (!function_exists('get_whatsapp')) {
    /**
     * Obtiene el número de WhatsApp
     */
    function get_whatsapp()
    {
        return get_config('whatsapp', '1234567890');
    }
}

if (!function_exists('get_whatsapp_url')) {
    /**
     * Obtiene la URL de WhatsApp
     */
    function get_whatsapp_url()
    {
        return get_config('whatsapp_url', 'https://wa.me/1234567890');
    }
}

if (!function_exists('get_facebook_url')) {
    /**
     * Obtiene la URL de Facebook
     */
    function get_facebook_url()
    {
        return get_config('facebook_url', '#');
    }
}

if (!function_exists('get_instagram_url')) {
    /**
     * Obtiene la URL de Instagram
     */
    function get_instagram_url()
    {
        return get_config('instagram_url', '#');
    }
}

if (!function_exists('get_twitter_url')) {
    /**
     * Obtiene la URL de Twitter
     */
    function get_twitter_url()
    {
        return get_config('twitter_url', '#');
    }
} 