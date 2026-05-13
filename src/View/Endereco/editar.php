<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Endereço - Expresso Verde</title>
    <link rel="stylesheet" href="src/View/Endereco/style.css">
</head>
<body>
    <main class="endereco-container">
        <div class="endereco-box">
            <h1>Editar Endereço</h1>
            <p class="subtitle">Atualize as informações do seu endereço.</p>
            
            <form action="index.php?rota=editar_endereco&id=<?php echo $endereco['id_endereco']; ?>" method="POST" class="endereco-form">
                <div class="input-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" placeholder="00000-000" value="<?php echo htmlspecialchars($endereco['cep']); ?>" required>
                </div>
                
                <div class="input-group">
                    <label for="logradouro">Rua / Logradouro</label>
                    <input type="text" id="logradouro" name="logradouro" placeholder="Ex: Rua das Flores, 123" value="<?php echo htmlspecialchars($endereco['logradouro']); ?>" required>
                </div>
                
                <div class="input-row">
                    <div class="input-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" placeholder="Centro" value="<?php echo htmlspecialchars($endereco['bairro']); ?>" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" placeholder="São Paulo" value="<?php echo htmlspecialchars($endereco['cidade']); ?>" required>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="zona">Zona</label>
                    <select id="zona" name="zona" required>
                        <option value="urbana" <?php echo $endereco['zona'] === 'urbana' ? 'selected' : ''; ?>>Urbana</option>
                        <option value="rural" <?php echo $endereco['zona'] === 'rural' ? 'selected' : ''; ?>>Rural</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-salvar">Salvar Alterações</button>
                <a href="index.php?rota=perfil" class="btn-cancelar">Cancelar</a>
            </form>
        </div>
    </main>
</body>
</html>
