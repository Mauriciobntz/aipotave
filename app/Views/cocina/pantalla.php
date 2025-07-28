<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Cocina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .pantalla-header {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .pantalla-content {
            margin-top: 120px;
            padding: 20px;
        }
        
        .pedido-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            overflow: hidden;
            transition: all 0.3s ease;
            border-left: 8px solid;
        }
        
        .pedido-card.confirmado {
            border-left-color: #ffc107;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        }
        
        .pedido-card.en_preparacion {
            border-left-color: #007bff;
            background: linear-gradient(135deg, #cce7ff 0%, #b3d9ff 100%);
        }
        
        .pedido-card.listo {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        }
        
        .pedido-header {
            padding: 20px;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }
        
        .pedido-numero {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .pedido-estado {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 25px;
            text-transform: uppercase;
        }
        
        .estado-confirmado {
            background: #ffc107;
            color: #856404;
        }
        
        .estado-en_preparacion {
            background: #007bff;
            color: white;
        }
        
        .estado-listo {
            background: #28a745;
            color: white;
        }
        
        .pedido-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        
        .pedido-cliente {
            font-size: 1.3rem;
            font-weight: 600;
            color: #34495e;
        }
        
        .pedido-hora {
            font-size: 1.1rem;
            color: #7f8c8d;
            font-weight: 500;
        }
        
        .pedido-items {
            padding: 20px;
        }
        
        .item-lista {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .item {
            background: rgba(255, 255, 255, 0.8);
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #3498db;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .item-nombre {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .item-cantidad {
            background: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .item-notas {
            font-style: italic;
            color: #e67e22;
            margin-top: 5px;
            font-size: 0.9rem;
        }
        
        .timestamp {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
        }
        
        .no-pedidos {
            text-align: center;
            padding: 100px 20px;
            color: white;
            font-size: 2rem;
        }
        
        .no-pedidos i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.7;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pedido-card.confirmado {
            animation: pulse 2s infinite;
        }
        
        .pedido-card.en_preparacion {
            animation: pulse 3s infinite;
        }
    </style>
</head>
<body>
    <!-- Header fijo -->
    <div class="pantalla-header">
        <h1><i class="fas fa-utensils me-3"></i>PANEL DE COCINA</h1>
        <p class="mb-0">Pedidos en preparación</p>
    </div>
    
    <!-- Contenido principal -->
    <div class="pantalla-content">
        <?php if (empty($pedidos)): ?>
            <div class="no-pedidos">
                <i class="fas fa-check-circle"></i>
                <h2>¡Excelente trabajo!</h2>
                <p>No hay pedidos pendientes de preparación</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="pedido-card <?= $pedido['estado'] ?>">
                            <div class="pedido-header">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="pedido-numero">#<?= $pedido['id'] ?></div>
                                        <div class="pedido-cliente"><?= esc($pedido['nombre_cliente']) ?></div>
                                    </div>
                                    <div class="text-end">
                                        <div class="pedido-estado estado-<?= $pedido['estado'] ?>">
                                            <?= ucfirst(str_replace('_', ' ', $pedido['estado'])) ?>
                                        </div>
                                        <div class="pedido-hora">
                                            <?= date('H:i', strtotime($pedido['fecha'])) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if (!empty($pedido['observaciones'])): ?>
                                    <div class="mt-3 p-3 bg-warning bg-opacity-25 rounded">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Observaciones:</strong> <?= esc($pedido['observaciones']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="pedido-items">
                                <ul class="item-lista">
                                    <?php foreach ($pedido['detalles'] as $item): ?>
                                        <li class="item">
                                            <div class="flex-grow-1">
                                                <div class="item-nombre"><?= esc($item['producto_nombre']) ?></div>
                                                <?php if (!empty($item['observaciones'])): ?>
                                                    <div class="item-notas"><?= esc($item['observaciones']) ?></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="item-cantidad">x<?= $item['cantidad'] ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Timestamp -->
    <div class="timestamp">
        <i class="fas fa-clock me-2"></i>
        <?= date('d/m/Y H:i:s') ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-refresh cada 30 segundos
        setTimeout(function() {
            location.reload();
        }, 30000);
        
        // Actualizar timestamp cada segundo
        setInterval(function() {
            const now = new Date();
            const timestamp = now.toLocaleDateString('es-ES') + ' ' + now.toLocaleTimeString('es-ES');
            document.querySelector('.timestamp').innerHTML = '<i class="fas fa-clock me-2"></i>' + timestamp;
        }, 1000);
    </script>
</body>
</html> 