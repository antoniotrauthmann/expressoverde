<?php
include 'src/View/Cabecalho/index.php'; 
include 'config/conexao.php';
require_once 'src/Model/ProdutoModel.php';
?>
<link rel="stylesheet" href="src/View/Produto/style.css">

<?php
$id_produto = $_GET['p'] ?? $_POST['p'] ?? null;
if (!$id_produto) {
    echo "<div class='container pt-5 text-center'><p class='alert alert-warning'>Produto não encontrado.</p></div>";
    exit;
}
$stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.id_produto = ?");
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$result = $stmt->get_result();
$first_result = $result->fetch_assoc();

$precoOriginal = (float)$first_result["preco"];
$precoDesconto = $precoOriginal - ($precoOriginal / 5);
$precoParcela = $precoOriginal / 2;
?>

<div class="product-page-wrapper py-5">
    <div class="container product-container bg-white shadow-sm rounded-4 p-4 p-md-5">
        <div class="row gx-5 justify-content-center">
            
            <div class="col-12 col-md-6 col-lg-5 mb-4 mb-md-0">
                <div class="gallery-container">
                    <div class="main-image-box mb-3 border rounded-4 overflow-hidden shadow-sm">
                        <?php if(!empty($first_result['produto_caminho_imagem'])): ?>
                            <img src="public/uploads/<?= htmlspecialchars($first_result["produto_caminho_imagem"]) ?>" id="img-principal-galeria" class="img-principal" alt="<?= htmlspecialchars($first_result["produto_nome"]) ?>">
                        <?php else: ?>
                            <img src="public/img/imagemnaodisponivel.png" id="img-principal-galeria" class="img-principal" alt="Imagem não disponível">
                        <?php endif; ?>
                    </div>
                    
                    <div class="row g-2 thumbnail-row">
                        <?php if(!empty($first_result['produto_caminho_imagem'])): ?>
                            <div class="col-3">
                                <div class="thumb-wrapper active" onclick="atualizarFotoPrincipal(this, 'public/uploads/<?= htmlspecialchars($first_result['produto_caminho_imagem']) ?>')">
                                    <img src="public/uploads/<?= htmlspecialchars($first_result["produto_caminho_imagem"]) ?>" class="img-miniatura" alt="Miniatura">
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php while($row = $result->fetch_assoc()) { ?>
                            <?php if(!empty($row["produto_caminho_imagem"])): ?>
                                <div class="col-3">
                                    <div class="thumb-wrapper" onclick="atualizarFotoPrincipal(this, 'public/uploads/<?= htmlspecialchars($row['produto_caminho_imagem']) ?>')">
                                        <img src="public/uploads/<?= htmlspecialchars($row["produto_caminho_imagem"]) ?>" class="img-miniatura" alt="Miniatura adicional">
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-5">
                <div class="product-info-box">
                    
                    <nav class="breadcrumb-nav mb-2">
                        <span class="text-muted small text-uppercase fw-semibold tracking-wider">
                            <?= htmlspecialchars($first_result["categoria"]) ?> <i class="fa-solid fa-angle-right mx-1" style="font-size: 10px;"></i> <?= htmlspecialchars($first_result["produto_nome"]) ?>
                        </span>
                    </nav>
                    
                    <h1 class="product-title h3 fw-bold text-dark mb-2">
                        <?= htmlspecialchars($first_result["produto_nome"]) ?>
                    </h1>

                    <div class="price-card p-3 rounded-4 mb-4">
                        <div class="d-flex align-items-center flex-wrap gap-3 mb-2">
                            <span class="product-price h2 fw-bold mb-0">
                                R$ <?= number_format($precoOriginal, 2, ',', '.') ?>
                            </span>
                        </div>
                        <p class="text-muted small mb-0">
                            Ou em até <strong class="text-dark">2x de R$ <?= number_format($precoParcela, 2, ',', '.') ?></strong> sem juros
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold text-uppercase tracking-wider mb-2">Quantidade</label>
                        <div class="input-group quantity-selector rounded-3 overflow-hidden border" style="max-width: 130px;">
                            <button class="btn btn-light border-0 px-3 fs-5" type="button" onclick="mudarQtd(-1)">-</button>
                            <input type="text" id="qtd-exibicao" class="form-control text-center border-0 fw-bold bg-white" value="1" readonly>
                            <button class="btn btn-light border-0 px-3 fs-5" type="button" onclick="mudarQtd(1)">+</button>
                        </div>
                    </div>
                    

                    
                    <div class="description-section my-4">
                        <h2 class="h6 fw-bold mb-3 text-dark text-uppercase tracking-wider" style="font-size: 12px; color: #718096;">
                            <i class="fa-solid fa-align-left me-1 text-success"></i> Descrição do produto
                        </h2>
                        <p class="product-description text-muted">
                            <?= nl2br(htmlspecialchars($first_result["descricao"])) ?>
                        </p>
                    </div>

                    <hr class="my-4" style="border-color: #e2e8f0;">
                    
                    <div class="action-buttons-group mb-4">
                        <form action="index.php?rota=carrinho&action=add" method="POST" class="mb-2">
                            <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                            <input type="hidden" name="quantidade" id="form-qtd-comprar" value="1">
                            <input type="hidden" name="ir_checkout" value="1">
                            <button type="submit" class="btn btn-buy-now w-100 py-3">
                                <i class="fa-solid fa-bag-shopping me-2"></i> Comprar agora
                            </button>
                        </form>
                        
                        <form action="index.php?rota=carrinho&action=add" method="POST">
                            <input type="hidden" name="id_produto" value="<?= $first_result['id_produto'] ?>">
                            <input type="hidden" name="quantidade" id="form-qtd-carrinho" value="1">
                            <button type="submit" class="btn btn-add-cart w-100 py-3">
                                <i class="fa-solid fa-cart-plus me-2"></i> Adicionar ao carrinho
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function atualizarFotoPrincipal(miniatura, caminho) {
    document.getElementById('img-principal-galeria').src = caminho;
    document.querySelectorAll('.thumb-wrapper').forEach(t => t.classList.remove('active'));
    miniatura.classList.add('active');
}

function mudarQtd(delta) {
    var input = document.getElementById('qtd-exibicao');
    var valorAtual = parseInt(input.value) || 1;
    var novoValor = valorAtual + delta;
    if (novoValor < 1) novoValor = 1;
    
    input.value = novoValor;
    document.getElementById('form-qtd-comprar').value = novoValor;
    document.getElementById('form-qtd-carrinho').value = novoValor;
}
</script>