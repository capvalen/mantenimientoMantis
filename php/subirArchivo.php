<?php 
include "conexion.php";


$file = urlencode($_POST['placa']."-".$_FILES["archivo"]['name']);
$ruta = "../files/";
//comprobamos si existe un directorio para subir el archivo

if(!is_dir($ruta)) 
	mkdir($ruta, 0777);
//comprobamos si el archivo ha subido

if ($file && move_uploaded_file($_FILES["archivo"]['tmp_name'],$ruta.$file)){

	$sql="UPDATE `mantenimiento` SET `mantAdjunto`='{$file}' WHERE `idMantenimiento`={$_POST['idReg']};";
	$resultado=$cadena->query($sql);

	//echo $ruta;//devolvemos el nombre del archivo para pintar la imagen
	echo "ok";
}

?>