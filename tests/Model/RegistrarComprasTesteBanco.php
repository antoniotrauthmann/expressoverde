<?php

use PHPUnit\Framework\TestCase;


class RegistrarComprasTesteBanco extends TestCase
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../../src/Model/RegistrarCompras.php';
    }

    private function criarRegistrar(bool $executeRetorna): RegistrarCompras
    {
        $mockStmt = $this->createMock(mysqli_stmt::class);
        $mockStmt->method('bind_param')->willReturn(true);
        $mockStmt->method('execute')->willReturn($executeRetorna);

        $mockDb = $this->createMock(mysqli::class);
        $mockDb->method('prepare')->willReturn($mockStmt);

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