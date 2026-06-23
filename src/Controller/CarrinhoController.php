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
        // Atualizar estoque do banco para cada item do carrinho (garante dados frescos)
        $model = new ProdutoModel($this->db);
        foreach ($_SESSION['carrinho'] as $id => &$item) {
            $estoqueAtual = $model->buscarEstoque($id);
            $item['estoque'] = $estoqueAtual;
            // Se o estoque caiu abaixo da quantidade no carrinho, ajustar
            if ($item['quantidade'] > $estoqueAtual) {
                $item['quantidade'] = $estoqueAtual;
            }
            // Se estoque zerou, remover do carrinho
            if ($estoqueAtual <= 0) {
                unset($_SESSION['carrinho'][$id]);
            }
        }
        unset($item);

        include __DIR__ . '/../View/Carrinho/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto = (int)$_POST['id_produto'];
            $quantidade = (int)($_POST['quantidade'] ?? 1);

            $model = new ProdutoModel($this->db);
            $produto = $model->buscarPorId($id_produto);

            if ($produto) {
                // Verificar se o produto pertence à loja do usuário logado
                if (isset($_SESSION['usuario_id']) && !empty($produto['id_loja'])) {
                    $stmtLoja = $this->db->prepare("SELECT id_loja FROM usuario WHERE id_usuario = ?");
                    $stmtLoja->bind_param("i", $_SESSION['usuario_id']);
                    $stmtLoja->execute();
                    $resLoja = $stmtLoja->get_result()->fetch_assoc();
                    if ($resLoja && $resLoja['id_loja'] == $produto['id_loja']) {
                        // Vendedor tentando comprar próprio produto — bloquear
                        header("Location: index.php?rota=produto&p=" . $id_produto);
                        exit();
                    }
                }

                $estoqueDisponivel = (int)$produto['estoque'];
                $qtdAtualNoCarrinho = isset($_SESSION['carrinho'][$id_produto])
                    ? $_SESSION['carrinho'][$id_produto]['quantidade']
                    : 0;

                $novaQtd = $qtdAtualNoCarrinho + $quantidade;

                // Limitar à quantidade disponível em estoque
                if ($novaQtd > $estoqueDisponivel) {
                    $novaQtd = $estoqueDisponivel;
                }

                if ($novaQtd > 0) {
                    $_SESSION['carrinho'][$id_produto] = [
                        'id' => $produto['id_produto'],
                        'nome' => $produto['produto_nome'],
                        'preco' => $produto['preco'],
                        'quantidade' => $novaQtd,
                        'estoque' => $estoqueDisponivel
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
                    // Validar contra o estoque do banco
                    $model = new ProdutoModel($this->db);
                    $estoqueDisponivel = $model->buscarEstoque($id_produto);

                    if ($quantidade > $estoqueDisponivel) {
                        $quantidade = $estoqueDisponivel;
                    }

                    $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                    $_SESSION['carrinho'][$id_produto]['estoque'] = $estoqueDisponivel;
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
    
    /**
     * Atualiza quantidade via AJAX (retorna JSON, sem redirect)
     */
    public function updateAjax() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok' => false, 'erro' => 'Método inválido']);
            exit();
        }

        $id_produto = (int)($_POST['id_produto'] ?? 0);
        $quantidade = (int)($_POST['quantidade'] ?? 0);

        // Buscar estoque atual do banco
        $model = new ProdutoModel($this->db);
        $estoqueDisponivel = $model->buscarEstoque($id_produto);

        if ($quantidade > 0) {
            // Limitar ao estoque disponível
            if ($quantidade > $estoqueDisponivel) {
                $quantidade = $estoqueDisponivel;
            }

            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
                $_SESSION['carrinho'][$id_produto]['estoque'] = $estoqueDisponivel;
            }
        } else {
            $this->removeById($id_produto);
        }

        // Calcular novos totais
        $subtotal = 0;
        if (isset($_SESSION['carrinho'][$id_produto])) {
            $item = $_SESSION['carrinho'][$id_produto];
            $subtotal = $item['preco'] * $item['quantidade'];
        }

        $totalGeral = 0;
        $totalItens = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $totalGeral += $item['preco'] * $item['quantidade'];
            $totalItens += $item['quantidade'];
        }

        echo json_encode([
            'ok'         => true,
            'quantidade' => $quantidade,
            'estoque'    => $estoqueDisponivel,
            'subtotal'   => number_format($subtotal, 2, ',', '.'),
            'total'      => number_format($totalGeral, 2, ',', '.'),
            'totalItens' => $totalItens,
            'removido'   => $quantidade <= 0,
            'limitado'   => ((int)($_POST['quantidade'] ?? 0)) > $estoqueDisponivel
        ]);
        exit();
    }

    private function removeById($id) {
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }
}
