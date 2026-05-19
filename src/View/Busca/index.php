oi
<br>
<?php
// require_once 'src/Model/ProdutoModel.php';
include '../../../config/conexao.php';
require_once '../../Model/ProdutoModel.php';

print_r($_GET);
$pesquisa = $_GET['busca'];
// WHERE produto_nome LIKE '%$pesquisa%'"

$stmt = $mysqli->prepare("SELECT * FROM produto WHERE produto_nome LIKE '%$pesquisa%'");
$stmt->execute();   
$result = $stmt->get_result()->fetch_assoc();

print_r($result);

?>