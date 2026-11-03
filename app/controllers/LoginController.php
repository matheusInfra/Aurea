<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class LoginController extends Controller
{
    public function entrar()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método de requisição inválido.']);
            return;
        }

        // Validação de CSRF
        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validarTokenCSRF($token)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Sessão expirada. Recarregue a página e tente novamente.']);
            return;
        }

        $email = isset($_POST['email_cliente']) ? trim($_POST['email_cliente']) : '';
        $senha = isset($_POST['senha_cliente']) ? $_POST['senha_cliente'] : '';

        if (empty($email) || empty($senha)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
            return;
        }

        $clienteModel = new Cliente();
        $cliente = $clienteModel->buscarPorEmail($email);

        if (!$cliente || !password_verify($senha, $cliente['senha_cliente'])) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Credenciais incorretas ou conta inativa.']);
            return;
        }

        // Sessão segura: regenerar identificador para evitar session fixation
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        $_SESSION['id_cliente']    = (int)$cliente['id_cliente'];
        $_SESSION['nome_cliente']  = $cliente['nome_cliente'];
        $_SESSION['email_cliente'] = $cliente['email_cliente'];
        $_SESSION['tipo']          = 'cliente';

        // Redirecionamento inteligente: se veio da tela de reserva
        $redirect = URL_BASE . 'home';
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'reserva') !== false) {
            $redirect = URL_BASE . 'reserva';
        }

        echo json_encode([
            'sucesso'  => true,
            'mensagem' => 'Bem-vindo de volta, ' . htmlspecialchars($cliente['nome_cliente']) . '!',
            'redirect' => $redirect
        ]);
    }

    public function cadastrar()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método de requisição inválido.']);
            return;
        }

        $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validarTokenCSRF($token)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Sessão expirada. Recarregue a página.']);
            return;
        }

        $nome     = isset($_POST['nome_cliente']) ? trim($_POST['nome_cliente']) : '';
        $email    = isset($_POST['email_cliente']) ? trim($_POST['email_cliente']) : '';
        $telefone = isset($_POST['telefone_cliente']) ? trim($_POST['telefone_cliente']) : '';
        $senha    = isset($_POST['senha_cliente']) ? $_POST['senha_cliente'] : '';

        if (empty($nome) || empty($email) || empty($senha)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos obrigatórios devem ser preenchidos.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Por favor, informe um endereço de e-mail válido.']);
            return;
        }

        if (strlen($senha) < 6) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'A senha deve conter no mínimo 6 caracteres.']);
            return;
        }

        $clienteModel = new Cliente();

        if ($clienteModel->verificarEmailExiste($email)) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Este e-mail já está cadastrado em nosso sistema. Faça login.']);
            return;
        }

        $idNovoCliente = $clienteModel->cadastrar([
            'nome_cliente'     => $nome,
            'email_cliente'    => $email,
            'telefone_cliente' => $telefone,
            'senha_cliente'    => $senha
        ]);

        if ($idNovoCliente) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);

            $_SESSION['id_cliente']    = (int)$idNovoCliente;
            $_SESSION['nome_cliente']  = $nome;
            $_SESSION['email_cliente'] = $email;
            $_SESSION['tipo']          = 'cliente';

            $redirect = URL_BASE . 'reserva';

            echo json_encode([
                'sucesso'  => true,
                'mensagem' => 'Conta criada com sucesso! Redirecionando...',
                'redirect' => $redirect
            ]);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar conta. Tente novamente mais tarde.']);
        }
    }

    public function sair()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        header('Location: ' . URL_BASE . 'home');
        exit;
    }
}
