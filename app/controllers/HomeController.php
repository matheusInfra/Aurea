<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        $pratoModel = new Prato();
        $feedbackModel = new Feedback();

        $pratosDestaque = $pratoModel->getPratosDestaque(6);
        $feedbacks = $feedbackModel->getFeedbacksAprovados(3);

        $dados = [
            'titulo'         => 'Uma Experiência Gastronômica Inesquecível',
            'pagina_ativa'   => 'home',
            'pratos_destaque'=> $pratosDestaque,
            'feedbacks'      => $feedbacks
        ];

        $this->carregarViews('home', $dados);
    }
}
