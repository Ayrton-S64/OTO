<?php
  include_once ('./conexion.php');
  session_start();
  $con = conectar();
  $user = $_REQUEST['usuario'];
  $clave = $_REQUEST['clave'];
  $query = "SELECT * FROM USUARIOS WHERE nombre_usuario='".$user."';";
  $result = pg_query($query);
  if(pg_num_rows($result)==1){
    $fila = pg_fetch_array($result);
    if($fila['clave']==$clave){
      $_SESSION['user_id']=$fila['id_usuario'];
      $_SESSION['user']=$fila['nombre_usuario'];
      $resp = array('success'=>1, 'mensaje'=>'Sesion Iniciada', 'data'=>json_encode($fila));
    } else {
      $resp = array('success'=>0, 'mensaje'=>'Clave incorrecta');
    }
  }else{
    $resp = array('success'=>0, 'mensaje'=>'Usuario no encontrado');
  }
  pg_close($con);
  echo json_encode($resp);
?>