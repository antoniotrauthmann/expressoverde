<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../src/Model/PostModel.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$metodo = $_SERVER['REQUEST_METHOD'];
$model = new PostModel($mysqli);

switch ($metodo) {
    case 'GET':
        $posts = $model->buscarTodos();
        echo json_encode($posts);
        break;

    case 'POST':
        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode(['erro' => 'Login necessário para postar']);
            exit;
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $conteudo = $body['conteudo'] ?? '';
        $id_usuario = $_SESSION['usuario_id'];
        $titulo = "Post via API";

        if (empty($conteudo)) {
            http_response_code(400);
            echo json_encode(['erro' => 'O conteúdo do post não pode estar vazio']);
            exit;
        }

        $sucesso = $model->inserir($id_usuario, $titulo, $conteudo, null);

        if ($sucesso) {
            echo json_encode(['mensagem' => 'Post criado com sucesso']);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao salvar post no banco de dados']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['erro' => 'Método não permitido']);
        break;
}