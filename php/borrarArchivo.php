<?php 
include "conexion.php";
unlink('../files/'.$_POST['archivo']);
$sql="UPDATE `mantenimiento` SET `mantAdjunto`='' WHERE `idMantenimiento`= {$_POST['idMantenimiento']}; ";

if($cadena->query($sql)){
   echo "todo ok";
}else{
   echo "fallo algo";
}
?>