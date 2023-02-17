<?php 

include "conexion.php";

$sql="INSERT INTO `placas`(`idPlaca`, movilidad, `placSerie`, `placActivo`) VALUES (null, '{$_POST['movilidad']}', '{$_POST['placa']}',1);";
$resultado=$cadena->query($sql);
if($resultado){
	echo "ok";
}else{
	echo "error";
}
?>