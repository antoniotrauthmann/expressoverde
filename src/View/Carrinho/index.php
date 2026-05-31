<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho - Expresso Verde</title>
    <link rel="stylesheet" href="src/View/Carrinho/style.css">
</head>
<body>
    <main class="carrinho-container">
        <h1>Meu Carrinho</h1>
        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="empty-cart">
                <i class="fa-solid fa-basket-shopping"></i>
                <p>Seu carrinho está vazio.</p>
                <a href="index.php?rota=catalogo" class="btn-continuar">Continuar comprando</a>
            </div>
        <?php else: ?>
            <div class="carrinho-content">
                <div class="table-responsive">
                    <table class="carrinho-table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $totalGeral = 0;
                            foreach ($_SESSION['carrinho'] as $item): 
                                $subtotal = $item['preco'] * $item['quantidade'];
                                $totalGeral += $subtotal;
                            ?>
                            <tr>
                                <td data-label="Produto"><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td data-label="Preço">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                <td data-label="Quantidade">
                                    <form action="index.php?rota=carrinho&action=update" method="POST" class="form-update">
                                        <input type="hidden" name="id_produto" value="<?php echo $item['id']; ?>">
                                        <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="0" class="input-qtd">
                                        <button type="submit" class="btn-update"><i class="fa-solid fa-rotate"></i></button>
                                    </form>
                                </td>
                                <td data-label="Subtotal">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                                <td data-label="Ações">
                                    <a href="index.php?rota=carrinho&action=remove&id=<?php echo $item['id']; ?>" class="btn-remove"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="carrinho-resumo">
                    <h2>Total: <span class="total-value">R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></span></h2>
                    <div class="carrinho-actions">
                        <a href="index.php?rota=catalogo" class="btn-continuar">Continuar Comprando</a>
                        <a href="index.php?rota=checkout" class="btn-checkout">Finalizar Compra <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
