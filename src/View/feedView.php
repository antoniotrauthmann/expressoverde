<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comunidade</title>
    <style>
        /* ConfiguraÃ§Ã£o Geral */
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        nav {
            width: 100%;
            max-width: 500px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 10px;
            border-bottom: 2px solid transparent;
        }

        nav a.active {
            color: #2ecc71;
            border-bottom: 2px solid #2ecc71;
        }

        form, .post {
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        textarea {
            width: 100%;
            background: #3d3d3d;
            border: 1px solid #4d4d4d;
            color: white;
            border-radius: 4px;
            padding: 10px;
            resize: none;
        }

        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }

        button:hover {
            background-color: #27ae60;
        }

        .btn-excluir {
            color: #ff4757;
            text-decoration: none;
            float: right;
            font-size: 13px;
            font-weight: bold;
        }
        
        .btn-excluir:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>

    <nav>
        <a href="index.php?rota=feed" class="active">Comunidade</a>
        <a href="index.php?rota=manual">Manual de Cuidados ðŸŒ¿</a>
    </nav>

    <h2>Compartilhe com a comunidade</h2>

    <form action="index.php?rota=salvar" method="POST" enctype="multipart/form-data">
        <textarea name="conteudo_texto" placeholder="O que vocÃª quer compartilhar?"></textarea>
        <br>
        <input type="file" name="imagem" accept="image/*">
        <br>
        <button type="submit">Postar</button>
    </form>

    <hr style="width: 100%; max-width: 500px; border: 0; border-top: 1px solid #4d4d4d; margin: 20px 0;">

    <div class="feed">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post" style="border: 1px solid #4d4d4d; padding: 20px; margin-bottom: 20px; position: relative;">
                
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $post['id_usuario']): ?>
                    <a href="index.php?rota=excluir&id=<?= $post['id_post'] ?>" 
                       class="btn-excluir" 
                       onclick="return confirm('Tem certeza que deseja apagar seu post?')">
                       Excluir ðŸ—‘ï¸
                    </a>
                <?php endif; ?>

                <strong style="color: #2ecc71;">@<?= htmlspecialchars($post['usuario_nome']) ?></strong>
                
                <p><?= htmlspecialchars($post['conteudo']) ?></p>
                
                <?php if (!empty($post['post_caminho_imagem'])): ?>
                    <img src="<?= htmlspecialchars($post['post_caminho_imagem']) ?>" alt="Imagem" style="max-width: 100%; border-radius: 4px; margin-top: 10px;">
                <?php endif; ?>
                
                <br><br>
                <small style="color: #aaa;">Postado em: <?= $post['criado_em'] ?></small>
                
                <hr style="border: 0; border-top: 1px solid #4d4d4d; margin: 15px 0;">

                <div class="curtidas-container">
                    <a href="index.php?rota=curtir&id=<?= $post['id_post'] ?>" style="text-decoration: none; color: #ff4757; font-weight: bold;">
                        â¤ï¸ <?= $post['curtidas'] ?> Curtidas
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum post ainda. Seja o primeiro a compartilhar</p>
    <?php endif; ?>
</div>

</body>
</html>
