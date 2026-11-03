<?php require_once('templates/head.php'); ?>
<?php require_once('templates/cabecalho.php'); ?>

<main class="py-5">
    <!-- Cabeçalho -->
    <section class="text-center py-4 mb-4" style="background: linear-gradient(rgba(20, 25, 23, 0.92), rgba(20, 25, 23, 0.92)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600&auto=format&fit=crop&q=80') center/cover;">
        <div class="container">
            <span class="hero-tag">Atendimento Exclusivo</span>
            <h1 class="display-4 mb-2">Solicitação de <span class="texto-dourado font-titulos fst-italic">Reserva</span></h1>
            <div class="separador-aurea"></div>
            <p class="text-bege mx-auto" style="max-width: 600px;">
                Complete os dados abaixo para reservar sua mesa. Nosso sistema valida em tempo real a disponibilidade de espaço e atendimento.
            </p>
        </div>
    </section>

    <div class="container">
        <!-- Indicador de Passos (Stepper) -->
        <div class="reserva-stepper mb-5">
            <div class="step-item active" id="stepIndicator1">
                <div class="step-num">1</div>
                <span>Data & Horário</span>
            </div>
            <div class="step-item" id="stepIndicator2">
                <div class="step-num">2</div>
                <span>Seleção da Mesa</span>
            </div>
            <div class="step-item" id="stepIndicator3">
                <div class="step-num">3</div>
                <span>Confirmação</span>
            </div>
        </div>

        <?php if (isset($_SESSION['erro_reserva'])): ?>
            <div class="alert alert-danger mx-auto mb-4" style="max-width: 850px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo htmlspecialchars($_SESSION['erro_reserva']); unset($_SESSION['erro_reserva']); ?>
            </div>
        <?php endif; ?>

        <div class="card border border-warning border-opacity-35 shadow-lg mx-auto" style="max-width: 850px; background-color: var(--verde-escuro);">
            <div class="card-body p-4 p-md-5">
                <form id="formReserva" method="POST" action="<?php echo URL_BASE; ?>reserva/confirmar">
                    <?php echo campoCSRF(); ?>

                    <!-- CAMPOS OCULTOS DE TRANSPORTE DO FORMULÁRIO -->
                    <input type="hidden" name="id_mesa" id="inputMesaId" required>
                    <input type="hidden" name="data_reserva" id="inputDataReserva" required>
                    <input type="hidden" name="hora_inicio" id="inputHoraInicio" required>
                    <input type="hidden" name="qtd_pessoas" id="inputQtdPessoas" value="2" required>

                    <!-- PASSO 1: DATA, HORÁRIO E PESSOAS -->
                    <div id="passo1">
                        <h4 class="texto-dourado mb-4 font-titulos">Passo 1: Escolha a Data, Horário e Convidados</h4>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="campoData" class="form-label text-bege fw-bold">Data da Visita *</label>
                                <input type="date" class="form-control form-control-aurea" id="campoData" min="<?php echo date('Y-m-d'); ?>" required>
                                <div class="form-text text-bege small mt-2">
                                    <i class="bi bi-info-circle texto-dourado me-1"></i> O restaurante não abre às segundas-feiras.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="campoPessoas" class="form-label text-bege fw-bold">Quantidade de Pessoas *</label>
                                <select class="form-select form-control-aurea" id="campoPessoas" required>
                                    <option value="1">1 Pessoa</option>
                                    <option value="2" selected>2 Pessoas</option>
                                    <option value="3">3 Pessoas</option>
                                    <option value="4">4 Pessoas</option>
                                    <option value="5">5 Pessoas</option>
                                    <option value="6">6 Pessoas</option>
                                    <option value="7">7 Pessoas</option>
                                    <option value="8">8 Pessoas</option>
                                </select>
                            </div>
                        </div>

                        <!-- Carregamento Dinâmico de Horários -->
                        <div class="mb-4">
                            <label class="form-label text-bege fw-bold d-block">Horários Disponíveis *</label>
                            
                            <div id="loadingHorarios" class="text-center py-3 d-none">
                                <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                                <span class="text-bege ms-2 small">Consultando horários de funcionamento...</span>
                            </div>

                            <div id="avisoHorarios" class="p-3 rounded border border-secondary border-opacity-25 text-bege small mb-2" style="background-color: rgba(20, 25, 23, 0.6);">
                                <i class="bi bi-calendar3 texto-dourado me-1"></i> Selecione uma data acima para carregar os horários disponíveis.
                            </div>

                            <div id="containerHorarios" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="text-end pt-3 border-top border-secondary border-opacity-25">
                            <button type="button" class="btn btn-aurea px-4 py-2" id="btnAvancarPasso1" disabled>
                                Avançar para Escolha da Mesa <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- PASSO 2: SELEÇÃO DA MESA -->
                    <div id="passo2" class="d-none">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="texto-dourado mb-0 font-titulos">Passo 2: Selecione sua Mesa</h4>
                            <span class="badge bg-dark border border-warning text-warning small px-3 py-2" id="badgeResumoPasso1"></span>
                        </div>

                        <div id="loadingMesas" class="text-center py-5 d-none">
                            <div class="spinner-border text-warning" role="status"></div>
                            <p class="text-bege mt-2">Buscando mesas disponíveis que comportam o grupo...</p>
                        </div>

                        <div id="avisoMesas" class="alert alert-warning d-none"></div>

                        <div class="row g-3 mb-4" id="containerMesas">
                            <!-- Mesas inseridas via JS -->
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top border-secondary border-opacity-25">
                            <button type="button" class="btn btn-aurea-outline px-4 py-2" id="btnVoltarPasso1">
                                <i class="bi bi-arrow-left me-1"></i> Voltar
                            </button>
                            <button type="button" class="btn btn-aurea px-4 py-2" id="btnAvancarPasso2" disabled>
                                Revisar Reserva <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- PASSO 3: CONFIRMAÇÃO & RESUMO -->
                    <div id="passo3" class="d-none">
                        <h4 class="texto-dourado mb-4 font-titulos">Passo 3: Revisão & Confirmação da Reserva</h4>

                        <div class="p-4 rounded border border-warning border-opacity-25 mb-4" style="background-color: var(--verde-dark);">
                            <h5 class="texto-bege mb-3 border-bottom border-secondary border-opacity-25 pb-2">Resumo da Reserva</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <strong class="texto-dourado d-block small">Titular da Reserva:</strong>
                                    <span class="text-white fs-6"><?php echo htmlspecialchars($_SESSION['nome_cliente']); ?></span>
                                </div>
                                <div class="col-sm-6">
                                    <strong class="texto-dourado d-block small">E-mail:</strong>
                                    <span class="text-white fs-6"><?php echo htmlspecialchars($_SESSION['email_cliente']); ?></span>
                                </div>
                                <div class="col-sm-4">
                                    <strong class="texto-dourado d-block small">Data:</strong>
                                    <span id="resumoData" class="text-white fw-bold fs-6">-</span>
                                </div>
                                <div class="col-sm-4">
                                    <strong class="texto-dourado d-block small">Horário:</strong>
                                    <span id="resumoHora" class="text-white fw-bold fs-6">-</span>
                                </div>
                                <div class="col-sm-4">
                                    <strong class="texto-dourado d-block small">Quantidade:</strong>
                                    <span id="resumoPessoas" class="text-white fw-bold fs-6">-</span>
                                </div>
                                <div class="col-12">
                                    <strong class="texto-dourado d-block small">Mesa Selecionada:</strong>
                                    <span id="resumoMesa" class="texto-bege fw-bold fs-6">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Observações Especiais -->
                        <div class="mb-4">
                            <label for="campoObservacoes" class="form-label text-bege fw-bold">Observações ou Preferências (Opcional)</label>
                            <textarea class="form-control form-control-aurea" id="campoObservacoes" name="observacoes" rows="3" placeholder="Ex: Aniversário, restrições alimentares de convidados, preferência por mesa tranquila..."></textarea>
                        </div>

                        <!-- Regras e Termos da Reserva -->
                        <div class="alert alert-dark bg-transparent border-secondary border-opacity-50 p-3 mb-4">
                            <h6 class="texto-bege small mb-2"><i class="bi bi-shield-check texto-dourado me-1"></i> Regras Importantes do Auréa:</h6>
                            <ul class="text-bege small ps-3 mb-0">
                                <li>Tolerância de chegada de até 15 minutos. Após esse período, a mesa poderá ser liberada.</li>
                                <li>O cancelamento sem custo pode ser feito até 2 horas antes do horário reservado pelo portal do cliente.</li>
                                <li>Ao confirmar, será gerado um <strong>Código Único de Reserva</strong> que será exigido no tablet ao chegar no restaurante.</li>
                            </ul>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input bg-dark border-secondary" type="checkbox" id="aceiteRegras" required>
                            <label class="form-check-label text-bege small" for="aceiteRegras">
                                Li e concordo com as regras de reserva e políticas de cancelamento do restaurante Auréa.
                            </label>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top border-secondary border-opacity-25">
                            <button type="button" class="btn btn-aurea-outline px-4 py-2" id="btnVoltarPasso2">
                                <i class="bi bi-arrow-left me-1"></i> Escolher Outra Mesa
                            </button>
                            <button type="submit" class="btn btn-aurea px-5 py-3" id="btnFinalizarReserva">
                                <i class="bi bi-check2-circle me-1"></i> Confirmar Minha Reserva
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let horarioSelecionado = null;
    let mesaSelecionada = null;

    const campoData = document.getElementById('campoData');
    const campoPessoas = document.getElementById('campoPessoas');
    const containerHorarios = document.getElementById('containerHorarios');
    const loadingHorarios = document.getElementById('loadingHorarios');
    const avisoHorarios = document.getElementById('avisoHorarios');
    const btnAvancarPasso1 = document.getElementById('btnAvancarPasso1');

    const passo1 = document.getElementById('passo1');
    const passo2 = document.getElementById('passo2');
    const passo3 = document.getElementById('passo3');

    const stepIndicator1 = document.getElementById('stepIndicator1');
    const stepIndicator2 = document.getElementById('stepIndicator2');
    const stepIndicator3 = document.getElementById('stepIndicator3');

    // 1. Carregar horários ao mudar a data
    campoData.addEventListener('change', function () {
        const data = this.value;
        if (!data) return;

        horarioSelecionado = null;
        btnAvancarPasso1.disabled = true;
        containerHorarios.innerHTML = '';
        loadingHorarios.classList.remove('d-none');
        avisoHorarios.classList.add('d-none');

        fetch(`<?php echo URL_BASE; ?>reserva/horarios?data=${data}`)
            .then(res => res.json())
            .then(res => {
                loadingHorarios.classList.add('d-none');

                if (!res.sucesso) {
                    avisoHorarios.className = 'alert alert-warning py-2 small';
                    avisoHorarios.textContent = res.mensagem;
                    avisoHorarios.classList.remove('d-none');
                    return;
                }

                if (res.horarios.length === 0) {
                    avisoHorarios.className = 'alert alert-secondary py-2 small';
                    avisoHorarios.textContent = 'Não há horários disponíveis para esta data hoje.';
                    avisoHorarios.classList.remove('d-none');
                    return;
                }

                res.horarios.forEach(h => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-sm btn-aurea-outline px-3 py-2 fw-bold';
                    btn.textContent = h;
                    btn.addEventListener('click', function () {
                        containerHorarios.querySelectorAll('button').forEach(b => {
                            b.classList.remove('btn-aurea');
                            b.classList.add('btn-aurea-outline');
                        });
                        this.classList.remove('btn-aurea-outline');
                        this.classList.add('btn-aurea');
                        horarioSelecionado = h;
                        btnAvancarPasso1.disabled = false;
                    });
                    containerHorarios.appendChild(btn);
                });
            })
            .catch(err => {
                loadingHorarios.classList.add('d-none');
                avisoHorarios.className = 'alert alert-danger py-2 small';
                avisoHorarios.textContent = 'Erro ao consultar horários. Tente novamente.';
                avisoHorarios.classList.remove('d-none');
            });
    });

    // 2. Avançar do Passo 1 para o Passo 2
    btnAvancarPasso1.addEventListener('click', function () {
        if (!campoData.value || !horarioSelecionado) return;

        document.getElementById('inputDataReserva').value = campoData.value;
        document.getElementById('inputHoraInicio').value = horarioSelecionado;
        document.getElementById('inputQtdPessoas').value = campoPessoas.value;

        // Atualizar badges
        document.getElementById('badgeResumoPasso1').textContent = 
            `${formatarDataBR(campoData.value)} às ${horarioSelecionado} — ${campoPessoas.value} pessoas`;

        passo1.classList.add('d-none');
        passo2.classList.remove('d-none');
        stepIndicator1.classList.replace('active', 'completed');
        stepIndicator2.classList.add('active');

        carregarMesasDisponiveis();
    });

    // 3. Voltar ao Passo 1
    document.getElementById('btnVoltarPasso1').addEventListener('click', function () {
        passo2.classList.add('d-none');
        passo1.classList.remove('d-none');
        stepIndicator2.classList.remove('active');
        stepIndicator1.classList.replace('completed', 'active');
    });

    // 4. Carregar Mesas Disponíveis
    function carregarMesasDisponiveis() {
        const data = campoData.value;
        const hora = horarioSelecionado;
        const pessoas = campoPessoas.value;

        const containerMesas = document.getElementById('containerMesas');
        const loadingMesas = document.getElementById('loadingMesas');
        const avisoMesas = document.getElementById('avisoMesas');
        const btnAvancarPasso2 = document.getElementById('btnAvancarPasso2');

        mesaSelecionada = null;
        btnAvancarPasso2.disabled = true;
        containerMesas.innerHTML = '';
        loadingMesas.classList.remove('d-none');
        avisoMesas.classList.add('d-none');

        fetch(`<?php echo URL_BASE; ?>reserva/mesas?data=${data}&hora=${hora}&pessoas=${pessoas}`)
            .then(res => res.json())
            .then(res => {
                loadingMesas.classList.add('d-none');

                if (!res.sucesso || res.mesas.length === 0) {
                    avisoMesas.textContent = 'Não encontramos mesas livres para esse horário com capacidade para ' + pessoas + ' pessoas. Tente outro horário.';
                    avisoMesas.classList.remove('d-none');
                    return;
                }

                res.mesas.forEach(m => {
                    const col = document.createElement('div');
                    col.className = 'col-sm-6 col-lg-4';
                    col.innerHTML = `
                        <div class="card-mesa-aurea" data-id="${m.id_mesa}">
                            <i class="bi bi-grid-3x3-gap-fill mesa-icone"></i>
                            <h5 class="texto-dourado mb-1">Mesa ${m.numero_mesa}</h5>
                            <span class="badge bg-secondary bg-opacity-50 text-white mb-2 fw-bold">${m.localizacao}</span>
                            <p class="text-bege small mb-1">Capacidade: <strong>Até ${m.capacidade} pessoas</strong></p>
                            <small class="text-white-50 d-block fst-italic">${m.descricao || ''}</small>
                        </div>
                    `;

                    col.querySelector('.card-mesa-aurea').addEventListener('click', function () {
                        containerMesas.querySelectorAll('.card-mesa-aurea').forEach(c => c.classList.remove('selected'));
                        this.classList.add('selected');
                        mesaSelecionada = m;
                        document.getElementById('inputMesaId').value = m.id_mesa;
                        btnAvancarPasso2.disabled = false;
                    });

                    containerMesas.appendChild(col);
                });
            })
            .catch(err => {
                loadingMesas.classList.add('d-none');
                avisoMesas.textContent = 'Erro ao buscar mesas disponíveis.';
                avisoMesas.classList.remove('d-none');
            });
    }

    // 5. Avançar do Passo 2 para o Passo 3
    document.getElementById('btnAvancarPasso2').addEventListener('click', function () {
        if (!mesaSelecionada) return;

        document.getElementById('resumoData').textContent = formatarDataBR(campoData.value);
        document.getElementById('resumoHora').textContent = horarioSelecionado;
        document.getElementById('resumoPessoas').textContent = `${campoPessoas.value} convidados`;
        document.getElementById('resumoMesa').textContent = `Mesa ${mesaSelecionada.numero_mesa} (${mesaSelecionada.localizacao} — até ${mesaSelecionada.capacidade} pessoas)`;

        passo2.classList.add('d-none');
        passo3.classList.remove('d-none');
        stepIndicator2.classList.replace('active', 'completed');
        stepIndicator3.classList.add('active');
    });

    // 6. Voltar ao Passo 2
    document.getElementById('btnVoltarPasso2').addEventListener('click', function () {
        passo3.classList.add('d-none');
        passo2.classList.remove('d-none');
        stepIndicator3.classList.remove('active');
        stepIndicator2.classList.replace('completed', 'active');
    });

    function formatarDataBR(dataStr) {
        if (!dataStr) return '';
        const partes = dataStr.split('-');
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
    }
});
</script>

<?php require_once('templates/footer.php'); ?>
