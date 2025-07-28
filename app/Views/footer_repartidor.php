<footer class="bg-warning text-dark text-center py-3 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <small>
                    <i class="fas fa-clock me-1"></i>
                    <?= date('d/m/Y H:i:s') ?>
                </small>
            </div>
            <div class="col-md-6">
                <small>
                    <i class="fas fa-user me-1"></i>
                    <?= esc(session('user_name') ?? 'Repartidor') ?> - 
                    <?= ucfirst(session('user_role') ?? 'Repartidor') ?>
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 