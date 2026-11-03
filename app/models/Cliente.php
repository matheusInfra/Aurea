<?php
require_once __DIR__ . '/../../rotas/Model.php';

class Cliente extends Model
{
    public function cadastrar($dados)
    {
        if (!$this->db) return false;
        try {
            $senhaHash = password_hash($dados['senha_cliente'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO tbl_clientes (nome_cliente, email_cliente, telefone_cliente, senha_cliente, ativo, criado_em)
                    VALUES (:nome, :email, :telefone, :senha, 1, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome', trim($dados['nome_cliente']));
            $stmt->bindValue(':email', strtolower(trim($dados['email_cliente'])));
            $stmt->bindValue(':telefone', isset($dados['telefone_cliente']) ? trim($dados['telefone_cliente']) : null);
            $stmt->bindValue(':senha', $senhaHash);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro em Cliente::cadastrar: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPorEmail($email)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT * FROM tbl_clientes WHERE email_cliente = :email AND ativo = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', strtolower(trim($email)));
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Cliente::buscarPorEmail: " . $e->getMessage());
            return null;
        }
    }

    public function verificarEmailExiste($email, $ignorarId = null)
    {
        if (!$this->db) return false;
        try {
            $sql = "SELECT id_cliente FROM tbl_clientes WHERE email_cliente = :email";
            if ($ignorarId) {
                $sql .= " AND id_cliente != :id";
            }
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', strtolower(trim($email)));
            if ($ignorarId) {
                $stmt->bindValue(':id', (int)$ignorarId, PDO::PARAM_INT);
            }
            $stmt->execute();
            return (bool)$stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Cliente::verificarEmailExiste: " . $e->getMessage());
            return false;
        }
    }

    public function buscarPorId($id)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT id_cliente, nome_cliente, email_cliente, telefone_cliente, ativo, criado_em 
                    FROM tbl_clientes WHERE id_cliente = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Cliente::buscarPorId: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarDados($id, $dados)
    {
        if (!$this->db) return false;
        try {
            $sql = "UPDATE tbl_clientes 
                    SET nome_cliente = :nome, telefone_cliente = :telefone
                    WHERE id_cliente = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome', trim($dados['nome_cliente']));
            $stmt->bindValue(':telefone', trim($dados['telefone_cliente']));
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro em Cliente::atualizarDados: " . $e->getMessage());
            return false;
        }
    }
}
