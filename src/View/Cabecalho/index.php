<link rel="stylesheet" href="src/View/Cabecalho/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- <header class="cabecalho">
    <div class="logo">
        <a href="index.php?rota=catalogo" class="logo-l">Expresso Verde</a>
    </div>

    <div class="search-container">
        <button type="button" class="btn btn-primary">Primary</button>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" class="search-input" placeholder="Buscar &quot;Ferramentas&quot;">
        
        <div class="location-selector dropdown">
            <i class="fa-solid fa-location-dot"></i>
            <span>TO</span>
            <i class="fa-solid fa-chevron-down"></i>
            <div class="dropdown-content">
                <a href="#">PR</a>
                <a href="#">MA</a>
                <a href="#">MT</a>
            </div>
        </div>
        
        <button class="search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
    <nav class="nav-menu">
        <a href="index.php?rota=feed" class="btn btn-entrar">comunidade</a>
        <php 
        if(isset( $_SESSION["usuario_id"])){
            $id = $_SESSION["usuario_id"];
        } else {
            $id = 0;
        }
        
        if ($id == NULL)
        {
            echo '<a href="index.php?rota=login" class="btn btn-entrar">Entrar</a>';
        } 
        else if ($id > 0){
            echo 'Bem vindo,<br>' . $_SESSION["usuario_nome"];
            echo '<a href="index.php?rota=perfil" class="btn btn-entrar">Perfil</a>';
            echo '<a href="index.php?rota=logout" class="btn btn-entrar">Sair</a>';
        }
        ?>
    </nav>
</header> -->