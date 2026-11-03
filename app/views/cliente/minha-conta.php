<?php require_once('../app/views/templates/head.php'); ?>
<?php require_once('../app/views/templates/cabecalho.php'); ?>

<main class="py-5">
    <div class="container">
        <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <span class="hero-tag">Meu Perfil</span>
            <h2 class="display-6 font-titulos mb-0">Minha <span class="texto-dourado fst-italic">Conta</span></h2>
        </div>

        <div class="row g-4">
            <!-- Coluna 1: Cartão de Perfil -->
            <div class="col-lg-4">
                <div class="card border border-warning border-opacity-25 shadow text-center p-4" style="background-color: var(--verde-escuro);">
                    <div class="mb-3">
                        <i class="bi bi-person-circle texto-dourado display-3"></i>
                    </div>
                    <h4 class="texto-bege mb-1"><?php echo htmlspecialchars($cliente['nome_cliente']); ?></h4>
                    <span class="badge bg-dark border border-warning text-warning small px-3 py-1 mb-3">Cliente Auréa</span>
                    <p class="text-bege small mb-4">
                        Membro desde <strong class="texto-dourado"><?php echo date('M/Y', strtotime($cliente['criado_em'])); ?></strong>
                    </p>

                    <div class="p-3 rounded border border-secondary border-opacity-25 text-start" style="background-color: var(--verde-dark);">
                        <div class="d-flex justify-content-between mb-2 small text-bege">
                            <span>Total de Reservas:</span>
                            <strong class="texto-dourado fs-6"><?php echo $total_reservas; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between small text-bege">
                            <span>Status da Conta:</span>
                            <span class="text-success fw-bold"><i class="bi bi-shield-check me-1"></i> Ativa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna 2: Dados Cadastrais & LGPD -->
            <div class="col-lg-8">
                <div class="card border border-warning border-opacity-25 shadow p-4" style="background-color: var(--verde-escuro);">
                    <h4 class="texto-dourado mb-4 font-titulos">Informações Pessoais</h4>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-bege small">Nome Completo</label>
                            <input type="text" class="form-control form-control-aurea" value="<?php echo htmlspecialchars($cliente['nome_cliente']); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-bege small">E-mail Cadastrado</label>
                            <input type="email" class="form-control form-control-aurea" value="<?php echo htmlspecialchars($cliente['email_cliente']); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-bege small">Telefone / WhatsApp</label>
                            <input type="text" class="form-control form-control-aurea" value="<?php echo htmlspecialchars($cliente['telefone_cliente'] ?? 'Não informado'); ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-bege small">Data de Registro</label>
                            <input type="text" class="form-control form-control-aurea" value="<?php echo date('d/m/Y H:i', strtotime($cliente['criado_em'])); ?>" readonly>
                        </div>
                    </div>

                    <!-- LGPD & Segurança Cibernética -->
                    <div class="alert alert-dark bg-transparent border-secondary border-opacity-50 p-3">
                        <h6 class="texto-bege small mb-2">
                            <i class="bi bi-shield-lock-fill texto-dourado me-1"></i> Proteção e Privacidade de Dados (LGPD)
                        </h6>
                        <p class="text-mutado small mb-0">
                            Seus dados cadastrais e registros de reservas são processados sob rigoroso controle de acesso e criptografia, utilizados exclusivamente para confirmação de mesa e identificação no tablet do restaurante.
                        </p>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="<?php echo URL_BASE; ?>cliente/minhasReservas" class="btn btn-aurea">
                            <i class="bi bi-calendar-check me-1"></i> Ver Minhas Reservas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once('../app/views/templates/footer.php'); ?>