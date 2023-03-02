<?php 
include "conexion.php";

$sql="UPDATE `placas` SET `ano`={$_POST['ano']},
`rango`={$_POST['rangoAceite']},`porcentajeAviso`={$_POST['porcentajeAceite']},`rango2`={$_POST['rangoCaja']},`porcentajeAviso2`={$_POST['porcentajeCaja']} WHERE 
`idPlaca`= {$_POST['idPlaca']}
";
//echo $sql; die();
if($resultado=$cadena->query($sql)){
	echo 'ok';
}else{
	echo -1;
}


?>