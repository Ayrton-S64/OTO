<?php
  $url = 'https://a6a748bf-203f-4af8-abb9-6e6295bafaef:Wa9jklJkXzMrEYD4gAvzpA@api.blower.io' . "/messages";
  $data = array('to' => '+51 933856134', 'message' => 'Hello from Blower.io');
  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $response = curl_exec($ch);
  curl_close($ch);
?>