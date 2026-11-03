<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class ClienteController extends Controller
{
    public function minhasReservas()
    {
        requireLogin();

        $reservaModel = new Reserva();
        $reservas = $reservaModel->getReservasPorCliente($_SESSION['id_cliente']);

        // Separar reservas em ativas (futuras/confirmadas) e histórico (concluídas/canceladas)
        $ativas = [];
        $historico = [];
        $hoje = date('Y-m-d');
        $horaAgora = date('H:i:s');

        foreach ($reservas as $r) {
            $eFutura = ($r['data_reserva'] > $hoje) || ($r['data_reserva'] === $hoje && $r['hora_fim'] >= $horaAgora);

            if ($r['status_reserva'] === 'confirmada' && $eFutura) {
                $ativas[] = $r;
            } else {
                $historico[] = $r;
            }
        }

        $dados = [
            'titulo'       => 'Minhas Reservas',
            'pagina_ativa' => 'cliente',
            'ativas'       => $ativas,
            'historico'    => $historico
        ];

        $this->carregarViews('cliente/minhas-reservas', $dados);
    }

    public function cancelarReserva()
    {
        requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método inválido.']);
            return;
        }

        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validarTokenCSRF($token)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Sessão expirada. Recarregue a página.']);
            return;
        }

        $id_reserva = isset($_POST['id_reserva']) ? (int)$_POST['id_reserva'] : 0;
        $motivo     = isset($_POST['motivo']) ? trim($_POST['motivo']) : 'Cancelado pelo cliente pelo portal';

        if (empty($id_reserva)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Reserva não identificada.']);
            return;
        }

        $reservaModel = new Reserva();
        $resultado = $reservaModel->cancelarReserva($id_reserva, $_SESSION['id_cliente'], $motivo);

        echo json_encode($resultado);
    }

    public function minhaConta()
    {
        requireLogin();

        $clienteModel = new Cliente();
        $reservaModel = new Reserva();

        $cliente = $clienteModel->buscarPorId($_SESSION['id_cliente']);
        $reservas = $reservaModel->getReservasPorCliente($_SESSION['id_cliente']);

        $dados = [
            'titulo'         => 'Minha Conta',
            'pagina_ativa'   => 'cliente',
            'cliente'        => $cliente,
            'total_reservas' => count($reservas)
        ];

        $this->carregarViews('cliente/minha-conta', $dados);
    }
}
