<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Restaurante de comida de alta calidad con servicio a domicilio">
    <meta name="keywords" content="restaurante, comida, delivery, pedidos">
    <title><?= isset($title) ? esc($title) : 'Mi Restaurante' ?></title>
    <link rel="manifest" href="<?= base_url('manifest.json') ?>">
    <meta name="theme-color" content="#ffc107">
    
    <!-- Preload de fuentes y recursos críticos -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=moped,moped_package" />
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #A44A3F;
            --secondary-color: #F19C79;
            --accent-color: #D4E09B;
            --light-bg: #F6F4D2;
            --success-color: #CBDFBD;
            --warning-color: #F19C79;
            --danger-color: #A44A3F;
            --info-color: #D4E09B;
            --dark-color: #2C3E50;
            --light-color: #F6F4D2;
            --text-dark: #2C3E50;
            --text-light: #6C757D;
            --border-color: #E9ECEF;
            --shadow-color: rgba(164, 74, 63, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            scroll-behavior: smooth;
        }
        
        /* Aplicar fondo solo a páginas públicas */
        body[data-page="public"] {
            background-color: var(--light-bg);
        }
        
        /* Cards modernas con sombras y transiciones */
        /* .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px var(--shadow-color);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(164, 74, 63, 0.15);
        }
        */
        /* Botones específicos para páginas públicas */
        /* .btn-public-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-public-primary:hover {
            background: linear-gradient(135deg, #8B3A32 0%, #E88A6A 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(164, 74, 63, 0.3);
            color: white;
        }
        
        .btn-public-success {
            background: linear-gradient(135deg, var(--success-color) 0%, var(--accent-color) 100%);
            border: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        .btn-public-success:hover {
            background: linear-gradient(135deg, #B8D4A8 0%, #C4D8A0 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(203, 223, 189, 0.3);
            color: var(--text-dark);
        }
        
        .btn-public-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-public-warning:hover {
            background: linear-gradient(135deg, #E88A6A 0%, #F19C79 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(241, 156, 121, 0.3);
            color: white;
        }
        
        /* Badges específicos para páginas públicas */
        /* .badge-public-primary {
            background: var(--primary-color) !important;
            color: white !important;
        }
        
        .badge-public-success {
            background: var(--success-color) !important;
            color: var(--text-dark) !important;
        }
        
        .badge-public-warning {
            background: var(--warning-color) !important;
            color: white !important;
        }
        
        .badge-public-info {
            background: var(--accent-color) !important;
            color: var(--text-dark) !important;
        }
        */
        /* Alertas específicas para páginas públicas */
        /* .alert-public-success {
            background: linear-gradient(135deg, var(--success-color) 0%, var(--accent-color) 100%);
            border: none;
            color: var(--text-dark);
        }
        
        .alert-public-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
        }
        
        .alert-public-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--primary-color) 100%);
            border: none;
            color: white;
        }
        
        .alert-public-info {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--success-color) 100%);
            border: none;
            color: var(--text-dark);
        }
        */
        /* Efecto de hover para botones */
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
        
        /* Efecto de carga */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            vertical-align: middle;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Efecto de hover para cards de producto */
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Animación para elementos nuevos */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Efecto de hover para navbar */
        /* .nav-link {
            position: relative;
            padding: 8px 12px;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        */
        /* Mejoras para inputs */
        /* .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
        }
        */
        /* Badges modernos */
        /* .badge { ... } */
        
        /* Efecto de hover para cards de carrito */
        .cart-item-card {
            transition: all 0.3s ease;
        }
        
        .cart-item-card:hover {
            background-color: rgba(255, 235, 235, 0.3);
        }
        
        /* Efecto de skeleton loading */
        .skeleton {
            animation: skeleton-loading 1.5s linear infinite alternate;
            opacity: 0.7;
            border-radius: 4px;
        }
        
        @keyframes skeleton-loading {
            0% {
                background-color: hsl(200, 20%, 80%);
            }
            100% {
                background-color: hsl(200, 20%, 95%);
            }
        }
        
        /* Mejoras para el mapa */
        #map {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        
        /* Efecto de hover para imágenes */
        .product-img {
            transition: transform 0.5s ease;
        }
        
        .product-img:hover {
            transform: scale(1.05);
        }
        
        /* Mejoras para las alertas */
        /* .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        */
        /* Efecto de hover para botones de cantidad */
        .quantity-btn {
            transition: all 0.2s ease;
        }
        
        .quantity-btn:hover {
            background-color: #f0f0f0;
        }
        
        /* Scroll personalizado */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ff5252;
        }
        
        /* Efecto de hover para cards de dashboard */
        .dashboard-card {
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Animación para el carrito */
        @keyframes cartBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .cart-animation {
            animation: cartBounce 0.5s ease;
        }
        
        /* Estilos para el buscador de seguimiento mejorado */
        .tracking-form {
            position: relative;
        }
        
        .tracking-input-group {
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 4px 15px var(--shadow-color);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        .tracking-input-group:hover {
            box-shadow: 0 6px 20px rgba(164, 74, 63, 0.15);
            transform: translateY(-2px);
        }
        
        .tracking-input-group:focus-within {
            box-shadow: 0 8px 25px rgba(164, 74, 63, 0.3);
            transform: translateY(-3px);
        }
        
        .tracking-icon {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.1rem;
            padding: 12px 15px;
            border-radius: 25px 0 0 25px;
        }
        
        .tracking-input {
            border: none;
            background: rgba(246, 244, 210, 0.95);
            padding: 12px 20px;
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .tracking-input::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }
        
        .tracking-input:focus {
            outline: none;
            background: var(--light-bg);
            box-shadow: none;
        }
        
        .tracking-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 0 25px 25px 0;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .tracking-btn:hover {
            background: linear-gradient(135deg, #8B3A32 0%, #E88A6A 100%);
            color: white;
            transform: translateX(2px);
            box-shadow: 0 4px 15px rgba(164, 74, 63, 0.4);
        }
        
        .tracking-btn:active {
            transform: translateX(1px) scale(0.98);
        }
        
        /* Animación de entrada para el buscador */
        @keyframes trackingSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tracking-form {
            animation: trackingSlideIn 0.6s ease-out;
        }
        
        /* Responsive para el buscador */
        @media (max-width: 768px) {
            .tracking-input-group {
                border-radius: 20px;
            }
            
            .tracking-icon {
                padding: 10px 12px;
                font-size: 1rem;
            }
            
            .tracking-input {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .tracking-btn {
                padding: 10px 15px;
                font-size: 0.8rem;
            }
        }
        
        /* Efecto de brillo en hover */
        .tracking-input-group::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .tracking-input-group:hover::before {
            left: 100%;
        }

        /* Navbar con la nueva paleta - solo para páginas públicas */
        /* body[data-page="public"] .navbar-dark {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            box-shadow: 0 4px 20px var(--shadow-color);
        }
        
        body[data-page="public"] .navbar-brand {
            color: white !important;
            font-weight: 700;
        }
        
        body[data-page="public"] .navbar-brand .brand-text {
            background: linear-gradient(135deg, var(--light-bg) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        body[data-page="public"] .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        
        body[data-page="public"] .nav-link:hover {
            color: var(--light-bg) !important;
            transform: translateY(-1px);
        }
        */
        /* Carrito con la nueva paleta - solo para páginas públicas */
        /* body[data-page="public"] .badge.bg-danger {
            background: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Scroll personalizado con la nueva paleta - solo para páginas públicas */
        /* body[data-page="public"] ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }
        
        body[data-page="public"] ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
        */

        /* Estilos específicos para páginas públicas */
        .hero-section {
            background: linear-gradient(135deg, var(--light-bg) 0%, var(--accent-color) 100%);
            padding: 80px 0;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px var(--shadow-color);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(164, 74, 63, 0.2);
            border-color: var(--accent-color);
        }
        
        .product-price {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .category-badge {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--success-color) 100%);
            color: var(--text-dark);
            border: none;
            font-weight: 600;
        }
        
        .cart-item {
            background: white;
            border-radius: 12px;
            border-left: 4px solid var(--accent-color);
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            border-left-color: var(--primary-color);
            box-shadow: 0 4px 15px var(--shadow-color);
        }
        
        .checkout-section {
            background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px var(--shadow-color);
        }
        
        .order-summary {
            background: white;
            border-radius: 12px;
            border: 2px solid var(--accent-color);
            padding: 20px;
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 40px 0;
        }
        
        /* Estados de pedidos con la nueva paleta */
        .status-pendiente {
            background: var(--warning-color);
            color: white;
        }
        
        .status-confirmado {
            background: var(--accent-color);
            color: var(--text-dark);
        }
        
        .status-en_preparacion {
            background: var(--secondary-color);
            color: white;
        }
        
        .status-listo {
            background: var(--success-color);
            color: var(--text-dark);
        }
        
        .status-entregado {
            background: var(--primary-color);
            color: white;
        }

        /* Sistema para detectar páginas públicas */
        .public-page {
            background-color: var(--light-bg);
        }
        
        .public-page .card {
            box-shadow: 0 4px 20px var(--shadow-color);
        }
        
        .public-page .card:hover {
            box-shadow: 0 8px 25px rgba(164, 74, 63, 0.15);
        }
        
        /* Aplicar estilos públicos automáticamente en ciertas rutas */
        /* body[data-page="public"] .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        body[data-page="public"] .btn-primary:hover {
            background: linear-gradient(135deg, #8B3A32 0%, #E88A6A 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(164, 74, 63, 0.3);
            color: white;
        }
        
        body[data-page="public"] .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, var(--accent-color) 100%);
            border: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }
        
        body[data-page="public"] .btn-success:hover {
            background: linear-gradient(135deg, #B8D4A8 0%, #C4D8A0 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(203, 223, 189, 0.3);
            color: var(--text-dark);
        }
        
        body[data-page="public"] .badge.bg-primary {
            background: var(--primary-color) !important;
            color: white !important;
        }
        
        body[data-page="public"] .badge.bg-success {
            background: var(--success-color) !important;
            color: var(--text-dark) !important;
        }
        
        body[data-page="public"] .alert-success {
            background: linear-gradient(135deg, var(--success-color) 0%, var(--accent-color) 100%);
            border: none;
            color: var(--text-dark);
        }
        
        body[data-page="public"] .alert-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
        }
        
        /* Footer específico para páginas públicas */
        /* body[data-page="public"] .footer-public {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding-top: 3rem;
            padding-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        body[data-page="public"] .footer-public::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(164, 74, 63, 0.1) 0%, rgba(241, 156, 121, 0.1) 100%);
            pointer-events: none;
        }
        
        body[data-page="public"] .footer-title {
            color: var(--light-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        body[data-page="public"] .footer-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
            border-radius: 1px;
        }
        
        body[data-page="public"] .footer-text {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }
        
        body[data-page="public"] .footer-icon {
            color: var(--accent-color);
            transition: all 0.3s ease;
        }
        
        body[data-page="public"] .footer-link {
            color: rgba(255, 255, 255, 0.8) !important;
            text-decoration: none !important;
            transition: all 0.3s ease;
            position: relative;
        }
        
        body[data-page="public"] .footer-link:hover {
            color: var(--accent-color) !important;
            transform: translateX(5px);
        }
        
        body[data-page="public"] .footer-link:hover .footer-icon {
            transform: rotate(90deg);
            color: var(--accent-color);
        }
        
        body[data-page="public"] .social-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        body[data-page="public"] .social-link:hover {
            color: var(--accent-color) !important;
            transform: translateY(-3px) scale(1.1);
        }
        
        body[data-page="public"] .footer-divider {
            border-color: rgba(255, 255, 255, 0.2);
            opacity: 0.3;
        }
        
        body[data-page="public"] .footer-heart {
            color: var(--secondary-color);
            animation: heartbeat 2s infinite;
        }
        
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
    
    <script>
    // Detectar páginas públicas automáticamente
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const publicPages = [
            '/',
            '/catalogo',
            '/carrito',
            '/checkout',
            '/pedido',
            '/pedidos',
            '/producto',
            '/categoria',
            '/buscar',
            '/contacto',
            '/about',
            '/menu',
            '/seguimiento'
        ];
        
        // Verificar si estamos en una página pública
        const isPublicPage = publicPages.some(page => currentPath.startsWith(page)) || 
                           currentPath === '/' || 
                           currentPath.includes('catalogo') ||
                           currentPath.includes('carrito') ||
                           currentPath.includes('checkout') ||
                           currentPath.includes('pedido') ||
                           currentPath.includes('seguimiento');
        
        // Aplicar clase y atributo para páginas públicas
        if (isPublicPage) {
            document.body.setAttribute('data-page', 'public');
            document.body.classList.add('public-page');
        }
    });
    </script>
</head>
<body>