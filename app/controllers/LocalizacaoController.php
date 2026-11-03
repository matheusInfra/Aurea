<?php
require_once __DIR__ . '/../../rotas/Controller.php';

class LocalizacaoController extends Controller
{
    public function index()
    {
        $dados = [
            'titulo'       => 'Localização & Contato',
            'pagina_ativa' => 'localizacao'
        ];

        $this->carregarViews('localizacao', $dados);
    }
}
