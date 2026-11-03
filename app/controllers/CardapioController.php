<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class CardapioController extends Controller
{
    public function index()
    {
        $pratoModel = new Prato();
        $categorias = $pratoModel->getCategorias();
        $todosPratos = $pratoModel->getTodosPratos();

        $dados = [
            'titulo'       => 'Cardápio Exclusivo',
            'pagina_ativa' => 'cardapio',
            'categorias'   => $categorias,
            'pratos'       => $todosPratos
        ];

        $this->carregarViews('cardapio', $dados);
    }
}
