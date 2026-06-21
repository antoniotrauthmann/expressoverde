<?php include 'src/View/Cabecalho/index.php'; ?>
<!-- Utilizando o mesmo arquivo de estilização do Index do Perfil -->
<link rel="stylesheet" href="src/View/Perfil/style.css">

<?php
$stmt = $mysqli->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$old    = $_SESSION['perfil_old'] ?? [];
$errors = $_SESSION['perfil_errors'] ?? [];
unset($_SESSION['perfil_old'], $_SESSION['perfil_errors']);

$nome  = htmlspecialchars($old['nome']  ?? $result['usuario_nome']);
$email = htmlspecialchars($old['email'] ?? $result['email']);
?>

<div class="dashboard-wrapper">
    <div class="container pf-main-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                
                <!-- Reaproveitando a classe principal .profile-card -->
                <div class="profile-card shadow-sm">
                    
                    <!-- Topo do Card Padronizado (Verde Gradiente) -->
                    <div class="profile-card-header">
                        <div class="avatar-wrapper">
                            <div class="avatar-circle">
                                <i class="fa-solid fa-user-gear" style="font-size: 32px;"></i>
                            </div>
                        </div>
                        <h2 class="profile-display-name">Editar Perfil</h2>
                        <p class="profile-display-email">Atualize suas informações cadastrais</p>
                    </div>

                    <!-- Formulário envolvendo o corpo e as ações -->
                    <form method="POST" action="index.php?rota=salvar_perfil">
                        
                        <!-- Corpo do Card -->
                        <div class="profile-card-body px-4 pt-4 pb-2">
                            
                            <!-- Mensagens de Erro Estilizadas -->
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger d-flex flex-column gap-2 border-0 rounded-3 mb-4" style="background-color: rgba(231, 76, 60, 0.08); color: #e74c3c; font-size: 14px;">
                                    <?php foreach ($errors as $e): ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-exclamation"></i>
                                            <span><?= htmlspecialchars($e) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Campo: Nome utilizando Bootstrap Moderno -->
                            <div class="mb-4">
                                <label for="nome" class="form-label fw-semibold text-uppercase tracking-wider" style="font-size: 11px; color: #718096; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-id-card me-1" style="color: #104c4b;"></i> Nome Completo
                                </label>
                                <input type="text" id="nome" name="nome" class="form-control form-control-lg border-secondary-subtle focus-ring-success" value="<?= $nome ?>" required style="font-size: 15px; border-radius: 8px; padding: 12px;">
                            </div>

                            <!-- Campo: E-mail -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-uppercase tracking-wider" style="font-size: 11px; color: #718096; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-envelope me-1" style="color: #104c4b;"></i> Endereço de E-mail
                                </label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg border-secondary-subtle" value="<?= $email ?>" required style="font-size: 15px; border-radius: 8px; padding: 12px;">
                            </div>

                        </div>

                        <!-- Rodapé do Card com os Botões Alinhados -->
                        <div class="profile-card-footer px-4 pb-4 bg-transparent border-0">
                            <button type="submit" class="btn-pf-primary mb-2 shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i> Salvar Alterações
                            </button>
                            
                            <a href="index.php?rota=perfil" class="btn-pf-logout mt-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-solid fa-ban"></i> Cancelar e Voltar
                            </a>
                        </div>
                        
                    </form>

                </div>
                
            </div>
        </div>
    </div>
</div>