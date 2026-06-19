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

        <?php if (!empty($_SESSION['carrinho_erro'])): ?>
            <div class="carrinho-alerta" id="carrinhoAlerta">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?php echo htmlspecialchars($_SESSION['carrinho_erro']); ?></span>
                <button type="button" class="alerta-fechar" onclick="document.getElementById('carrinhoAlerta').remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <?php unset($_SESSION['carrinho_erro']); ?>
        <?php endif; ?>

        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="empty-cart" id="emptyCart">
                <i class="fa-solid fa-basket-shopping"></i>
                <p>Seu carrinho está vazio.</p>
                <a href="index.php?rota=catalogo" class="btn-continuar">Continuar comprando</a>
            </div>
        <?php else: ?>
            <div class="carrinho-content" id="carrinhoContent">
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
                        <tbody id="carrinhoBody">
                            <?php 
                            $totalGeral = 0;
                            foreach ($_SESSION['carrinho'] as $item): 
                                $subtotal = $item['preco'] * $item['quantidade'];
                                $totalGeral += $subtotal;
                                $estoqueMax = isset($item['estoque']) ? (int)$item['estoque'] : 999;
                            ?>
                            <tr id="row-<?php echo $item['id']; ?>" data-estoque="<?php echo $estoqueMax; ?>">
                                <td data-label="Produto">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                    <small class="estoque-info" id="estoque-info-<?php echo $item['id']; ?>">
                                        <?php echo $estoqueMax; ?> disponíve<?php echo $estoqueMax === 1 ? 'l' : 'is'; ?>
                                    </small>
                                </td>
                                <td data-label="Preço">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                <td data-label="Quantidade">
                                    <div class="qty-stepper">
                                        <button type="button" class="qty-btn qty-minus" data-id="<?php echo $item['id']; ?>" title="Diminuir">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="qty-value" id="qty-<?php echo $item['id']; ?>"><?php echo $item['quantidade']; ?></span>
                                        <button type="button" class="qty-btn qty-plus" data-id="<?php echo $item['id']; ?>" title="Aumentar"
                                            <?php if ($item['quantidade'] >= $estoqueMax): ?>disabled<?php endif; ?>>
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>

                                </td>
                                <td data-label="Subtotal">
                                    <span id="subtotal-<?php echo $item['id']; ?>">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                                </td>
                                <td data-label="Ações">
                                    <button type="button" class="btn-remove" data-id="<?php echo $item['id']; ?>" title="Remover item">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="carrinho-resumo">
                    <h2>Total: <span class="total-value" id="totalGeral">R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></span></h2>
                    <div class="carrinho-actions">
                        <a href="index.php?rota=catalogo" class="btn-continuar">Continuar Comprando</a>
                        <a href="index.php?rota=checkout" class="btn-checkout">Finalizar Compra <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
        /**
         * Envia atualização de quantidade via AJAX e atualiza a UI
         */
        function atualizarQuantidade(idProduto, novaQtd) {
            const row = document.getElementById('row-' + idProduto);
            if (!row) return;

            // Feedback visual — pulso suave
            row.style.opacity = '0.6';

            const formData = new FormData();
            formData.append('id_produto', idProduto);
            formData.append('quantidade', novaQtd);

            fetch('index.php?rota=carrinho&action=update_ajax', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (!data.ok) return;

                if (data.removido) {
                    // Animação de saída e remoção
                    row.style.transition = 'all 0.35s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-30px)';
                    setTimeout(() => {
                        row.remove();
                        // Se o carrinho ficou vazio, recarrega para mostrar estado vazio
                        if (!document.querySelectorAll('#carrinhoBody tr').length) {
                            window.location.reload();
                        }
                    }, 350);
                } else {
                    // Atualizar valores na tela
                    document.getElementById('qty-' + idProduto).textContent = data.quantidade;
                    document.getElementById('subtotal-' + idProduto).textContent = 'R$ ' + data.subtotal;

                    // Atualizar estoque disponível no data attribute
                    row.dataset.estoque = data.estoque;

                    // Atualizar info de estoque
                    const estoqueInfo = document.getElementById('estoque-info-' + idProduto);
                    if (estoqueInfo) {
                        estoqueInfo.textContent = data.estoque + ' disponíve' + (data.estoque === 1 ? 'l' : 'is');
                    }

                    // Habilitar/desabilitar botão +
                    const btnPlus = row.querySelector('.qty-plus');
                    if (btnPlus) {
                        btnPlus.disabled = (data.quantidade >= data.estoque);
                    }

                    // Mostrar aviso se foi limitado pelo estoque
                    if (data.limitado) {
                        row.classList.add('row-limited');
                        setTimeout(() => row.classList.remove('row-limited'), 1500);
                    }

                    // Pulso verde de confirmação
                    row.style.opacity = '1';
                    row.classList.add('row-updated');
                    setTimeout(() => row.classList.remove('row-updated'), 600);
                }

                // Atualizar total geral
                document.getElementById('totalGeral').textContent = 'R$ ' + data.total;
            })
            .catch(() => {
                row.style.opacity = '1';
            });
        }

        // --- Botões + e - ---
        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const row = document.getElementById('row-' + id);
                const span = document.getElementById('qty-' + id);
                const qtdAtual = parseInt(span.textContent);
                const estoqueMax = parseInt(row.dataset.estoque);

                if (qtdAtual >= estoqueMax) {
                    // Já no limite — feedback visual
                    row.classList.add('row-limited');
                    setTimeout(() => row.classList.remove('row-limited'), 1500);
                    return;
                }

                atualizarQuantidade(id, qtdAtual + 1);
            });
        });

        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const span = document.getElementById('qty-' + id);
                const qtdAtual = parseInt(span.textContent);
                if (qtdAtual <= 1) {
                    if (confirm('Remover este item do carrinho?')) {
                        atualizarQuantidade(id, 0);
                    }
                } else {
                    atualizarQuantidade(id, qtdAtual - 1);
                }
            });
        });

        // --- Botão remover (lixeira) ---
        document.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', () => {
                if (confirm('Remover este item do carrinho?')) {
                    atualizarQuantidade(btn.dataset.id, 0);
                }
            });
        });
    </script>
</body>
</html>
