<?php
require_once __DIR__ . '/../Model/ProdutoModel.php';

class CarrinhoController {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    public function index() {
        include __DIR__ . '/../View/Carrinho/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto = (int)$_POST['id_produto'];
            $quantidade = (int)($_POST['quantidade'] ?? 1);

            $model = new ProdutoModel($this->db);
            $produto = $model->buscarPorId($id_produto);

            if ($produto) {
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade;
                } else {
                    $_SESSION['carrinho'][$id_produto] = [
                        'id' => $produto['id_produto'],
                        'nome' => $produto['produto_nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => $quantidade
                    ];
                }
            }
        }
        header("Location: index.php?rota=carrinho");
        exit();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto = (int)$_POST['id_produto'];
            $quantidade = (int)$_POST['quantidade'];

            if ($quantidade > 0) {
                if (isset($_SESSION['carrinho'][$id_produto])) {
                    $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                }
            } else {
                $this->removeById($id_produto);
            }
        }
        header("Location: index.php?rota=carrinho");
        exit();
    }

    public function remove() {
        if (isset($_GET['id'])) {
            $this->removeById((int)$_GET['id']);
        }
        header("Location: index.php?rota=carrinho");
        exit();
    }
    
    private function removeById($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
}
