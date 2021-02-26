<?php
   $request = [ 
    "api_key" => ' c50fa8648ee8454789e5ff3cf0285b2d',
    "messages" => [ 
       [
           "from" => "REMITENTE",
          "to" => "+51933856134",
          "text" => "Texto del mensaje a enviar"
       ]
    ]
 ];
 $headers = array('Content-Type: application/json');
 $ch = curl_init('https://api.gateway360.com/api/3.0/sms/send');
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
 $result = curl_exec($ch);
 if (curl_errno($ch) != 0 ){
 die("curl error: ".curl_errno($ch));
}
?>