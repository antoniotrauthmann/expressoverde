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
}
