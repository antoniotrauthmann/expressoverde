<?php include 'src/View/Cabecalho/index.php'; ?>
<link rel="stylesheet" href="src/View/Perfil/style.css">

<?php
require_once 'src/Model/EnderecoModel.php';

$stmt = $mysqli->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$enderecoModel = new EnderecoModel($mysqli);
$enderecos = $enderecoModel->buscarTodosPorUsuario($_SESSION['usuario_id']);
?>


<div class="profile-container">
    <div class="title-wrapper">
        <h1>Meu Perfil</h1>
    </div>

    <div class="avatar-section">
        <div class="avatar-circle"><?= mb_substr($result["usuario_nome"], 0, 1, "UTF-8") ?></div> 
    </div>

    <div class="field-group">
        <label>Nome</label>
        <div class="info-box"><?= $result["usuario_nome"] ?></div>
    </div>

    <div class="field-group">
        <label>E-mail</label>
        <div class="info-box"><?= $result["email"] ?></div>
    </div>

    <div class="field-group">
        <label>Data de cadastro</label>
        <div class="info-box"><?= $result["data_cadastro"] ?></div>
    </div>

    <div class="field-group">
        <label>Plano</label>
        <div class="info-box"><?= $result["plano"] ?? 'Nenhum' ?></div>
    </div>

    <div class="actions">
        <button class="btn-primary">Editar Perfil</button>
        <a href="index.php?rota=logout" class="btn-logout">Sair da conta</a>
    </div>
</div>

<!-- Seção de Endereços -->
<div class="enderecos-section">
    <div class="title-wrapper">
        <h2>Meus Endereços</h2>
    </div>

    <?php if (empty($enderecos)): ?>
        <div class="enderecos-empty">
            <i class="fa-solid fa-map-location-dot"></i>
            <p>Você ainda não cadastrou nenhum endereço.</p>
        </div>
    <?php else: ?>
        <div class="enderecos-lista">
            <?php foreach ($enderecos as $end): ?>
                <div class="endereco-card">
                    <div class="endereco-card-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="endereco-card-info">
                        <p class="endereco-logradouro"><?= htmlspecialchars($end['logradouro']) ?></p>
                        <p class="endereco-detalhe"><?= htmlspecialchars($end['bairro']) ?> — <?= htmlspecialchars($end['cidade']) ?></p>
                        <p class="endereco-detalhe">CEP: <?= htmlspecialchars($end['cep']) ?> · Zona <?= ucfirst($end['zona']) ?></p>
                    </div>
                    <div class="endereco-card-actions">
                        <a href="index.php?rota=editar_endereco&id=<?= $end['id_endereco'] ?>" class="btn-editar-endereco" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="index.php?rota=cadastrar_endereco&origin=perfil" class="btn-add-endereco">
        <i class="fa-solid fa-plus"></i> Adicionar Endereço
    </a>
</div>
