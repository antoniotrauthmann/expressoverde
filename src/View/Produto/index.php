<?php include 'src/View/Cabecalho/index.php'; ?>

<link rel="stylesheet" href="src/View/Produto/style.css">

<?php
$id_produto = $_GET['id'] ?? $_POST['id'] ?? null;
if (!$id_produto) {
    echo "<p>Produto não encontrado.</p>";
    exit;
}
$stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.id_produto = ?");
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$result = $stmt->get_result();
$first_result = $result->fetch_assoc();
?>

<div class="product-container">
    <div class="left-column">
        <div class="main-image">
            <?= '<img src="public/uploads/'. $first_result["produto_caminho_imagem"] .'">'?>
        </div>
        <div class="thumbnail-gallery">
            <?= '<img src="public/uploads/'. $first_result["produto_caminho_imagem"] .'">'?>
            <?php while($row = $result->fetch_assoc()) { ?>
            <?= '<img src="public/uploads/'. $row["produto_caminho_imagem"] .'">'?>
            <?php } ?>
        </div>
    </div>

    <div class="right-column">
        <div class="breadcrumbs">
            ferramentas / escavação / pá
        </div>
        
        <h1 class="product-title"><?= $first_result["produto_nome"]?></h1>
        
        <div class="promo-tag">
            <?= "R$ ". ($first_result["preco"] - ($first_result["preco"]/5)) . " na 1ª compra"?>
        </div>
        
        <div class="price-section">
            <span class="current-price"><?= "R$ ". ($first_result["preco"])?></span>
            <p class="installments">em até <strong><?= "2x R$ ". ($first_result["preco"]/2)?></strong></p>
        </div>
        
        <div class="action-buttons">
            <form action="index.php?rota=carrinho&action=add" method="POST" style="display:inline;">
                <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                <input type="hidden" name="quantidade" value="1">
                <input type="hidden" name="ir_checkout" value="1">
                <button type="submit" class="btn-primary">comprar agora</button>
            </form>
            <form action="index.php?rota=carrinho&action=add" method="POST" style="display:inline;">
                <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                <input type="hidden" name="quantidade" value="1">
                <button type="submit" class="btn-secondary">adicionar ao carrinho</button>
            </form>
        </div>
        
        <div class="description-section">
            <h2>descrição do produto</h2>
            <p><?= $first_result["descricao"]?></p>
        </div>

        <div class="brand-section">
            <div class="brand-info">
                <span>marca</span>
                <strong>qualquer uma</strong>
            </div>
        </div>
    </div>
</div>
