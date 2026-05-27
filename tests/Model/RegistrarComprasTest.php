<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../vendor/autoload.php';

class FakeStmt extends mysqli_stmt
{
    public bool $executeRetorna;

    public function __construct() {}
    public function bind_param($types, &...$vars): bool
    {
        return true;
    }
    public function execute(?array $params = null): bool
    {
        return $this->executeRetorna;
    }
}
class RegistrarComprasTest extends TestCase
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../../src/Model/RegistrarCompras.php';
    }

    private function criarRegistrar(bool $executeRetorna): RegistrarCompras
    {
        $fakeStmt = new FakeStmt();
        $fakeStmt->executeRetorna = $executeRetorna;

        $mockDb = $this->createMock(mysqli::class);
        $mockDb->method('prepare')->willReturn($fakeStmt);

        return new RegistrarCompras($mockDb);
    }

    public function test_registrar_item_pedido_com_sucesso(): void
    {
        $registrar = $this->criarRegistrar(true);
        $resultado = $registrar->registrarItemPedido(1, 2, 3, 29.90);
        $this->assertTrue($resultado);
    }

    public function test_registrar_item_pedido_lanca_excecao_em_falha(): void
    {
        $registrar = $this->criarRegistrar(false);
        $this->expectException(RuntimeException::class);
        $registrar->registrarItemPedido(1, 2, 3, 29.90);
    }

    public function test_registrar_pedido_com_sucesso(): void
    {
        $registrar = $this->criarRegistrar(true);
        $resultado = $registrar->registrarPedido(1, 1, 1, 1, 'pendente', 99.90, '2026-01-01 00:00:00');
        $this->assertTrue($resultado);
    }

    public function test_registrar_pedido_lanca_excecao_em_falha(): void
    {
        $registrar = $this->criarRegistrar(false);
        $this->expectException(RuntimeException::class);
        $registrar->registrarPedido(1, 1, 1, 1, 'pendente', 99.90, '2026-01-01 00:00:00');
    }
}
