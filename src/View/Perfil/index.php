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
$qtdEnderecos = count($enderecos);
?>

<div class="dashboard-wrapper">
    <div class="container-fluid pf-main-container">
        <div class="row">
            
            <div class="col-12 col-lg-5 col-xl-4 mb-4">
                <div class="profile-card shadow-sm">
                    <div class="profile-card-header">
                        <div class="avatar-wrapper">
                            <div class="avatar-circle">
                                <?= mb_substr($result["usuario_nome"], 0, 1, "UTF-8") ?>
                            </div>
                            <span class="profile-badge-type <?= $_SESSION['usuario_tipo'] === 'profissional' ? 'badge-prof' : 'badge-client' ?>">
                                <i class="fa-solid <?= $_SESSION['usuario_tipo'] === 'profissional' ? 'fa-user-tie' : 'fa-user' ?>"></i>
                                <?= ucfirst($_SESSION['usuario_tipo'] ?? 'Cliente') ?>
                            </span>
                        </div>
                        <h2 class="profile-display-name"><?= htmlspecialchars($result["usuario_nome"]) ?></h2>
                        <p class="profile-display-email"><i class="fa-regular fa-envelope"></i> <?= htmlspecialchars($result["email"]) ?></p>
                    </div>

                    <div class="profile-card-body">
                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-id-card"></i></div>
                            <div class="info-content">
                                <label>Nome Completo</label>
                                <div class="info-value"><?= htmlspecialchars($result["usuario_nome"]) ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-calendar-day"></i></div>
                            <div class="info-content">
                                <label>Data de Cadastro</label>
                                <div class="info-value"><?= date('d/m/Y', strtotime($result["data_cadastro"])) ?></div>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon"><i class="fa-solid fa-gem"></i></div>
                            <div class="info-content">
                                <label>Plano Atual</label>
                                <div class="info-value">
                                    <span class="badge-plano"><?= htmlspecialchars($result["plano"] ?? 'Nenhum') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-card-footer">
                        <button class="btn-pf-primary" onclick="window.location.href='index.php?rota=editar_perfil'">
                            <i class="fa-solid fa-user-pen"></i> Editar Perfil
                        </button>
                        
                        <?php if ($_SESSION['usuario_tipo'] === 'profissional'): ?>
                            <button class="btn-pf-secondary" onclick="window.location.href='index.php?rota=cadastrar_produto'">
                                <i class="fa-solid fa-plus-circle"></i> Cadastrar Produto
                            </button>
                        <?php endif; ?>
                        
                        <a href="index.php?rota=logout" class="btn-pf-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Sair da Conta
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7 col-xl-8 mb-4">
                <div class="addresses-card shadow-sm">
                    <div class="addresses-card-header">
                        <div class="title-section">
                            <h2><i class="fa-solid fa-map-marked-alt"></i> Meus Endereços</h2>
                            <span class="counter-badge"><?= $qtdEnderecos ?> salvo(s)</span>
                        </div>
                        <a href="index.php?rota=cadastrar_endereco&origin=perfil" class="btn-pf-add">
                            <i class="fa-solid fa-plus"></i> Novo Endereço
                        </a>
                    </div>

                    <div class="addresses-card-body">
                        <?php if (empty($enderecos)): ?>
                            <div class="enderecos-empty-state">
                                <div class="empty-icon-box">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <h3>Nenhum endereço cadastrado</h3>
                                <p>Cadastre um endereço de entrega para facilitar e agilizar as suas futuras compras em nossa plataforma.</p>
                                <a href="index.php?rota=cadastrar_endereco&origin=perfil" class="btn-pf-primary d-inline-flex align-items-center gap-2" style="width: auto; padding: 10px 20px;">
                                    <i class="fa-solid fa-plus"></i> Adicionar Primeiro Endereço
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="enderecos-grid-layout">
                                <?php foreach ($enderecos as $end): ?>
                                    <div class="endereco-modern-card">
                                        <div class="end-icon">
                                            <i class="fa-solid fa-house-chimney"></i>
                                        </div>
                                        <div class="end-details">
                                            <h4 class="end-logradouro"><?= htmlspecialchars($end['logradouro']) ?></h4>
                                            <p class="end-bairro-cidade">
                                                <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($end['bairro']) ?> — <?= htmlspecialchars($end['cidade']) ?>
                                            </p>
                                            <div class="end-meta">
                                                <span class="meta-item"><strong>CEP:</strong> <?= htmlspecialchars($end['cep']) ?></span>
                                                <span class="meta-badge <?= strtolower($end['zona']) === 'urbana' ? 'zona-urbana' : 'zona-rural' ?>">
                                                    Zona <?= ucfirst(htmlspecialchars($end['zona'])) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="end-actions">
                                            <a href="index.php?rota=editar_endereco&id=<?= $end['id_endereco'] ?>" class="btn-end-edit" title="Editar Endereço">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>