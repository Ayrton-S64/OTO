<?php
  require_once('./conexion.php');

  echo "Testing...";
  
  $con = conectar();
  $query =  'SELECT * FROM CATEGORIAS';
  $result = pg_query($query) or die('La consulta fallo: '.pg_last_error());
  
  echo "Connected to the DB\n";

  echo "<table>";
  while($fila = pg_fetch_array($result)){
    echo "<tr>";
    foreach($fila as $col){
      echo '<td>'.$col.'</td>';
    }
    echo "</tr>";
  }
  echo "</table>";
?>