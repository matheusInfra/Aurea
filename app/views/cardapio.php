<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main class="py-5">
    <!-- Cabeçalho do Cardápio -->
    <section class="text-center py-5 mb-4" style="background: linear-gradient(rgba(20, 25, 23, 0.9), rgba(20, 25, 23, 0.9)), url('assets/img/bannercardapio.jpg') center/cover fixed;">
        <div class="containe
            <span class="hero-tag">Nossa Carta Gastronômica</span>
            <h1 class="display-4 mb-2">O <span class="texto-dourado font-titulos fst-italic">Cardápio</span> Auréa</h1>
            <div class="separador-aurea"></div>
            <p class="texto-bege mx-auto" style="max-width: 650px;">
                Criações autorais harmonizadas por nosso sommelier e preparadas artesanalmente para cada cliente com os mais frescos ingredientes da estação.
            </p>
        </div>
    </section>

    <div class="container">
        <!-- Filtro por Categorias -->
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <button class="btn btn-sm btn-aurea filter-cat-btn active" data-categoria="todas">
                Todas as Opções
            </button>
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $cat): ?>
                    <button class="btn btn-sm btn-aurea-outline filter-cat-btn" data-categoria="<?php echo $cat['id_categoria']; ?>">
                        <i class="bi <?php echo !empty($cat['icone_categoria']) ? htmlspecialchars($cat['icone_categoria']) : 'bi-tag'; ?> me-1"></i>
                        <?php echo htmlspecialchars($cat['nome_categoria']); ?>
                    </button>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Grid de Pratos -->
        <div class="row g-4" id="gridPratos">
            <?php if (!empty($pratos)): ?>
                <?php foreach ($pratos as $p): ?>
                    <?php 
                    $nomeFoto = !empty($p['foto_prato']) ? $p['foto_prato'] : 'sem-foto.jpg';
                    $imgPrato = URL_BASE . 'assets/img/pratos/' . $nomeFoto;
                    ?>
                    <div class="col-lg-4 col-md-6 prato-item" data-cat="<?php echo $p['id_categoria']; ?>">
                        <div class="card-prato-aurea">
                            <div class="card-prato-img-wrapper">
                                <img src="<?php echo $imgPrato; ?>" 
                                     alt="<?php echo htmlspecialchars($p['nome_prato']); ?>" 
                                     class="card-prato-img"
                                     onerror="this.onerror=null; this.src='<?php echo URL_BASE; ?>assets/img/pratos/sem-foto.jpg';">
                                <span class="card-prato-categoria-badge">
                                    <?php echo htmlspecialchars($p['nome_categoria']); ?>
                                </span>
                            </div>
                            <div class="card-prato-corpo">
                                <h3 class="card-prato-titulo"><?php echo htmlspecialchars($p['nome_prato']); ?></h3>
                                <p class="card-prato-desc">
                                    <?php echo htmlspecialchars($p['descricao_prato']); ?>
                                </p>

                                <?php if (!empty($p['ingredientes'])): ?>
                                    <div class="mb-2">
                                        <small class="text-bege d-block">
                                            <strong class="texto-dourado">Ingredientes:</strong> <?php echo htmlspecialchars($p['ingredientes']); ?>
                                        </small>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($p['restricoes'])): ?>
                                    <div class="mb-3">
                                        <span class="badge bg-secondary bg-opacity-25 text-warning small border border-warning border-opacity-25">
                                            <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($p['restricoes']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <div class="card-prato-rodape">
                                    <span class="card-prato-preco">
                                        R$ <?php echo number_format((float)$p['preco'], 2, ',', '.'); ?>
                                    </span>
                                    <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-sm btn-aurea-outline">
                                        <i class="bi bi-calendar-check me-1"></i> Reservar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="texto-mutado">Nenhum prato disponível no momento.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Banner de Reserva ao final do Cardápio -->
        <div class="mt-5 p-5 text-center rounded border border-warning border-opacity-25" style="background-color: var(--verde-escuro);">
            <h3 class="texto-dourado mb-2">Deseja Degustar Nosso Menu?</h3>
            <p class="texto-bege mb-4">Garantimos a mesa ideal para você e seus convidados com todo o requinte Auréa.</p>
            <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea px-4 py-3">
                <i class="bi bi-calendar-heart me-1"></i> Fazer Reserva Agora
            </a>
        </div>
    </div>
</main>

<script>
// Filtro dinâmico de pratos no navegador
document.addEventListener('DOMContentLoaded', function () {
    const botoes = document.querySelectorAll('.filter-cat-btn');
    const pratos = document.querySelectorAll('.prato-item');

    botoes.forEach(btn => {
        btn.addEventListener('click', function () {
            botoes.forEach(b => {
                b.classList.remove('active', 'btn-aurea');
                b.classList.add('btn-aurea-outline');
            });
            this.classList.add('active', 'btn-aurea');
            this.classList.remove('btn-aurea-outline');

            const cat = this.getAttribute('data-categoria');

            pratos.forEach(p => {
                if (cat === 'todas' || p.getAttribute('data-cat') === cat) {
                    p.style.display = 'block';
                } else {
                    p.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php require_once('templates/footer.php'); ?>
