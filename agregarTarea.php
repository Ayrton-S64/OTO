<?php
  include_once('./conexion.php');
  session_start();
  $con = conectar();
  $userID = $_SESSION['user_id'];
  $nombreTarea = $_REQUEST['nombreTarea'];
  $fecha = $_REQUEST['fechaInicio'];
  $horaInicio = $_REQUEST['horaInicio'];
  $duracion = $_REQUEST['duracion'];
  $descripcion = $_REQUEST['descripcion'];
  $query = "INSERT INTO tareas(id_usuario, nombre_tarea, fecha, hora_inicio, duracion, descripcion, estado)
                            VALUES (".$userID.", '".$nombreTarea."', ".$fecha.", ".$horaInicio.", ".$duracion.", '".$descripcion."', 1);";
  $result = pg_query($query);
  if(!$result){
    $resp = array('success'=>0, 'mensaje'=>'Surgió un problema al agregar la tarea');
  } else {
    $respuesta = pg_query("SELECT * FROM tareas WHERE id_usuario=".$userID.";");
    $numTareas = pg_num_rows($respuesta);
    $resp = array('success'=>1, 'mensaje'=>'Se agregó con exito la tarea','total'=>$numTareas);
    pg_close($con);
  }
  echo json_encode($resp);
?>