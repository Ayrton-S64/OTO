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

  $tareaIntersecto = "";

  $miFechaInicio = new DateTime($fecha." ".$horaInicio);;
  $miFechaFin = clone $miFechaInicio;
  $miTiempo = explode(':',$duracion);
  $miFechaFin->modify('+ '.$miTiempo[0].' hour');
  $miFechaFin->modify('+ '.$miTiempo[1].' minutes');


  $valido = TRUE;
  $result = pg_query("SELECT * FROM tareas WHERE id_usuario=".$userID." AND fecha=".$fecha." AND estado=1);");
  while($fila = pg_fetch_array($result)){
    $dbDate = $fila['fecha'];
    $dbInicio = $fila['hora_inicio'];
    $dbDuracion = $fila['duracion'];
    $dbFechaInicio = new DateTime($dbDate." ".$dbInicio);;
    $dbFechaFin = clone $dbFechaInicio;
    $tiempo = explode(':',$dbDuracion);
    $dbFechaFin->modify('+ '.$tiempo[0].' hour');
    $dbFechaFin->modify('+ '.$tiempo[1].' minutes');
    if(($miFechaInicio > $dbFechaInicio && $miFechaInicio < $dbFechaFin) || ($miFechaFin > $dbFechaInicio && $miFechaFin < $dbFechaFin)){
      $valido = FALSE;
      $tareaIntersecto = $fila["nombre_tarea"];
    }
  }
  if($valido || ($_REQUEST['forzar']==1)){
    $query = "INSERT INTO tareas(id_usuario, nombre_tarea, fecha, hora_inicio, duracion, descripcion, estado)
    VALUES (".$userID.", '".$nombreTarea."', '".$fecha."', '".$horaInicio."', '".$duracion."', '".$descripcion."', 1);";
    $result = pg_query($query);
    if(!$result){
      $resp = array('success'=>0, 'mensaje'=>'Surgió un problema al agregar la tarea');
    } else {
      $respuesta = pg_query("SELECT * FROM tareas WHERE id_usuario=".$userID.";");
      $numTareas = pg_num_rows($respuesta);
      if(intval($miTiempo[0])<3){
        $resp = array('success'=>1, 'mensaje'=>'Se agregó con exito la tarea','total'=>$numTareas);
      }else{
        $resp = array('success'=>1, 'mensaje'=>'La tarea es de larga duración, le recomendamos tomar descansos regularmente');
      }
      pg_close($con);
    }
  }else{
    $resp = array('success'=>2, 'mensaje'=>'La tarea que quiere agregar intersecta con la siguiente tarea '.$tareaIntersecto.'<br>
                                            ¿Estas seguro que quieres continuar?');
  }

  echo json_encode($resp);
?>