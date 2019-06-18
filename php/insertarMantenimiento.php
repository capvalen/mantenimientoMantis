<?php 
include "conexion.php";

$sql="INSERT INTO `mantenimiento`(`idMantenimiento`, `idPlaca`, `manFecha`, `idTipoMantenimiento`, `mantDescipcion`, `mantKilometraje`, `mantLugar`, `mantResponsable`, `mantMonto`, `mantAdjunto`, `mantActivo`) VALUES
(null, {$_POST['placa']}, '{$_POST['fecha']}', {$_POST['tipo']}, '{$_POST['descripcion']}', {$_POST['kilome']}, '{$_POST['lugar']}', '{$_POST['responsable']}', {$_POST['monto']}, '', 1); ";
$resultado=$cadena->query($sql);
//echo "ok";
echo $cadena->insert_id;

?>