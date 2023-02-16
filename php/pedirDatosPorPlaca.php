<?php
include "conexion.php";

$sql = "SELECT * from placas where placSerie = '{$_POST['placa']}' and placActivo=1;";
$resultado = $cadena->query($sql);
$row = $resultado->fetch_assoc();
echo json_encode(
	array( 'foto' => $row['foto'],
	'id' => $row['idPlaca']
	)
);


?>