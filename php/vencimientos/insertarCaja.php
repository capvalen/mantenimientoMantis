<?php 
include "../conexion.php";

$sql = "INSERT INTO `caja`(`idPlaca`, `fActualizacion`, `horometro`, observacion) VALUES 
({$_POST['idPlaca']}, '{$_POST['fecha']}', {$_POST['horometro']}, '{$_POST['observacion']}')";
//echo $sql; die();
if( $cadena->query($sql)){
	echo 'ok';
}else{
	echo -1;
}
