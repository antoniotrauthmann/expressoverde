<?php include __DIR__ . '/../Cabecalho/index.php'; ?>
<link rel="stylesheet" href="/projeto-es/src/View/Central_vendas/style.css">

<title>Central de Vendas - Expresso Verde</title>
<?php if (!empty($_SESSION['venda_sucesso'])): ?>
    <div class="cv-modal-overlay" id="modalSucesso">
        <div class="cv-modal">
            <div class="cv-modal-icon sucesso">✓</div>
            <p><?= htmlspecialchars($_SESSION['venda_sucesso']) ?></p>
            <button onclick="document.getElementById('modalSucesso').remove()">OK</button>
        </div>
    </div>
    <?php unset($_SESSION['venda_sucesso']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['venda_erro'])): ?>
    <div class="cv-modal-overlay" id="modalErro">
        <div class="cv-modal">
            <div class="cv-modal-icon erro">✕</div>
            <p><?= htmlspecialchars($_SESSION['venda_erro']) ?></p>
            <button onclick="document.getElementById('modalErro').remove()">OK</button>
        </div>
    </div>
    <?php unset($_SESSION['venda_erro']); ?>
<?php endif; ?>

<div class="cv-wrapper">
    <div class="cv-container">
        <!-- Header da Central -->
        <div class="cv-header">
            <div class="cv-header-text">
                <h1>Central de Vendas</h1>
                <p class="cv-subtitle">Gerencie seus produtos, pedidos e acompanhe sua renda</p>
            </div>
            <div class="cv-header-icon">
                <i class="fa-solid fa-store"></i>
            </div>
        </div>

        <!-- Navegação por Abas -->
        <div class="cv-tabs">
            <button type="button" class="cv-tab-btn <?= ($aba === 'pedidos') ? 'active' : '' ?>" onclick="mudarAba('pedidos', this)">
                <i class="fa-solid fa-clipboard-list"></i> Pedidos Recebidos
            </button>
            <button type="button" class="cv-tab-btn <?= ($aba === 'produto') ? 'active' : '' ?>" onclick="mudarAba('produto', this)">
                <i class="fa-solid fa-plus-circle"></i> Cadastrar Produto
            </button>
            <button type="button" class="cv-tab-btn <?= ($aba === 'renda') ? 'active' : '' ?>" onclick="mudarAba('renda', this)">
                <i class="fa-solid fa-chart-line"></i> Renda Diária
            </button>
        </div>

        <!-- ==================== ABA: PEDIDOS RECEBIDOS ==================== -->
        <div class="cv-tab-content <?= ($aba === 'pedidos') ? 'active' : '' ?>" id="tab-pedidos">
            <?php if (empty($pedidos)): ?>
                <div class="cv-empty">
                    <i class="fa-solid fa-inbox"></i>
                    <p>Nenhum pedido recebido ainda.</p>
                    <span>Quando clientes comprarem seus produtos, os pedidos aparecerão aqui.</span>
                </div>
            <?php else: ?>
                <div class="cv-pedidos-lista">
                    <?php foreach ($pedidos as $pedido): ?>
                        <div class="cv-pedido-card">
                            <div class="cv-pedido-header">
                                <div class="cv-pedido-info">
                                    <span class="cv-pedido-numero">Pedido #<?= $pedido['id_pedido'] ?></span>
                                    <span class="cv-pedido-data">
                                        <i class="fa-regular fa-calendar"></i>
                                        <?= date('d/m/Y H:i', strtotime($pedido['criado_em'])) ?>
                                    </span>
                                </div>
                                <span class="cv-pedido-status status-<?= strtolower($pedido['status']) ?>">
                                    <?= ucfirst(str_replace('_', ' ', $pedido['status'])) ?>
                                </span>
                            </div>

                            <div class="cv-pedido-comprador">
                                <i class="fa-solid fa-user"></i>
                                <span>Comprador: <strong>Cliente #<?= $pedido['id_pedido'] ?></strong></span>
                            </div>

                            <div class="cv-pedido-itens">
                                <ul>
                                    <?php foreach ($pedido['itens'] as $item): ?>
                                        <li>
                                            <span class="cv-item-qtd"><?= $item['quantidade'] ?>x</span>
                                            <span class="cv-item-nome"><?= htmlspecialchars($item['produto_nome']) ?></span>
                                            <span class="cv-item-preco">R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Detalhes expandíveis -->
                            <div class="cv-pedido-detalhes" id="detalhes-<?= $pedido['id_pedido'] ?>" style="display: none;">
                                <?php if (!empty($pedido['endereco'])): ?>
                                    <div class="cv-detalhe-endereco">
                                        <div class="cv-detalhe-icon">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div class="cv-detalhe-info">
                                            <p class="cv-detalhe-titulo">Endereço de Entrega</p>
                                            <p class="cv-detalhe-rua"><?= htmlspecialchars($pedido['endereco']['logradouro']) ?></p>
                                            <p class="cv-detalhe-sub">
                                                <?= htmlspecialchars($pedido['endereco']['bairro']) ?> — 
                                                <?= htmlspecialchars($pedido['endereco']['cidade']) ?>
                                            </p>
                                            <p class="cv-detalhe-sub">
                                                CEP: <?= htmlspecialchars($pedido['endereco']['cep']) ?> · 
                                                Zona <?= ucfirst($pedido['endereco']['zona']) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="cv-sem-endereco">Endereço não disponível.</p>
                                <?php endif; ?>
                            </div>

                            <div class="cv-pedido-footer">
                                <button type="button" class="cv-btn-detalhes" onclick="toggleDetalhes(<?= $pedido['id_pedido'] ?>)">
                                    <i class="fa-solid fa-chevron-down" id="icon-<?= $pedido['id_pedido'] ?>"></i>
                                    <span id="text-<?= $pedido['id_pedido'] ?>">Ver Detalhes</span>
                                </button>

                                <form method="POST" action="index.php?rota=atualizar_status_pedido" class="cv-status-form">
                                    <input type="hidden" name="id_pedido" value="<?= $pedido['id_pedido'] ?>">
                                    <label for="status-<?= $pedido['id_pedido'] ?>">Alterar status:</label>
                                    <select name="novo_status" id="status-<?= $pedido['id_pedido'] ?>" class="cv-select-status">
                                        <option value="pendente" <?= $pedido['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                        <option value="confirmado" <?= $pedido['status'] === 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                                        <option value="em_rota" <?= $pedido['status'] === 'em_rota' ? 'selected' : '' ?>>Em Rota</option>
                                        <option value="entregue" <?= $pedido['status'] === 'entregue' ? 'selected' : '' ?>>Entregue</option>
                                        <option value="cancelado" <?= $pedido['status'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                    <button type="submit" class="cv-btn-atualizar">
                                        <i class="fa-solid fa-arrows-rotate"></i> Atualizar
                                    </button>
                                </form>

                                <div class="cv-pedido-total">
                                    <span class="cv-total-label">Total:</span>
                                    <span class="cv-total-valor">R$ <?= number_format($pedido['total'], 2, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ==================== ABA: CADASTRAR PRODUTO ==================== -->
        <div class="cv-tab-content <?= ($aba === 'produto') ? 'active' : '' ?>" id="tab-produto">
            <div class="cv-cadastro-produto-wrapper">
                <?php if (!empty($_SESSION['sucesso'])): ?>
                    <div class="cv-modal-overlay" id="modalProdutoSucesso">
                        <div class="cv-modal">
                            <div class="cv-modal-icon sucesso">✓</div>
                            <p><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
                            <button onclick="document.getElementById('modalProdutoSucesso').remove()">OK</button>
                        </div>
                    </div>
                    <?php unset($_SESSION['sucesso']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['erro'])): ?>
                    <div class="cv-modal-overlay" id="modalProdutoErro">
                        <div class="cv-modal">
                            <div class="cv-modal-icon erro">✕</div>
                            <p><?= htmlspecialchars($_SESSION['erro']) ?></p>
                            <button onclick="document.getElementById('modalProdutoErro').remove()">OK</button>
                        </div>
                    </div>
                    <?php unset($_SESSION['erro']); ?>
                <?php endif; ?>

                <form action="index.php?rota=cadastrar_produto" method="POST" enctype="multipart/form-data" class="cv-form-produto">
                    <div class="cv-form-header">
                        <h2>Novo Produto</h2>
                    </div>

                    <div class="cv-form-tabs">
                        <button type="button" class="cv-form-tab active" data-tab="cv-dados">Dados</button>
                        <button type="button" class="cv-form-tab" data-tab="cv-midia">Imagens & Descrição</button>
                    </div>

                    <!-- Aba Dados -->
                    <div class="cv-form-content active" id="cv-tab-cv-dados">
                        <div class="cv-input-group">
                            <div class="cv-input-box">
                                <label for="cv-nome">Produto</label>
                                <input id="cv-nome" name="nome" type="text" placeholder="Nome do produto" required>
                            </div>
                            <div class="cv-input-box">
                                <label for="cv-categoria">Categoria</label>
                                <select id="cv-categoria" name="categoria" required>
                                    <option value="">Selecione...</option>
                                    <option value="planta">Planta</option>
                                    <option value="kit_jardinagem">Kit Jardinagem</option>
                                    <option value="suplemento">Suplemento</option>
                                    <option value="semente">Semente</option>
                                    <option value="ferramenta">Ferramenta</option>
                                    <option value="acessorio">Acessório</option>
                                </select>
                            </div>
                            <div class="cv-input-row">
                                <div class="cv-input-box">
                                    <label for="cv-preco">Preço</label>
                                    <input id="cv-preco" name="preco" type="number" step="0.01" placeholder="0,00" required>
                                </div>
                                <div class="cv-input-box">
                                    <label for="cv-estoque">Estoque</label>
                                    <input id="cv-estoque" name="estoque" type="number" placeholder="Quantidade" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aba Imagens & Descrição -->
                    <div class="cv-form-content" id="cv-tab-cv-midia">
                        <div class="cv-input-group">
                            <div class="cv-input-box">
                                <label>Imagens do Produto</label>
                                <div class="cv-drop-zone" id="cvDropZone">
                                    <input type="file" id="cvImagens" name="imagens[]" accept="image/*" multiple style="display:none">
                                    <div class="cv-drop-inner" id="cvDropInner">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                        <p>Arraste imagens aqui ou <span>clique para selecionar</span></p>
                                    </div>
                                    <div class="cv-drop-preview" id="cvDropPreview"></div>
                                </div>
                            </div>
                            <div class="cv-input-box">
                                <label for="cv-descricao">Descrição</label>
                                <textarea id="cv-descricao" name="descricao" placeholder="Descreva o produto..." rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="cv-form-submit">
                        <button type="submit"><i class="fa-solid fa-paper-plane"></i> Publicar Produto</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== ABA: RENDA DIÁRIA ==================== -->
        <div class="cv-tab-content <?= ($aba === 'renda') ? 'active' : '' ?>" id="tab-renda">
            <?php if (empty($rendaDiaria)): ?>
                <div class="cv-empty">
                    <i class="fa-solid fa-piggy-bank"></i>
                    <p>Nenhuma venda registrada ainda.</p>
                    <span>Sua renda diária aparecerá aqui conforme as vendas forem realizadas.</span>
                </div>
            <?php else: ?>
                <?php
                    $totalGeral = 0;
                    foreach ($rendaDiaria as $dia) {
                        $totalGeral += $dia['total_dia'];
                    }
                ?>
                <div class="cv-renda-resumo">
                    <div class="cv-renda-resumo-card">
                        <i class="fa-solid fa-wallet"></i>
                        <div>
                            <span class="cv-renda-resumo-label">Total Acumulado</span>
                            <span class="cv-renda-resumo-valor">R$ <?= number_format($totalGeral, 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="cv-renda-resumo-card">
                        <i class="fa-solid fa-calendar-days"></i>
                        <div>
                            <span class="cv-renda-resumo-label">Dias com Vendas</span>
                            <span class="cv-renda-resumo-valor"><?= count($rendaDiaria) ?></span>
                        </div>
                    </div>
                </div>

                <div class="cv-renda-lista">
                    <?php foreach ($rendaDiaria as $dia): ?>
                        <div class="cv-renda-card">
                            <div class="cv-renda-data">
                                <i class="fa-regular fa-calendar-check"></i>
                                <span><?= date('d/m/Y', strtotime($dia['dia'])) ?></span>
                            </div>
                            <div class="cv-renda-valor">
                                R$ <?= number_format($dia['total_dia'], 2, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Navegação das abas principais
    function mudarAba(aba, btn) {
        document.querySelectorAll('.cv-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.cv-tab-content').forEach(c => c.classList.remove('active'));
        
        btn.classList.add('active');
        document.getElementById('tab-' + aba).classList.add('active');

        // Atualizar URL sem recarregar
        const url = new URL(window.location);
        url.searchParams.set('aba', aba);
        window.history.replaceState({}, '', url);
    }

    // Toggle detalhes do pedido
    function toggleDetalhes(id) {
        const detalhes = document.getElementById('detalhes-' + id);
        const icon = document.getElementById('icon-' + id);
        const text = document.getElementById('text-' + id);
        
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

    // Abas do formulário de produto
    document.querySelectorAll('.cv-form-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.cv-form-tab').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.cv-form-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('cv-tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Drop zone para imagens
    const cvDropZone = document.getElementById('cvDropZone');
    const cvFileInput = document.getElementById('cvImagens');
    const cvDropInner = document.getElementById('cvDropInner');
    const cvDropPreview = document.getElementById('cvDropPreview');

    if (cvDropZone) {
        cvDropZone.addEventListener('click', () => cvFileInput.click());
        cvDropZone.addEventListener('dragover', e => {
            e.preventDefault();
            cvDropZone.classList.add('drag-over');
        });
        cvDropZone.addEventListener('dragleave', () => cvDropZone.classList.remove('drag-over'));
        cvDropZone.addEventListener('drop', e => {
            e.preventDefault();
            cvDropZone.classList.remove('drag-over');
            cvHandleFiles(e.dataTransfer.files);
        });
        cvFileInput.addEventListener('change', () => cvHandleFiles(cvFileInput.files));
    }

    function cvHandleFiles(files) {
        if (!files.length) return;
        cvDropPreview.innerHTML = '';
        cvDropInner.style.display = 'none';
        cvDropPreview.style.display = 'flex';
        Array.from(files).forEach(file => {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.title = file.name;
            const remove = document.createElement('button');
            remove.type = 'button';
            remove.innerHTML = '&times;';
            remove.addEventListener('click', e => {
                e.stopPropagation();
                remove.parentElement.remove();
                if (!cvDropPreview.children.length) {
                    cvDropInner.style.display = 'flex';
                    cvDropPreview.style.display = 'none';
                }
            });
            const wrap = document.createElement('div');
            wrap.className = 'cv-preview-item';
            wrap.appendChild(img);
            wrap.appendChild(remove);
            cvDropPreview.appendChild(wrap);
        });
    }
</script>

