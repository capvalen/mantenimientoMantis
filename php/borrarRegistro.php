<?php 
include "conexion.php";
$sql="UPDATE `mantenimiento` SET `mantActivo`=0 WHERE `idMantenimiento`= {$_POST['idDescripc']}; ";

if($cadena->query($sql)){
   echo "todo ok";
}else{
   echo "fallo algo";
}
?>