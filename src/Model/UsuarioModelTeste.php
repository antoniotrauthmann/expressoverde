<?php
class UsuarioModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare(
            "SELECT id_usuario, usuario_nome, email, senha_hash, tipo FROM usuario WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function inserir($nome, $email, $senha_hash, $tipo) {
        $stmt = $this->db->prepare(
            "INSERT INTO usuario (usuario_nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $tipo);
        $stmt->execute();
    }
}