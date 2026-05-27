<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Expresso Verde</title>
    <link rel="stylesheet" href="src/View/Checkout/style.css">
</head>
<body>
    <main class="checkout-container">
        <h1>Finalizar Compra</h1>

        <form action="index.php?rota=checkout" method="POST" id="checkout-form">
            
            <!-- Seleção de Endereço -->
            <section class="checkout-section">
                <h2><i class="fa-solid fa-location-dot"></i> Endereço de Entrega</h2>
                
                <div class="enderecos-grid">
                    <?php foreach ($enderecos as $i => $end): ?>
                        <label class="endereco-option <?php echo $i === 0 ? 'selected' : ''; ?>">
                            <input type="radio" name="id_endereco" value="<?php echo $end['id_endereco']; ?>" <?php echo $i === 0 ? 'checked' : ''; ?> required>
                            <div class="endereco-option-content">
                                <div class="endereco-option-icon">
                                    <i class="fa-solid fa-house"></i>
                                </div>
                                <div class="endereco-option-info">
                                    <p class="endereco-option-rua"><?php echo htmlspecialchars($end['logradouro']); ?></p>
                                    <p class="endereco-option-detalhe"><?php echo htmlspecialchars($end['bairro']); ?> — <?php echo htmlspecialchars($end['cidade']); ?></p>
                                    <p class="endereco-option-detalhe">CEP: <?php echo htmlspecialchars($end['cep']); ?> · Zona <?php echo ucfirst($end['zona']); ?></p>
                                </div>
                                <div class="endereco-option-check">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>

                <a href="index.php?rota=cadastrar_endereco" class="btn-novo-endereco">
                    <i class="fa-solid fa-plus"></i> Adicionar novo endereço
                </a>
            </section>

            <!-- Resumo do Pedido -->
            <section class="checkout-section">
                <h2><i class="fa-solid fa-basket-shopping"></i> Resumo do Pedido</h2>

                <div class="resumo-itens">
                    <?php foreach ($carrinho as $item): ?>
                        <div class="resumo-item">
                            <div class="resumo-item-info">
                                <span class="resumo-item-qtd"><?php echo $item['quantidade']; ?>x</span>
                                <span class="resumo-item-nome"><?php echo htmlspecialchars($item['nome']); ?></span>
                            </div>
                            <span class="resumo-item-preco">R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="resumo-total">
                    <span>Total</span>
                    <span class="total-valor">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                </div>
            </section>

            <!-- Botões -->
            <div class="checkout-actions">
                <a href="index.php?rota=carrinho" class="btn-voltar">
                    <i class="fa-solid fa-arrow-left"></i> Voltar ao carrinho
                </a>
                <button type="submit" class="btn-confirmar">
                    Confirmar Pedido <i class="fa-solid fa-check"></i>
                </button>
            </div>
        </form>
    </main>

    <script>
        // Highlight selected address
        document.querySelectorAll('.endereco-option input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.endereco-option').forEach(opt => opt.classList.remove('selected'));
                radio.closest('.endereco-option').classList.add('selected');
            });
        });
    </script>
</body>
</html>
