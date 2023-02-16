<?php 
include "conexion.php";

$ruta = "../images/";

$file = urlencode($_FILES["archivo"]['name']);

$tipoArchivo = strtolower(pathinfo( $ruta . basename($_FILES["archivo"]["name"]) ,PATHINFO_EXTENSION));
$queArchivo = uniqid() . "." . $tipoArchivo;
$archivoFinal = $ruta . $queArchivo; //basename($_FILES["archivo"]["name"]);

//comprobamos si existe un directorio para subir el archivo

if(!is_dir($ruta)) 
	mkdir($ruta, 0777);
//comprobamos si el archivo ha subido

if ($file && move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivoFinal)){

	$sql="UPDATE `placas` SET `foto`='{$queArchivo}' WHERE `idPlaca`={$_POST['idPlaca']};";
	echo $sql;
	$resultado=$cadena->query($sql);

	//echo $ruta;//devolvemos el nombre del archivo para pintar la imagen
	echo "ok";
}

?>