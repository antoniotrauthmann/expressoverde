<?php
include 'src/View/Cabecalho/index.php'; 
include 'config/conexao.php';
require_once 'src/Model/ProdutoModel.php';

// Sanitização e fallback seguro para as variáveis de URL
$c = filter_input(INPUT_GET, 'c', FILTER_DEFAULT) ?? '';
$b = filter_input(INPUT_GET, 'b', FILTER_DEFAULT) ?? '';

$categoria = 0;
$pesquisa = '';

// Define a estratégia de busca com base nos parâmetros passados
if (!empty($c)) {
    if ($c === "maisvendidos") {
        $categoria = 2;
    } else if ($c === "barato") {
        $categoria = 3;
    } else {
        $pesquisa = '%' . $c . '%'; 
        $categoria = 1; // Filtro por categoria nominal
    }
} else {
    $pesquisa = '%' . $b . '%';
    $categoria = 0; // Busca padrão por nome do produto
}

// Define o termo que aparecerá no título da página
$termo_pesquisado = !empty($b) ? $b : (!empty($c) && $categoria === 1 ? $c : '');

// Construção inteligente da Query SQL para evitar repetição de código
$sql = "SELECT p.*, i.produto_caminho_imagem 
        FROM produto p 
        LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto ";

switch ($categoria) {
    case 1:
        $sql .= "WHERE p.categoria LIKE ? GROUP BY p.id_produto";
        break;
    case 2:
        // Ordena por menor estoque simulando maior giro/vendas
        $sql .= "GROUP BY p.id_produto ORDER BY p.estoque ASC"; 
        break;
    case 3:
        // Correção da lógica anterior: filtra ordenando pelo menor preço
        $sql .= "GROUP BY p.id_produto ORDER BY p.preco ASC"; 
        break;
    case 0:
    default:
        $sql .= "WHERE p.produto_nome LIKE ? GROUP BY p.id_produto";
        break;
}

$stmt = $mysqli->prepare($sql);

// Vincula parâmetros APENAS se a query possuir placeholders '?' (Casos 0 e 1)
if ($categoria === 0 || $categoria === 1) {
    $stmt->bind_param("s", $pesquisa);
}

$stmt->execute();   
$resultado = $stmt->get_result();
$todos_resultados = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="src/View/Busca/style.css">

<div class="container py-5 mt-4">

    <div class="mb-4">
        <h1 class="h4 font-weight-bold text-dark">
            Pesquisando por: 
            <span class="text-purple">
                <?= !empty($termo_pesquisado) ? htmlspecialchars($termo_pesquisado, ENT_QUOTES, 'UTF-8') : "Todos os produtos"; ?>
            </span>
        </h1>
        <small class="text-muted"><?= count($todos_resultados); ?> produtos encontrados</small>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
        <?php if (empty($todos_resultados)): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Nenhum produto encontrado para esta busca.</p>
                <a href="index.php" class="btn bg-purple-light btn-purple-custom">Ver todos os produtos</a>
            </div>
        <?php else: ?>
            <?php foreach ($todos_resultados as $value) { ?>
                <div class="col">
                    <a href="index.php?rota=produto&p=<?= urlencode($value['id_produto']); ?>" class="text-decoration-none text-reset d-block h-100 class-card-link">
                        <div class="card h-100 border-0 product-card shadow-sm">
                            
                            <div class="position-relative overflow-hidden img-container">
                                <?php if (!empty($value['produto_caminho_imagem'])): ?>
                                    <img src="public/uploads/<?= htmlspecialchars($value["produto_caminho_imagem"], ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($value["produto_nome"], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <img src="public/img/imagemnaodisponivel.png" class="card-img-top product-img" alt="Imagem indisponível">
                                <?php endif; ?>
                                
                                <div class="position-absolute top-0 end-0 m-2 badge-likes shadow-sm">
                                    <span class="icon-u">Qtd: </span><?= (int)$value["estoque"]; ?>
                                </div>
                            </div>

                            <div class="card-body px-2 py-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="price-current mb-1">
                                        R$ <?= number_format((float)$value["preco"], 2, ',', '.'); ?>
                                    </div>
                                    <div class="product-title"><?= htmlspecialchars($value["produto_nome"], ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                
                                <div class="product-brand mt-2">
                                    <?php 
                                        $descricao = $value["descricao"] ?? '';
                                        echo mb_strlen($descricao, 'UTF-8') > 45 ? mb_substr($descricao, 0, 42, 'UTF-8') . '...' : $descricao; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <?php endif; ?>
    </div>
</div>