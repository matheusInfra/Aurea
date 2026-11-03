<footer class="footer-aurea mt-auto">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Coluna 1: Conceito Auréa -->
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <span class="logo-texto font-decorativa texto-dourado" style="font-size: 2.5rem;">Auréa</span>
                    <span class="logo-sub">Alta Gastronomia</span>
                </div>
                <p class="texto-mutado pe-lg-4">
                    Uma celebração diária aos sentidos. Cardápios autorais que combinam técnicas clássicas mundiais aos mais seletos ingredientes frescos e sazonais.
                </p>
                <div class="d-flex mt-3">
                    <a href="https://instagram.com" target="_blank" class="footer-social-link" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Coluna 2: Navegação -->
            <div class="col-lg-2 col-md-6">
                <h5>Navegação</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo URL_BASE; ?>home" class="footer-link">Início</a></li>
                    <li><a href="<?php echo URL_BASE; ?>cardapio" class="footer-link">Cardápio</a></li>
                    <li><a href="<?php echo URL_BASE; ?>reserva" class="footer-link">Reservas</a></li>
                    <li><a href="<?php echo URL_BASE; ?>localizacao" class="footer-link">Localização</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Horários de Funcionamento -->
            <div class="col-lg-3 col-md-6">
                <h5>Horários</h5>
                <ul class="list-unstyled texto-mutado small">
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Segunda-feira:</span>
                        <span class="text-danger">Fechado</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Terça a Sexta:</span>
                        <span class="text-white">12:00 – 23:00</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Sábado e Domingo:</span>
                        <span class="text-white">12:00 – 00:00</span>
                    </li>
                </ul>
                <div class="alert alert-dark bg-transparent border-warning border-opacity-25 p-2 mt-3">
                    <small class="texto-dourado d-block">
                        <i class="bi bi-info-circle me-1"></i> Atendimento exclusivo com reserva prévia.
                    </small>
                </div>
            </div>

            <!-- Coluna 4: Contato & Localização -->
            <div class="col-lg-3 col-md-6">
                <h5>Localização</h5>
                <ul class="list-unstyled texto-mutado small">
                    <li class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt texto-dourado mt-1"></i>
                        <span>Av. Paulista, 1000 — Bela Vista, São Paulo - SP</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telephone texto-dourado"></i>
                        <span>(11) 3000-0000</span>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope texto-dourado"></i>
                        <span>contato@restauranteaurea.com.br</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Linha inferior de direitos e créditos -->
        <div class="row pt-4 border-top border-secondary border-opacity-25 align-items-center">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <small class="texto-mutado">
                    &copy; <?php echo date('Y'); ?> Auréa Restaurante. Todos os direitos reservados. Projeto Integrador em Segurança Cibernética.
                </small>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <small class="texto-mutado">
                    Privacidade &middot; Termos de Uso &middot; LGPD Compliant
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Principal Auréa -->
<script src="<?php echo URL_BASE; ?>assets/js/script.js"></script>
</body>
</html>