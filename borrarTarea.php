<?php
  include_once('./conexion.php');
  session_start();
  $con = conectar();
  $tareaID = $_REQUEST['tareaID'];
  $userID = $_SESSION['user_id'];
  $query = "UPDATE tareas SET estado= 0 WHERE id_tarea=".$tareaID.";";
  $result = pg_query($query);
  if(!$result){
    $resp = array('success'=>0, 'mensaje'=>'Surgió un problema al eliminar la tarea');
  } else {
    $resp = array('success'=>1, 'mensaje'=>'Se eliminó con exito la tarea');
    pg_close($con);
  }
  echo json_encode($resp);
?>