<header class="header-aurea">
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <!-- Logotipo do Restaurante Auréa -->
            <a class="navbar-brand-aurea" href="<?php echo URL_BASE; ?>home">
                <div>
                    <span class="logo-texto font-decorativa texto-dourado" style="font-size: 2.8rem;">Auréa</span>
                    <span class="logo-sub">Alta Gastronomia</span>
                </div>
            </a>

            <!-- Botão Menu Mobile -->
            <button class="navbar-toggler border-0 text-dourado" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAurea" aria-controls="navbarAurea" aria-expanded="false" aria-label="Alternar navegação">
                <i class="bi bi-list fs-1 texto-dourado"></i>
            </button>

            <!-- Links de Navegação -->
            <div class="collapse navbar-collapse" id="navbarAurea">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-aurea <?php echo (isset($dados['pagina_ativa']) && $dados['pagina_ativa'] === 'home') ? 'active' : ''; ?>" href="<?php echo URL_BASE; ?>home">
                            Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-aurea <?php echo (isset($dados['pagina_ativa']) && $dados['pagina_ativa'] === 'cardapio') ? 'active' : ''; ?>" href="<?php echo URL_BASE; ?>cardapio">
                            Cardápio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-aurea <?php echo (isset($dados['pagina_ativa']) && $dados['pagina_ativa'] === 'reserva') ? 'active' : ''; ?>" href="<?php echo URL_BASE; ?>reserva">
                            Reservas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-aurea <?php echo (isset($dados['pagina_ativa']) && $dados['pagina_ativa'] === 'localizacao') ? 'active' : ''; ?>" href="<?php echo URL_BASE; ?>localizacao">
                            Localização
                        </a>
                    </li>
                </ul>

                <!-- Ações do Cliente (Autenticação) -->
                <div class="d-flex align-items-center gap-3">
                    <?php if (isset($_SESSION['id_cliente'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-aurea-outline dropdown-toggle d-flex align-items-center gap-2" type="button" id="dropdownCliente" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 texto-dourado"></i>
                                <span><?php echo htmlspecialchars(explode(' ', $_SESSION['nome_cliente'])[0]); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-aurea dropdown-menu-end" aria-labelledby="dropdownCliente">
                                <li>
                                    <a class="dropdown-item" href="<?php echo URL_BASE; ?>cliente/minhasReservas">
                                        <i class="bi bi-calendar-check me-2 texto-dourado"></i> Minhas Reservas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo URL_BASE; ?>cliente/minhaConta">
                                        <i class="bi bi-person-gear me-2 texto-dourado"></i> Minha Conta
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider border-secondary"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?php echo URL_BASE; ?>login/sair">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <button type="button" class="btn btn-aurea-outline" data-bs-toggle="modal" data-bs-target="#modalLogin">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </button>
                        <button type="button" class="btn btn-aurea" data-bs-toggle="modal" data-bs-target="#modalCadastro">
                            <i class="bi bi-person-plus me-1"></i> Cadastrar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- MODAL DE LOGIN -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-aurea">
            <div class="modal-header modal-header-aurea">
                <h5 class="modal-title font-titulos text-uppercase tracking-wide" id="modalLoginLabel">
                    <i class="bi bi-key texto-dourado me-2"></i>Acessar Conta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4">
                <div id="alertaLogin" class="alert d-none" role="alert"></div>
                <form id="formLogin" method="POST" action="<?php echo URL_BASE; ?>login/entrar">
                    <?php echo campoCSRF(); ?>
                    
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label text-bege small">E-mail</label>
                        <input type="email" class="form-control form-control-aurea" id="loginEmail" name="email_cliente" placeholder="seuemail@exemplo.com" required autocomplete="email">
                    </div>

                    <div class="mb-4">
                        <label for="loginSenha" class="form-label text-bege small">Senha</label>
                        <input type="password" class="form-control form-control-aurea" id="loginSenha" name="senha_cliente" placeholder="••••••••" required autocomplete="current-password">
                    </div>

                    <button type="submit" class="btn btn-aurea w-100 py-3" id="btnLoginSubmit">
                        <span class="btn-texto">Entrar</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-mutado small">Ainda não possui conta?</span>
                    <a href="#" class="texto-dourado text-decoration-none fw-bold ms-1 small" data-bs-toggle="modal" data-bs-target="#modalCadastro">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE CADASTRO -->
<div class="modal fade" id="modalCadastro" tabindex="-1" aria-labelledby="modalCadastroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-aurea">
            <div class="modal-header modal-header-aurea">
                <h5 class="modal-title font-titulos text-uppercase tracking-wide" id="modalCadastroLabel">
                    <i class="bi bi-person-plus texto-dourado me-2"></i>Novo Cliente Auréa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-4">
                <div id="alertaCadastro" class="alert d-none" role="alert"></div>
                <form id="formCadastro" method="POST" action="<?php echo URL_BASE; ?>login/cadastrar">
                    <?php echo campoCSRF(); ?>

                    <div class="mb-3">
                        <label for="cadNome" class="form-label text-bege small">Nome Completo *</label>
                        <input type="text" class="form-control form-control-aurea" id="cadNome" name="nome_cliente" placeholder="Ex: Carlos Silva" required autocomplete="name">
                    </div>

                    <div class="mb-3">
                        <label for="cadEmail" class="form-label text-bege small">E-mail *</label>
                        <input type="email" class="form-control form-control-aurea" id="cadEmail" name="email_cliente" placeholder="seuemail@exemplo.com" required autocomplete="email">
                    </div>

                    <div class="mb-3">
                        <label for="cadTelefone" class="form-label text-bege small">Telefone / WhatsApp *</label>
                        <input type="tel" class="form-control form-control-aurea" id="cadTelefone" name="telefone_cliente" placeholder="(11) 98765-4321" required autocomplete="tel">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cadSenha" class="form-label text-bege small">Senha *</label>
                            <input type="password" class="form-control form-control-aurea" id="cadSenha" name="senha_cliente" minlength="6" placeholder="Mínimo 6 dígitos" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cadConfSenha" class="form-label text-bege small">Confirmar Senha *</label>
                            <input type="password" class="form-control form-control-aurea" id="cadConfSenha" name="confirmar_senha" minlength="6" placeholder="Repita a senha" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input bg-dark border-secondary" type="checkbox" id="aceiteTermos" required>
                        <label class="form-check-label text-mutado small" for="aceiteTermos">
                            Concordo com a Política de Privacidade e os Termos de Reserva em conformidade com a LGPD.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-aurea w-100 py-3" id="btnCadastroSubmit">
                        <span class="btn-texto">Criar Conta e Continuar</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <span class="text-mutado small">Já possui cadastro?</span>
                    <a href="#" class="texto-dourado text-decoration-none fw-bold ms-1 small" data-bs-toggle="modal" data-bs-target="#modalLogin">Fazer login</a>
                </div>
            </div>
        </div>
    </div>
</div>