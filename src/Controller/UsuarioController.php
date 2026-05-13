<?php
require_once __DIR__ . '/../Model/UsuarioModel.php';

class UsuarioController {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function login() {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];

            $model = new UsuarioModel($this->db);
            $usuario = $model->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                $_SESSION['usuario_id']    = $usuario['id_usuario'];
                $_SESSION['usuario_nome']  = $usuario['usuario_nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_tipo']  = $usuario['tipo'];
                header("Location: index.php?rota=feed");
                exit();
            } else {
                $erro = "E-mail ou senha inválidos.";
            }
        }

        include __DIR__ . '/../View/Login/index.php';
    }

    public function cadastro() {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $conf  = $_POST['confirmar_senha'];
            $tipo = $_POST['tipo'];

            if ($senha !== $conf) {
                $erro = "As senhas não coincidem.";
            } else {
                $model = new UsuarioModel($this->db);

                if ($model->buscarPorEmail($email)) {
                    $erro = "Este e-mail já está cadastrado.";
                } else {
                    $hash = password_hash($senha, PASSWORD_BCRYPT);
                    $model->inserir($nome, $email, $hash, $tipo);
                    header("Location: index.php?rota=login");
                    exit();
                }
            }
        }

        include __DIR__ . '/../View/Cadastro_usuario/index.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?rota=login");
        exit();
    }
}