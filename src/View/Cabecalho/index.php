<link rel="stylesheet" href="src/View/Cabecalho/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<header class="cabecalho">
    <div class="logo">
        <a href="index.php?rota=catalogo" class="logo-l">Expresso Verde</a>
    </div>

    <div class="search-container">
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
        <?php 
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
            echo 'Bem vindo,<br>' . htmlspecialchars($_SESSION["usuario_nome"] ?? '');
            echo '<a href="index.php?rota=carrinho" class="btn btn-entrar"><i class="fa-solid fa-cart-shopping"></i></a>';
            echo '<a href="index.php?rota=pedidos" class="btn btn-entrar">Pedidos</a>';
            echo '<a href="index.php?rota=perfil" class="btn btn-entrar">Perfil</a>';
            echo '<a href="index.php?rota=logout" class="btn btn-entrar">Sair</a>';
        }
        ?>
    </nav>
</header>