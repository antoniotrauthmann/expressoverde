<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../src/Model/UsuarioModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

$body  = json_decode(file_get_contents('php://input'), true);
$nome  = trim($body['nome']  ?? '');
$email = trim($body['email'] ?? '');
$senha = $body['senha'] ?? '';
$conf  = $body['confirmar_senha'] ?? '';
$tipo  = $body['tipo'] ?? '';

if (!$nome || !$email || !$senha || !$conf || !$tipo) {
    http_response_code(400);
    echo json_encode(['erro' => 'Todos os campos são obrigatórios']);
    exit;
}

if ($senha !== $conf) {
    http_response_code(400);
    echo json_encode(['erro' => 'As senhas não coincidem']);
    exit;
}

$model = new UsuarioModel($mysqli);

if ($model->buscarPorEmail($email)) {
    http_response_code(409);
    echo json_encode(['erro' => 'Este e-mail já está cadastrado']);
    exit;
}

$hash = password_hash($senha, PASSWORD_BCRYPT);
$model->inserir($nome, $email, $hash, $tipo);

http_response_code(201);
echo json_encode(['mensagem' => 'Usuário cadastrado com sucesso']);