<?php
include "conexion.php";

$sql="SELECT idPlaca, upper(placSerie) as placSerie FROM  `placas` where placActivo=1;";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	?>
	<option value="<?= $row['idPlaca'];?>"><?= $row['placSerie'];?></option>
	<?php
}
?>