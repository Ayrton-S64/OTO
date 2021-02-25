<?php
  include_once './conexion.php';
  session_start();
      // $con = conectar();
      // $user = $_REQUEST['user'];
      // $clave = $_REQUEST['clave'];

      // $result = pg_query('SELECT * FROM USUARIOS WHERE nombre_usuario="'.$user.'";');
      // if(pg_num_rows($result)==1){
      //   $fila = pg_fetch_array($result);
      //   if($fila['clave']==$clave){
      //     $_SESSION['user_id']=$fila['id_usuario'];
      //     $_SESSION['user']=$fila['nombre_usuario'];
      //     echo 'se encontró el usuario';
      //   } else {
      //     echo 'Clave Incorrecta: '.$clave;
      //   }
      // }else{
      //   echo "No se encuentra ".$user;
      // }
      // echo "terminó el test"

  class Clase_usuario{

    private $param = array();
    private $con;

    public function gestionar($param){
      $this->param = $param;
      switch ($param['param_opcion']) {
        case 'logear':
          echo $this->logearUsuario();
          break;
        case 'registrar':
          echo $this->registrarUsuario();
          break;
        default:
          echo 'surgioProblema al indentificar';
          break;
      }
    }

    private function logearUsuario(){
      session_start();
      $conn_string = 'dbname=da14tgvhr874p2 host=ec2-52-22-161-59.compute-1.amazonaws.com port=5432 user=rzlfddaekpdauw password=104c50531b81f50affca244b773a6f428079c01ca21d9cc61e0274c5d25c9cba sslmode=require';
      $con = pg_connect($conn_string) or die('Could not connect: '. pg_last_error());
      $user = $this->param['param_usuario'];
      $clave = $this->param['param_clave'];
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
      return json_encode($resp);
    }

    private function registrarUsuario(){
      $user = $this->param['param_usuario'];
      $clave = $this->param['param_clave'];
      $correo = $this->param['param_correo'];
      $celular = $this->param['param_celular'];

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
    }
  }
?>