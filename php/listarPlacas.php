<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

$sqlPlacas="SELECT `idPlaca`, upper(`placSerie`) as placSerie, `placActivo` FROM `placas` WHERE placActivo=1";
$resultadoPlacas=$cadena->query($sqlPlacas); $i=1;
while($rowPlacas=$resultadoPlacas->fetch_assoc()){ 
?>
<tr>
<td><?= $i; ?></td>
<td><?= $rowPlacas['placSerie']; ?></td>
<td><button class="btn btn-outline-danger btn-sm" onclick="borrarPlaca(<?= $rowPlacas['idPlaca'];?>)"><i class="icofont-ui-delete"></i></button></td>
</tr>
<?php	
} $i++; ?>