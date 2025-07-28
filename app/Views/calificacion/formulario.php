<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        .rating > input {
            display: none;
        }
        .rating > label {
            position: relative;
            width: 1.1em;
            font-size: 2rem;
            color: #FFD700;
            cursor: pointer;
        }
        .rating > label::before {
            content: "\2605";
            position: absolute;
            opacity: 0;
        }
        .rating > label:hover:before,
        .rating > label:hover ~ label:before {
            opacity: 1 !important;
        }
        .rating > input:checked ~ label:before {
            opacity: 1;
        }
        .rating:hover > input:checked ~ label:before {
            opacity: 0.4;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Calificar Pedido #<?= $pedido['codigo_seguimiento'] ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6>Detalles del Pedido:</h6>
                            <ul class="list-unstyled">
                                <li><strong>Cliente:</strong> <?= $pedido['nombre_cliente'] ?></li>
                                <li><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></li>
                                <li><strong>Total:</strong> $<?= number_format($pedido['total'], 2) ?></li>
                                <li><strong>Estado:</strong> 
                                    <span class="badge bg-success"><?= ucfirst(str_replace('_', ' ', $pedido['estado'])) ?></span>
                                </li>
                            </ul>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('calificar/procesar') ?>" method="post">
                            <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                            
                            <div class="mb-4">
                                <label class="form-label">¿Cómo calificarías tu experiencia?</label>
                                <div class="rating">
                                    <input type="radio" name="puntuacion" value="5" id="5" required>
                                    <label for="5">☆</label>
                                    <input type="radio" name="puntuacion" value="4" id="4" required>
                                    <label for="4">☆</label>
                                    <input type="radio" name="puntuacion" value="3" id="3" required>
                                    <label for="3">☆</label>
                                    <input type="radio" name="puntuacion" value="2" id="2" required>
                                    <label for="2">☆</label>
                                    <input type="radio" name="puntuacion" value="1" id="1" required>
                                    <label for="1">☆</label>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted">1 = Muy malo, 5 = Excelente</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="comentario" class="form-label">Comentario (opcional)</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="4" 
                                          placeholder="Cuéntanos sobre tu experiencia..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Enviar Calificación
                                </button>
                                <a href="<?= base_url('pedido/seguimiento/' . $codigo_seguimiento) ?>" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver al Seguimiento
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 