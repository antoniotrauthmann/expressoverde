<?php
include 'src/View/Cabecalho/index.php'; 
include 'config/conexao.php';
require_once 'src/Model/ProdutoModel.php';
?>
<link rel="stylesheet" href="src/View/Produto/style.css">
<!-- <link rel="stylesheet" href="src/View/Produto/style.css"> -->

<?php
$id_produto = $_GET['p'] ?? $_POST['p'] ?? null;
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
<div class="container pt-5 mb-5">
    <div class="row gx-5 pt-5 w-75 mx-auto">
        
        <div class="col-md-5 mb-4">
            <div class="mb-3 shadow-sm rounded-4">
                <?php if($first_result['produto_caminho_imagem'] != NULL){
                    echo('<img src="public/uploads/'. $first_result["produto_caminho_imagem"] .'" class="img-principal">');
                } else {
                    echo('<img src="public/img/imagemnaodisponivel.png" class="img-principal">');
                } ?>
            </div>
            
            <div class="row g-2">
                <div class="col-3">
                    <?= '<img src="public/uploads/'. $first_result["produto_caminho_imagem"] .'" class="img-miniatura">'?>
                </div>
                <?php while($row = $result->fetch_assoc()) { ?>
                <div class="col-3">
                    <?= '<img src="public/uploads/'. $row["produto_caminho_imagem"] .'" class="img-miniatura">'?>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-7">
            
            <div class="text-muted small mb-2">
                <?= $first_result["categoria"] . ' / ' . $first_result["produto_nome"] ?>
            </div>
            
            <h1 class="h3 fw-bold text-dark mb-4">
                <?= $first_result["produto_nome"]?>
            </h1>
            
            <div class="mb-4">
                <div class="d-flex align-items-center gap-3 mb-1">
                    <span class="h3 fw-bold mb-0" style="color: var(--cor-primaria);">
                        <?= "R$ ". ($first_result["preco"])?>
                    </span>
                    <span class="badge-desconto">
                        <?= "R$ ". ($first_result["preco"] - ($first_result["preco"]/5)) . " na 1ª compra"?>
                    </span>
                </div>
                <p class="text-muted small mb-0">
                    em até <strong><?= "2x R$ ". ($first_result["preco"]/2)?></strong>
                </p>
            </div>
            
            <div class="mb-5">
                <form action="index.php?rota=carrinho&action=add" method="POST" class="mb-2">
                    <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                    <input type="hidden" name="quantidade" value="1">
                    <input type="hidden" name="ir_checkout" value="1">
                    <button type="submit" class="btn btn-roxo w-100">comprar agora</button>
                </form>
                
                <form action="index.php?rota=carrinho&action=add" method="POST">
                    <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                    <input type="hidden" name="quantidade" value="1">
                    <button type="submit" class="btn btn-outline-roxo w-100">adicionar ao carrinho</button>
                </form>
            </div>
            
            <hr style="border-color: var(--cor-borda);">
            
            <div class="my-4">
                <h2 class="h6 fw-bold mb-3 text-dark">descrição do produto</h2>
                <p class="text-muted" style="line-height: 1.6;">
                    <?= $first_result["descricao"]?>
                </p>
            </div>

            <hr style="border-color: var(--cor-borda);">

            <div class="d-flex justify-content-between align-items-center my-4">
                <div>
                    <span class="text-muted small d-block mb-1">marca</span>
                    <strong class="text-dark">qualquer uma</strong>
                </div>
                <button class="btn btn-outline-roxo btn-sm px-4">seguir</button>
            </div>

        </div>
    </div>
</div>