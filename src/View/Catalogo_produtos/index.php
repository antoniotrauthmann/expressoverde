<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">
</head>
<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>

    <div class="marketplace-grid">
    <?php 
        $sql = "SELECT p.id_produto, p.produto_nome, p.preco, p.estoque, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto"; 
        $result = $mysqli->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo('
                    <a href="index.php?rota=produto&id=' . $row["id_produto"] . '" class="card-form">
                        <div class="card btn-card">
                            <div class="card-image">
                                <img src="public/uploads/'. $row["produto_caminho_imagem"] . '" alt="' . htmlspecialchars($row["produto_nome"]) . '">
                            </div>
                            <div class="card-content">
                                <div class="card-title">' . htmlspecialchars($row["produto_nome"]) . '</div>
                                <span class="price">R$ ' . $row["preco"] . '</span>
                                <span class="card-condition">'. $row["estoque"] .' em estoque</span>
                            </div>
                        </div>
                    </a>
                ');
            }
        } else {
            echo "0 resultados";
        }
    ?>
    </div>
</body>
</html>
