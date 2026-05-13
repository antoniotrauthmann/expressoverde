<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../src/Model/ProdutoModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'profissional') {
    http_response_code(401);
    echo json_encode(['erro' => 'Acesso negado. Faça login como profissional']);
    exit;
}

$body      = json_decode(file_get_contents('php://input'), true);
$nome      = trim($body['nome']      ?? '');
$categoria = $body['categoria']      ?? '';
$preco     = $body['preco']          ?? '';
$estoque   = $body['estoque']        ?? 0;
$descricao = trim($body['descricao'] ?? '');

if (!$nome || !$categoria || !$preco || !$descricao) {
    http_response_code(400);
    echo json_encode(['erro' => 'Nome, categoria, preço e descrição são obrigatórios']);
    exit;
}

$model = new ProdutoModel($mysqli);

try {
    $id_produto = $model->inserir($nome, $categoria, $preco, $estoque, $descricao);
    http_response_code(201);
    echo json_encode([
        'mensagem'   => 'Produto cadastrado com sucesso',
        'id_produto' => $id_produto
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar produto']);
}