<?php
  require_once('./conexion.php');

  echo "Testing...";
  $con = conectar();
  $result = pg_query("SELECT * FROM tareas WHERE id_usuario=1 AND fecha='2021-02-25';");
  while($fila = pg_fetch_array($result)){
    $dbDate = $fila['fecha'];
    $dbInicio = $fila['hora_inicio'];
    $dbFin = $fila['hora_inicio'] + $fila['duracion'];
    $dbDuracion = $fila['duracion'];
    $miFechaInicio = new DateTime($dbDate." ".$dbInicio);
    $tempFecha = new DateTime($dbDate." ".$dbDuracion);
    $diferencia = $miFechaInicio->diff($tempFecha);
    $miFechaFin = (new DateTime($dbDate." ".$dbInicio))->add($diferencia);
    $newDAte = new DateTime('2021-02-25 16:44:00');
    echo "DbDATE=".gettype($dbDate)."<br>";
    echo "DbInicio=".$dbDate." ".$dbInicio."<br>";
    echo "DbDuracion=".$dbDuracion."<br>";
    echo "DbFin=".$dbFin."<br>";
    echo "iFecha=".date_format($miFechaInicio,'Y-m-d H:i:s')."<br>";
    echo "dFecha=".date_format($newDAte,'Y-m-d H:i:s')."<br>";
    echo "fFecha=".date_format($miFechaFin,'Y-m-d H:i:s')."<br>";
    echo "<br>";
  }
  echo "testFinalizado";
?>