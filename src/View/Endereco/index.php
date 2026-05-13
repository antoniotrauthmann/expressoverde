<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Endereço - Expresso Verde</title>
    <link rel="stylesheet" href="src/View/Endereco/style.css">
</head>
<body>
    <main class="endereco-container">
        <div class="endereco-box">
            <h1>Endereço de Entrega</h1>
            <p class="subtitle">Precisamos do seu endereço para continuar com a compra.</p>
            
            <form action="index.php?rota=cadastrar_endereco&origin=<?php echo htmlspecialchars($origin ?? ''); ?>" method="POST" class="endereco-form">
                <div class="input-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" placeholder="00000-000" required>
                </div>
                
                <div class="input-group">
                    <label for="logradouro">Rua / Logradouro</label>
                    <input type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Flores, 123" required>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" placeholder="Centro" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" placeholder="São Paulo" required>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="zona">Zona</label>
                    <select id="zona" name="zona" required>
                        <option value="urbana">Urbana</option>
                        <option value="rural">Rural</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-salvar">Salvar e Continuar</button>
                <?php if (($origin ?? '') === 'perfil'): ?>
                    <a href="index.php?rota=perfil" class="btn-cancelar">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
    </main>
</body>
</html>
