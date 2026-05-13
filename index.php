<?php
session_start();
?>
<title>Expresso Verde</title>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/conexao.php';
require_once 'src/Controller/PostController.php';
require_once 'src/Controller/UsuarioController.php';
require_once 'src/Controller/ProdutoController.php';
require_once 'src/Controller/CarrinhoController.php';
require_once 'src/Controller/PedidoController.php';
require_once 'src/Controller/EnderecoController.php';

//(Roteamento simples)
$rota = $_GET['rota'] ?? 'login';

$controller = new PostController($mysqli);
$usuarioController = new UsuarioController($mysqli);
$produtoController = new ProdutoController($mysqli);
$carrinhoController = new CarrinhoController($mysqli);
$pedidoController = new PedidoController($mysqli);
$enderecoController = new EnderecoController($mysqli);

if ($rota === 'login') {
    $usuarioController->login();
} elseif ($rota === 'cadastro') {
    $usuarioController->cadastro();
} elseif ($rota === 'logout') {
    $usuarioController->logout();
} elseif ($rota === 'feed') {
    $controller->index();
} elseif ($rota === 'salvar') {
    $controller->salvar();
} elseif ($rota === 'curtir') {
    $controller->curtir();
} elseif ($rota === 'excluir') {
    $controller->excluir();
} elseif ($rota === 'manual') {
    include 'src/View/manualView.php';
} elseif ($rota === 'catalogo') {
    include 'src/View/Catalogo_produtos/index.php';
} elseif ($rota === 'produto') {
    include 'src/View/Produto/index.php';
} elseif ($rota === 'perfil') {
    include 'src/View/Perfil/index.php';
} elseif ($rota === 'cadastrar_produto') {
    $produtoController->cadastrar();
} elseif ($rota === 'carrinho') {
    $action = $_GET['action'] ?? null;
    if ($action === 'add') {
        $carrinhoController->add();
    } elseif ($action === 'remove') {
        $carrinhoController->remove();
    } elseif ($action === 'update') {
        $carrinhoController->update();
    } else {
        $carrinhoController->index();
    }
} elseif ($rota === 'testeVisualizacao') {
    include 'src/View/testeVisualizacao.php';
} elseif ($rota === 'editar_endereco') {
    $enderecoController->editar();
} elseif ($rota === 'cadastrar_endereco') {
    $enderecoController->cadastrar();
} elseif ($rota === 'checkout') {
    $pedidoController->checkout();
} elseif ($rota === 'pedidos') {
    $pedidoController->index();
} else {
    echo "<h1>404 - Rota não encontrada</h1>";
}