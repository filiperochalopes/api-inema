<?php

$con_string = "host=localhost port=5432 dbname=meioambiente user=postgres password=inema";
$mydb = pg_connect($con_string)or die("Nao foi possivel conectar");

?>