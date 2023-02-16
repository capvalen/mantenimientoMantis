<?php 
include "conexion.php";
unlink('../facturas/'.$_POST['archivo']);
$sql="UPDATE `mantenimiento` SET `mantFactura`='' WHERE `idMantenimiento`= {$_POST['idMantenimiento']}; ";

if($cadena->query($sql)){
   echo "todo ok";
}else{
   echo "fallo algo";
}
?>