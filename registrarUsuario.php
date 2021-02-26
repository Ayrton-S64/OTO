<?php
  include_once('./conexion.php');
  $user = $_REQUEST['usuario'];
  $clave = $_REQUEST['clave'];
  $correo = $_REQUEST['correo'];
  $celular = $_REQUEST['celular'];

  session_start();
  $con = conectar();
  $consulta = pg_query("SELECT * FROM USUARIOS WHERE nombre_usuario='".$user."';");
  if(pg_num_rows($consulta)==0){
    $result = pg_query("INSERT INTO USUARIOS(nombre_usuario, clave, telefono, correo) VALUES ('".$user."', '".$clave."', '".$celular."','".$correo."');");
    if(!$result){
      $resp = array('success'=>0,'mensaje'=>'Surgió un problema intentalo mas tarde');
    }else{
      if(pg_affected_rows($result)==1){
        $resp = array('success'=>1,'mensaje'=>'Registro exitoso');
      }else{
        $resp = array('success'=>0, 'mensaje'=>'No se afectaron ninguna fila?');
      }
    }
  }else{
    $resp = array('success'=>0,'mensaje'=>'Este usuario ya existe');
  }
  pg_close($con); 
  return json_encode($resp);
?>