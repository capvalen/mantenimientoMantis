<?php
include "../conexion.php";

$idPlaca = (int)$_POST['idPlaca'];
$tipo = $cadena->real_escape_string($_POST['tipo']);
$ruta = "../../archivos/";

$sql = "SELECT id, ruta FROM archivos WHERE idPlaca = $idPlaca AND tipo = '$tipo' AND activo = 1 ORDER BY id DESC LIMIT 1";
$result = $cadena->query($sql);

if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	$oldFile = $ruta . $row['ruta'];
	if(file_exists($oldFile))
		unlink($oldFile);
	$cadena->query("UPDATE archivos SET activo = 0 WHERE id = {$row['id']}");
	echo "ok";
} else {
	echo "error";
}
?>
