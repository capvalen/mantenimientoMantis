<?php 
include "../conexion.php";

switch($_POST['tipo']){
	case 'horometro': horometro($cadena); break;
}

function horometro($cadena){
	$sql = "INSERT INTO `aceite`(`idPlaca`, `fActualizacion`, `horometro`, `fMantenimiento`, `kilometraje`, 
	`observacion`, `tipo`) VALUES 
	({$_POST['idPlaca']}, '{$_POST['fechaHoro']}', {$_POST['horometro']}, '{$_POST['fechaActual']}', {$_POST['kilometraje']}, 
	'{$_POST['kilometraje']}',{$_POST['observacion']})";
	if( $cadena->query($sql)){
		echo 'ok';
	}else{
		echo -1;
	}
	
}