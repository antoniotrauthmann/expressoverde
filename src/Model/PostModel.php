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

    public function buscarPorId($id_post) {
        $stmt = $this->db->prepare("SELECT * FROM post_comunidade WHERE id_post = ?");
        $stmt->bind_param("i", $id_post);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function inserir($id_usuario, $titulo, $conteudo, $post_caminho_imagem) {
        $stmt = $this->db->prepare("INSERT INTO post_comunidade (id_usuario, titulo, conteudo, post_caminho_imagem, curtidas) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("isss", $id_usuario, $titulo, $conteudo, $post_caminho_imagem);
        return $stmt->execute();
    }

    public function alternarCurtida($id_post, $id_usuario) {
        $stmt = $this->db->prepare("SELECT 1 FROM curtida_post WHERE id_post = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_post, $id_usuario);
        $stmt->execute();
        $jaCurtiu = $stmt->get_result()->fetch_assoc();

        if ($jaCurtiu) {
            $stmtDeletar = $this->db->prepare("DELETE FROM curtida_post WHERE id_post = ? AND id_usuario = ?");
            $stmtDeletar->bind_param("ii", $id_post, $id_usuario);
            $stmtDeletar->execute();

            $stmtDecrementar = $this->db->prepare("UPDATE post_comunidade SET curtidas = GREATEST(curtidas - 1, 0) WHERE id_post = ?");
            $stmtDecrementar->bind_param("i", $id_post);
            return $stmtDecrementar->execute();
        } else {
            $stmtInserir = $this->db->prepare("INSERT INTO curtida_post (id_post, id_usuario) VALUES (?, ?)");
            $stmtInserir->bind_param("ii", $id_post, $id_usuario);
            $stmtInserir->execute();

            $stmtIncrementar = $this->db->prepare("UPDATE post_comunidade SET curtidas = curtidas + 1 WHERE id_post = ?");
            $stmtIncrementar->bind_param("i", $id_post);
            return $stmtIncrementar->execute();
        }
    }
    
    public function excluirSeguro($id_post, $id_usuario) {
        $stmtCurtidas = $this->db->prepare("DELETE FROM curtida_post WHERE id_post = ?");
        $stmtCurtidas->bind_param("i", $id_post);
        $stmtCurtidas->execute();

        $stmt = $this->db->prepare("DELETE FROM post_comunidade WHERE id_post = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_post, $id_usuario);
        return $stmt->execute();
    }

    public function validarConteudo($texto) {
        $textoLimpo = trim($texto);
        return !empty($textoLimpo);
    }
}