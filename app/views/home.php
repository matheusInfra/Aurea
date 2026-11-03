<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main>
    <!-- 1. HERO SECTION -->
    <section class="secao-hero-aurea">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="hero-tag">
                        <i class="bi bi-stars me-1"></i> Alta Gastronomia Contemporânea
                    </span>
                    <h1>
                        Onde o Sabor Encontra a <span class="texto-dourado font-titulos fst-italic">Elegância</span>
                    </h1>
                    <p>
                        Uma jornada sensorial inesquecível. Pratos autorais elaborados com ingredientes nobres, servidos em um ambiente sofisticado com atendimento exclusivo.
                    </p>

                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                        <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea">
                            <i class="bi bi-calendar-check me-1"></i> Reservar Mesa
                        </a>
                        <a href="<?php echo URL_BASE; ?>cardapio" class="btn btn-aurea-outline">
                            <i class="bi bi-journal-text me-1"></i> Conhecer o Cardápio
                        </a>
                    </div>

                    <!-- Badges de Excelência -->
                    <div class="hero-badges justify-content-center justify-content-lg-start">
                        <div class="hero-badge-item">
                            <i class="bi bi-award"></i>
                            <div>
                                <h6>Chef Premiado</h6>
                                <small>Criações autorais</small>
                            </div>
                        </div>
                        <div class="hero-badge-item">
                            <i class="bi bi-feather"></i>
                            <div>
                                <h6>Ingredientes Nobres</h6>
                                <small>Seleção diária</small>
                            </div>
                        </div>
                        <div class="hero-badge-item">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <h6>Reserva Exclusiva</h6>
                                <small>Sem filas ou espera</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto do Prato Principal em Destaque -->
                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <div class="hero-frame-img">
                        <img src="<?php echo URL_BASE; ?>assets/img/pratos/bowl-mediterrâneo.png" 
                             alt="Prato nobre do Auréa Restaurante" 
                             class="hero-dish-img img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. NÚMEROS & EXPERIÊNCIA -->
    <section class="py-5" style="background-color: var(--verde-escuro); border-bottom: 1px solid rgba(201, 168, 76, 0.2);">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <h2 class="display-5 fw-bold texto-dourado mb-1">12+</h2>
                    <p class="texto-bege text-uppercase small tracking-wide mb-0">Anos de Excelência</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="display-5 fw-bold texto-dourado mb-1">50+</h2>
                    <p class="texto-bege text-uppercase small tracking-wide mb-0">Receitas Autorais</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="display-5 fw-bold texto-dourado mb-1">10k+</h2>
                    <p class="texto-bege text-uppercase small tracking-wide mb-0">Clientes Encantados</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="display-5 fw-bold texto-dourado mb-1">4.9 ★</h2>
                    <p class="texto-bege text-uppercase small tracking-wide mb-0">Avaliação Média</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SIGNATURE COLLECTION (CARROSSEL COM IMAGENS ACHATADAS QUE SE EXPANDEM NO HOVER) -->
    <section class="py-5" style="padding: 90px 0;">
        <div class="container position-relative">
            <div class="text-center mb-5">
                <span class="hero-tag">Favoritos do Chef</span>
                <h2 class="display-5 mb-2">Coleção <span class="texto-dourado font-titulos fst-italic">Signature</span></h2>
                <div class="separador-aurea"></div>
                <p class="texto-bege mx-auto" style="max-width: 620px;">
                    Pratos desenhados com precisão artística para proporcionar uma experiência marcante a cada degustação.
                </p>
            </div>

            <?php if (!empty($pratos_destaque)): ?>
                <?php 
                // Agrupar pratos em slides de 3 itens
                $slides = array_chunk($pratos_destaque, 3);
                ?>

                <!-- CARROSSEL BOOTSTRAP COLEÇÃO -->
                <div id="carouselSignature" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6500">
                    <div class="carousel-inner pb-5">
                        <?php $slideIndex = 0; ?>
                        <?php foreach ($slides as $grupo): ?>
                            <div class="carousel-item <?php echo $slideIndex === 0 ? 'active' : ''; ?>">
                                <div class="row g-4 justify-content-center">
                                    <?php foreach ($grupo as $prato): ?>
                                        <?php 
                                        $nomeFoto = !empty($prato['foto_prato']) ? $prato['foto_prato'] : 'sem-foto.jpg';
                                        $foto = URL_BASE . 'assets/img/pratos/' . $nomeFoto;
                                        ?>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="card-prato-aurea">
                                                <!-- Container de imagem mais achatada que se expande no hover -->
                                                <div class="card-prato-img-wrapper">
                                                    <img src="<?php echo $foto; ?>" 
                                                         alt="<?php echo htmlspecialchars($prato['nome_prato']); ?>" 
                                                         class="card-prato-img"
                                                         onerror="this.onerror=null; this.src='<?php echo URL_BASE; ?>assets/img/pratos/sem-foto.jpg';">
                                                    <span class="card-prato-categoria-badge">
                                                        <?php echo htmlspecialchars($prato['nome_categoria']); ?>
                                                    </span>
                                                </div>
                                                <div class="card-prato-corpo">
                                                    <h3 class="card-prato-titulo"><?php echo htmlspecialchars($prato['nome_prato']); ?></h3>
                                                    <p class="card-prato-desc">
                                                        <?php echo htmlspecialchars($prato['descricao_prato']); ?>
                                                    </p>
                                                    
                                                    <?php if (!empty($prato['restricoes'])): ?>
                                                        <div class="mb-3">
                                                            <span class="badge bg-secondary bg-opacity-25 text-warning small border border-warning border-opacity-25">
                                                                <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($prato['restricoes']); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="card-prato-rodape">
                                                        <span class="card-prato-preco">
                                                            R$ <?php echo number_format((float)$prato['preco'], 2, ',', '.'); ?>
                                                        </span>
                                                        <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-sm btn-aurea-outline">
                                                            Reservar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php $slideIndex++; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controles de Navegação do Carrossel (Setas Douradas Elegantes) -->
                    <?php if (count($slides) > 1): ?>
                        <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
                            <button class="carousel-btn-aurea" type="button" data-bs-target="#carouselSignature" data-bs-slide="prev" aria-label="Anterior">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            
                            <div class="carousel-indicators position-static m-0 d-flex align-items-center">
                                <?php for ($s = 0; $s < count($slides); $s++): ?>
                                    <button type="button" data-bs-target="#carouselSignature" data-bs-slide-to="<?php echo $s; ?>" class="<?php echo $s === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $s + 1; ?>"></button>
                                <?php endfor; ?>
                            </div>

                            <button class="carousel-btn-aurea" type="button" data-bs-target="#carouselSignature" data-bs-slide="next" aria-label="Próximo">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <p class="texto-bege">Nenhum prato em destaque no momento.</p>
                </div>
            <?php endif; ?>

            <div class="text-center mt-5">
                <a href="<?php echo URL_BASE; ?>cardapio" class="btn btn-aurea px-4 py-3">
                    <i class="bi bi-book-half me-2"></i> Ver Todo o Cardápio
                </a>
            </div>
        </div>
    </section>

    <!-- 4. NOSSA HISTÓRIA / CONCEITO -->
    <section class="secao-historia-aurea">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="historia-mosaic">
                        <img src="<?php echo URL_BASE; ?>assets/img/historia1.jpg" 
                             alt="Chef executivo do Auréa" 
                             class="historia-img-principal img-fluid">
                        <img src="<?php echo URL_BASE; ?>assets/img/historia2.jpg" 
                             alt="Salão nobre do restaurante Auréa" 
                             class="historia-img-detalhe img-fluid d-none d-sm-block">
                    </div>
                </div>

                <div class="col-lg-6">
                    <span class="hero-tag">Nossa Essência</span>
                    <h2 class="display-5 mb-3">Paixão em Cada <span class="texto-dourado font-titulos fst-italic">Criação</span></h2>
                    <div class="separador-aurea ms-0"></div>
                    <p class="texto-bege mb-4">
                        O <strong>Auréa</strong> nasceu da convicção de que jantar fora não é apenas uma refeição, mas uma memória compartilhada. Nossas mesas foram pensadas para o conforto absoluto, enquanto nossos chefs transformam ingredientes puros em obras de arte.
                    </p>
                    <p class="texto-bege mb-4">
                        Por trabalharmos exclusivamente com reservas, garantimos que cada ingrediente seja preparado no momento ideal e que cada mesa desfrute de um atendimento privativo e sem pressa.
                    </p>

                    <div class="d-flex align-items-center gap-4 pt-3 border-top border-secondary border-opacity-25">
                        <div>
                            <span class="font-decorativa texto-dourado display-6">Auréa</span>
                            <span class="d-block small text-bege">Haute Cuisine Paris & São Paulo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. DEPOIMENTOS DE CLIENTES -->
    <section class="py-5" style="padding: 90px 0;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="hero-tag">O que Dizem Nossos Convidados</span>
                <h2 class="display-5 mb-2">Experiências <span class="texto-dourado font-titulos fst-italic">Inesquecíveis</span></h2>
                <div class="separador-aurea"></div>
            </div>

            <div class="row g-4">
                <?php if (!empty($feedbacks)): ?>
                    <?php foreach ($feedbacks as $fb): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card-depoimento-aurea">
                                <div class="depoimento-aspas">“</div>
                                <div class="depoimento-estrelas">
                                    <?php for ($i = 0; $i < (int)$fb['nota']; $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="texto-bege fst-italic mb-4">
                                    "<?php echo htmlspecialchars($fb['comentario']); ?>"
                                </p>
                                <div class="border-top border-secondary border-opacity-25 pt-3">
                                    <h6 class="texto-bege mb-0"><?php echo htmlspecialchars($fb['nome_cliente']); ?></h6>
                                    <small class="texto-dourado">Cliente Verificado</small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-depoimento-aurea">
                            <div class="depoimento-aspas">“</div>
                            <div class="depoimento-estrelas">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="texto-bege fst-italic mb-4">
                                "O carpaccio de wagyu e o pato confitado estavam impecáveis. O atendimento exclusivo sem filas fez toda a diferença."
                            </p>
                            <div class="border-top border-secondary border-opacity-25 pt-3">
                                <h6 class="texto-bege mb-0">Eduardo Vasconcelos</h6>
                                <small class="texto-dourado">São Paulo, SP</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-depoimento-aurea">
                            <div class="depoimento-aspas">“</div>
                            <div class="depoimento-estrelas">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="texto-bege fst-italic mb-4">
                                "Celebramos nosso aniversário de casamento na Área VIP. A privacidade, o menu harmonizado e a atenção da equipe superaram todas as expectativas."
                            </p>
                            <div class="border-top border-secondary border-opacity-25 pt-3">
                                <h6 class="texto-bege mb-0">Mariana & Gabriel Rios</h6>
                                <small class="texto-dourado">São Paulo, SP</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-depoimento-aurea">
                            <div class="depoimento-aspas">“</div>
                            <div class="depoimento-estrelas">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <p class="texto-bege fst-italic mb-4">
                                "O sistema de tablet na mesa associado ao nosso código de reserva foi super moderno e discreto. Uma das melhores cartas de vinhos do país."
                            </p>
                            <div class="border-top border-secondary border-opacity-25 pt-3">
                                <h6 class="texto-bege mb-0">Rodrigo Alencar</h6>
                                <small class="texto-dourado">Curitiba, PR</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 6. BANNER CTA FINAL DE RESERVA -->
    <section class="py-5 text-center text-white position-relative" 
             style="background: linear-gradient(rgba(20, 25, 23, 0.92), rgba(20, 25, 23, 0.92)), 
                    url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600&auto=format&fit=crop&q=80') center/cover fixed; 
                    padding: 100px 0; border-top: 1px solid rgba(201, 168, 76, 0.2);">
        <div class="container">
            <span class="hero-tag">Acesso Exclusivo</span>
            <h2 class="display-4 mb-3">Pronto para Vivenciar o <span class="texto-dourado font-titulos fst-italic">Auréa</span>?</h2>
            <div class="separador-aurea"></div>
            <p class="texto-bege mx-auto mb-4" style="max-width: 650px; font-size: 1.15rem;">
                Devido ao caráter artesanal de nossa cozinha, as reservas são limitadas diariamente. Garanta seu momento especial com antecedência.
            </p>
            <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea px-5 py-3 fs-6">
                <i class="bi bi-calendar-heart me-2"></i> Iniciar Reserva Agora
            </a>
        </div>
    </section>
</main>

<?php require_once('templates/footer.php'); ?>