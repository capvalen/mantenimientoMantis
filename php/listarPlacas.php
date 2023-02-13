<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

$sqlPlacas="SELECT `idPlaca`, upper(`placSerie`) as placSerie, `placActivo` FROM `placas` WHERE placActivo=1";
$resultadoPlacas=$cadena->query($sqlPlacas); $i=1;
while($rowPlacas=$resultadoPlacas->fetch_assoc()){ 
?>
<tr>
	<td class="p-1"><?= $i; ?></td>
	<td class="p-1"><?= $rowPlacas['placSerie']; ?></td>
	<td class="p-1"><button class="btn btn-outline-danger btn-sm border-0" onclick="borrarPlaca(<?= $rowPlacas['idPlaca'];?>)"> <i class="bi bi-eraser"></i> </button></td>
</tr>
<?php	
$i++; } ?>