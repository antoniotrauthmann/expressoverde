<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../src/Model/UsuarioModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);
$email = trim($body['email'] ?? '');
$senha = $body['senha'] ?? '';

if (!$email || !$senha) {
    http_response_code(400);
    echo json_encode(['erro' => 'Email e senha são obrigatórios']);
    exit;
}

$model = new UsuarioModel($mysqli);
$usuario = $model->buscarPorEmail($email);

if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'E-mail ou senha inválidos']);
    exit;
}

$_SESSION['usuario_id']    = $usuario['id_usuario'];
$_SESSION['usuario_nome']  = $usuario['usuario_nome'];
$_SESSION['usuario_email'] = $usuario['email'];
$_SESSION['usuario_tipo']  = $usuario['tipo'];

http_response_code(200);
echo json_encode([
    'mensagem' => 'Login realizado com sucesso',
    'usuario'  => [
        'id'   => $usuario['id_usuario'],
        'nome' => $usuario['usuario_nome'],
        'tipo' => $usuario['tipo']
    ]
]);