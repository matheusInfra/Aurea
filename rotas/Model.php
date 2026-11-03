<?php
//! CLASSE BASE PARA TODOS OS MODELS
//* Implementa padrão MVC - Camada de Dados (Model)
//* Responsável por interação com banco de dados MySQL via PDO

class Model
{
    //! PROPRIEDADE PARA CONEXÃO COM BANCO
    protected $db;

    //! CONSTRUTOR DA CLASSE MODEL
    public function __construct()
    {
        try {
            // Suporta porta no host (ex: localhost:3307)
            $hostParts = explode(':', DB_HOST);
            $host = $hostParts[0];
            $port = isset($hostParts[1]) ? ';port=' . $hostParts[1] : '';

            $dsn = "mysql:dbname=" . DB_NAME . ";host=" . $host . $port . ";charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->db = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Falha de conexão com o banco de dados Auréa: " . $e->getMessage());
            // Não expor dados sensíveis ao usuário
            $this->db = null;
        }
    }

    public function getDb()
    {
        return $this->db;
    }
}
