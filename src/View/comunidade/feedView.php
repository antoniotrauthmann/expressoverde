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
        <div class="row g-4">
            
            <!-- Coluna Principal (Feed e Formulário) -->
            <div class="col-lg-8">
                
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

                <!-- Lista de Postagens -->
                <div class="feed-container">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="post-card">
                                
                                <!-- Topo do Card: Usuário e Botões -->
                                <div class="post-header">
                                    <div class="user-meta">
                                        <div class="user-avatar">
                                            <?= strtoupper(substr($post['usuario_nome'], 0, 1)) ?>
                                        </div>
                                        <div class="user-info">
                                            <span class="username">@<?= htmlspecialchars($post['usuario_nome']) ?></span>
                                            <span class="post-date">
                                                <i class="fa-regular fa-clock"></i> <?= isset($post['criado_em']) ? $post['criado_em'] : 'Data indisponível' ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $post['id_usuario']): ?>
                                        <a href="index.php?rota=excluir&id=<?= $post['id_post'] ?>" 
                                           class="btn-delete-post" 
                                           onclick="return confirm('Tem certeza que deseja apagar seu post?')">
                                           <i class="fa-regular fa-trash-can"></i> Excluir
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <!-- Conteúdo Central do Post -->
                                <div class="post-body">
                                    <p class="post-text"><?= htmlspecialchars($post['conteudo']) ?></p>
                                    
                                    <?php if (!empty($post['post_caminho_imagem'])): ?>
                                        <div class="post-image-wrapper">
                                            <img src="/PROJETO-ES/public/uploads/<?= $row['post_caminho_imagem'] ?>" alt="Imagem da publicação">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Rodapé do Card: Interações -->
                                <div class="post-footer">
                                    <a href="index.php?rota=curtir&id=<?= $post['id_post'] ?>" class="btn-like">
                                        <i class="fa-solid fa-heart"></i> <span><?= $post['curtidas'] ?></span> Curtidas
                                    </a>
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
            </div>

        </div>
    </div>

</div>