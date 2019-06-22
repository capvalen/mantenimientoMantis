<?php 
include "conexion.php";

$sql="UPDATE `mantenimiento` SET `manFecha`='{$_POST['fecha']}', `idTipoMantenimiento`='{$_POST['tipo']}', `mantDescipcion`='{$_POST['descripcion']}', `mantKilometraje`='{$_POST['kilome']}', `mantLugar`='{$_POST['lugar']}', `mantResponsable`= '{$_POST['responsable']}', `mantMonto`='{$_POST['monto']}' WHERE `idMantenimiento`= {$_POST['idMantenimientoReg']};";
$resultado=$cadena->query($sql);

echo $_POST['idMantenimientoReg'];
?>