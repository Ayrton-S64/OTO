<?php
  echo "Testing...";
  $dbconn = pg_connect($conn_string) or die('Could not connect: '. pg_last_error());

  echo "Connected to the DB";
?>d