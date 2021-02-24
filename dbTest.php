<?php
  echo "Testing...";
  $conn_string = 'dbname=da14tgvhr874p2 host=ec2-52-22-161-59.compute-1.amazonaws.com port=5432 user=rzlfddaekpdauw password=104c50531b81f50affca244b773a6f428079c01ca21d9cc61e0274c5d25c9cba sslmode=require';
  $dbconn = pg_connect($conn_string) or die('Could not connect: '. pg_last_error());

  echo "Connected to the DB";
?>d