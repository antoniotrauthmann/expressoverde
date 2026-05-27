<?php include 'src/View/Cabecalho/index.php'; ?>
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

<div class="profile-container">
    <div class="title-wrapper">
        <h1>Editar Perfil</h1>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert-errors">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?rota=salvar_perfil">
        <div class="field-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="info-box" value="<?= $nome ?>">
        </div>

        <div class="field-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" class="info-box" value="<?= $email ?>">
        </div>

        <div class="actions">
            <button type="submit" class="btn-primary">Salvar</button>
            <a href="index.php?rota=perfil" class="btn-logout">Cancelar</a>
        </div>
    </form>
</div>