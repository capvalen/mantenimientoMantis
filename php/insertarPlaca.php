<?php 

include "conexion.php";

$sql="INSERT INTO `placas`(`idPlaca`, `placSerie`, `placActivo`) VALUES (null, '{$_POST['placa']}',1);";
$resultado=$cadena->query($sql);
if($resultado){
	echo "ok";
}else{
	echo "error";
}
?>