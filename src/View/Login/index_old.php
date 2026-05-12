<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/View/Login/style.css">
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="src/View/Login/img/img2.png" alt="Imagem de login">
        </div>
        <div class="form">
            <form action="index.php?rota=login" method="POST">
                <div class="form-header">
                    <div class="title">
                        <h1>Entre na conta</h1>
                    </div>
                </div>

                <?php if (!empty($erro)): ?>
                    <div class="modal-overlay" id="modalErro">
                        <div class="modal">
                            <div class="modal-icon" style="background:#fde8e8; color:#c0392b;">✕</div>
                            <p><?= htmlspecialchars($erro) ?></p>
                            <button onclick="document.getElementById('modalErro').remove()">OK</button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" name="email" type="email" placeholder="Digite o e-mail" required>
                    </div>
                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input id="senha" name="senha" type="password" placeholder="Digite a senha" required>
                    </div>
                </div>
                <div class="continue-button">
                    <button type="submit">Entrar</button>
                </div>
                <p style="text-align:center; margin-top: 12px; font-size: 14px;">
                    Não tem conta? <a href="index.php?rota=cadastro" style="color: #1a5c4a;">Cadastre-se</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>