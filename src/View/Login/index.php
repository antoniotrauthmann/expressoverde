<link rel="stylesheet" href="/projeto-es/src/View/Login/style.css">

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

        <form action="index.php?rota=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input id="senha" name="senha" type="password" class="form-control" placeholder="Senha" required>
            </div>
            
            <button type="submit" class="btn btn-brand text-center w-100 py-2 fw-bold">Entrar</button>
        </form>
    </div>
</div>
