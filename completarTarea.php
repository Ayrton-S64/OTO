<?php
  include_once('./conexion.php');
  session_start();
  $con = conectar();
  $tareaID = $_REQUEST['tareaID'];
  $userID = $_SESSION['user_id'];
  $query = "UPDATE tareas SET estado= 2 WHERE id_tarea=".$tareaID.";";
  $result = pg_query($query);
  if(!$result){
    $resp = array('success'=>0, 'mensaje'=>'Surgió un problema al mandar la solicitud');
  } else {
    $resp = array('success'=>1, 'mensaje'=>'Se realizó con exito la solicitud');
    pg_close($con);
  }
  echo json_encode($resp);
?>