<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class ErroController extends Controller
{
    public function index()
    {
        $dados = [
            'titulo'       => 'Página Não Encontrada',
            'pagina_ativa' => 'erro'
        ];

        $this->carregarViews('erro', $dados);
    }
}