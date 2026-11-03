<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main class="d-flex align-items-center py-5" style="min-height: 70vh;">
    <div class="container text-center">
        <span class="hero-tag">Erro 404</span>
        <h1 class="display-1 fw-bold texto-dourado font-titulos mb-2">404</h1>
        <h2 class="display-6 texto-bege mb-3">Página Não Encontrada</h2>
        <div class="separador-aurea"></div>
        <p class="texto-mutado mx-auto mb-4" style="max-width: 500px;">
            A página que você está procurando não existe ou foi movida. Explore nossa alta gastronomia ou faça uma reserva exclusiva.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="<?php echo URL_BASE; ?>home" class="btn btn-aurea">
                <i class="bi bi-house me-1"></i> Ir para o Início
            </a>
            <a href="<?php echo URL_BASE; ?>cardapio" class="btn btn-aurea-outline">
                <i class="bi bi-book me-1"></i> Ver Cardápio
            </a>
        </div>
    </div>
</main>

<?php require_once('templates/footer.php'); ?>