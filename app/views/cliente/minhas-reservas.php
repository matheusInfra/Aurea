<?php require_once('../app/views/templates/head.php'); ?>
<?php require_once('../app/views/templates/cabecalho.php'); ?>

<main class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <span class="hero-tag">Área Exclusiva</span>
                <h2 class="display-6 font-titulos mb-0">Minhas <span class="texto-dourado fst-italic">Reservas</span></h2>
            </div>
            <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea mt-3 mt-md-0">
                <i class="bi bi-plus-circle me-1"></i> Nova Reserva
            </a>
        </div>

        <!-- Abas de Navegação -->
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="btn btn-sm btn-aurea active me-2" id="pills-ativas-tab" data-bs-toggle="pill" data-bs-target="#pills-ativas" type="button" role="tab" aria-selected="true">
                    <i class="bi bi-calendar-event me-1"></i> Reservas Confirmadas (<?php echo count($ativas); ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-sm btn-aurea-outline" id="pills-historico-tab" data-bs-toggle="pill" data-bs-target="#pills-historico" type="button" role="tab" aria-selected="false">
                    <i class="bi bi-clock-history me-1"></i> Histórico (<?php echo count($historico); ?>)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- 1. ABA ATIVAS -->
            <div class="tab-pane fade show active" id="pills-ativas" role="tabpanel">
                <?php if (!empty($ativas)): ?>
                    <div class="row g-4">
                        <?php foreach ($ativas as $res): ?>
                            <div class="col-lg-6">
                                <div class="card border border-warning border-opacity-35 shadow h-100" style="background-color: var(--verde-escuro);">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <span class="badge bg-success bg-opacity-25 text-success border border-success text-uppercase px-2 py-1 small fw-bold">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Confirmada
                                                </span>
                                            </div>
                                            <div class="text-end">
                                                <span class="d-block small text-bege fw-semibold">Código de Acesso</span>
                                                <strong class="texto-dourado font-monospace fs-4"><?php echo htmlspecialchars($res['codigo_reserva']); ?></strong>
                                            </div>
                                        </div>

                                        <h4 class="texto-bege mb-3">
                                            Mesa <?php echo $res['numero_mesa']; ?> — <?php echo htmlspecialchars($res['localizacao_mesa']); ?>
                                        </h4>

                                        <!-- Informações com alto contraste e visibilidade -->
                                        <div class="row g-3 mb-3 p-3 rounded" style="background-color: rgba(20, 25, 23, 0.7); border: 1px solid rgba(201, 168, 76, 0.15);">
                                            <div class="col-6 reserva-info-grid">
                                                <i class="bi bi-calendar3 texto-dourado me-1"></i>
                                                <strong class="text-white">Data:</strong>
                                                <span class="text-bege"><?php echo date('d/m/Y', strtotime($res['data_reserva'])); ?></span>
                                            </div>
                                            <div class="col-6 reserva-info-grid">
                                                <i class="bi bi-clock texto-dourado me-1"></i>
                                                <strong class="text-white">Horário:</strong>
                                                <span class="text-bege"><?php echo substr($res['hora_inicio'], 0, 5); ?> às <?php echo substr($res['hora_fim'], 0, 5); ?></span>
                                            </div>
                                            <div class="col-6 reserva-info-grid">
                                                <i class="bi bi-people texto-dourado me-1"></i>
                                                <strong class="text-white">Convidados:</strong>
                                                <span class="text-bege"><?php echo $res['qtd_pessoas']; ?> pessoas</span>
                                            </div>
                                            <div class="col-6 reserva-info-grid">
                                                <i class="bi bi-tablet texto-dourado me-1"></i>
                                                <strong class="text-white">Tablet:</strong>
                                                <span class="text-bege">Utilize seu código</span>
                                            </div>
                                        </div>

                                        <?php if (!empty($res['observacoes'])): ?>
                                            <div class="p-2 rounded bg-dark bg-opacity-75 border border-secondary border-opacity-50 mb-3 small text-bege">
                                                <strong class="texto-dourado">Obs:</strong> <?php echo htmlspecialchars($res['observacoes']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                                            <span class="text-bege small">
                                                <i class="bi bi-info-circle me-1 texto-dourado"></i> Cancelamento grátis até 2h antes
                                            </span>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-cancelar-reserva px-3 py-1 fw-bold" 
                                                    data-id="<?php echo $res['id_reserva']; ?>"
                                                    data-codigo="<?php echo htmlspecialchars($res['codigo_reserva']); ?>">
                                                <i class="bi bi-x-circle me-1"></i> Cancelar Reserva
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 rounded border border-secondary border-opacity-25" style="background-color: var(--verde-escuro);">
                        <i class="bi bi-calendar-x texto-dourado display-4 mb-3 d-block"></i>
                        <h4 class="texto-bege mb-2">Você não possui reservas futuras ativas</h4>
                        <p class="text-bege mb-4">Que tal planejar um almoço ou jantar inesquecível no Auréa hoje?</p>
                        <a href="<?php echo URL_BASE; ?>reserva" class="btn btn-aurea">
                            <i class="bi bi-calendar-check me-1"></i> Fazer uma Reserva
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 2. ABA HISTÓRICO -->
            <div class="tab-pane fade" id="pills-historico" role="tabpanel">
                <?php if (!empty($historico)): ?>
                    <div class="table-responsive rounded border border-secondary border-opacity-25 shadow">
                        <table class="table table-dark table-hover mb-0" style="background-color: var(--verde-escuro);">
                            <thead>
                                <tr class="text-bege border-secondary border-opacity-25 small text-uppercase">
                                    <th>Código</th>
                                    <th>Data & Horário</th>
                                    <th>Mesa</th>
                                    <th>Pessoas</th>
                                    <th>Status</th>
                                    <th>Observações / Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historico as $h): ?>
                                    <tr class="align-middle">
                                        <td class="font-monospace texto-dourado fw-bold"><?php echo htmlspecialchars($h['codigo_reserva']); ?></td>
                                        <td>
                                            <span class="text-white fw-bold"><?php echo date('d/m/Y', strtotime($h['data_reserva'])); ?></span><br>
                                            <span class="text-bege small"><?php echo substr($h['hora_inicio'], 0, 5); ?></span>
                                        </td>
                                        <td class="text-white">Mesa <?php echo $h['numero_mesa']; ?> (<?php echo htmlspecialchars($h['localizacao_mesa']); ?>)</td>
                                        <td class="text-white"><?php echo $h['qtd_pessoas']; ?></td>
                                        <td>
                                            <?php if ($h['status_reserva'] === 'cancelada'): ?>
                                                <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50">Cancelada</span>
                                            <?php elseif ($h['status_reserva'] === 'concluida'): ?>
                                                <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-50">Concluída</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($h['status_reserva']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-bege">
                                            <?php echo htmlspecialchars($h['cancelamento_motivo'] ?? $h['observacoes'] ?? '-'); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 rounded border border-secondary border-opacity-25" style="background-color: var(--verde-escuro);">
                        <p class="text-bege mb-0">Nenhuma reserva concluída ou cancelada no histórico.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Modal de Cancelamento de Reserva -->
<div class="modal fade" id="modalCancelarReserva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-aurea">
            <div class="modal-header modal-header-aurea">
                <h5 class="modal-title font-titulos text-danger">
                    <i class="bi bi-exclamation-octagon me-2"></i> Confirmar Cancelamento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="alertaCancelamento" class="alert d-none"></div>
                <p class="text-white">
                    Tem certeza de que deseja cancelar a reserva <strong class="texto-dourado font-monospace" id="cancelarCodigoText"></strong>?
                </p>
                <p class="text-bege small">
                    Ao confirmar, sua mesa será imediatamente liberada para outros clientes. Esta ação não poderá ser desfeita.
                </p>

                <div class="mb-3">
                    <label for="motivoCancelamento" class="form-label text-bege small">Motivo do Cancelamento (Opcional)</label>
                    <textarea class="form-control form-control-aurea" id="motivoCancelamento" rows="2" placeholder="Ex: Imprevisto pessoal..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-secondary border-opacity-25">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Manter Reserva</button>
                <button type="button" class="btn btn-danger btn-sm" id="btnConfirmarCancelamento">Confirmar Cancelamento</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let idReservaCancelar = null;
    const modalEl = document.getElementById('modalCancelarReserva');
    const modalCancelar = new bootstrap.Modal(modalEl);
    const alerta = document.getElementById('alertaCancelamento');
    const btnConfirmar = document.getElementById('btnConfirmarCancelamento');

    document.querySelectorAll('.btn-cancelar-reserva').forEach(btn => {
        btn.addEventListener('click', function () {
            idReservaCancelar = this.dataset.id;
            document.getElementById('cancelarCodigoText').textContent = this.dataset.codigo;
            alerta.className = 'alert d-none';
            modalCancelar.show();
        });
    });

    btnConfirmar.addEventListener('click', function () {
        if (!idReservaCancelar) return;

        btnConfirmar.disabled = true;
        btnConfirmar.textContent = 'Processando...';

        const formData = new FormData();
        formData.append('id_reserva', idReservaCancelar);
        formData.append('csrf_token', '<?php echo gerarTokenCSRF(); ?>');
        formData.append('motivo', document.getElementById('motivoCancelamento').value);

        fetch('<?php echo URL_BASE; ?>cliente/cancelarReserva', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                alerta.className = 'alert alert-success';
                alerta.textContent = data.mensagem;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alerta.className = 'alert alert-danger';
                alerta.textContent = data.mensagem;
                btnConfirmar.disabled = false;
                btnConfirmar.textContent = 'Confirmar Cancelamento';
            }
        })
        .catch(err => {
            console.error(err);
            alerta.className = 'alert alert-danger';
            alerta.textContent = 'Erro ao processar cancelamento.';
            btnConfirmar.disabled = false;
            btnConfirmar.textContent = 'Confirmar Cancelamento';
        });
    });
});
</script>

<?php require_once('../app/views/templates/footer.php'); ?>
