<?php
// Copyright (c) 2020, Altiria TIC SL
// All rights reserved.
// El uso de este c�digo de ejemplo es solamente para mostrar el uso de la pasarela de env�o de SMS de Altiria
// Para un uso personalizado del c�digo, es necesario consultar la API de especificaciones t�cnicas, donde tambi�n podr�s encontrar
// m�s ejemplos de programaci�n en otros lenguajes y otros protocolos (http, REST, web services)
// https://www.altiria.com/api-envio-sms/

// XX, YY y ZZ se corresponden con los valores de identificacion del
// usuario en el sistema.
include('./API/httpPHPAltiria.php');
session_start();

$altiriaSMS = new AltiriaSMS();

$altiriaSMS->setLogin('ayrtonxd.123@gmail.com');
$altiriaSMS->setPassword('db28c34b');

$altiriaSMS->setDebug(true);

//Use this ONLY with Sender allowed by altiria sales team
//$altiriaSMS->setSenderId('TestAltiria');
//Concatenate messages. If message length is more than 160 characters. It will consume as many credits as the number of messages needed
//$altiriaSMS->setConcat(true);
//Use unicode encoding (only value allowed). Can send ����� but message length reduced to 70 characters
//$altiriaSMS->setEncoding('unicode');

//$sDestination = '346xxxxxxxx';
$con = conectar();
$result = pg_query('SELECT * FROM usuarios WHERE id_usuario='.$_SESSION['userID'].';');
$fila = pg_fetch_array($result);
$sDestination = '51'.$fila['telefono'].'';
//$sDestination = array('346xxxxxxxx','346yyyyyyyy');
$mensaje = "Tienes las siguientes tareas pendientes:\n";
echo "SELECT * FROM tareas WHERE estado=1 AND id_usuario=".$_SESSION['userID'].";";
$result = pg_query("SELECT * FROM tareas WHERE estado=1 AND id_usuario=".$_SESSION['user_id'].";");

while($fila = pg_fetch_array($result)){
   $mensaje .= '   -'.$fila['nombre_tarea'].'para '.$fila['fecha'].'\n';
}
$mensaje.="para mas detalle entrar a https://oto-task.herokuapp.com/";

$response = $altiriaSMS->sendSMS($sDestination, $mensaje);

if (!$response)
  echo "El env�o ha terminado en error";
else
  echo $response;
?>
