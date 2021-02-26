<?php
  require_once('./conexion.php');

  echo "Testing...";
  $con = conectar();
  $result = pg_query("SELECT * FROM tareas WHERE id_usuario=1 AND fecha='2021-02-25';");
  while($fila = pg_fetch_array($result)){
    $dbDate = $fila['fecha'];
    $dbInicio = $fila['hora_inicio'];
    $dbFin = $fila['hora_inicio'] + $fila['duracion'];
    $miFecha = new DateTime($dbDate);
    echo "DbDATE=".$dbDate."\n";
    echo "DbInicio=".$dbInicioc."\n";
    echo "DbDuracion=".$fila['duracion']."\n";
    echo "DbFin=".$dbFin."\n";
    echo "oFecha=".date_format($miFecha,'Y-m-d H:i:s')."\n";
    echo "\n";
  }
  echo "testFinalizado";
?>