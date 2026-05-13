<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="src/View/Cadastro_produto/style.css">
</head>

<body>
    <?php include 'src/View/Cabecalho/index.php'; ?>
    <?php if (!empty($_SESSION['sucesso'])): ?>
        <div class="modal-overlay" id="modalSucesso">
            <div class="modal">
                <div class="modal-icon">âœ“</div>
                <p><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
                <button onclick="fecharModal()">OK</button>
            </div>
        </div>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['erro'])): ?>
        <div class="modal-overlay" id="modalErro">
            <div class="modal">
                <div class="modal-icon" style="background:#fde8e8; color:#c0392b;">âœ•</div>
                <p><?= htmlspecialchars($_SESSION['erro']) ?></p>
                <button onclick="document.getElementById('modalErro').remove()">OK</button>
            </div>
        </div>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>
    <div class="container">
        <div class="form-image">
            <img src="src/View/Cadastro_produto/img/img1.png">
        </div>
        <div class="form">
            <form action="index.php?rota=cadastrar_produto" method="POST" enctype="multipart/form-data">
                <div class="form-header">
                    <div class="title">
                        <h1>Seu produto</h1>
                    </div>
                </div>

                <?php if (!empty($erro)): ?>
                    <p class="erro"><?= htmlspecialchars($erro) ?></p>
                <?php endif; ?>

                <!-- Abas -->
                <div class="tabs">
                    <button type="button" class="tab-btn active" data-tab="dados">Dados</button>
                    <button type="button" class="tab-btn" data-tab="midia">Imagens & DescriÃ§Ã£o</button>
                </div>

                <!-- Aba: Dados -->
                <div class="tab-content active" id="tab-dados">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Produto</label>
                            <input id="nome" name="nome" type="text" placeholder="Nome do produto" required>
                        </div>
                        <div class="input-box">
                            <label for="categoria">Categoria</label>
                            <select id="categoria" name="categoria" required>
                                <option value="">Selecione...</option>
                                <option value="planta">Planta</option>
                                <option value="kit_jardinagem">Kit Jardinagem</option>
                                <option value="suplemento">Suplemento</option>
                                <option value="semente">Semente</option>
                                <option value="ferramenta">Ferramenta</option>
                                <option value="acessorio">AcessÃ³rio</option>
                            </select>
                        </div>
                        <div class="input-box half">
                            <label for="preco">PreÃ§o</label>
                            <input id="preco" name="preco" type="number" step="0.01" placeholder="0,00" required>
                        </div>
                        <div class="input-box half">
                            <label for="estoque">Estoque</label>
                            <input id="estoque" name="estoque" type="number" placeholder="Quantidade" required>
                        </div>
                    </div>
                </div>

                <!-- Aba: Imagens & DescriÃ§Ã£o -->
                <div class="tab-content" id="tab-midia">
                    <div class="input-group">
                        <div class="input-box">
                            <label>Imagens do Produto</label>
                            <div class="drop-zone" id="dropZone">
                                <input type="file" id="imagens" name="imagens[]" accept="image/*" multiple style="display:none">
                                <div class="drop-zone-inner" id="dropInner">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    <p>Arraste imagens aqui ou <span>clique para selecionar</span></p>
                                </div>
                                <div class="drop-preview" id="dropPreview"></div>
                            </div>
                            <input type="hidden" id="imagensCaminhos" name="imagens_caminhos">
                        </div>
                        <div class="input-box">
                            <label for="descricao">DescriÃ§Ã£o</label>
                            <textarea id="descricao" name="descricao" placeholder="Descreva o produto..." rows="4" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="publisher-button">
                    <button type="submit">Publicar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
            });
        });

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('imagens');
        const dropInner = document.getElementById('dropInner');
        const dropPreview = document.getElementById('dropPreview');
        const hiddenInput = document.getElementById('imagensCaminhos');

        dropZone.addEventListener('click', () => fileInput.click());
        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            handleFiles(e.dataTransfer.files);
        });
        fileInput.addEventListener('change', () => handleFiles(fileInput.files));

        function handleFiles(files) {
            if (!files.length) return;
            dropPreview.innerHTML = '';
            dropInner.style.display = 'none';
            dropPreview.style.display = 'flex';
            const caminhos = [];
            Array.from(files).forEach(file => {
                caminhos.push('uploads/' + file.name);
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.title = file.name;
                const remove = document.createElement('button');
                remove.type = 'button';
                remove.innerHTML = '&times;';
                remove.addEventListener('click', e => {
                    e.stopPropagation();
                    remove.parentElement.remove();
                    if (!dropPreview.children.length) {
                        dropInner.style.display = 'flex';
                        dropPreview.style.display = 'none';
                    }
                    updateCaminhos();
                });
                const wrap = document.createElement('div');
                wrap.className = 'preview-item';
                wrap.appendChild(img);
                wrap.appendChild(remove);
                dropPreview.appendChild(wrap);
            });
            hiddenInput.value = caminhos.join(',');
        }

        function updateCaminhos() {
            hiddenInput.value = Array.from(dropPreview.querySelectorAll('img')).map(i => 'uploads/' + i.title).join(',');
        }

        function fecharModal() {
            document.getElementById('modalSucesso').remove();
        }
    </script>
</body>

</html>
