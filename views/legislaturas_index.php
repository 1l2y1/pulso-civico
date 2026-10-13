<?php
declare(strict_types=1);

use PulsoCivico\Core\Router;
use PulsoCivico\Core\ViewHelper;

/**
 * @var array $catalog
 * @var array $disponibles
 * @var array $seo
 */

$homeUrl = Router::url('/');

require __DIR__ . '/layout/header.php';
?>

<!-- Breadcrumbs -->
<nav aria-label="breadcrumb" class="breadcrumb-ios mb-3">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?= $homeUrl ?>">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Legislaturas</li>
    </ol>
</nav>

<!-- Hero Section -->
<div class="text-center py-4 py-md-5 mb-4">
    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 small fw-semibold mb-2">
        <i class="bi bi-bank me-1"></i>H. Congreso de la Unión
    </span>
    <h1 class="display-5 fw-bold text-dark mb-3">
        Legislaturas de México
    </h1>
    <p class="lead text-secondary mx-auto mb-4" style="max-width: 680px; font-size: 1.1rem;">
        Explora la integración, balances de poder y perfiles parlamentarios por periodo constitucional en la historia democrática de México.
    </p>
</div>

<!-- Grid de Legislaturas -->
<div class="row g-4 mb-5">
    <?php foreach ($catalog as $num => $leg): ?>
        <?php 
        $esActiva = (($leg['estatus'] ?? '') === 'activa');
        $tieneDatos = in_array($num, $disponibles, true);
        $url = Router::url('/legislaturas/' . $num);
        ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card-civic p-4 h-100 border <?= $esActiva ? 'border-primary shadow-sm bg-primary-subtle bg-opacity-10' : '' ?> d-flex flex-column justify-content-between transition-card">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                        <span class="h4 fw-bold <?= $esActiva ? 'text-primary' : 'text-dark' ?> mb-0">
                            <?= ViewHelper::e($leg['romano']) ?> Legislatura
                        </span>
                        <span class="badge bg-light text-secondary border">
                            <?= ViewHelper::e($leg['periodo']) ?>
                        </span>
                    </div>

                    <div class="mb-3">
                        <?php if ($esActiva): ?>
                            <span class="badge bg-primary text-white rounded-pill px-2 py-1 small">Actual &bull; En Funciones</span>
                        <?php elseif ($tieneDatos): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small">Dataset Disponible</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-1 small">Periodo Histórico</span>
                        <?php endif; ?>
                    </div>

                    <p class="text-secondary small mb-3">
                        <?= ViewHelper::e($leg['descripcion']) ?>
                    </p>
                </div>

                <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <a href="<?= $url ?>" class="btn btn-sm <?= $esActiva ? 'btn-primary' : 'btn-outline-primary' ?> rounded-pill px-3 py-1 fw-semibold small">
                        Ver información &rarr;
                    </a>
                    <a href="<?= ViewHelper::e($leg['sil_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-link text-secondary text-decoration-none small p-0" style="font-size: 0.75rem;">
                        SIL SEGOB ↗
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
