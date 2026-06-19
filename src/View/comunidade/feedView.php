<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comunidade</title>
    <link rel="stylesheet" href="/projeto-es/src/View/comunidade/style.css">
</head>
<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>
    <div class="pt-5" style="color: white;">.</div>
    <nav>
        <a href="index.php?rota=feed" class="active">👥 Comunidade</a>
        <a href="index.php?rota=manual">🌱 Manual de Cuidados</a>
    </nav>

    <h2>Compartilhe com a comunidade</h2>

    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'conteudo_vazio'): ?>
        <p style="color: #ff4757; font-weight: bold;">⚠️ Não é possível publicar um post vazio.</p>
    <?php endif; ?>

    <form action="index.php?rota=salvar" method="POST" enctype="multipart/form-data">
        <textarea name="conteudo_texto" placeholder="O que você quer compartilhar?"></textarea>
        <br>
        <input type="file" name="imagem" accept="image/*" class="upload-input">
        <br>
        <button type="submit">Postar</button>
    </form>

    <hr style="width: 100%; max-width: 500px; border: 0; border-top: 1px solid #4d4d4d; margin: 20px 0;">

    <div class="feed" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post" style="border: 1px solid #4d4d4d; padding: 20px; margin-bottom: 20px; position: relative; width: 100%; max-width: 500px; box-sizing: border-box;">
                
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $post['id_usuario']): ?>
                    <a href="index.php?rota=excluir&id=<?= $post['id_post'] ?>" 
                       class="btn-excluir" 
                       onclick="return confirm('Tem certeza que deseja apagar seu post?')">
                       Excluir  🗑️
                    </a>
                <?php endif; ?>

                <strong style="color: #2ecc71;">@<?= htmlspecialchars($post['usuario_nome']) ?></strong>
                
                <p style="color: #ffffff; margin-top: 10px; margin-bottom: 10px; word-wrap: break-word;">
                    <?= htmlspecialchars($post['conteudo']) ?>
                </p>
                
                <?php if (!empty($post['post_caminho_imagem'])): ?>
                    <img src="<?= htmlspecialchars($post['post_caminho_imagem']) ?>" alt="Imagem" style="max-width: 100%; border-radius: 4px; margin-top: 10px;">
                <?php endif; ?>
                
                <br>
                <small style="color: #aaa;">
                    Postado em: <?= isset($post['criado_em']) ? $post['criado_em'] : 'Data indisponível' ?>
                </small>
                
                <hr style="border: 0; border-top: 1px solid #4d4d4d; margin: 15px 0;">

                <div class="curtidas-container">
                    <a href="index.php?rota=curtir&id=<?= $post['id_post'] ?>" 
                       class="btn-curtir" 
                       style="text-decoration: none; color: #ff4757; font-weight: bold;">
                        ❤️ <span><?= $post['curtidas'] ?></span> Curtidas
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #ffffff;">Nenhum post ainda. Seja o primeiro a compartilhar</p>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const botoesCurtir = document.querySelectorAll('.btn-curtir');

    botoesCurtir.forEach(botao => {
        botao.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.getAttribute('href');
            const spanQuantidade = this.querySelector('span');

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro na resposta do servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.sucesso) {
                    spanQuantidade.textContent = data.curtidas;
                } else {
                    console.error('Erro no processamento da curtida:', data.erro);
                }
            })
            .catch(error => {
                console.error('Falha na requisição AJAX:', error);
                window.location.href = url;
            });
        });
    });
});
</script>
</body>
</html>