<?php include __DIR__ . '/../Cabecalho/index.php'; ?>

<link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">

<?php 
    $sql = "SELECT COUNT(DISTINCT p.id_produto) AS total_produtos FROM produto p";
    $resultado = $mysqli->query($sql);
    $total_produtos = $resultado->fetch_assoc()["total_produtos"];
?>
<!-- 
<php    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo('
                <form method="POST" action="index.php?rota=produto" class="card-form">
                    
                    <input type="hidden" name="rota" value="produto">
                    <input type="hidden" name="id" value="' . $row["id_produto"] . '">
                    
                    <button type="submit" class="card btn-card">
                        <div class="card-image">
                            <img src="public/uploads/'. $row["produto_caminho_imagem"] . '" alt="' . $row["produto_nome"] . '">
                        </div>
                        <div class="card-content">
                            <div class="card-title">' . $row["produto_nome"] . '</div>
                            <span class="price">R$ ' . $row["preco"] . '</span>
                            <span class="card-condition">'. $row["estoque"] .' em estoque</span>
                        </div>
                    </button>
                </form>
            ');
        }
    } else {
        echo "0 resultados";
    }

    $mysqli->close();
?> -->

<div class="corpo">
    <div class="category-bar">
        <a href="#">Todas as categorias</a>
        <a href="#">plantas</a>
        <a href="#">kit_jardinagem</a>
        <a href="#">suplemento</a>
        <a href="#">semente</a>
        <a href="#">ferramenta</a>
        <a href="#">acessorios</a>
    </div>

    <!-- Banner Principal -->
    <div id="carouselExample" class="carousel slide banner">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="public/img/Imagem_login.png" class="propaganda-imagem d-block w-100 h-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
   <!--  <div class="banner">
        <div class="arrow">&lt;</div>
        <div class="banner-text">PROPAGANDA</div>
        <div class="arrow">&gt;</div>
    </div> -->

    <!-- Seção de Conteúdo (Fundo Cinza) -->
    <div class="container">
        <!-- Categorias -->
        <div class="category-grid">
            <div class="category-box">Mais Vendidos</div>
            <div class="category-box">Preço de banana</div>
            <div class="category-box">Suplementos poderosos</div>
            <div class="category-box">Ferramentas obrigatórias</div>
        </div>

        <!-- Produtos Relevantes -->
        <div class="product-grid">
        <?php 
                $sql = "SELECT p.produto_nome, i.produto_caminho_imagem  FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 5"; 
                $result = $mysqli->query($sql);
                // print_r($result->fetch_assoc());
                $i = 0;
                if ($result->num_rows > 0) {
                    while($i < 5 && $row = $result->fetch_assoc()) {
                        echo "<div class=\"product-box\" style=\"background-image: url('/PROJETO-ES/public/uploads/{$row['produto_caminho_imagem']}'); max-height: 200px; background-size: cover; background-position: center;\">{$row['produto_nome']}</div>";
                        $i++;
                        }
                        }
                        ?>
        </div>
    </div>

</div>
<?php $mysqli->close(); ?>
