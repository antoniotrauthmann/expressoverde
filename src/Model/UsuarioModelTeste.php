<?php
// chama o phpunit e a classe original (UsuarioModel)
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/UsuarioModel.php';

class UsuarioModelTeste extends TestCase {
    
    // simuladores de banco de dados (mocks)
    private $mysqliMock;
    private $stmtMock;
    private $resultMock;
    private $usuarioModel;

    // configura os mocks antes dos testes
    protected function setUp(): void {
        $this->mysqliMock = $this->createMock(mysqli::class);
        $this->stmtMock = $this->createMock(mysqli_stmt::class);
        $this->resultMock = $this->createMock(mysqli_result::class);

        // instancia a classe e ja usa o mock
        $this->usuarioModel = new UsuarioModel($this->mysqliMock);
    }

    //testa buscar o usuario pelo email dele e retornar os dados
    public function testBuscarPorEmailRetornaDadosDoUsuario() {
        $emailTeste = "gabriel@email.com";
        $dadosEsperados = [
            'id_usuario' => 13,
            'usuario_nome' => 'Gabriel Henriq',
            'email' => 'gabriel@email.com',
            'senha_hash' => '$2y$10$5MJGD36Ua0vHbI0SliGuEeTSQ1FA3eNnC8ahh2qFI.f7C1LmiMIVG',
            'tipo' => 'cliente'
        ];

        // configura o mysqli que ja tem em UsuarioMOdel.php e monta o roteiro pro mock seguir
        $this->mysqliMock->expects($this->once())
            ->method('prepare')
            ->with("SELECT id_usuario, usuario_nome, email, senha_hash, tipo FROM usuario WHERE email = ?")
            ->willReturn($this->stmtMock);

        $this->stmtMock->expects($this->once())
            ->method('bind_param')
            ->with("s", $emailTeste);

        $this->stmtMock->expects($this->once())
            ->method('execute');

        $this->stmtMock->expects($this->once())
            ->method('get_result')
            ->willReturn($this->resultMock);

        $this->resultMock->expects($this->once())
            ->method('fetch_assoc')
            ->willReturn($dadosEsperados);

        // execução do teste
        $resultado = $this->usuarioModel->buscarPorEmail($emailTeste);

        // se der ruim, ele avisa
        $this->assertEquals($dadosEsperados, $resultado);
    }

    public function testInserirNovoUsuarioComSucesso() {
        $nome = "teste";
        $email = "teste@exemplo.com";
        $senhaHash = "hash123";
        $tipo = "cliente";

        // monta o roteiro do insert
        $this->mysqliMock->expects($this->once())
            ->method('prepare')
            ->with("INSERT INTO usuario (usuario_nome, email, senha_hash, tipo) VALUES (?, ?, ?, ?)")
            ->willReturn($this->stmtMock);

        // verifica se o bind param esta passando a tipagem e os valores corretos
        $this->stmtMock->expects($this->once())
            ->method('bind_param')
            ->with("ssss", $nome, $email, $senhaHash, $tipo);

        // verifica se o execute é chamado
        $this->stmtMock->expects($this->once())
            ->method('execute');

        // executa o metodo, se der ruim ele avisa
        $this->usuarioModel->inserir($nome, $email, $senhaHash, $tipo);
    }
}