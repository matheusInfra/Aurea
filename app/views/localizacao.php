<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main class="py-5">
    <!-- Cabeçalho da Página -->
    <section class="text-center py-5 mb-5" style="background: linear-gradient(rgba(20, 25, 23, 0.9), rgba(20, 25, 23, 0.9)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600&auto=format&fit=crop&q=80') center/cover fixed;">
        <div class="container">
            <span class="hero-tag">Encontre Nosso Restaurante</span>
            <h1 class="display-4 mb-2">Localização & <span class="texto-dourado font-titulos fst-italic">Ambiente</span></h1>
            <div class="separador-aurea"></div>
            <p class="texto-bege mx-auto" style="max-width: 650px;">
                Situado no coração financeiro e cultural de São Paulo, o Auréa oferece fácil acesso, serviço de manobrista e uma atmosfera reservada.
            </p>
        </div>
    </section>

    <div class="container">
        <div class="row g-5 align-items-center mb-5">
            <!-- Informações Institucionais -->
            <div class="col-lg-5">
                <div class="p-4 rounded border border-warning border-opacity-25" style="background-color: var(--verde-escuro);">
                    <h3 class="texto-dourado mb-4 font-titulos">Informações do Estabelecimento</h3>
                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-geo-alt-fill fs-3 texto-dourado"></i>
                        <div>
                            <h6 class="texto-bege mb-1">Endereço</h6>
                            <p class="texto-mutado mb-0">Av. Paulista, 1000 — Bela Vista<br>São Paulo - SP, CEP 01310-100</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-clock-fill fs-3 texto-dourado"></i>
                        <div>
                            <h6 class="texto-bege mb-1">Horário de Funcionamento</h6>
                            <p class="texto-mutado mb-0">
                                <strong>Segunda:</strong> Fechado para manutenção<br>
                                <strong>Terça a Sexta:</strong> 12:00 às 23:00<br>
                                <strong>Sábado e Domingo:</strong> 12:00 às 00:00
                            </p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-telephone-fill fs-3 texto-dourado"></i>
                        <div>
                            <h6 class="texto-bege mb-1">Central de Atendimento</h6>
                            <p class="texto-mutado mb-0">(11) 3000-0000 | (11) 98765-4321</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-envelope-fill fs-3 texto-dourado"></i>
                        <div>
                            <h6 class="texto-bege mb-1">E-mail Corporativo</h6>
                            <p class="texto-mutado mb-0">contato@restauranteaurea.com.br</p>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-4">

                    <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea w-100 py-3">
                        <i class="bi bi-calendar-check me-2"></i> Reservar uma Mesa
                    </a>
                </div>
            </div>

            <!-- Mapa Interativo (Google Maps Embed) -->
            <div class="col-lg-7">
                <div class="rounded overflow-hidden border border-warning border-opacity-25 shadow-lg" style="height: 480px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.106696296001!2d-46.65438882379116!3d-23.56461117879796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c8da0aa315%3A0xd59f9431f2c9776a!2sAv.%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1715000000000!5m2!1spt-BR!2sbr" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Orientações de Como Chegar -->
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="p-4 rounded border border-secondary border-opacity-25 h-100" style="background-color: var(--verde-escuro);">
                    <i class="bi bi-train-front texto-dourado fs-2 mb-3 d-block"></i>
                    <h5 class="texto-bege mb-2">Transporte Público / Metrô</h5>
                    <p class="texto-mutado small mb-0">
                        Localizado a apenas 250 metros da Estação Trianon-MASP (Linha 2-Verde). Saída direta na Alameda Santos.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 rounded border border-secondary border-opacity-25 h-100" style="background-color: var(--verde-escuro);">
                    <i class="bi bi-car-front texto-dourado fs-2 mb-3 d-block"></i>
                    <h5 class="texto-bege mb-2">Valet & Estacionamento</h5>
                    <p class="texto-mutado small mb-0">
                        Serviço cortesia de manobrista (Valet) na porta principal do restaurante com segurança 24 horas.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 rounded border border-secondary border-opacity-25 h-100" style="background-color: var(--verde-escuro);">
                    <i class="bi bi-universal-access texto-dourado fs-2 mb-3 d-block"></i>
                    <h5 class="texto-bege mb-2">Acessibilidade Total</h5>
                    <p class="texto-mutado small mb-0">
                        Instalações totalmente adaptadas para pessoas com mobilidade reduzida, elevadores dedicados e banheiros acessíveis.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once('templates/footer.php'); ?>
