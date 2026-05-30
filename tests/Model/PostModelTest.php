<?php
use PHPUnit\Framework\TestCase;

// 1. Carrega o ambiente do PHPUnit
require_once __DIR__ . '/../../vendor/autoload.php';

// 2. IMPORTAÇÃO MANUAL: Diz exatamente pro PHP onde encontrar o seu PostModel
require_once __DIR__ . '/../../src/Model/PostModel.php';

class PostModelTest extends TestCase {
    
    // Teste 1: Garante que o sistema aceita um post escrito corretamente
    public function testDeveAceitarTextoValido() {
        $postModel = new PostModel(null);
        
        $resultado = $postModel->validarConteudo("Meu primeiro post na comunidade");
        
        $this->assertTrue($resultado);
    }

    // Teste 2: Garante que o sistema barra posts totalmente em branco
    public function testDeveRecusarTextoVazio() {
        $postModel = new PostModel(null);
        
        $resultado = $postModel->validarConteudo("");
        
        $this->assertFalse($resultado);
    }
}