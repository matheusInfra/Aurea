<?php

//! CLASSE PRINCIPAL DO SISTEMA DE ROTAS
//* Implementa padrão MVC com roteamento dinâmico baseado em URL
//* Converte URLs amigáveis em chamadas de controllers e métodos

class Rotas
{
    //! MÉTODO PRINCIPAL DE EXECUÇÃO DO ROTEAMENTO
    //* Analisa a URL atual e determina qual controller e método executar
    public function execultar()
    {
        //! INICIALIZAÇÃO DA URL BASE
        //* Define URL padrão como '/' (página inicial)
        $url = '/';

        //? ANÁLISE DA URL RECEBIDA
        //* Verifica se existe parâmetro 'url' na requisição GET
        //* Exemplo: /public/?url=produtos/listar -> $url = '/produtos/listar'
        if (isset($_GET['url'])) {
            $url .= $_GET['url'];
            // var_dump($url); // Debug: mostra URL processada
        }

        //! INICIALIZAÇÃO DO ARRAY DE PARÂMETROS
        //* Array para armazenar parâmetros adicionais da URL
        $parametro = array();

        //? PROCESSAMENTO DE URLS NÃO VAZIAS
        //* Se URL não está vazia e não é apenas '/', processa os segmentos
        if (!empty($url) && $url != '/') {

            //! DIVISÃO DA URL EM SEGMENTOS
            //* Divide URL por '/' para extrair controller, método e parâmetros
            //* Exemplo: '/produtos/listar/123' -> ['produtos', 'listar', '123']
            $url = explode('/', $url);
            array_shift($url); // Remove primeiro elemento vazio

            //! DETERMINAÇÃO DO CONTROLLER
            //* Primeiro segmento da URL vira o nome do controller
            //* Converte primeira letra para maiúscula e adiciona 'Controller'
            //* Exemplo: 'produtos' -> 'ProdutosController'
            $controladorAtual = ucfirst($url[0]) . 'Controller';

            //! REMOÇÃO DO SEGMENTO DO CONTROLLER
            //* Remove o primeiro elemento (controller) do array para processar método
            array_shift($url);

            //? DETERMINAÇÃO DO MÉTODO/AÇÃO
            //* Segundo segmento da URL vira o método do controller
            //* Se não existe segundo segmento, usa 'index' como padrão
            if (isset($url[0]) && !empty($url[0])) {
                $acaoAtual = $url[0];
                array_shift($url); // Remove método do array
            } else {
                $acaoAtual = 'index'; // Método padrão
                //echo $acaoAtual; // Debug: mostra método atual
            }

            //! CAPTURA DE PARÂMETROS ADICIONAIS
            //* Qualquer segmento restante na URL vira parâmetro para o método
            if (count($url) > 0) {
                $parametro = $url;
            }
        } else {
            //! CONFIGURAÇÃO PADRÃO PARA PÁGINA INICIAL
            //* Se URL está vazia ou é apenas '/', usa HomeController
            $controladorAtual = 'HomeController';
            $acaoAtual = 'index';
        }

        //! VALIDAÇÃO DE CONTROLLER E MÉTODO
        //* Verifica se o arquivo do controller existe e se o método existe
        //* Se não existir, redireciona para ErroController (ou retorna JSON se for requisição da API)
        if (!file_exists('../app/controllers/' . $controladorAtual . '.php') || !method_exists($controladorAtual, $acaoAtual)) {
            if ($controladorAtual === 'ApiController') {
                if (!headers_sent()) {
                    http_response_code(404);
                    header('Content-Type: application/json; charset=utf-8');
                }
                echo json_encode(["erro" => "Endpoint '{$acaoAtual}' não encontrado na API."], JSON_UNESCAPED_UNICODE);
                return;
            }
            $controladorAtual = "ErroController";
            $acaoAtual = "index";
        }

        //! INSTANCIAÇÃO E EXECUÇÃO DO CONTROLLER
        //* Cria instância do controller determinado
        //* Chama o método com os parâmetros extraídos da URL
        $controller = new $controladorAtual();
        call_user_func_array(array($controller, $acaoAtual), $parametro);
    }
}