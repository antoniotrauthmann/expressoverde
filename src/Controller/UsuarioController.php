<?php
require_once __DIR__ . '/../Model/UsuarioModel.php';

class UsuarioController
{
    private $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function login()
    {
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
                $_SESSION['login_erro'] = $erro;
                header('Location: index.php?rota=catalogo');
                exit;
            }
        }

        include __DIR__ . '/../View/Login/index.php';
    }

    public function cadastro()
    {
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

    public function logout()
    {
        session_destroy();
        header("Location: index.php?rota=catalogo");
        exit();
    }

    public function editarPerfil()
    {
        $id    = $_SESSION['usuario_id'];
        $nome  = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $errors = [];

        if (empty($nome)) $errors[] = 'Nome é obrigatório.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'E-mail inválido.';

        if (empty($errors)) {
            $stmt = $this->db->prepare("SELECT id_usuario FROM usuario WHERE email = ? AND id_usuario != ?");
            $stmt->bind_param("si", $email, $id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors[] = 'Este e-mail já está em uso.';
            }
        }

        if (empty($errors)) {
            $stmt = $this->db->prepare("UPDATE usuario SET usuario_nome = ?, email = ? WHERE id_usuario = ?");
            $stmt->bind_param("ssi", $nome, $email, $id);
            $stmt->execute();
            $_SESSION['usuario_nome']  = $nome;
            $_SESSION['usuario_email'] = $email;
            header('Location: index.php?rota=perfil&sucesso=1');
            exit;
        }

        $_SESSION['perfil_errors'] = $errors;
        $_SESSION['perfil_old']    = ['nome' => $nome, 'email' => $email];
        header('Location: index.php?rota=editar_perfil');
        exit;
    }
}
