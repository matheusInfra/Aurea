<?php

//! CLASSE BASE PARA TODOS OS CONTROLLERS
//* Implementa padrão MVC - Camada de Controle
//* Responsável por intermediar entre Models (dados) e Views (interface)

class Controller
{
    //! MÉTODO PARA CARREGAR VIEWS
    //* Renderiza templates/páginas HTML com dados do controller
    //* @param string $views - Nome da view a ser carregada (sem extensão .php)
    //* @param array $dados - Array associativo com dados para a view
    public function carregarViews($views, $dados = array())
    {
        //! EXTRAÇÃO DE VARIÁVEIS PARA A VIEW
        //* Converte array associativo em variáveis individuais
        //* Exemplo: $dados['titulo'] vira $titulo na view
        extract($dados);

        //! INCLUSÃO DA VIEW
        //* Carrega arquivo PHP da view correspondente
        //* Exemplo: carregarViews('home', $dados) -> carrega '../app/views/home.php'
        require_once __DIR__ . '/../app/views/' . $views . '.php';
        //? Exemplo de uso: '../app/views/home.php'
    }
}
