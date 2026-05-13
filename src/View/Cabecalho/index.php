<link rel="stylesheet" href="src/View/Cabecalho/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?php if (session_status() === PHP_SESSION_NONE) session_start();?>

<div class="cabecalho">
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
    <div class="nav-menu">
        <a href="index.php?rota=feed" class="btn btn-entrar">comunidade</a>
        <?php 
        if(isset( $_SESSION["usuario_id"])){
            $id = $_SESSION["usuario_id"];
        } else {
            $id = 0;
        }
        
        if ($id == NULL)
        {
            echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Entrar</button>';
            echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadastroModal">Cadastrar</button>';
        } 
        else if ($id > 0){
            echo 'Bem vindo,<br>' . htmlspecialchars($_SESSION["usuario_nome"] ?? '');
            echo '<a href="index.php?rota=carrinho" class="btn btn-entrar"><i class="fa-solid fa-cart-shopping"></i></a>';
            echo '<a href="index.php?rota=pedidos" class="btn btn-entrar">Pedidos</a>';
            echo '<a href="index.php?rota=perfil" class="btn btn-entrar">Perfil</a>';
            echo '<a href="index.php?rota=logout" class="btn btn-entrar">Sair</a>';
        }
        ?>
    </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 d-flex justify-content-center">
        <?php include __DIR__ . '/../Login/index.php'; ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 d-flex justify-content-center">
        <?php include __DIR__ . '/../Cadastro_usuario/index.php'; ?>
      </div>
    </div>
  </div>
</div>