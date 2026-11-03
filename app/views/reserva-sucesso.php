<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main class="py-5">
    <div class="container py-4">
        <div class="card border border-warning border-opacity-25 shadow-lg mx-auto text-center" style="max-width: 750px; background-color: var(--verde-escuro);">
            <div class="card-body p-4 p-md-5">
                <!-- Ícone de Sucesso -->
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill texto-dourado" style="font-size: 4.5rem;"></i>
                </div>

                <span class="hero-tag">Reserva Confirmada</span>
                <h2 class="display-5 mb-3 font-titulos text-white">Sua Experiência no Auréa está Garantida!</h2>
                <div class="separador-aurea"></div>

                <p class="texto-bege fs-5 mb-4">
                    Olá, <strong><?php echo htmlspecialchars($reserva['nome_cliente']); ?></strong>. Sua mesa exclusiva foi reservada com sucesso.
                </p>

                <!-- Box com o Código Único em Destaque -->
                <div class="codigo-reserva-box">
                    <span class="text-bege text-uppercase small tracking-wide d-block mb-1">Seu Código Único de Identificação</span>
                    <div class="codigo-reserva-destaque"><?php echo htmlspecialchars($reserva['codigo_reserva']); ?></div>
                    <small class="texto-mutado mt-2 d-block">
                        <i class="bi bi-tablet me-1"></i> Informe ou digite este código no tablet disponível na sua mesa ao chegar.
                    </small>
                </div>

                <!-- Resumo dos Dados -->
                <div class="p-3 rounded border border-secondary border-opacity-25 text-start mb-4" style="background-color: var(--verde-dark);">
                    <div class="row g-3 small text-mutado">
                        <div class="col-sm-6">
                            <strong class="texto-bege d-block">Data da Reserva:</strong>
                            <span class="text-white"><?php echo date('d/m/Y', strtotime($reserva['data_reserva'])); ?></span>
                        </div>
                        <div class="col-sm-6">
                            <strong class="texto-bege d-block">Horário de Chegada:</strong>
                            <span class="text-white"><?php echo substr($reserva['hora_inicio'], 0, 5); ?> (tolerância de 15 minutos)</span>
                        </div>
                        <div class="col-sm-6">
                            <strong class="texto-bege d-block">Mesa Reservada:</strong>
                            <span class="text-white">Mesa <?php echo $reserva['numero_mesa']; ?> — <?php echo htmlspecialchars($reserva['localizacao_mesa']); ?></span>
                        </div>
                        <div class="col-sm-6">
                            <strong class="texto-bege d-block">Convidados:</strong>
                            <span class="text-white"><?php echo $reserva['qtd_pessoas']; ?> pessoas</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="<?php echo URL_BASE; ?>cliente/minhasReservas" class="btn btn-aurea px-4 py-2">
                        <i class="bi bi-calendar-check me-1"></i> Acessar Minhas Reservas
                    </a>
                    <a href="<?php echo URL_BASE; ?>home" class="btn btn-aurea-outline px-4 py-2">
                        <i class="bi bi-house me-1"></i> Voltar ao Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once('templates/footer.php'); ?>