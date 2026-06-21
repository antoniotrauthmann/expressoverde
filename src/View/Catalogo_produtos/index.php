<?php include __DIR__ . '/../Cabecalho/index.php'; ?>

<link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">

<?php 
    $sql = "SELECT COUNT(DISTINCT p.id_produto) AS total_produtos FROM produto p";
    $resultado = $mysqli->query($sql);
    $total_produtos = $resultado->fetch_assoc()["total_produtos"];
?>

<div class="corpo w-100">
    <div class="hero-section">
        <div class="container hero-container">
            <div class="row align-items-center h-100">
                <div class="col-lg-6 hero-text-side">
                    <span class="badge-tag">Expresso Verde</span>
                    <h1 class="hero-title">Cultive a sua Vida do Jeito Mais <span class="highlight-text">Verde</span></h1>
                    <p class="hero-subtitle">Plantas selecionadas com amor, ferramentas profissionais e suplementos poderosos entregues diretamente à sua porta.</p>
                    
                    <div class="hero-actions">
                        <a href="#produtos-relevantes" class="btn-order-now">Explorar Loja</a>
                        <span class="total-count-badge">🌿 <b><?= $total_produtos ?></b> Espécies Disponíveis</span>
                    </div>

                    <div class="hero-reviews mt-4 d-flex align-items-center gap-3">
                        <div class="review-stars text-warning fs-5">★★★★★</div>
                        <div class="review-text text-white-50 fs-7">
                            <span class="text-white fw-bold">5/5</span> baseado em mais de 2 clientes felizes.
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div id="carouselExample" class="carousel slide banner-carousel shadow-lg" data-bs-ride="carousel" data-bs-interval="7000">
                        <div class="carousel-inner rounded-4">
                            <div class="carousel-item active">
                                <img src="public/img/banner1.png" class="propaganda-imagem d-block w-100" alt="Banner 1">
                            </div>
                            <div class="carousel-item">
                                <img src="public/img/banner2.png" class="propaganda-imagem d-block w-100" alt="Banner 2">
                            </div>
                            <div class="carousel-item">
                                <img src="public/img/banner3.png" class="propaganda-imagem d-block w-100" alt="Banner 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container section-padding">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="section-title text-start">Explore as Nossas Categorias</h2>
                <p class="section-subtitle text-start text-muted">Encontre tudo o que precisa para o seu jardim</p>
            </div>
        </div>

        <div class="category-grid-modern mb-5" id="produtos-relevantes">
            <a href="index.php?rota=busca&c=planta" class="category-card-item">
                <div class="category-icon-wrapper">🌿</div>
                <span class="category-name">Plantas</span>
            </a>
            <a href="index.php?rota=busca&c=kit_jardinagem" class="category-card-item">
                <div class="category-icon-wrapper">🪚</div>
                <span class="category-name">Ferramentas</span>
            </a>
            <a href="index.php?rota=busca&c=suplemento" class="category-card-item">
                <div class="category-icon-wrapper">🌱</div>
                <span class="category-name">Suplementos</span>
            </a>
            <a href="index.php?rota=busca&c=semente" class="category-card-item">
                <div class="category-icon-wrapper">🫘</div>
                <span class="category-name">Sementes</span>
            </a>
            <a href="index.php?rota=busca&c=acessorio" class="category-card-item">
                <div class="category-icon-wrapper">🪴</div>
                <span class="category-name">Acessórios</span>
            </a>
        </div>

        <div class="pt-4 position-relative">
            <div class="text-center mb-4">
                <h2 class="section-title">Produtos Relevantes</h2>
                <div class="category-tabs-bar mt-3">
                    <a href="index.php?rota=busca&c=maisvendidos" class="tab-pill active">Todos</a>
                    <a href="index.php?rota=busca&c=planta" class="tab-pill">Plantas</a>
                    <a href="index.php?rota=busca&c=suplemento" class="tab-pill">Suplementos</a>
                    <a href="index.php?rota=busca&c=semente" class="tab-pill">Sementes</a>
                </div>
            </div>

            <div id="carrosselProdutos" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                        $sql = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem, p.preco FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 15"; 
                        $result = $mysqli->query($sql);
                        
                        $produtos = [];
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $produtos[] = $row;
                            }
                        }

                        $totalProdutos = count($produtos);
                        $itensPorSlide = 4;

                        if ($totalProdutos > 0) {
                            $numSlides = ceil($totalProdutos / $itensPorSlide); 
                            
                            for ($s = 0; $s < $numSlides; $s++) {
                                $activeClass = ($s == 0) ? 'active' : '';
                                echo "<div class='carousel-item {$activeClass}'>";
                                echo "<div class='product-grid-modern'>";
                                
                                for ($i = 0; $i < $itensPorSlide; $i++) {
                                    $index = ($s * $itensPorSlide + $i) % $totalProdutos;
                                    $row = $produtos[$index];
                                    ?>
                                    <a href="index.php?rota=produto&p=<?= $row['id_produto'] ?>" class="product-card-modern">
                                        <div class="product-img-wrapper">
                                            <img src="/PROJETO-ES/public/uploads/<?= $row['produto_caminho_imagem'] ?>" alt="<?= $row['produto_nome'] ?>">
                                        </div>
                                        <div class="product-info-wrapper">
                                            <h5 class="product-title-modern"><?= $row['produto_nome'] ?></h5>
                                            <p class="product-meta-modern">🚐 Entrega Segura &middot; Expresso Verde</p>
                                            <div class="product-footer-modern">
                                                <span class="product-price-modern">R$ <?= number_format($row['preco'], 2, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                                </div>
                            </div>
                        <?php } } ?>
                </div>

                <button class="carousel-control-prev custom-control-btn" type="button" data-bs-target="#carrosselProdutos" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next custom-control-btn" type="button" data-bs-target="#carrosselProdutos" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>

        <div class="section-padding pt-5">
            <div class="row align-items-stretch">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="promo-banner-card">
                        <span class="promo-badge">🔥 Ofertas Relâmpago</span>
                        <h3>Renove Seu Espaço Hoje</h3>
                        <p>Suplementos e mudas com valores especiais por tempo limitado.</p>
                        <div class="countdown-placeholder">Aproveite as taxas de entrega grátis!</div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        <?php 
                            // Filtro simulando ofertas (Ordenado por menor preço como destaque de promoção)
                            $sql_ofertas = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem, p.preco FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto ORDER BY p.preco ASC LIMIT 3";
                            $res_ofertas = $mysqli->query($sql_ofertas);
                            while($row = $res_ofertas->fetch_assoc()) { 
                        ?>
                            <div class="col-md-4">
                                <a href="index.php?rota=produto&p=<?= $row['id_produto'] ?>" class="compact-offer-card mt-3">
                                    <span class="tag-discount">PROMO</span>
                                    <div class="offer-img-box">
                                        <img src="/PROJETO-ES/public/uploads/<?= $row['produto_caminho_imagem'] ?>" alt="<?= $row['produto_nome'] ?>">
                                    </div>
                                    <h5><?= $row['produto_nome'] ?></h5>
                                    <div class="price-line">
                                        <span class="old-price">R$ <?= number_format($row['preco'] * 1.25, 2, ',', '.') ?></span>
                                        <span class="new-price">R$ <?= number_format($row['preco'], 2, ',', '.') ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-padding premium-showcase-bg rounded-4 my-5 px-4 py-5">
            <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                <div>
                    <span class="text-warning text-uppercase fw-bold fs-7 tracking-wider">Edição Exclusiva</span>
                    <h2 class="text-white font-weight-bold m-0">Plantas Raras & Colecionáveis</h2>
                </div>
                <a href="index.php?rota=busca&c=planta" class="btn btn-outline-light rounded-pill btn-sm px-4">Ver Todas</a>
            </div>
            <div class="row g-4">
                <?php 
                    // Filtragem por ordem randômica focada em exclusividade visual
                    $sql_raras = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem, p.preco FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.categoria = 'planta' GROUP BY p.id_produto ORDER BY p.preco DESC LIMIT 4";
                    $res_raras = $mysqli->query($sql_raras);
                    while($row = $res_raras->fetch_assoc()) { 
                ?>
                    <div class="col-md-3">
                        <div class="rare-product-card">
                            <div class="rare-img-wrapper">
                                <img src="/PROJETO-ES/public/uploads/<?= $row['produto_caminho_imagem'] ?>" alt="<?= $row['produto_nome'] ?>">
                            </div>
                            <div class="rare-info">
                                <h4><?= $row['produto_nome'] ?></h4>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="rare-price">R$ <?= number_format($row['preco'], 2, ',', '.') ?></span>
                                    <a href="index.php?rota=produto&p=<?= $row['id_produto'] ?>" class="rare-btn-view">📦</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="section-padding pt-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Kits Completos de Jardinagem</h2>
                <p class="text-muted">Tudo o que você precisa em uma única caixa para começar a plantar imediatamente</p>
            </div>
            <div class="row g-4">
                <?php 
                    // Filtragem simulando os lançamentos mais recentes/IDs maiores
                    $sql_kits = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem, p.preco, p.descricao FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.categoria = 'kit_jardinagem' GROUP BY p.id_produto ORDER BY p.id_produto DESC LIMIT 2";
                    $res_kits = $mysqli->query($sql_kits);
                    while($row = $res_kits->fetch_assoc()) { 
                ?>
                    <div class="col-md-6">
                        <div class="kit-horizontal-card">
                            <div class="kit-img">
                                <img src="/PROJETO-ES/public/uploads/<?= $row['produto_caminho_imagem'] ?>" alt="<?= $row['produto_nome'] ?>">
                            </div>
                            <div class="kit-body">
                                <span class="kit-badge">Combo Prático</span>
                                <h4><?php echo mb_strlen($row['produto_nome'], 'UTF-8') > 45 ? mb_substr($row['produto_nome'], 0, 42, 'UTF-8') . '...' : $row['produto_nome']; ?></h4>
                                <p class="text-muted fs-7"><?php echo mb_strlen($row['descricao'], 'UTF-8') > 45 ? mb_substr($row['descricao'], 0, 42, 'UTF-8') . '...' : $row['descricao']; ?></p>
                                <div class="d-flex align-items-center justify-content-between mt-auto">
                                    <span class="kit-price">R$ <?= number_format($row['preco'], 2, ',', '.') ?></span>
                                    <a href="index.php?rota=produto&p=<?= $row['id_produto'] ?>" class="btn-kit-buy">Comprar Kit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="section-padding pt-5">
            <div class="mb-4">
                <h2 class="section-title text-start">Acessórios em Destaque</h2>
                <p class="section-subtitle text-start text-muted">Peças selecionadas para elevar o nível estético do seu ambiente</p>
            </div>
            <div class="accessories-bento-grid">
                <?php 
                    $sql = "SELECT p.id_produto, p.produto_nome, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto LIMIT 5"; 
                    $result = $mysqli->query($sql);
                    $index = 1;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                            <a href='index.php?rota=produto&p={$row['id_produto']}' class='accessory-bento-item item-style-{$index}'>
                                <div class='accessory-bg-img' style=\"background-image: url('/PROJETO-ES/public/uploads/{$row['produto_caminho_imagem']}');\"></div>
                                <div class='accessory-overlay'>
                                    <div class='accessory-text-content'>
                                        <span class='accessory-category-tag'>Premium</span>
                                        <span class='accessory-title'>{$row['produto_nome']}</span>
                                    </div>
                                </div>
                            </a>";
                            $index++;
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $mysqli->close(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Mantém a lógica de abrir o modal de cadastro via URL (vinda do Upstream)
        const params = new URLSearchParams(window.location.search);
        if (params.get('modal') === 'cadastro') {
            const cadastroModal = document.getElementById('cadastroModal');
            if (cadastroModal) {
                new bootstrap.Modal(cadastroModal).show();
            }
        }

        // 2. Mantém a lógica dinâmica do cabeçalho ao scrollar (vinda do Stash)
        const header = document.querySelector('.cabecalho.header-dynamic');
        if (header) {
            function checkScroll() {
                // Altera o estado assim que o usuário realiza o primeiro scroll para baixo (mais de 15px)
                if (window.scrollY > 15) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', checkScroll);
            checkScroll(); // Executa na inicialização da página caso já comece com scroll
        }
    });
</script>