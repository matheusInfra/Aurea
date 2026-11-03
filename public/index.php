<?php
//! ARQUIVO PRINCIPAL DO SISTEMA SELMA FLOR
//* Este é o ponto de entrada único do sistema (Single Entry Point)
//* Todas as requisições passam por este arquivo através do sistema de rotas

//! CONFIGURAÇÕES DE DESENVOLVIMENTO
//* Habilitando exibição de erros para facilitar desenvolvimento e debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//! INICIALIZAÇÃO DA SESSÃO
//* Inicia sessão PHP para gerenciar dados de usuários logados (clientes e funcionários)
session_start();

//! CARREGAMENTO DAS CONFIGURAÇÕES
//* Carrega arquivo de configuração com constantes do banco de dados e URLs
require_once('../config/config.php');

//! INICIALIZAÇÃO DO SISTEMA DE ROTAS
//* Cria instância da classe Rotas e executa o roteamento
//* O sistema de rotas analisa a URL e direciona para o controller/método apropriado
$caminho = new Rotas();
$caminho->execultar();
