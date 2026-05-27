<?php 
    $hostname = "localhost";
    $bancodedados = "projetoes";
    $usuario = "root";
    $senha = "";
    $porta = 3306;

    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados, $porta);
    if ($mysqli->connect_errno){
        echo "falha:(" . $mysqli->connect_errno . ")". $mysqli->connect_errno;
    }
    else {
        // echo "Conectado ao banco de dados";
    }
    // Para exibir erros de conexão e consultas
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>