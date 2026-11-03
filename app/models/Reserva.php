<?php
require_once __DIR__ . '/../../rotas/Model.php';

class Reserva extends Model
{
    /**
     * Cria uma reserva utilizando transação e validação de concorrência
     */
    public function criarReserva($dados)
    {
        if (!$this->db) return ['sucesso' => false, 'mensagem' => 'Erro de conexão com o banco de dados.'];

        try {
            $this->db->beginTransaction();

            $id_cliente  = (int)$dados['id_cliente'];
            $id_mesa     = (int)$dados['id_mesa'];
            $data        = $dados['data_reserva'];
            $hora_inicio = $dados['hora_inicio'];
            $qtd_pessoas = (int)$dados['qtd_pessoas'];
            $observacoes = isset($dados['observacoes']) ? trim($dados['observacoes']) : null;

            // Duração padrão da reserva: 2 horas
            $hora_inicio_time = strtotime($hora_inicio);
            $hora_fim = date('H:i:s', strtotime('+2 hours', $hora_inicio_time));

            // 1. Revalidação: mesa existe e comporta a quantidade
            $stmtMesa = $this->db->prepare("SELECT capacidade, ativa FROM tbl_mesas WHERE id_mesa = :id FOR UPDATE");
            $stmtMesa->bindValue(':id', $id_mesa, PDO::PARAM_INT);
            $stmtMesa->execute();
            $mesa = $stmtMesa->fetch();

            if (!$mesa || (int)$mesa['ativa'] !== 1) {
                $this->db->rollBack();
                return ['sucesso' => false, 'mensagem' => 'A mesa selecionada não está disponível.'];
            }

            if ((int)$mesa['capacidade'] < $qtd_pessoas) {
                $this->db->rollBack();
                return ['sucesso' => false, 'mensagem' => 'A mesa selecionada não comporta a quantidade de pessoas informada.'];
            }

            // 2. Revalidação rigorosa de conflito de ocupação no banco
            $sqlConflito = "SELECT COUNT(*) as total 
                            FROM tbl_reservas 
                            WHERE id_mesa = :id_mesa 
                              AND data_reserva = :data_reserva 
                              AND status_reserva = 'confirmada'
                              AND (:hora_inicio < hora_fim AND :hora_fim > hora_inicio)";
            $stmtConf = $this->db->prepare($sqlConflito);
            $stmtConf->bindValue(':id_mesa', $id_mesa, PDO::PARAM_INT);
            $stmtConf->bindValue(':data_reserva', $data);
            $stmtConf->bindValue(':hora_inicio', $hora_inicio);
            $stmtConf->bindValue(':hora_fim', $hora_fim);
            $stmtConf->execute();
            $conf = $stmtConf->fetch();

            if ($conf && (int)$conf['total'] > 0) {
                $this->db->rollBack();
                return ['sucesso' => false, 'mensagem' => 'Infelizmente esta mesa acabou de ser reservada por outro cliente. Por favor, escolha outra mesa.'];
            }

            // 3. Gerar código único e não previsível (ex: AUR-20241015-8492)
            $prefixo = 'AUR-' . date('Ymd', strtotime($data)) . '-';
            $codigo = $prefixo . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

            // 4. Inserir reserva
            $sqlInsert = "INSERT INTO tbl_reservas 
                          (id_cliente, id_mesa, codigo_reserva, data_reserva, hora_inicio, hora_fim, qtd_pessoas, status_reserva, observacoes, criado_em)
                          VALUES (:id_cliente, :id_mesa, :codigo, :data_reserva, :hora_inicio, :hora_fim, :qtd_pessoas, 'confirmada', :observacoes, NOW())";
            $stmtIns = $this->db->prepare($sqlInsert);
            $stmtIns->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmtIns->bindValue(':id_mesa', $id_mesa, PDO::PARAM_INT);
            $stmtIns->bindValue(':codigo', $codigo);
            $stmtIns->bindValue(':data_reserva', $data);
            $stmtIns->bindValue(':hora_inicio', $hora_inicio);
            $stmtIns->bindValue(':hora_fim', $hora_fim);
            $stmtIns->bindValue(':qtd_pessoas', $qtd_pessoas, PDO::PARAM_INT);
            $stmtIns->bindValue(':observacoes', $observacoes);
            $stmtIns->execute();

            $id_reserva = $this->db->lastInsertId();
            $this->db->commit();

            return [
                'sucesso'        => true,
                'id_reserva'     => $id_reserva,
                'codigo_reserva' => $codigo,
                'mensagem'       => 'Reserva confirmada com sucesso!'
            ];
        } catch (PDOException $e) {
            if ($this->db && $this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Erro em Reserva::criarReserva: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Não foi possível processar a reserva. Tente novamente mais tarde.'];
        }
    }

    public function getReservasPorCliente($id_cliente)
    {
        if (!$this->db) return [];
        try {
            $sql = "SELECT r.*, m.numero_mesa, m.localizacao as localizacao_mesa, m.capacidade as capacidade_mesa
                    FROM tbl_reservas r
                    INNER JOIN tbl_mesas m ON r.id_mesa = m.id_mesa
                    WHERE r.id_cliente = :id_cliente
                    ORDER BY r.data_reserva DESC, r.hora_inicio DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_cliente', (int)$id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro em Reserva::getReservasPorCliente: " . $e->getMessage());
            return [];
        }
    }

    public function getReservaById($id)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT r.*, m.numero_mesa, m.localizacao as localizacao_mesa, c.nome_cliente, c.email_cliente, c.telefone_cliente
                    FROM tbl_reservas r
                    INNER JOIN tbl_mesas m ON r.id_mesa = m.id_mesa
                    INNER JOIN tbl_clientes c ON r.id_cliente = c.id_cliente
                    WHERE r.id_reserva = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Reserva::getReservaById: " . $e->getMessage());
            return null;
        }
    }

    public function getReservaPorCodigo($codigo)
    {
        if (!$this->db) return null;
        try {
            $sql = "SELECT r.*, m.numero_mesa, m.localizacao as localizacao_mesa, c.nome_cliente
                    FROM tbl_reservas r
                    INNER JOIN tbl_mesas m ON r.id_mesa = m.id_mesa
                    INNER JOIN tbl_clientes c ON r.id_cliente = c.id_cliente
                    WHERE r.codigo_reserva = :codigo LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', trim($codigo));
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro em Reserva::getReservaPorCodigo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cancelamento de reserva com validação de propriedade e prazo mínimo de 2 horas
     */
    public function cancelarReserva($id_reserva, $id_cliente, $motivo = 'Cancelado pelo cliente')
    {
        if (!$this->db) return ['sucesso' => false, 'mensagem' => 'Erro de conexão.'];

        try {
            // 1. Buscar a reserva
            $sql = "SELECT * FROM tbl_reservas WHERE id_reserva = :id AND id_cliente = :id_cliente LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', (int)$id_reserva, PDO::PARAM_INT);
            $stmt->bindValue(':id_cliente', (int)$id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            $reserva = $stmt->fetch();

            if (!$reserva) {
                return ['sucesso' => false, 'mensagem' => 'Reserva não encontrada ou você não tem permissão para cancelá-la.'];
            }

            if ($reserva['status_reserva'] !== 'confirmada') {
                return ['sucesso' => false, 'mensagem' => 'Esta reserva não pode ser cancelada pois está ' . $reserva['status_reserva'] . '.'];
            }

            // 2. Validação do prazo mínimo: 2 horas antes do início
            $dataHoraReserva = strtotime($reserva['data_reserva'] . ' ' . $reserva['hora_inicio']);
            $agora = time();
            $diferencaHoras = ($dataHoraReserva - $agora) / 3600;

            if ($diferencaHoras < 2) {
                return ['sucesso' => false, 'mensagem' => 'O cancelamento só é permitido com pelo menos 2 horas de antecedência ao horário agendado. Em caso de imprevistos, entre em contato direto com nossa equipe.'];
            }

            // 3. Atualizar status para cancelada
            $sqlUpdate = "UPDATE tbl_reservas 
                          SET status_reserva = 'cancelada', 
                              cancelamento_motivo = :motivo, 
                              cancelado_em = NOW() 
                          WHERE id_reserva = :id";
            $stmtUp = $this->db->prepare($sqlUpdate);
            $stmtUp->bindValue(':motivo', $motivo);
            $stmtUp->bindValue(':id', (int)$id_reserva, PDO::PARAM_INT);
            $stmtUp->execute();

            return ['sucesso' => true, 'mensagem' => 'Reserva cancelada com sucesso. A mesa foi liberada.'];
        } catch (PDOException $e) {
            error_log("Erro em Reserva::cancelarReserva: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao processar cancelamento. Tente novamente mais tarde.'];
        }
    }

    /**
     * Verifica se o restaurante abre na data e horário informados
     */
    public function verificarHorarioFuncionamento($data, $hora)
    {
        if (!$this->db) return false;
        try {
            $diaSemana = date('w', strtotime($data)); // 0=Domingo, 1=Segunda, etc.
            
            $sql = "SELECT * FROM tbl_horarios_funcionamento WHERE dia_semana = :dia AND ativo = 1 LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dia', (int)$diaSemana, PDO::PARAM_INT);
            $stmt->execute();
            $horario = $stmt->fetch();

            if (!$horario) {
                return false; // Fechado no dia
            }

            $horaConsulta = strtotime($hora);
            $horaAbertura = strtotime($horario['hora_abertura']);
            $horaFechamento = strtotime($horario['hora_fechamento']);

            // Se fechamento for 00:00 (meia-noite)
            if ($horario['hora_fechamento'] === '00:00:00') {
                $horaFechamento = strtotime('23:59:59');
            }

            return ($horaConsulta >= $horaAbertura && $horaConsulta <= $horaFechamento);
        } catch (PDOException $e) {
            error_log("Erro em Reserva::verificarHorarioFuncionamento: " . $e->getMessage());
            return false;
        }
    }
}
