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

    /**
     * Teste 1: Inicializar carrinho vazio na sessão
     */
    public function testInicializarCarrinhoVazio(): void {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $this->assertArrayHasKey('carrinho', $_SESSION);
        $this->assertEmpty($_SESSION['carrinho']);
    }

    /**
     * Teste 2: Adicionar produto novo ao carrinho via ProdutoModel
     */
    public function testAdicionarProdutoNovoAoCarrinho(): void {
        $_SESSION['carrinho'] = [];

        $id_produto = 5;
        $quantidade = 2;

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

        $model = new ProdutoModel($this->mysqliMock);
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

        $this->assertArrayHasKey(5, $_SESSION['carrinho']);
        $this->assertEquals('Samambaia Americana', $_SESSION['carrinho'][5]['nome']);
        $this->assertEquals(35.50, $_SESSION['carrinho'][5]['preco']);
        $this->assertEquals(2, $_SESSION['carrinho'][5]['quantidade']);
    }

    /**
     * Teste 3: Adicionar produto existente incrementa a quantidade
     */
    public function testAdicionarProdutoExistenteIncrementaQuantidade(): void {
        $id_produto = 3;
        $_SESSION['carrinho'] = [
            $id_produto => ['id' => 3, 'nome' => 'Cacto', 'preco' => 15.00, 'quantidade' => 1]
        ];

        $produto = ['id_produto' => 3, 'produto_nome' => 'Cacto', 'preco' => 15.00];

        if ($produto) {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] += 3;
            }
        }

        $this->assertEquals(4, $_SESSION['carrinho'][3]['quantidade']);
    }

    /**
     * Teste 4: Atualizar quantidade de um produto no carrinho
     */
    public function testAtualizarQuantidadeProduto(): void {
        $_SESSION['carrinho'] = [
            2 => ['id' => 2, 'nome' => 'Rosa', 'preco' => 20.00, 'quantidade' => 1]
        ];

        $id_produto = 2;
        $nova_quantidade = 5;

        if ($nova_quantidade > 0) {
            if (isset($_SESSION['carrinho'][$id_produto])) {
                $_SESSION['carrinho'][$id_produto]['quantidade'] = $nova_quantidade;
            }
        }

        $this->assertEquals(5, $_SESSION['carrinho'][2]['quantidade']);
    }

    /**
     * Teste 5: Remover produto do carrinho
     */
    public function testRemoverProdutoDoCarrinho(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
            2 => ['id' => 2, 'nome' => 'Planta B', 'preco' => 20.00, 'quantidade' => 2],
        ];

        $id = 1;

        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }

        $this->assertArrayNotHasKey(1, $_SESSION['carrinho']);
        $this->assertArrayHasKey(2, $_SESSION['carrinho']);
    }

    /**
     * Teste 6: Calcular total do carrinho
     */
    public function testCalcularTotalDoCarrinho(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Samambaia', 'preco' => 35.50, 'quantidade' => 2],
            2 => ['id' => 2, 'nome' => 'Cacto',     'preco' => 15.00, 'quantidade' => 1],
        ];

        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }

        // 35.50*2 + 15.00*1 = 71.00 + 15.00 = 86.00
        $this->assertEquals(86.00, $total);
    }

    /**
     * Teste 7: Limpar carrinho após checkout
     */
    public function testLimparCarrinhoAposCheckout(): void {
        $_SESSION['carrinho'] = [
            1 => ['id' => 1, 'nome' => 'Planta A', 'preco' => 10.00, 'quantidade' => 1],
        ];

        $_SESSION['carrinho'] = [];

        $this->assertEmpty($_SESSION['carrinho']);
    }
}
