<?php
	$server="mysql1004.mochahost.com";
	$username="ronaldqv_infocat";
	$password="*123456*";
	$db='ronaldqv_intranetCarros';
	$conection= mysqli_connect($server,$username,$password)or die("No se ha podido establecer la conexion" . mysqli_connect_error() . PHP_EOL );
	$sdb= mysqli_select_db($conection,$db)or die("La base de datos no existe");
	$conection->set_charset("utf8");

	$cadena= new mysqli($server, $username, $password, $db);
	$cadena->set_charset("utf8");

	$esclavo= new mysqli($server, $username, $password, $db);
	$esclavo->set_charset("utf8");
?>