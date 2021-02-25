<?php
  include_once './modelUsuario.php';
  session_start();
  $param = array();
  $param['param_opcion'] = '';
  $param['param_usuario']='';
  $param['param_clave']='';
  $param['param_correo']='';
  $param['param_celular']='';

  if (isset($_POST['param_opcion'])){
    $param['param_opcion']=$_POST['param_opcion'];
  }
  if (isset($_POST['param_usuario'])){
    $param['param_usuario']=$_POST['param_usuario'];
  }
  if (isset($_POST['param_clave'])){
    $param['param_clave']=$_POST['param_clave'];
  }
  if (isset($_POST['param_correo'])){
    $param['param_correo']=$_POST['param_correo'];
  }
  if (isset($_POST['param_celular'])){
    $param['param_celular']=$_POST['param_celular'];
  }
  echo $param['param_opcion'];
  echo $param['param_usuario'];
  echo $param['param_clave'];
  // $clase = new Clase_usuario();
  // echo $Clase->gestionar($param);
?>