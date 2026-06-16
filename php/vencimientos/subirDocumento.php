<?php
include "../conexion.php";

$idPlaca = (int)$_POST['idPlaca'];
$tipo = $cadena->real_escape_string($_POST['tipo']);
$ruta = "../../archivos/";

if(!is_dir($ruta))
	mkdir($ruta, 0777);

$sql = "SELECT id, ruta FROM archivos WHERE idPlaca = $idPlaca AND tipo = '$tipo' AND activo = 1 ORDER BY id DESC LIMIT 1";
$result = $cadena->query($sql);

if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	$oldFile = $ruta . $row['ruta'];
	if(file_exists($oldFile))
		unlink($oldFile);
	$cadena->query("UPDATE archivos SET activo = 0 WHERE id = {$row['id']}");
}

$ext = strtolower(pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION));
$nombreArchivo = uniqid() . "." . $ext;
$archivoFinal = $ruta . $nombreArchivo;

if(move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivoFinal)){
	$cadena->query("INSERT INTO archivos (idPlaca, tipo, ruta, activo, registro) VALUES ($idPlaca, '$tipo', '$nombreArchivo', 1, NOW())");
	echo "ok";
} else {
	echo "error";
}
?>
