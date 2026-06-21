<link rel="stylesheet" href="/projeto-es/src/View/comunidade/style.css">

<div class="comunidade-page">
    
    <?php include 'src/View/Cabecalho/index.php'; ?>

    <div class="container comunidade-container">
        <!-- Navegação Interna Superior -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 col-lg-6">
                <nav class="comunidade-nav">
                    <a href="index.php?rota=feed" class="nav-item-link active">
                        <i class="fa-solid fa-users"></i> Feed da Comunidade
                    </a>
                    <a href="index.php?rota=manual" class="nav-item-link">
                        <i class="fa-solid fa-seedling"></i> Manual de Cuidados
                    </a>
                </nav>
            </div>
        </div>

        <!-- Layout de Duas Colunas (Feed + Lateral informativa) -->
        <div class="row g-4 justify-content-center">
            
            <!-- Coluna Principal (Feed e Formulário) -->
            <div class="col-lg-8" style="width: fit-content">
                
                <!-- Card de Publicação -->
                <div class="publish-card">
                    <h3>Compartilhe com a comunidade 🌿</h3>
                    
                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'conteudo_vazio'): ?>
                        <div class="alert-erro">
                            <i class="fa-solid fa-circle-exclamation"></i> Não é possível publicar um post vazio.
                        </div>
                    <?php endif; ?>

                    <form action="index.php?rota=salvar" method="POST" enctype="multipart/form-data" class="publish-form">
                        <textarea name="conteudo_texto" placeholder="O que você está cultivando hoje? Compartilhe dicas, fotos ou dúvidas..."></textarea>
                        
                        <div class="form-actions">
                            <!-- Input de upload estilizado como botão de ícone -->
                            <label class="upload-label">
                                <input type="file" name="imagem" accept="image/*" class="hidden-upload-input">
                                <i class="fa-regular fa-image"></i> Adicionar Foto
                            </label>
                            <button type="submit" class="btn-submit">
                                Postar <i class="fa-regular fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="feed-header-title mb-3">
                    <span>Publicações Recentes</span>
                </div>

    <div class="feed" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post" style="border: 1px solid #4d4d4d; padding: 20px; margin-bottom: 20px; position: relative; width: 100%; max-width: 500px; box-sizing: border-box;">
                
                <!-- Conteúdo Central do Post -->
                <div class="post-body">
                    <strong style="color: #2ecc71;">@<?= htmlspecialchars($post['usuario_nome']) ?></strong>
                    <p class="post-text"><?= htmlspecialchars($post['conteudo']) ?></p>
                    
                    <?php if (!empty($post['post_caminho_imagem'])): ?>
                        <div class="post-image-wrapper">
                            <img src="<?= htmlspecialchars($post['post_caminho_imagem']) ?>" alt="Imagem da publicação">
                        </div>
                    <?php endif; ?>
                </div>

                <small  style="color: #aaa;">Postado em: <?= isset($post['criado_em']) ? $post['criado_em'] : 'Data indisponível' ?></small>
                <!-- Rodapé do Card: Interações -->
                <div class="post-footer d-flex justify-content-between">
                    <a href="index.php?rota=curtir&id=<?= $post['id_post'] ?>" class="btn-like btn-curtir">
                        <i class="fa-solid fa-heart"></i> <span><?= $post['curtidas'] ?></span> Curtidas
                    </a>
                    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $post['id_usuario']): ?>
                        <a href="index.php?rota=excluir&id=<?= $post['id_post'] ?>" 
                            class="btn-excluir btn-delete-post" 
                            onclick="return confirm('Tem certeza que deseja apagar seu post?')"
                            style="text-decoration:none">
                            Excluir  🗑️
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-feed-card">
                <i class="fa-solid fa-comments"></i>
                <p>Nenhum post ainda. Seja o primeiro a movimentar a comunidade!</p>
            </div>
        <?php endif; ?>
                </div>
            </div>

            <!-- Coluna Secundária (Sidebar Opcional/Novos Elementos) -->
            <div class="col-lg-4">
                <div class="sidebar-sticky">
                    
                    <!-- Elemento Novo 1: Diretrizes -->
                    <div class="sidebar-card">
                        <h4>Diretrizes do Grupo 📋</h4>
                        <ul class="sidebar-list">
                            <li><i class="fa-solid fa-circle-check text-success"></i> Seja respeitoso com os outros membros.</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Compartilhe experiências reais sobre o cultivo de plantas.</li>
                            <li><i class="fa-solid fa-circle-check text-success"></i> Tire dúvidas e ajude quem está começando.</li>
                        </ul>
                    </div>

                    <!-- Elemento Novo 2: Atalho Informativo -->
                    <div class="sidebar-card highlight-card">
                        <h4>Precisa de ajuda técnica? 🌱</h4>
                        <p>Dúvidas frequentes sobre rega, iluminação ou poda podem ser resolvidas diretamente no nosso catálogo oficial de guias rápidos.</p>
                        <a href="index.php?rota=manual" class="btn-sidebar-action">
                            Ver Manual de Cuidados <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
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
