<?php

use PHPUnit\Framework\TestCase;

class UsuarioModelTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        // Banco de teste em memória (não afeta o banco real)
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cria tabela igual à do seu schema
        $this->pdo->exec("
            CREATE TABLE usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                senha TEXT NOT NULL
            )
        ");
    }

    public function test_inserir_usuario(): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
        );
        $stmt->execute(['João', 'joao@email.com', md5('123456')]);

        $id = $this->pdo->lastInsertId();
        $this->assertGreaterThan(0, $id);
    }

    public function test_buscar_usuario_por_email(): void
    {
        $this->pdo->exec(
            "INSERT INTO usuarios (nome, email, senha) VALUES ('Maria', 'maria@email.com', '123')"
        );

        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute(['maria@email.com']);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Maria', $usuario['nome']);
        $this->assertEquals('maria@email.com', $usuario['email']);
    }

    public function test_email_duplicado_lanca_excecao(): void
    {
        $this->expectException(\PDOException::class);

        $this->pdo->exec(
            "INSERT INTO usuarios (nome, email, senha) VALUES ('A', 'dup@email.com', '123')"
        );
        $this->pdo->exec(
            "INSERT INTO usuarios (nome, email, senha) VALUES ('B', 'dup@email.com', '456')"
        );
    }
}