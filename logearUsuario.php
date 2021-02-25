<?php
  include_once ('./conexion.php');
  echo "Hola mundo";
  session_start();
  $con = conectar();
  $user = $_REQUEST['usuario'];
  $clave = $_REQUEST['clave'];
  $query = "SELECT * FROM USUARIOS WHERE nombre_usuario='".$user."';";
  echo $query;
  $result = pg_query($query);
  if(pg_num_rows($result)==1){
    $fila = pg_fetch_array($result);
    if($fila['clave']==$clave){
      $_SESSION['user_id']=$fila['id_usuario'];
      $_SESSION['user']=$fila['nombre_usuario'];
      $resp = array('success'=>1, 'mensaje'=>'Sesion Iniciada', 'data'=>json_encode($fila));
    } else {
      $resp = array('success'=>1, 'mensaje'=>'Clave incorrecta');
    }
  }else{
    $resp = array('success'=>1, 'mensaje'=>'Usuario no encontrado');
  }
  echo json_encode($resp);
?>