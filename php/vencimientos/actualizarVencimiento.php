<?php
include "./../conexion.php";

$sql = "UPDATE `placas` SET 
`vencimientoSoat`= IF('{$_POST['soat']}' = '', null, '{$_POST['soat']}' ), `vencimientoRT`=IF('{$_POST['rt']}' = '', null, '{$_POST['rt']}' ), `vencimientoRCT`= IF('{$_POST['rct']}' = '', null, '{$_POST['rct']}' )
WHERE `idPlaca`= {$_POST['id']};";
//echo $sql;
if($resultado = $cadena->query($sql)){
	echo 'ok';
}else{
	echo -1;
}