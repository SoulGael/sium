<?php

$hostname_conecta="localhost";
$database_conecta="bd_sium";
$username_conecta="root";
$password_conecta="";
$conecta=mysqli_connect($hostname_conecta,$username_conecta,$password_conecta,$database_conecta);
mysqli_set_charset($conecta,"utf8");
?>