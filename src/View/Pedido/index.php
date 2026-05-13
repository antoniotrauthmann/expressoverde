<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos - Expresso Verde</title>
    <link rel="stylesheet" href="src/View/Pedido/style.css">
</head>
<body>
    <main class="pedidos-container">
        <h1>Meus Pedidos</h1>
        
        <?php if (empty($pedidos)): ?>
            <div class="empty-pedidos">
                <i class="fa-solid fa-box-open"></i>
                <p>Você ainda não realizou nenhuma compra.</p>
                <a href="index.php?rota=catalogo" class="btn-comprar">Fazer primeira compra</a>
            </div>
        <?php else: ?>
            <div class="pedidos-lista">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="pedido-card">
                        <div class="pedido-header">
                            <div>
                                <span class="pedido-numero">Pedido #<?php echo $pedido['id_pedido']; ?></span>
                                <span class="pedido-data"><?php echo date('d/m/Y H:i', strtotime($pedido['criado_em'])); ?></span>
                            </div>
                            <span class="pedido-status status-<?php echo strtolower($pedido['status']); ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $pedido['status'])); ?>
                            </span>
                        </div>
                        
                        <div class="pedido-itens">
                            <ul>
                                <?php foreach ($pedido['itens'] as $item): ?>
                                    <li>
                                        <span class="item-qtd"><?php echo $item['quantidade']; ?>x</span>
                                        <span class="item-nome"><?php echo htmlspecialchars($item['produto_nome']); ?></span>
                                        <span class="item-preco">R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Detalhes do Pedido (endereço) -->
                        <div class="pedido-detalhes" id="detalhes-<?php echo $pedido['id_pedido']; ?>" style="display: none;">
                            <?php if (!empty($pedido['endereco'])): ?>
                                <div class="detalhe-endereco">
                                    <div class="detalhe-endereco-icon">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div class="detalhe-endereco-info">
                                        <p class="detalhe-titulo">Endereço de Entrega</p>
                                        <p class="detalhe-rua"><?php echo htmlspecialchars($pedido['endereco']['logradouro']); ?></p>
                                        <p class="detalhe-complemento">
                                            <?php echo htmlspecialchars($pedido['endereco']['bairro']); ?> — 
                                            <?php echo htmlspecialchars($pedido['endereco']['cidade']); ?>
                                        </p>
                                        <p class="detalhe-complemento">
                                            CEP: <?php echo htmlspecialchars($pedido['endereco']['cep']); ?> · 
                                            Zona <?php echo ucfirst($pedido['endereco']['zona']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="detalhe-sem-endereco">Endereço não disponível.</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="pedido-footer">
                            <button type="button" class="btn-detalhes" onclick="toggleDetalhes(<?php echo $pedido['id_pedido']; ?>)">
                                <i class="fa-solid fa-chevron-down" id="icon-detalhes-<?php echo $pedido['id_pedido']; ?>"></i>
                                <span id="text-detalhes-<?php echo $pedido['id_pedido']; ?>">Ver Detalhes</span>
                            </button>
                            <div class="pedido-total-wrapper">
                                <span class="pedido-total-label">Total Pago:</span>
                                <span class="pedido-total-valor">R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>
        function toggleDetalhes(id) {
            const detalhes = document.getElementById('detalhes-' + id);
            const icon = document.getElementById('icon-detalhes-' + id);
            const text = document.getElementById('text-detalhes-' + id);
            
            if (detalhes.style.display === 'none') {
                detalhes.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                text.textContent = 'Ocultar Detalhes';
            } else {
                detalhes.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                text.textContent = 'Ver Detalhes';
            }
        }
    </script>
</body>
</html>
