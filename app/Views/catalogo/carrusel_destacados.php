<?php if (!empty($slides)): ?>
<div class="w-100 mt-5 pt-1">
    <div id="carouselSlides" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($slides as $index => $slide): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <a href="<?= !empty($slide['link_destino']) ? $slide['link_destino'] : '#' ?>" class="text-decoration-none">
                    <div class="slide-container">
                        <?php if (!empty($slide['imagen'])): ?>
                            <img src="<?= base_url('public/' . $slide['imagen']) ?>" 
                                 class="slide-img" 
                                 alt="<?= esc($slide['titulo'] ?? 'Slide') ?>"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="slide-placeholder">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['titulo']) || !empty($slide['subtitulo'])): ?>
                        <div class="slide-caption">
                            <?php if (!empty($slide['titulo'])): ?>
                                <h3 class="slide-title"><?= esc($slide['titulo']) ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($slide['subtitulo'])): ?>
                                <p class="slide-subtitle"><?= esc($slide['subtitulo']) ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($slides) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselSlides" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselSlides" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        
        <div class="carousel-indicators">
            <?php foreach ($slides as $index => $slide): ?>
            <button type="button" 
                    data-bs-target="#carouselSlides" 
                    data-bs-slide-to="<?= $index ?>" 
                    class="<?= $index === 0 ? 'active' : '' ?>"
                    aria-label="Slide <?= $index + 1 ?>">
            </button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<style>
.slide-container {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
}

.slide-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.slide-container:hover .slide-img {
    transform: scale(1.05);
}

.slide-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
}

.slide-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: white;
    padding: 2rem 1rem 1rem;
    text-align: center;
}

.slide-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.slide-subtitle {
    font-size: 1.1rem;
    margin-bottom: 0;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.carousel-indicators {
    bottom: 20px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
}

.carousel-indicators button.active {
    background-color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .slide-container {
        height: 300px;
    }
    
    .slide-title {
        font-size: 1.5rem;
    }
    
    .slide-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .slide-container {
        height: 250px;
    }
    
    .slide-title {
        font-size: 1.2rem;
    }
    
    .slide-subtitle {
        font-size: 0.9rem;
    }
    
    .slide-caption {
        padding: 1.5rem 0.75rem 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('carouselSlides');
    if (carousel) {
        new bootstrap.Carousel(carousel, {
            interval: 5000,
            wrap: true,
            pause: 'hover',
            keyboard: true
        });
    }
});
</script>