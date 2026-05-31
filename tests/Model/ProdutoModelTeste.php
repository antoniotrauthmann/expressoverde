<?php
// chama o phpunit e a classe original (ProdutoModel)
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Model/ProdutoModel.php'; 

class ProdutoModelTeste extends TestCase {

     // simuladores de banco de dados (mocks)
     private $mysqliMock;
     private $stmtMock;
     private $resultMock;
     private $produtoModel;

     protected function setUp(): void {
          $this->mysqliMock = $this->createMock(mysqli::class);
          $this->stmtMock = $this->createMock(mysqli_stmt::class);
          $this->resultMock = $this->createMock(mysqli_result::class);

          // instancia a classe e ja usa o mock
          $this->produtoModel = new ProdutoModel($this->mysqliMock);
    }

     protected function obterUltimoIdInserido($stmt) {
          return $stmt->insert_id;
     }

     //testa buscar o produto pelo id e retornar os dados
     public function testBuscarProdutoPorId() {
        $id_produto = 1;
        $dadosEsperados = [
            'id_produto' => 1, 
            'produto_nome' => 'Samambaia Americana', 
            'preco' => 35.50
        ];

          // configura o mysqli que ja tem em ProdutoModel.php e monta o roteiro pro mock seguir
          $this->mysqliMock->expects($this->once())
               ->method('prepare')
               ->with("SELECT * FROM produto WHERE id_produto = ?")
               ->willReturn($this->stmtMock);

          // configura statement mock para esperar o bind param
          $this->stmtMock->expects($this->once())
               ->method('bind_param')
               ->with("i", $id_produto);

          // espera que o execute seja chamado
          $this->stmtMock->expects($this->once())
               ->method('execute')
               ->willReturn(true);

          // configura o retorno do get_result
          $this->stmtMock->expects($this->once())
               ->method('get_result')
               ->willReturn($this->resultMock);

          // simulamo o fetch_assoc retornando os dados de teste
          $this->resultMock->expects($this->once())
               ->method('fetch_assoc')
               ->willReturn($dadosEsperados);

          // execução da função real que deve ser testada
          $resultado = $this->produtoModel->buscarPorId($id_produto);

          // assert = deu bom; error = ruim 
          $this->assertEquals($dadosEsperados, $resultado);
    }
}