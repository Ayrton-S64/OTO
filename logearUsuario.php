<?php
  echo "Hola mundo \n";
  session_start();
  echo "Conectando";
  $con = conectar();
  echo "Conexcion realizada";
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
      echo "Exito";
    } else {
      echo "Contraseña incorrecta";
    }
  }else{
    echo "No hay dato";
  }
?>