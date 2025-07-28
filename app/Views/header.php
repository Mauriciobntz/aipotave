<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'Mi Restaurante' ?></title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffc107">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos modernos basados en ejemplos */
        .card-counter {
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px;
            padding: 20px 10px;
            border-radius: 5px;
            transition: .3s linear all;
        }
        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }
        .card-counter.danger {
            background-color: #ef5350;
            color: #FFF;
        }  
        .card-counter.success {
            background-color: #66bb6a;
            color: #FFF;
        }  
        .card-counter.info {
            background-color: #26c6da;
            color: #FFF;
        }  
        .card-counter i {
            font-size: 5em;
            opacity: 0.2;
        }
        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }
        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.5;
            display: block;
            font-size: 18px;
        }
        
        /* Cards con bordes de colores */
        .order-card {
            border-left: 4px solid;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .order-card.pending {
            border-left-color: #ffc107;
        }
        .order-card.preparing {
            border-left-color: #fd7e14;
        }
        .order-card.delivery {
            border-left-color: #0d6efd;
        }
        .order-card.delivered {
            border-left-color: #198754;
        }
        .order-card.cancelled {
            border-left-color: #dc3545;
        }
        
        /* Badges personalizados */
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-preparing {
            background-color: #fd7e14;
            color: #fff;
        }
        .badge-delivery {
            background-color: #0d6efd;
            color: #fff;
        }
        .badge-delivered {
            background-color: #198754;
            color: #fff;
        }
        .badge-cancelled {
            background-color: #dc3545;
            color: #fff;
        }
        
        /* Productos */
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        /* Navbar mejorado */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        /* Dashboard cards */
        .dashboard-card {
            border-left: 4px solid;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .dashboard-card.primary {
            border-left-color: #007bff;
        }
        .dashboard-card.success {
            border-left-color: #28a745;
        }
        .dashboard-card.warning {
            border-left-color: #ffc107;
        }
        .dashboard-card.danger {
            border-left-color: #dc3545;
        }
        .dashboard-card.info {
            border-left-color: #17a2b8;
        }
        
        /* Tablas mejoradas */
        .table-hover tbody tr:hover {
            background-color: rgba(0,123,255,0.1);
        }
        
        /* Botones modernos */
        .btn-modern {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        /* Alertas mejoradas */
        .alert-modern {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* Formularios modernos */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        
        /* Modales mejorados */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        /* Scroll personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0056b3;
        }
    </style>
</head>
<body> 