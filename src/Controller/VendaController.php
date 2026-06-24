<?php
require_once __DIR__ . '/../Model/PedidoModel.php';
require_once __DIR__ . '/../Model/ProdutoModel.php';

class VendaController {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    /**
     * Página principal da Central de Vendas
     */
    public function index() {
        // Verifica se o usuário está logado e é profissional
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'profissional') {
            header("Location: index.php?rota=catalogo");
            exit();
        }

        // Busca o id_loja do vendedor
        $stmt = $this->db->prepare("SELECT id_loja FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $id_loja = $result['id_loja'] ?? null;

        $pedidos = [];
        $rendaDiaria = [];

        if ($id_loja) {
            $pedidoModel = new PedidoModel($this->db);

            // Buscar pedidos do vendedor
            $pedidos = $pedidoModel->buscarPedidosPorVendedor($id_loja);

            // Para cada pedido, buscar os itens da loja e o endereço
            foreach ($pedidos as &$pedido) {
                $pedido['itens'] = $pedidoModel->buscarItensPorPedidoELoja($pedido['id_pedido'], $id_loja);
                $pedido['endereco'] = $pedidoModel->buscarEnderecoPorPedido($pedido['id_pedido']);
            }

            // Buscar renda diária
            $rendaDiaria = $pedidoModel->buscarRendaDiaria($id_loja);
        }

        $aba = $_GET['aba'] ?? 'pedidos';

        include __DIR__ . '/../View/Central_vendas/index.php';
    }

    /**
     * Atualiza o status de um pedido (POST)
     */
    public function atualizarStatus() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'profissional') {
            header("Location: index.php?rota=catalogo");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?rota=central_vendas");
            exit();
        }

        $id_pedido = (int)($_POST['id_pedido'] ?? 0);
        $novo_status = $_POST['novo_status'] ?? '';

        // Busca o id_loja do vendedor
        $stmt = $this->db->prepare("SELECT id_loja FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $_SESSION['usuario_id']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $id_loja = $result['id_loja'] ?? null;

        if ($id_loja) {
            $pedidoModel = new PedidoModel($this->db);

            // Verifica se o pedido contém produto dessa loja
            if ($pedidoModel->pedidoPertenceALoja($id_pedido, $id_loja)) {
                $pedidoModel->atualizarStatus($id_pedido, $novo_status);
                $_SESSION['venda_sucesso'] = 'Status do pedido atualizado com sucesso!';
            } else {
                $_SESSION['venda_erro'] = 'Você não tem permissão para alterar este pedido.';
            }
        }

        header("Location: index.php?rota=central_vendas&aba=pedidos");
        exit();
    }
}
