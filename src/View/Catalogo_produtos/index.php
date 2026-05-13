<!DOCTYPE html>

    <link rel="stylesheet" href="src/View/Catalogo_produtos/style.css">

<div class="marketplace-grid">
<!-- <php 
    $sql = "SELECT * FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto"; 
    $result = $mysqli->query($sql);
    
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
    <div class="banner">
        <div class="arrow">&lt;</div>
        <div class="banner-text">PROPAGANDA</div>
        <div class="arrow">&gt;</div>
    </div>

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
            <div class="product-box">Produto Relevante 1</div>
            <div class="product-box">Produto Relevante 2</div>
            <div class="product-box">Produto Relevante 3</div>
            <div class="product-box">Produto Relevante 4</div>
            <div class="product-box">Produto Relevante 5</div>
        </div>
    </div>

</div>
