<?php
class PostModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function buscarTodos() {
        $sql = "SELECT p.*, u.usuario_nome FROM post_comunidade p INNER JOIN usuario u ON p.id_usuario = u.id_usuario ORDER BY p.id_post DESC";
        $resultado = $this->db->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function inserir($id_usuario, $titulo, $conteudo, $post_caminho_imagem) {
        $stmt = $this->db->prepare("INSERT INTO post_comunidade (id_usuario, titulo, conteudo, post_caminho_imagem, curtidas) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("isss", $id_usuario, $titulo, $conteudo, $post_caminho_imagem);
        return $stmt->execute();
    }

    public function adicionarCurtida($id_post) {
        $stmt = $this->db->prepare("UPDATE post_comunidade SET curtidas = curtidas + 1 WHERE id_post = ?");
        $stmt->bind_param("i", $id_post);
        return $stmt->execute();
    }
    
    public function excluirSeguro($id_post, $id_usuario) {
        $stmt = $this->db->prepare("DELETE FROM post_comunidade WHERE id_post = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_post, $id_usuario);
        return $stmt->execute();
    }
}