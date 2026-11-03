<?php
require_once __DIR__ . '/../../rotas/Model.php';

class Feedback extends Model
{
    public function getFeedbacksAprovados($limit = 3)
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT f.*, c.nome_cliente 
                    FROM tbl_feedbacks f
                    INNER JOIN tbl_clientes c ON f.id_cliente = c.id_cliente
                    WHERE f.aprovado = 1
                    ORDER BY f.id_feedback DESC
                    LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em Feedback::getFeedbacksAprovados: " . $e->getMessage());
            return [];
        }
    }
}
