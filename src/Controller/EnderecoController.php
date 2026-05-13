<?php
require_once __DIR__ . '/../Model/EnderecoModel.php';

class EnderecoController {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function cadastrar() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?rota=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['usuario_id'];
            $logradouro = trim($_POST['logradouro']);
            $bairro     = trim($_POST['bairro']);
            $cidade     = trim($_POST['cidade']);
            $cep        = trim($_POST['cep']);
            $zona       = $_POST['zona'];

            $model = new EnderecoModel($this->db);
            $model->inserir($id_usuario, $logradouro, $bairro, $cidade, $cep, $zona);

            // Redirecionar com base na origem
            $origin = $_GET['origin'] ?? '';
            if ($origin === 'perfil') {
                header("Location: index.php?rota=perfil");
            } else {
                header("Location: index.php?rota=checkout");
            }
            exit();
        }

        $origin = $_GET['origin'] ?? '';
        include __DIR__ . '/../View/Endereco/index.php';
    }

    public function editar() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?rota=login");
            exit();
        }

        $id_endereco = (int)($_GET['id'] ?? 0);
        $model = new EnderecoModel($this->db);
        $endereco = $model->buscarPorId($id_endereco);

        // Verificar se o endereço pertence ao usuário logado
        if (!$endereco || $endereco['id_usuario'] != $_SESSION['usuario_id']) {
            header("Location: index.php?rota=perfil");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $logradouro = trim($_POST['logradouro']);
            $bairro     = trim($_POST['bairro']);
            $cidade     = trim($_POST['cidade']);
            $cep        = trim($_POST['cep']);
            $zona       = $_POST['zona'];

            $model->atualizar($id_endereco, $logradouro, $bairro, $cidade, $cep, $zona);

            header("Location: index.php?rota=perfil");
            exit();
        }

        include __DIR__ . '/../View/Endereco/editar.php';
    }
}
