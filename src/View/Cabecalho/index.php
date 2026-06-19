<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

// Verifica se a rota atual é vazia (home) ou explicitamente o catálogo de produtos
$is_catalogo = (!isset($_GET['rota']) || $_GET['rota'] === 'catalogo');
?>

<link rel="stylesheet" href="/projeto-es/src/View/Cabecalho/style.css">

<div class="cabecalho <?= $is_catalogo ? 'header-dynamic' : '' ?>">
    <div class="logo p-0">
        <a href="index.php?rota=catalogo" class="logo-l" style="box-sizing: border-box; ">
          <img src="/projeto-es/public/img/logo.png" style="height: 45px; object-fit: cover;">
        </a>
    </div>
    
    <form action="index.php" method="GET" class="search-container d-flex justify-content-between">
        <input name="rota" type="hidden" value="busca">
        <div class="ml-2">
          <input name="b" type="text" class="search-input w-100" placeholder="Buscar &quot;Ferramentas&quot;">
        </div>
        <button type="submit" class="btn btn-outline-secondary search-btn p-2 lh-1" id="inputBarraPesquisa">🔍</button>
    </form>
    
    <div class="nav-menu">
        <?php 
        if(isset( $_SESSION["usuario_id"])){
            $id = $_SESSION["usuario_id"];
        } else {
            $id = 0;
        }
        
        if ($id == NULL || $id == 0)
        {
            echo '<div class="d-flex flex-row" style="gap:5px;"><button type="button" class="btn btn-entrar" data-bs-toggle="modal" data-bs-target="#loginModal">Entrar</button>';
            echo '<button type="button" class="btn btn-entrar" data-bs-toggle="modal" data-bs-target="#cadastroModal">Cadastrar</button></div>';
        } 
        else if ($id > 0){
            echo '<div class="d-flex flex-row" style="gap:5px;"><a href="index.php?rota=carrinho" class="btn btn-entrar">🛒</a>';
            echo '<a href="index.php?rota=feed" class="btn btn-entrar">comunidade</a>';
            echo '<a href="index.php?rota=pedidos" class="btn btn-entrar">Pedidos</a>';
            echo '<a href="index.php?rota=perfil" class="btn btn-entrar">Perfil</a>';
            echo '<a href="index.php?rota=logout" class="btn btn-entrar">Sair</a></div>';
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

<script>
    const params = new URLSearchParams(window.location.search);
    if (params.get('modal') === 'cadastro') {
        new bootstrap.Modal(document.getElementById('cadastroModal')).show();
    }
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.querySelector('.cabecalho.header-dynamic');
        
        if (header) {
            function checkScroll() {
                // Altera o estado assim que o usuário realiza o primeiro scroll para baixo (mais de 15px)
                if (window.scrollY > 15) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            window.addEventListener('scroll', checkScroll);
            checkScroll(); // Executa na inicialização da página
        }
    });
</script>