<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="src/View/Cadastro_usuario/style.css">
</head>

<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>
    <div class="container">
        <div class="form-image">
            <img src="src/View/Cadastro_usuario/img/undraw_receipt_tzi0.svg" alt="IlustraÃ§Ã£o de cadastro">
        </div>
        <div class="form">
            <form action="index.php?rota=cadastro" method="POST">
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastre seu perfil</h1>
                    </div>
                </div>

                <?php if (!empty($erro)): ?>
                    <div class="modal-overlay" id="modalErro">
                        <div class="modal">
                            <div class="modal-icon" style="background:#fde8e8; color:#c0392b;">âœ•</div>
                            <p><?= htmlspecialchars($erro) ?></p>
                            <button onclick="document.getElementById('modalErro').remove()">OK</button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome Completo</label>
                        <input id="nome" name="nome" type="text" placeholder="Digite o nome completo"
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="tipo">Tipo de conta</label>
                        <select id="tipo" name="tipo" required>
                            <option value="">Selecione...</option>
                            <option value="cliente">Cliente</option>
                            <option value="profissional">Profissional</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" name="email" type="email" placeholder="Digite o e-mail"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input id="senha" name="senha" type="password" placeholder="Digite a senha" required>
                    </div>
                    <div class="input-box">
                        <label for="confirmar_senha">Repita a senha</label>
                        <input id="confirmar_senha" name="confirmar_senha" type="password" placeholder="Confirme sua senha" required>
                    </div>
                </div>

                <div class="continue-button">
                    <button type="submit">Prosseguir</button>
                </div>
                <p style="text-align:center; margin-top: 12px; font-size: 14px;">
                    JÃ¡ tem conta? <a href="index.php?rota=login" style="color: #1a5c4a;">Entrar</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>
