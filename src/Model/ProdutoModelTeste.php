<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/ProdutoModel.php'; 

// 1. Nova classe falsa para a conexão (livre das regras rígidas do PHP)
class DummyConnection {
    public function prepare($query) {}
}

// 2. Nossa classe falsa para o Statement (que você já havia criado)
class DummyStatement {
    public $insert_id;
    public function bind_param() {}
    public function execute() {}
    public function get_result() {}
}

class ProdutoModelTeste extends TestCase {
    private $mysqliMock;
    private $stmtMock;
    private $resultMock;
    private $produtoModel;

    protected function setUp(): void {
        // 3. Trocamos o mysqli::class pela nossa DummyConnection::class
        $this->mysqliMock = $this->createMock(DummyConnection::class);
        
        $this->stmtMock = $this->createMock(DummyStatement::class); 
        $this->resultMock = $this->createMock(mysqli_result::class);

        $this->produtoModel = new ProdutoModel($this->mysqliMock);
    }

    public function testBuscarProdutoPorId() {
        $id_produto = 1;
        $dadosEsperados = [
            'id_produto' => 1, 
            'produto_nome' => 'Notebook', 
            'preco' => 3500.00
        ];

        // 1. Configuramos o mock para esperar que o método 'prepare' seja chamado
        $this->mysqliMock->expects($this->once())
             ->method('prepare')
             ->with("SELECT * FROM produto WHERE id_produto = ?")
             ->willReturn($this->stmtMock);

        // 2. Configuramos o statement mock para esperar o 'bind_param'
        $this->stmtMock->expects($this->once())
             ->method('bind_param')
             ->with("i", $id_produto);

        // 3. Esperamos que o 'execute' seja chamado
        $this->stmtMock->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        // 4. Configuramos o retorno do 'get_result'
        $this->stmtMock->expects($this->once())
             ->method('get_result')
             ->willReturn($this->resultMock);

        // 5. Por fim, simulamos o fetch_assoc retornando nossos dados de teste
        $this->resultMock->expects($this->once())
             ->method('fetch_assoc')
             ->willReturn($dadosEsperados);

        // Executamos a função real que queremos testar
        $resultado = $this->produtoModel->buscarPorId($id_produto);

        // Afirmamos (Assert) que o resultado da função é igual aos dados que esperamos
        $this->assertEquals($dadosEsperados, $resultado);
    }

    public function testInserirProduto() {
        // Configuramos os Mocks para testar a inserção
        $this->mysqliMock->expects($this->once())
             ->method('prepare')
             ->willReturn($this->stmtMock);

        $this->stmtMock->expects($this->once())
             ->method('bind_param')
             ->with("ssdisi", "Mouse", "Informatica", 150.50, 10, "Mouse Gamer", 2);

        $this->stmtMock->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        // Simulamos o ID retornado pelo banco após o insert
        $this->stmtMock->insert_id = 99;

        $id_inserido = $this->produtoModel->inserir("Mouse", "Informatica", 150.50, 10, "Mouse Gamer", 2);

        $this->assertEquals(99, $id_inserido);
    }
}