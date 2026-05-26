<link rel="stylesheet" href="src/View/Login/style.css">
<link rel="stylesheet" href="src/View/Cadastro_usuario/style.css">

<div class="custom-modal modal-registro d-flex flex-column flex-md-row bg-white overflow-hidden shadow" style="border-radius: 12px; max-width: 900px; margin: auto;">

    <div class="registro-form-side p-4 p-md-5 w-100">
        <div class="mb-4">
            <h3 class="fw-bold mb-1 text-dark">Cadastre-se agora no</h3>
            <h3 class="fw-bold mb-2 brand-text-color">Expresso Verde</h3>
            <div class="title-underline"></div>
        </div>

        <form action="index.php?rota=cadastro" method="POST">
            <div class="mb-3">
                <label class="form-label text-dark fw-medium">Nome Completo</label>
                <input id="nome" name="nome" type="text" class="form-control custom-input" placeholder="Digite o nome completo" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-dark fw-medium">Tipo de conta</label>
                <select id="tipo" name="tipo" class="form-select custom-input" required>
                    <option selected disabled>Selecione...</option>
                    <option value="cliente">Cliente (Quero comprar produtos)</option>
                    <option value="profissional">Profissional (Quero anunciar produtos)</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-dark fw-medium">E-mail</label>
                <input id="email" name="email" type="email" class="form-control custom-input" placeholder="Digite o e-mail" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-dark fw-medium">Senha</label>
                    <input  id="senha" name="senha" type="password" class="form-control custom-input" placeholder="Digite a senha" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label text-dark fw-medium">Confirme sua senha</label>
                    <input id="confirmar_senha" name="confirmar_senha" type="password" class="form-control custom-input" placeholder="Repita a senha" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-brand w-100 py-2 fw-bold">Cadastrar</button>
        </form>
    </div>
</div>
