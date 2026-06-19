<?php
include 'src/View/Cabecalho/index.php'; 
include 'config/conexao.php';
require_once 'src/Model/ProdutoModel.php';


// print_r($_GET);
$categoria = 0;

// formata a variavel de busca
if ($_GET['c'] != NULL && strlen($_GET['c']) > 0){
    if ($_GET['c'] == "maisvendidos"){
        $categoria = 2;
    } else if($_GET['c'] == "barato"){
        $categoria = 3;
    } else {
        $pesquisa = '%' . $_GET['c'] . '%'; 
        $categoria = 1;
    }
} else{
    $pesquisa = '%' . $_GET['b'] . '%'; 
}
$pesquisa2 = $_GET['b'] ?? $_GET['c'];

// monta a query, a interrogação é onde a pesquisa vai parar
if($categoria == 1){
    $stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.categoria LIKE ? GROUP BY p.id_produto");
} else if ($categoria == 0){
    $stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.produto_nome LIKE ? GROUP BY p.id_produto");
}  else if ($categoria == 2){
    $stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto GROUP BY p.id_produto ORDER BY p.estoque ASC");
}  else if ($categoria == 3){
    $stmt = $mysqli->prepare("SELECT p.*, i.produto_caminho_imagem FROM produto p LEFT JOIN imagens_produto i ON p.id_produto = i.id_produto WHERE p.produto_nome LIKE ? GROUP BY p.id_produto");
} 
$stmt->bind_param("s", $pesquisa);

// executa e pega todos os resultados
$stmt->execute();   
$resultado = $stmt->get_result();
$todos_resultados = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="src/View/Busca/style.css">
<!DOCTYPE html>
<div class="pt-5" style="color: white;">.</div>
<div class="container py-4 pt-5">
    <div>
        <h4 class="font-weight-bold">Pesquisando por: <?php if(strlen($pesquisa2) > 0){ echo $pesquisa2; }else {echo "Todos os produtos";} ?></h4>
    </div>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4 pt-4">
        <?php foreach ($todos_resultados as $value) {?>
            <div class="col">
                <a href="index.php?rota=produto&p=<?= $value['id_produto']; ?>" class="text-decoration-none text-reset d-block h-100">
                    <div class="card h-100 border-0 cursor-pointer">
                        <div class="position-relative">
                            <?php if($value['produto_caminho_imagem'] != NULL){
                                echo('<img src="public/uploads/'. $value["produto_caminho_imagem"] .'" class="card-img-top product-img">');
                            } else {
                                echo('<img src="public/img/imagemnaodisponivel.png" class="card-img-top product-img">');
                            } ?>
                            <div class="position-absolute top-0 end-0 m-2 badge-likes shadow-sm">
                                <span class="icon-u">Em estoque: </span><?= $value["estoque"]; ?>
                            </div>
                        </div>
                        <div class="card-body px-0 py-2">
                            <div class="price-current"><?= $value["preco"]; ?></div>
                            <div class="product-title"><?= $value["produto_nome"]; ?></div>
                            <div class="product-brand">
                                <?php 
                                    $descricao = $value["descricao"] ?? '';
                                    echo mb_strlen($descricao, 'UTF-8') > 50 ? mb_substr($descricao, 0, 30, 'UTF-8') . '...' : $descricao; 
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
