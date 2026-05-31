<?php include __DIR__ . '/../Cabecalho/index.php'; ?>

<link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">

<?php 
    $sql = "SELECT COUNT(DISTINCT p.id_produto) AS total_produtos FROM produto p";
    $resultado = $mysqli->query($sql);
    $total_produtos = $resultado->fetch_assoc()["total_produtos"];
?>
<div class="pt-2" style="color: white;">.</div>
<div class="corpo pt-5">
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
    <div id="carouselExample" class="carousel slide banner" data-bs-ride="carousel" data-bs-interval="5000" dir="rtl">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="public/img/banner1.png" class="propaganda-imagem d-block w-100 h-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="public/img/banner2.png" class="propaganda-imagem d-block w-100 h-100" alt="...">
            </div>
            <div class="carousel-item">
            <img src="public/img/banner3.png" class="propaganda-imagem d-block w-100 h-100" alt="...">
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
            <a href="index.php?rota=busca&c=semente" class="category-box rounded"><img src="public/img/sementes.png" class="d-block w-100 h-100 rounded"></a>
            <div class="category-box"><img src="public/img/precoBanana.png" class="d-block w-100 h-100 rounded"></div>
            <div class="category-box"><img src="public/img/suplementopoderosos.png" class="d-block w-100 h-100 rounded"></div>
            <div class="category-box"><img src="public/img/mais.png" class="d-block w-100 h-100 rounded"></div>
        </div>

        <!-- Produtos Relevantes -->
        <div class="product-grid">
        <?php 
                $sql = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem  FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 5"; 
                $result = $mysqli->query($sql);
                // print_r($result->fetch_assoc());
                $i = 0;
                if ($result->num_rows > 0) {
                    while($i < 5 && $row = $result->fetch_assoc()) {
                        echo "<a href='index.php?rota=produto&p=".$row['id_produto']."' class=\"product-box\" style=\"background-image: url('/PROJETO-ES/public/uploads/{$row['produto_caminho_imagem']}'); text-decoration:none; max-height: 200px; background-size: cover; background-position: center; color: white;\">{$row['produto_nome']}</a>";
                        $i++;
                        }
                        }
                        ?>
        </div>
    </div>

</div>
<?php $mysqli->close(); ?>
