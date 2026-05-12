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

    <div class="custom-modal modal-login">
        <div class="login-image-side">
            <div class="image-text-top">
                <h4 class="font-quattrocento text-white mb-0">Expresso Verde</h4>
            </div>
            
            <div class="image-text-bottom">
                <h3 class="font-quattrocento text-white fw-bold mb-1">Bem-vindo(a) de volta!</h3>
                <p class="font-quattrocento text-white mb-0" style="font-size: 0.95rem; opacity: 0.9; line-height: 1.4;">
                    Entre na sua conta para encomendar produtos,<br>
                    interagir com a comunidade e muito mais!
                </p>
            </div>
        </div>

        <div class="login-form-side">
            <div class="mb-4">
                <div class="title-dark mb-0">Bem-vindo(a) à bordo do</div>
                <div class="brand-text">Expresso Verde</div>
            </div>

            <form>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-4">
                    <label class="form-label">Senha</label>
                    <input type="password" class="form-control" placeholder="Senha">
                </div>
                
                <button type="submit" class="btn btn-brand">Entrar</button>
                
                <div class="login-footer-text">
                    Não tem conta? <a href="#">Cadastre-se.</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>