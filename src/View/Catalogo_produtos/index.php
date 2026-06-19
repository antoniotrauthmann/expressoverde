<?php include __DIR__ . '/../Cabecalho/index.php'; ?>

<link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">

<?php 
    $sql = "SELECT COUNT(DISTINCT p.id_produto) AS total_produtos FROM produto p";
    $resultado = $mysqli->query($sql);
    $total_produtos = $resultado->fetch_assoc()["total_produtos"];
?>
<div class="pt-1" style="color: white;">.</div>
<div class="corpo pt-5 w-100">
    <div class="category-bar text-center d-flex justify-content-center gap-5 fw-bold fs-6">
        <a href="index.php?rota=busca&c=maisvendidos">Todas as categorias</a>
        <a href="index.php?rota=busca&c=planta">Plantas</a>
        <a href="index.php?rota=busca&c=kit_jardinagem">Ferramentas</a>
        <a href="index.php?rota=busca&c=suplemento">Suplementos</a>
        <a href="index.php?rota=busca&c=semente">Sementes</a>
        <a href="index.php?rota=busca&c=acessorio">Acessórios</a>
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

    <div class="container">
        <div class="category-grid">
            <a href="index.php?rota=busca&c=maisvendidos" class="category-box"><img src="public/img/mais.png" class="d-block w-100 h-100 rounded"></a>
            <a href="index.php?rota=busca&c=barato" class="category-box"><img src="public/img/precoBanana.png" class="d-block w-100 h-100 rounded"></a>
            <a href="index.php?rota=busca&c=suplemento" class="category-box"><img src="public/img/suplementopoderosos.png" class="d-block w-100 h-100 rounded"></a>
            <a href="index.php?rota=busca&c=semente" class="category-box rounded"><img src="public/img/sementes.png" class="d-block w-100 h-100 rounded"></a>
        </div>

        <div class="d-flex flex-row flex-wrap row-gap-5">
            <div class="w-100 pt-5 position-relative">
                <p class="fs-4 text-center fw-bold mb-4"> Produtos relevantes </p>
                <!-- CARROSSEL -->
                <div id="carrosselProdutos" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                            $sql = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem, p.preco FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 15"; 
                            $result = $mysqli->query($sql);
                            
                            $produtos = [];
                            // guarda todos os produtos em um array
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $produtos[] = $row;
                                }
                            }

                            $totalProdutos = count($produtos);
                            $itensPorSlide = 5;

                            if ($totalProdutos > 0) {
                                // calcula quantos slides serão necessários
                                $numSlides = ceil($totalProdutos / $itensPorSlide); 
                                
                                for ($s = 0; $s < $numSlides; $s++) {
                                    $activeClass = ($s == 0) ? 'active' : '';
                                    echo "<div class='carousel-item {$activeClass}'>";
                                    echo "<div class='product-grid'>";
                                    
                                    // preenche exatamente 5 itens por slide
                                    for ($i = 0; $i < $itensPorSlide; $i++) {
                                        // faz o indice voltar ao 0 se ultrapassar o total
                                        $index = ($s * $itensPorSlide + $i) % $totalProdutos;
                                        $row = $produtos[$index];
                                        ?>

                                        <!-- CARD DO PRODUTO -->
                                        <a <?= "href='index.php?rota=produto&p={$row['id_produto']}'" ?> class="card border-0 text-center" style="background-color: transparent; text-decoration: none;">
                                            <img class="card-img-top border border-gray rounded" <?= "src='/PROJETO-ES/public/uploads/{$row['produto_caminho_imagem']}'" ?> style="height: 250px; width: 100%; object-fit: cover;">
                                            <div class="card-body d-flex flex-column justify-content-end pb-0 px-0">
                                                <h5 class="card-title text-dark mb-4 mt-2" style="font-weight: 400; font-size: 1.1rem;"><?= $row['produto_nome'] ?></h5>
                                                <p class="card-text mb-2">
                                                    <span class="text-dark fst-italic" style="font-size: 0.9rem;">por apenas</span> 
                                                    <span class="fw-bold ms-1" style="color: #145c54; font-size: 1.6rem;">R$<?= number_format($row['preco'], 2, ',', '.') ?></span>
                                                </p>
                                            </div>
                                        </a>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        <?php } } ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carrosselProdutos" data-bs-slide="prev" style="width: 5%;">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carrosselProdutos" data-bs-slide="next" style="width: 5%;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            </div>

            <div class="w-100 pt-5">
                <p class="fs-4 text-center fw-bold"> Acessórios </p>
                <div class="product-grid">
                    <?php 
                        $sql = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem  FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 5"; 
                        $result = $mysqli->query($sql);
                        $i = 0;
                        if ($result->num_rows > 0) {
                            while($i < 5 && $row = $result->fetch_assoc()) {
                                echo "<a href='index.php?rota=produto&p=".$row['id_produto']."' 
                                class=\"product-box border border-gray\" style=\"background-image: url('/PROJETO-ES/public/uploads/{$row['produto_caminho_imagem']}'); 
                                text-decoration:none; text-shadow: 1px 1px black; max-height: 200px; background-size: cover; background-position: center; color: white;\">
                                {$row['produto_nome']}
                                </a>";
                                $i++;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $mysqli->close(); ?>
