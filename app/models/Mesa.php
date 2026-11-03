<?php
require_once __DIR__ . '/../../rotas/Model.php';

class Mesa extends Model
{
    public function getTodasMesas()
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT * FROM tbl_mesas WHERE ativa = 1 ORDER BY numero_mesa ASC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em Mesa::getTodasMesas: " . $e->getMessage());
            return [];
        }
    }

    public function getMesaById($id)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT * FROM tbl_mesas WHERE id_mesa = :id AND ativa = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Mesa::getMesaById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Retorna mesas ativas com capacidade compatível e que não tenham conflito de horário
     */
    public function getMesasDisponiveis($data, $hora_inicio, $hora_fim, $qtd_pessoas)
    {
        if (!$this->db) return [];
        try {
            // Mesas ativas que comportam o número de pessoas e não estão reservadas no intervalo
            $sql = "SELECT m.* 
                    FROM tbl_mesas m
                    WHERE m.ativa = 1
                      AND m.capacidade >= :qtd_pessoas
                      AND m.id_mesa NOT IN (
                          SELECT r.id_mesa 
                          FROM tbl_reservas r
                          WHERE r.data_reserva = :data_reserva
                            AND r.status_reserva = 'confirmada'
                            AND (
                                (:hora_inicio < r.hora_fim AND :hora_fim > r.hora_inicio)
                            )
                      )
                    ORDER BY m.capacidade ASC, m.numero_mesa ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':qtd_pessoas', (int)$qtd_pessoas, PDO::PARAM_INT);
            $stmt->bindValue(':data_reserva', $data);
            $stmt->bindValue(':hora_inicio', $hora_inicio);
            $stmt->bindValue(':hora_fim', $hora_fim);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em Mesa::getMesasDisponiveis: " . $e->getMessage());
            return [];
        }
    }

    public function verificarDisponibilidade($id_mesa, $data, $hora_inicio, $hora_fim, $excluir_reserva_id = null)
    {
        if (!$this->db) return false;
        try {
            $sql = "SELECT COUNT(*) as total
                    FROM tbl_reservas
                    WHERE id_mesa = :id_mesa
                      AND data_reserva = :data_reserva
                      AND status_reserva = 'confirmada'
                      AND (:hora_inicio < hora_fim AND :hora_fim > hora_inicio)";
            
            if ($excluir_reserva_id) {
                $sql .= " AND id_reserva != :excluir_id";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_mesa', (int)$id_mesa, PDO::PARAM_INT);
            $stmt->bindValue(':data_reserva', $data);
            $stmt->bindValue(':hora_inicio', $hora_inicio);
            $stmt->bindValue(':hora_fim', $hora_fim);
            if ($excluir_reserva_id) {
                $stmt->bindValue(':excluir_id', (int)$excluir_reserva_id, PDO::PARAM_INT);
            }
            $stmt->execute();
            $res = $stmt->fetch();
            return ($res && (int)$res['total'] === 0);
        } catch (PDOException $e) {
            error_log("Erro em Mesa::verificarDisponibilidade: " . $e->getMessage());
            return false;
        }
    }
}
