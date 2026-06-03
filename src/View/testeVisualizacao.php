<?php 
require_once dirname(__DIR__, 2) . '/config/conexao.php';
require_once dirname(__DIR__) . '/Helper/Auth.php';

Auth::verificar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expresso Verde</title>
    <style>
        /* Reset Básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Proxima Nova', -apple-system, 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
        }

        body {
            background-color: #ebebeb;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* --- HEADER --- */
        .header {
            background-color: #8a9f54;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0,0,0,.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 0 10px;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2d3277;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-bar {
            flex: 1;
            display: flex;
            background: #fff;
            border-radius: 2px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);
            height: 40px;
            overflow: hidden;
        }

        .search-bar input {
            flex: 1;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            outline: none;
            color: #333;
        }

        .search-bar button {
            background: #fff;
            border: none;
            border-left: 1px solid #e6e6e6;
            padding: 0 15px;
            cursor: pointer;
            color: #666;
        }

        .promo-banner {
            width: 340px;
            height: 39px;
            background-color: #2d3277;
            border-radius: 4px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .header-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #333;
        }

        .cep {
            display: flex;
            align-items: center;
            gap: 5px;
            color: rgba(0,0,0,.5);
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links li:hover {
            color: rgba(0,0,0,.6);
            cursor: pointer;
        }

        .user-links {
            display: flex;
            gap: 15px;
        }

        /* --- MAIN CONTAINER --- */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 10px;
        }

        /* Buscas Relacionadas */
        .related-searches {
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .related-searches span {
            font-weight: 600;
            color: #333;
        }

        .related-searches a {
            color: #3483fa;
            margin: 0 5px;
        }

        .breadcrumbs {
            font-size: 14px;
            color: #3483fa;
            margin-bottom: 20px;
        }

        .breadcrumbs span {
            color: #999;
            margin: 0 5px;
        }

        /* --- LAYOUT DUAS COLUNAS --- */
        .content-layout {
            display: flex;
            gap: 30px;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 250px;
            flex-shrink: 0;
        }

        .sidebar h1 {
            font-size: 26px;
            color: #333;
            margin-bottom: 4px;
        }

        .results-count {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        /* Switch Frete Grátis */
        .toggle-frete {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 14px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .filter-group {
            margin-bottom: 25px;
        }

        .filter-group h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 12px;
        }

        .filter-group ul li {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .filter-group ul li:hover {
            color: #3483fa;
        }

        .price-inputs {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .price-inputs input {
            width: 70px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
        }

        .price-inputs button {
            background: #ccc;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            color: #fff;
            font-weight: bold;
        }

        /* --- PRODUTOS (GRID) --- */
        .main-content {
            flex: 1;
        }

        .sort-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .sort-bar strong {
            color: #333;
            margin-left: 5px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .card {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
            transition: box-shadow 0.2s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,.15);
        }

        .card-img {
            width: 100%;
            height: 220px;
            background-color: #f7f7f7;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #aaa;
            font-size: 12px;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-title {
            font-size: 14px;
            color: #333;
            font-weight: 300;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 38px;
        }

        .card-price {
            font-size: 24px;
            color: #333;
            margin-bottom: 2px;
        }

        .card-installments {
            font-size: 13px;
            color: #333;
            margin-bottom: 5px;
        }

        .card-shipping {
            font-size: 13px;
            color: #00a650;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card-condition {
            font-size: 12px;
            color: rgba(0,0,0,.55);
            margin-top: auto;
        }

    </style>
</head>
<body>

    <header class="header">
        <div class="header-container">
            <div class="header-top">
                <div class="logo">
                    Expresso<br>Verde
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="O que você está procurando?">
                    <button>Lupa</button>
                </div>
            </div>
            
            <div class="header-bottom">
                <div class="cep">
                    Informe seu<br>CEP
                </div>
                <ul class="nav-links">
                    <li>Ferramentas</li>
                    <li>Plantas</li>
                    <li>Vasos</li>
                    <li>Acessórios</li>
                    <li>Vender</li>
                    <li>Comunidade</li>
                </ul>
                <ul class="user-links">
                    <li href="google.com">Crie a sua conta</li>
                    <li>Entre</li>
                    <li>Compras</li>
                    <li>Carrinho</li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container">

        <div class="breadcrumbs">
            Plantas <span>></span> Flores
        </div>

        <div class="content-layout">
            <aside class="sidebar">
                <h1>orquidea</h1>
                <p class="results-count">5 resultados</p>

                <div class="filter-group">
                    <h3>Custo de envio</h3>
                    <ul>
                        <li>Grátis</li>
                    </ul>
                </div>

                <div class="filter-group">
                    <h3>Preço</h3>
                    <ul>
                        <li>Até R$100</li>
                        <li>R$ 150 a R$200</li>
                        <li>Mais de R$200</li>
                    </ul>
                    <div class="price-inputs">
                        <input type="text" placeholder="Mínimo"> - 
                        <input type="text" placeholder="Máximo">
                        <button>›</button>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Retirada grátis</h3>
                    <ul>
                        <li>Rio de Janeiro</li>
                        <li>Lagoinha</li>
                        <li>Paraná</li>
                        <li>Fim do Mundo</li>
                        <li>Rio Grande do Sul</li>
                        <li>São Paulo</li>
                    </ul>
                </div>
            </aside>

            <section class="main-content">
                <div class="sort-bar">
                    Ordenar por <strong>Mais relevantes</strong>
                </div>

                <div class="grid">
                    <?php $sql = "SELECT * FROM produto"; $result = $mysqli->query($sql);?>

                    <?php 
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo('
                                    <div class="card">
                                        <div class="card-img">
                                            <img src="https://m.media-amazon.com/images/I/71L6lBws5YL.jpg">
                                        </div>
                                        <div class="card-info">
                                            <h2 class="card-title">' . $row["nome"] . '</h2>
                                                <span class="card-price">' . $row["preco"] . '</span>
                                                <span class="card-installments"> 12x de R$' .number_format(($row["preco"]/12), 2, '.', '')  .'</span>
                                                <span class="card-condition">Em estoque</span>
                                        </div>
                                    </div>
                                ');
                            }
                        } else {
                            echo "0 resultados";
                        }

                        $mysqli->close();
                    ?>
                </div>
            </section>
        </div>
    </main>

</body>
</html>