<?php
require_once __DIR__ . '/../../rotas/Model.php';

class Prato extends Model
{
    public function getPratosDestaque($limit = 6)
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT p.*, c.nome_categoria 
                    FROM tbl_pratos p
                    INNER JOIN tbl_categorias_cardapio c ON p.id_categoria = c.id_categoria
                    WHERE p.destaque = 1 AND p.disponivel = 1
                    ORDER BY p.id_prato ASC
                    LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em getPratosDestaque: " . $e->getMessage());
            return [];
        }
    }

    public function getTodosPratos()
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT p.*, c.nome_categoria 
                    FROM tbl_pratos p
                    INNER JOIN tbl_categorias_cardapio c ON p.id_categoria = c.id_categoria
                    WHERE p.disponivel = 1
                    ORDER BY c.ordem ASC, p.nome_prato ASC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em getTodosPratos: " . $e->getMessage());
            return [];
        }
    }

    public function getPratosPorCategoria($id_categoria)
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT p.*, c.nome_categoria 
                    FROM tbl_pratos p
                    INNER JOIN tbl_categorias_cardapio c ON p.id_categoria = c.id_categoria
                    WHERE p.id_categoria = :id_categoria AND p.disponivel = 1
                    ORDER BY p.nome_prato ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_categoria', (int)$id_categoria, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em getPratosPorCategoria: " . $e->getMessage());
            return [];
        }
    }

    public function getCategorias()
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT * FROM tbl_categorias_cardapio WHERE ativo = 1 ORDER BY ordem ASC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em getCategorias: " . $e->getMessage());
            return [];
        }
    }

    public function getPratoById($id)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT p.*, c.nome_categoria 
                    FROM tbl_pratos p
                    INNER JOIN tbl_categorias_cardapio c ON p.id_categoria = c.id_categoria
                    WHERE p.id_prato = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em getPratoById: " . $e->getMessage());
            return null;
        }
    }
}
