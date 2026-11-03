<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class ReservaController extends Controller
{
    public function index()
    {
        // 1. Exige autenticação para reservar mesa
        requireLogin();

        $mesaModel = new Mesa();
        $todasMesas = $mesaModel->getTodasMesas();

        $dados = [
            'titulo'       => 'Reserve sua Mesa Exclusiva',
            'pagina_ativa' => 'reserva',
            'mesas'        => $todasMesas,
            'cliente'      => [
                'id'    => $_SESSION['id_cliente'],
                'nome'  => $_SESSION['nome_cliente'],
                'email' => $_SESSION['email_cliente']
            ]
        ];

        $this->carregarViews('reserva', $dados);
    }

    /**
     * Endpoint AJAX: Retorna horários disponíveis para a data selecionada
     */
    public function horarios()
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = isset($_GET['data']) ? trim($_GET['data']) : '';

        if (empty($data) || strtotime($data) < strtotime(date('Y-m-d'))) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Selecione uma data válida presente ou futura.']);
            return;
        }

        $diaSemana = (int)date('w', strtotime($data));

        // Segunda-feira (1): fechado
        if ($diaSemana === 1) {
            echo json_encode([
                'sucesso'  => false,
                'fechado'  => true,
                'mensagem' => 'O Auréa não abre às segundas-feiras. Por favor, selecione outra data.'
            ]);
            return;
        }

        // Slots padrão de reserva (2 horas por atendimento)
        $horarios = [
            '12:00', '13:00', '14:00',
            '19:00', '19:30', '20:00', '20:30', '21:00', '21:30'
        ];

        // Sábado e domingo permite reserva às 22:00
        if ($diaSemana === 0 || $diaSemana === 6) {
            $horarios[] = '22:00';
        }

        // Se a data for hoje, remover horários que já passaram
        if ($data === date('Y-m-d')) {
            $horaAtual = date('H:i');
            $horarios = array_values(array_filter($horarios, function ($h) use ($horaAtual) {
                return $h > $horaAtual;
            }));
        }

        echo json_encode([
            'sucesso'  => true,
            'fechado'  => false,
            'horarios' => $horarios
        ]);
    }

    /**
     * Endpoint AJAX: Retorna mesas disponíveis para data, hora e pessoas
     */
    public function mesas()
    {
        header('Content-Type: application/json; charset=utf-8');

        $data        = isset($_GET['data']) ? trim($_GET['data']) : '';
        $hora_inicio = isset($_GET['hora']) ? trim($_GET['hora']) : '';
        $qtd_pessoas = isset($_GET['pessoas']) ? (int)$_GET['pessoas'] : 2;

        if (empty($data) || empty($hora_inicio) || $qtd_pessoas <= 0) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Parâmetros incompletos para busca de mesas.']);
            return;
        }

        // Garante formato HH:MM:SS
        if (strlen($hora_inicio) === 5) {
            $hora_inicio .= ':00';
        }

        $hora_fim = date('H:i:s', strtotime('+2 hours', strtotime($hora_inicio)));

        $mesaModel = new Mesa();
        $mesasDisponiveis = $mesaModel->getMesasDisponiveis($data, $hora_inicio, $hora_fim, $qtd_pessoas);

        echo json_encode([
            'sucesso' => true,
            'mesas'   => $mesasDisponiveis,
            'total'   => count($mesasDisponiveis)
        ]);
    }

    /**
     * POST: Confirma a reserva no banco de dados e gera o código único
     */
    public function confirmar()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URL_BASE . 'reserva');
            exit;
        }

        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validarTokenCSRF($token)) {
            $_SESSION['erro_reserva'] = 'Sessão expirada. Por favor, tente novamente.';
            header('Location: ' . URL_BASE . 'reserva');
            exit;
        }

        $id_mesa     = isset($_POST['id_mesa']) ? (int)$_POST['id_mesa'] : 0;
        $data        = isset($_POST['data_reserva']) ? trim($_POST['data_reserva']) : '';
        $hora_inicio = isset($_POST['hora_inicio']) ? trim($_POST['hora_inicio']) : '';
        $qtd_pessoas = isset($_POST['qtd_pessoas']) ? (int)$_POST['qtd_pessoas'] : 0;
        $observacoes = isset($_POST['observacoes']) ? trim($_POST['observacoes']) : '';

        if (empty($id_mesa) || empty($data) || empty($hora_inicio) || empty($qtd_pessoas)) {
            $_SESSION['erro_reserva'] = 'Todos os dados da reserva devem ser preenchidos.';
            header('Location: ' . URL_BASE . 'reserva');
            exit;
        }

        if (strlen($hora_inicio) === 5) {
            $hora_inicio .= ':00';
        }

        $reservaModel = new Reserva();
        $resultado = $reservaModel->criarReserva([
            'id_cliente'   => $_SESSION['id_cliente'],
            'id_mesa'      => $id_mesa,
            'data_reserva' => $data,
            'hora_inicio'  => $hora_inicio,
            'qtd_pessoas'  => $qtd_pessoas,
            'observacoes'  => $observacoes
        ]);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_reserva'] = [
                'codigo' => $resultado['codigo_reserva'],
                'id'     => $resultado['id_reserva']
            ];
            header('Location: ' . URL_BASE . 'reserva/sucesso');
            exit;
        } else {
            $_SESSION['erro_reserva'] = $resultado['mensagem'];
            header('Location: ' . URL_BASE . 'reserva');
            exit;
        }
    }

    public function sucesso()
    {
        requireLogin();

        if (empty($_SESSION['sucesso_reserva'])) {
            header('Location: ' . URL_BASE . 'reserva');
            exit;
        }

        $dadosReserva = $_SESSION['sucesso_reserva'];
        $reservaModel = new Reserva();
        $reserva = $reservaModel->getReservaById($dadosReserva['id']);

        $dados = [
            'titulo'       => 'Reserva Confirmada com Sucesso!',
            'pagina_ativa' => 'reserva',
            'reserva'      => $reserva
        ];

        $this->carregarViews('reserva-sucesso', $dados);
    }
}
