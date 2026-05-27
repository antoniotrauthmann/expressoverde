<?php
class ProdutoModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function inserir($produto_nome, $categoria, $preco, $estoque, $descricao, $id_loja = null) {
        $stmt = $this->db->prepare(
            "INSERT INTO produto (produto_nome, categoria, preco, estoque, descricao, id_loja) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssdisi", $produto_nome, $categoria, $preco, $estoque, $descricao, $id_loja);
        $stmt->execute();

        return $stmt->insert_id; 
    }

    public function inserirImagem($id_produto, $produto_caminho_imagem) {
        $stmt = $this->db->prepare(
            "INSERT INTO imagens_produto (id_produto, produto_caminho_imagem) VALUES (?, ?)"
        );
        $stmt->bind_param("is", $id_produto, $produto_caminho_imagem);
        $stmt->execute();
    }

    public function buscarPorId($id_produto) {
        $stmt = $this->db->prepare("SELECT * FROM produto WHERE id_produto = ?");
        $stmt->bind_param("i", $id_produto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}