<?php
class PedidoModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function inserir($id_usuario, $id_endereco, $total) {
        $stmt = $this->db->prepare(
            "INSERT INTO pedido (id_usuario, id_endereco, total, status) VALUES (?, ?, ?, 'pendente')"
        );
        $stmt->bind_param("iid", $id_usuario, $id_endereco, $total);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function inserirItem($id_pedido, $id_produto, $quantidade, $preco_unitario) {
        $stmt = $this->db->prepare(
            "INSERT INTO item_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiid", $id_pedido, $id_produto, $quantidade, $preco_unitario);
        $stmt->execute();
    }

    public function buscarPorUsuario($id_usuario) {
        $stmt = $this->db->prepare(
            "SELECT * FROM pedido WHERE id_usuario = ? ORDER BY criado_em DESC"
        );
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarItensPorPedido($id_pedido) {
        $stmt = $this->db->prepare(
            "SELECT i.*, p.produto_nome FROM item_pedido i 
             JOIN produto p ON i.id_produto = p.id_produto 
             WHERE i.id_pedido = ?"
        );
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarEnderecoPorPedido($id_pedido) {
        $stmt = $this->db->prepare(
            "SELECT e.* FROM endereco e
             JOIN pedido p ON p.id_endereco = e.id_endereco
             WHERE p.id_pedido = ?"
        );
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    /**
     * Busca pedidos que contenham produtos da loja do vendedor
     */
    public function buscarPedidosPorVendedor($id_loja) {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT p.*, u.usuario_nome AS nome_comprador
             FROM pedido p
             JOIN item_pedido ip ON ip.id_pedido = p.id_pedido
             JOIN produto pr ON pr.id_produto = ip.id_produto
             JOIN usuario u ON u.id_usuario = p.id_usuario
             WHERE pr.id_loja = ?
             ORDER BY p.criado_em DESC"
        );
        $stmt->bind_param("i", $id_loja);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Busca itens de um pedido que pertencem a uma loja específica
     */
    public function buscarItensPorPedidoELoja($id_pedido, $id_loja) {
        $stmt = $this->db->prepare(
            "SELECT i.*, p.produto_nome FROM item_pedido i
             JOIN produto p ON i.id_produto = p.id_produto
             WHERE i.id_pedido = ? AND p.id_loja = ?"
        );
        $stmt->bind_param("ii", $id_pedido, $id_loja);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Atualiza o status de um pedido
     */
    public function atualizarStatus($id_pedido, $novo_status) {
        $statusValidos = ['pendente', 'confirmado', 'em_rota', 'entregue', 'cancelado'];
        if (!in_array($novo_status, $statusValidos)) return false;

        $stmt = $this->db->prepare("UPDATE pedido SET status = ? WHERE id_pedido = ?");
        $stmt->bind_param("si", $novo_status, $id_pedido);
        return $stmt->execute();
    }

    /**
     * Verifica se um pedido contém produto da loja
     */
    public function pedidoPertenceALoja($id_pedido, $id_loja) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM item_pedido ip
             JOIN produto p ON p.id_produto = ip.id_produto
             WHERE ip.id_pedido = ? AND p.id_loja = ?"
        );
        $stmt->bind_param("ii", $id_pedido, $id_loja);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    /**
     * Busca renda diária do vendedor (somente dias com vendas, exclui cancelados)
     */
    public function buscarRendaDiaria($id_loja) {
        $stmt = $this->db->prepare(
            "SELECT DATE(p.criado_em) AS dia,
                    SUM(ip.preco_unitario * ip.quantidade) AS total_dia
             FROM pedido p
             JOIN item_pedido ip ON ip.id_pedido = p.id_pedido
             JOIN produto pr ON pr.id_produto = ip.id_produto
             WHERE pr.id_loja = ? AND p.status != 'cancelado'
             GROUP BY DATE(p.criado_em)
             ORDER BY dia DESC"
        );
        $stmt->bind_param("i", $id_loja);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Cancela um pedido e restaura o estoque dos produtos
     */
    public function cancelarPedido($id_pedido, $id_usuario) {
        // Verifica se o pedido pertence ao usuário e pode ser cancelado
        $stmt = $this->db->prepare(
            "SELECT status FROM pedido WHERE id_pedido = ? AND id_usuario = ?"
        );
        $stmt->bind_param("ii", $id_pedido, $id_usuario);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_assoc();

        if (!$pedido) return false;
        if (in_array($pedido['status'], ['cancelado', 'entregue'])) return false;

        // Buscar itens do pedido para restaurar estoque
        $itens = $this->buscarItensPorPedido($id_pedido);

        // Iniciar transação
        $this->db->begin_transaction();

        try {
            // Atualizar status para cancelado
            $stmt = $this->db->prepare("UPDATE pedido SET status = 'cancelado' WHERE id_pedido = ?");
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();

            // Restaurar estoque de cada produto
            foreach ($itens as $item) {
                $stmt = $this->db->prepare(
                    "UPDATE produto SET estoque = estoque + ? WHERE id_produto = ?"
                );
                $stmt->bind_param("ii", $item['quantidade'], $item['id_produto']);
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
