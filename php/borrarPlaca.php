<?php 
include "conexion.php";
$sql="UPDATE `placas` SET `placActivo`=0 WHERE `idPlaca`= {$_POST['idPlaca']}; ";

if($cadena->query($sql)){
   echo "todo ok";
}else{
   echo "fallo algo";
}
?>