<?php
class EnderecoModel {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function buscarPrimeiroPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM endereco WHERE id_usuario = ? LIMIT 1");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function buscarTodosPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM endereco WHERE id_usuario = ? ORDER BY id_endereco DESC");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorId($id_endereco) {
        $stmt = $this->db->prepare("SELECT * FROM endereco WHERE id_endereco = ?");
        $stmt->bind_param("i", $id_endereco);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function inserir($id_usuario, $logradouro, $bairro, $cidade, $cep, $zona) {
        $stmt = $this->db->prepare(
            "INSERT INTO endereco (id_usuario, logradouro, bairro, cidade, cep, zona) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssss", $id_usuario, $logradouro, $bairro, $cidade, $cep, $zona);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function atualizar($id_endereco, $logradouro, $bairro, $cidade, $cep, $zona) {
        $stmt = $this->db->prepare(
            "UPDATE endereco SET logradouro = ?, bairro = ?, cidade = ?, cep = ?, zona = ? WHERE id_endereco = ?"
        );
        $stmt->bind_param("sssssi", $logradouro, $bairro, $cidade, $cep, $zona, $id_endereco);
        $stmt->execute();
    }
}
