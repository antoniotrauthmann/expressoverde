<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/conexao.php';
require_once 'src/Controller/CarrinhoController.php';

// Rotas AJAX (precisam executar antes de qualquer output HTML)
$rota = $_GET['rota'] ?? 'catalogo';
$action = $_GET['action'] ?? null;

if ($rota === 'carrinho' && $action === 'update_ajax') {
    $carrinhoController = new CarrinhoController($mysqli);
    $carrinhoController->updateAjax();
    // updateAjax() já faz exit(), mas por segurança:
    exit();
}
?>
<title>Expresso Verde</title>
<?php
require_once 'src/Controller/PostController.php';
require_once 'src/Controller/UsuarioController.php';
require_once 'src/Controller/ProdutoController.php';
require_once 'src/Controller/PedidoController.php';
require_once 'src/Controller/EnderecoController.php';
require_once 'src/Controller/VendaController.php';


//(Roteamento simples)
$rota = $_GET['rota'] ?? 'catalogo';

$controller = new PostController($mysqli);
$usuarioController = new UsuarioController($mysqli);
$produtoController = new ProdutoController($mysqli);
$carrinhoController = new CarrinhoController($mysqli);
$pedidoController = new PedidoController($mysqli);
$enderecoController = new EnderecoController($mysqli);
$vendaController = new VendaController($mysqli);

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
    } elseif ($action === 'update_ajax') {
        $carrinhoController->updateAjax();
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
} elseif ($rota === 'cancelar_pedido') {
    $pedidoController->cancelar();
} elseif ($rota === 'editar_perfil'){
    include 'src/View/Perfil/editar_perfil.php';
} elseif ($rota === 'salvar_perfil') {
    $usuarioController->editarPerfil();
} elseif ($rota === 'busca') {
    include 'src/View/Busca/index.php';
} elseif ($rota === 'central_vendas') {
    $vendaController->index();
} elseif ($rota === 'atualizar_status_pedido') {
    $vendaController->atualizarStatus();
} else {
    echo "<h1>404 - Rota não encontrada</h1>";
}