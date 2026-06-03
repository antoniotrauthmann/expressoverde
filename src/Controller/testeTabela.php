<?php include dirname(__DIR__, 2) . '/config/conexao.php'; ?>

<table>
    <tr>
        <th>id</th>
        <th>produto</th>
        <th>preço</th>
    </tr>
<?php
$sql = "SELECT * FROM produto";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>" . 
        "<td>" . $row["id_produto"] . "</td>".
        "<td>" . $row["nome"] . "</td>".
        "<td>" . $row["preco"] . "</td>" .
        "</tr>";
    }
} else {
    echo "0 resultados";
}

$mysqli->close();
?>
</table>


<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>