<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/ProdutoModel.php';

/**
 * Testes unitários para a lógica do Carrinho de Compras.
 *
 * Como o CarrinhoController usa header()/exit() nos métodos de ação,
 * deve ser testado a lógica do carrinho isolando as operações de sessão
 * e a interação com o ProdutoModel.
 */
class CarrinhoControllerTest extends TestCase {

    private $mysqliMock;
    private $stmtMock;
    private $resultMock;

    protected function setUp(): void {
        $_SESSION = [];
        $_POST = [];
        $_GET = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->mysqliMock = $this->createMock(mysqli::class);
        $this->stmtMock = $this->createMock(mysqli_stmt::class);
        $this->resultMock = $this->createMock(mysqli_result::class);
    }

    protected function tearDown(): void {
        $_SESSION = [];
        $_POST = [];
        $_GET = [];
    }

    
    // TESTES DE INICIALIZAÇÃO DO CARRINHO


    /**
     * Teste 1: Sessão deve receber array vazio para carrinho quando não existe
     */
    public function testInicializarCarrinhoQuandoNaoExiste(): void {
        $this->assertArrayNotHasKey('carrinho', $_SESSION);

        // Simula a lógica do construtor do CarrinhoController
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $this->assertArrayHasKey('carrinho', $_SESSION);
        $this->assertIsArray($_SESSION['carrinho']);
        $this->assertEmpty($_SESSION['carrinho']);
    }

    /**
     * Teste 2: Carrinho existente não deve ser sobrescrito
     */
    public function testNaoSobrescreverCarrinhoExistente(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta X', 'preco' => 10.0, 'quantidade' => 2]
        ];

        // Simula a lógica do construtor
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $this->assertCount(1, $_SESSION['carrinho']);
        $this->assertEquals('Planta X', $_SESSION['carrinho'][1]['nome']);
    }

   
    // TESTES DE ADICIONAR PRODUTO AO CARRINHO


    /**
     * Teste 3: Adicionar produto novo ao carrinho via ProdutoModel
     */
    public function testAdicionarProdutoNovoAoCarrinho(): void {
        $_SESSION['carrinho'] = [];

        $id_produto = 5;
        $quantidade = 2;

        // Configura mock do ProdutoModel para retornar um produto
        $produtoRetornado = [
            'id_produto'    => 5,
            'produto_nome'  => 'Samambaia Americana',
            'preco'         => 35.50,
        ];

        $this->mysqliMock->expects($this->once())
            ->method('prepare')
            ->with("SELECT * FROM produto WHERE id_produto = ?")
            ->willReturn($this->stmtMock);

        $this->stmtMock->expects($this->once())
            ->method('bind_param')
            ->with("i", $id_produto);

        $this->stmtMock->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $this->stmtMock->expects($this->once())
            ->method('get_result')
            ->willReturn($this->resultMock);

        $this->resultMock->expects($this->once())
            ->method('fetch_assoc')
            ->willReturn($produtoRetornado);

        // Executa a busca via ProdutoModel
        $model = new ProdutoModel($this->mysqliMock);
        $produto = $model->buscarPorId($id_produto);

        // Simula a lógica do CarrinhoController::add()
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

        // Verificações
        $this->assertArrayHasKey(5, $_SESSION['carrinho']);
        $this->assertEquals(5, $_SESSION['carrinho'][5]['id']);
        $this->assertEquals('Samambaia Americana', $_SESSION['carrinho'][5]['nome']);
        $this->assertEquals(35.50, $_SESSION['carrinho'][5]['preco']);
        $this->assertEquals(2, $_SESSION['carrinho'][5]['quantidade']);
    }

    /**
     * Teste 4: Adicionar produto que já existe incrementa quantidade
     */
    public function testAdicionarProdutoExistenteIncrementaQuantidade(): void {
        $id_produto = 3;
        $quantidade_adicional = 3;

        // Produto já no carrinho com quantidade 1
        $_SESSION['carrinho'] = [
            $id_produto => ['id' => 3, 'nome' => 'Cacto', 'preco' => 15.00, 'quantidade' => 1]
        ];

        $produtoRetornado = [
            'id_produto'    => 3,
            'produto_nome'  => 'Cacto',
            'preco'         => 15.00,
        ];

        // Simula a lógica de incremento do CarrinhoController::add()
        if ($produtoRetornado) {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] += $quantidade_adicional;
            }
        }

        // Quantidade deve ser 1 + 3 = 4
        $this->assertEquals(4, $_SESSION['carrinho'][$id_produto]['quantidade']);
    }

    /**
     * Teste 5: Adicionar produto inexistente no banco não altera o carrinho
     */
    public function testAdicionarProdutoInexistenteNaoAlteraCarrinho(): void {
        $_SESSION['carrinho'] = [];

        $id_produto = 999;
        $quantidade = 1;

        // ProdutoModel retorna null (produto não existe)
        $produto = null;

        // Simula a lógica do CarrinhoController::add()
        if ($produto) {
            $_SESSION['carrinho'][$id_produto] = [
                'id' => $produto['id_produto'],
                'nome' => $produto['produto_nome'],
                'preco' => $produto['preco'],
                'quantidade' => $quantidade
            ];
        }

        $this->assertEmpty($_SESSION['carrinho']);
    }

    /**
     * Teste 6: Quantidade padrão quando não informada deve ser 1
     */
    public function testQuantidadePadraoDeve1(): void {
        $_SESSION['carrinho'] = [];

        // Simula $_POST sem quantidade (exatamente como o Controller trata)
        $quantidade = (int)($_POST['quantidade'] ?? 1);

        $this->assertEquals(1, $quantidade);
    }

    /**
     * Teste 7: Estrutura dos dados do item no carrinho
     */
    public function testEstruturaDoItemNoCarrinho(): void {
        $_SESSION['carrinho'] = [];

        $produto = [
            'id_produto'    => 7,
            'produto_nome'  => 'Orquídea',
            'preco'         => 89.90,
        ];
        $quantidade = 1;

        $_SESSION['carrinho'][$produto['id_produto']] = [
            'id' => $produto['id_produto'],
            'nome' => $produto['produto_nome'],
            'preco' => $produto['preco'],
            'quantidade' => $quantidade
        ];

        $item = $_SESSION['carrinho'][7];

        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('nome', $item);
        $this->assertArrayHasKey('preco', $item);
        $this->assertArrayHasKey('quantidade', $item);
        $this->assertIsInt($item['id']);
        $this->assertIsString($item['nome']);
        $this->assertIsFloat($item['preco']);
        $this->assertIsInt($item['quantidade']);
    }

    // =============================================
    // TESTES DE ATUALIZAR QUANTIDADE
    // =============================================

    /**
     * Teste 8: Atualizar quantidade de produto existente
     */
    public function testAtualizarQuantidadeProdutoExistente(): void {
        $_SESSION['carrinho'] = [
            2 => ['id' => 2, 'nome' => 'Rosa', 'preco' => 20.00, 'quantidade' => 1]
        ];

        $id_produto = 2;
        $nova_quantidade = 5;

        // Simula a lógica do CarrinhoController::update()
        if ($nova_quantidade > 0) {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] = $nova_quantidade;
            }
        }

        $this->assertEquals(5, $_SESSION['carrinho'][2]['quantidade']);
    }

    /**
     * Teste 9: Atualizar quantidade para zero deve remover o produto
     */
    public function testAtualizarQuantidadeZeroRemoveProduto(): void {
        $_SESSION['carrinho'] = [
            2 => ['id' => 2, 'nome' => 'Rosa', 'preco' => 20.00, 'quantidade' => 3]
        ];

        $id_produto = 2;
        $quantidade = 0;

        // Simula a lógica do CarrinhoController::update()
        if ($quantidade > 0) {
            $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
        } else {
            // removeById
            if (isset($_SESSION['carrinho'][$id_produto])) {
                unset($_SESSION['carrinho'][$id_produto]);
            }
        }

        $this->assertArrayNotHasKey(2, $_SESSION['carrinho']);
    }

    /**
     * Teste 10: Atualizar com quantidade negativa deve remover produto
     */
    public function testAtualizarQuantidadeNegativaRemoveProduto(): void {
        $_SESSION['carrinho'] = [
            4 => ['id' => 4, 'nome' => 'Lírio', 'preco' => 45.00, 'quantidade' => 2]
        ];

        $id_produto = 4;
        $quantidade = -1;

        if ($quantidade > 0) {
            $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
        } else {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                unset($_SESSION['carrinho'][$id_produto]);
            }
        }

        $this->assertArrayNotHasKey(4, $_SESSION['carrinho']);
    }

    /**
     * Teste 11: Atualizar produto inexistente no carrinho não causa erro
     */
    public function testAtualizarProdutoInexistenteNaoCausaErro(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1]
        ];

        $id_produto = 999;
        $quantidade = 5;

        if ($quantidade > 0) {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
            }
        }

        // Carrinho inalterado
        $this->assertCount(1, $_SESSION['carrinho']);
        $this->assertEquals(1, $_SESSION['carrinho'][1]['quantidade']);
    }

    // =============================================
    // TESTES DE REMOÇÃO
    // =============================================

    /**
     * Teste 12: Remover produto existente do carrinho
     */
    public function testRemoverProdutoExistente(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
            2 => ['id' => 2, 'nome' => 'Planta B', 'preco' => 20.00, 'quantidade' => 2],
        ];

        $id = 1;

        // Simula removeById()
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }

        $this->assertArrayNotHasKey(1, $_SESSION['carrinho']);
        $this->assertArrayHasKey(2, $_SESSION['carrinho']); // outro permanece
        $this->assertCount(1, $_SESSION['carrinho']);
    }

    /**
     * Teste 13: Remover produto inexistente não causa erro nem altera carrinho
     */
    public function testRemoverProdutoInexistenteNaoAlteraCarrinho(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
        ];

        $id = 999;

        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }

        $this->assertCount(1, $_SESSION['carrinho']);
        $this->assertArrayHasKey(1, $_SESSION['carrinho']);
    }

    /**
     * Teste 14: Remover todos os itens resulta em carrinho vazio
     */
    public function testRemoverTodosOsItens(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
            2 => ['id' => 2, 'nome' => 'Planta B', 'preco' => 20.00, 'quantidade' => 2],
            3 => ['id' => 3, 'nome' => 'Planta C', 'preco' => 30.00, 'quantidade' => 3],
        ];

        foreach (array_keys($_SESSION['carrinho']) as $id) {
            unset($_SESSION['carrinho'][$id]);
        }

        $this->assertEmpty($_SESSION['carrinho']);
    }

    // =============================================
    // TESTES DE CÁLCULO DO TOTAL
    // =============================================

    /**
     * Teste 15: Calcular total do carrinho com múltiplos itens
     */
    public function testCalcularTotalDoCarrinho(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Samambaia', 'preco' => 35.50, 'quantidade' => 2],
            2 => ['id' => 2, 'nome' => 'Cacto',     'preco' => 15.00, 'quantidade' => 1],
            3 => ['id' => 3, 'nome' => 'Orquídea',  'preco' => 89.90, 'quantidade' => 3],
        ];

        // Mesma lógica usada pelo PedidoController::checkout()
        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        // 35.50*2 + 15.00*1 + 89.90*3 = 71.00 + 15.00 + 269.70 = 355.70
        $this->assertEqualsWithDelta(355.70, $total, 0.01);
    }

    /**
     * Teste 16: Total do carrinho vazio é zero
     */
    public function testTotalCarrinhoVazioEhZero(): void {
        $_SESSION['carrinho'] = [];

        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        $this->assertEquals(0, $total);
    }

    /**
     * Teste 17: Total do carrinho com um único item
     */
    public function testTotalCarrinhoComUmItem(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Rosa', 'preco' => 25.00, 'quantidade' => 4],
        ];

        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        $this->assertEquals(100.00, $total);
    }

    // =============================================
    // TESTES DE LIMPAR CARRINHO (PÓS-CHECKOUT)
    // =============================================

    /**
     * Teste 18: Limpar carrinho após finalização do pedido
     */
    public function testLimparCarrinhoAposCheckout(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
            2 => ['id' => 2, 'nome' => 'Planta B', 'preco' => 20.00, 'quantidade' => 2],
        ];

        // Simula a lógica pós-checkout do PedidoController
        $_SESSION['carrinho'] = [];

        $this->assertIsArray($_SESSION['carrinho']);
        $this->assertEmpty($_SESSION['carrinho']);
    }
}
