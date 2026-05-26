<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comunidade</title>
    <style>
        /* Configuração Geral */
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        /* MENU DE NAVEGAÇÃO ATUALIZADO */
        nav {
            width: 100%;
            max-width: 500px;
            margin-bottom: 35px;
            display: flex;
            justify-content: center;
            background-color: #2d2d2d;
            padding: 6px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }

        nav a {
            text-decoration: none;
            color: #b3b3b3;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }

        /* Efeito ao passar o mouse nas abas apagadas */
        nav a:hover {
            color: #ffffff;
            background-color: #3d3d3d;
        }

        /* Aba ativa estilizada em verde */
        nav a.active {
            color: #ffffff;
            background-color: #2ecc71;
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
            box-sizing: border-box;
        }

        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
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

        .upload-input {
            margin-top: 15px;
            color: #e0e0e0;
            font-size: 14px;
        }

        .upload-input::file-selector-button {
            background-color: #4a4a4a;
            color: #ffffff;
            border: 1px solid #5a5a5a;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 10px;
            transition: background 0.2s;
        }

        .upload-input::file-selector-button:hover {
            background-color: #5a5a5a;
        }
    </style>
</head>
<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>

    <nav>
<<<<<<< HEAD
        <a href="index.php?rota=feed" class="active">Comunidade</a>
        <a href="index.php?rota=manual">Manual de Cuidados</a>
=======
        <a href="index.php?rota=feed" class="active">👥 Comunidade</a>
        <a href="index.php?rota=manual">🌱 Manual de Cuidados</a>
>>>>>>> 668c85436969dd389105faa6fba965b074598056
    </nav>

    <h2>Compartilhe com a comunidade</h2>

    <form action="index.php?rota=salvar" method="POST" enctype="multipart/form-data">
        <textarea name="conteudo_texto" placeholder="O que você quer compartilhar?"></textarea>
        <br>
        <input type="file" name="imagem" accept="image/*" class="upload-input">
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
                    <a href="index.php?rota=curtir&id=<?= $post['id_post'] ?>" style="text-decoration: none; color: #ff4757; font-weight: bold;">
                        ❤️ <?= $post['curtidas'] ?> Curtidas
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #ffffff;">Nenhum post ainda. Seja o primeiro a compartilhar</p>
    <?php endif; ?>
</div>

</body>
</html>