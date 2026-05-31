<?php

class RegistrarCompras
{
    private $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function registrarItemPedido($id_pedido, $id_produto, $quantidade, $preco_unitario)
    {
        $stmt = $this->db->prepare("INSERT INTO item_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $id_pedido, $id_produto, $quantidade, $preco_unitario);

        if (!$stmt->execute()) {
            $erro = $stmt->error ?? 'erro desconhecido';
            throw new RuntimeException("Erro ao registrar item do pedido: " . $erro);
        }
        return true;
    }

    public function registrarPedido($id_pedido, $id_usuario, $id_endereco, $id_assinatura, $status, $total, $criado_em)
    {
        $stmt = $this->db->prepare("INSERT INTO pedido (id_pedido, id_usuario, id_endereco, id_assinatura, `status`, total, criado_em) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiisds", $id_pedido, $id_usuario, $id_endereco, $id_assinatura, $status, $total, $criado_em);

        if (!$stmt->execute()) {
            $erro = $stmt->error ?? 'erro desconhecido';
            throw new RuntimeException("Erro ao registrar pedido: " . $erro);
        }

        return true;
    }
}
