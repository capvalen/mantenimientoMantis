<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

$sqlPlacas="SELECT `idPlaca`, upper(`placSerie`) as placSerie, `placActivo`, movilidad,rango,rango2,porcentajeAviso,porcentajeAviso2,ano FROM `placas` WHERE placActivo=1";
$resultadoPlacas=$cadena->query($sqlPlacas); $i=1;
while($rowPlacas=$resultadoPlacas->fetch_assoc()){ 
?>
<tr>
	<td class="p-1"><?= $i; ?></td>
	<td class="p-1"><?= $rowPlacas['movilidad']; ?></td>
	<td class="p-1"><?= $rowPlacas['placSerie']; ?></td>
	<td> <input type="number" value="<?=$rowPlacas['ano']?>" class="form-control ano" onchange="activarActualizacionBasicos(<?= $i; ?>, <?= $rowPlacas['idPlaca']?>)"> </td>
	<td> <input type="number" value="<?=$rowPlacas['rango']?>" class="form-control rangoAceite" onchange="activarActualizacionBasicos(<?= $i; ?>, <?= $rowPlacas['idPlaca']?>)"> </td>
	<td> <input type="number" value="<?=$rowPlacas['porcentajeAviso']?>" class="form-control porcentajeAceite" onchange="activarActualizacionBasicos(<?= $i; ?>, <?= $rowPlacas['idPlaca']?>)"> </td>
	<td> <input type="number" value="<?=$rowPlacas['rango2']?>" class="form-control rangoCaja" onchange="activarActualizacionBasicos(<?= $i; ?>, <?= $rowPlacas['idPlaca']?>)"> </td>
	<td> <input type="number" value="<?=$rowPlacas['porcentajeAviso2']?>" class="form-control porcentajeCaja" onchange="activarActualizacionBasicos(<?= $i; ?>, <?= $rowPlacas['idPlaca']?>)"> </td>
	<td class="p-1" style="white-space:nowrap">
		<button class="btn btn-outline-info btn-sm border-0 btnActualizar d-none" onclick="actualizarPlaca(<?= $rowPlacas['idPlaca'];?>)"> <i class="bi bi-arrow-clockwise"></i> </button>
		<button class="btn btn-outline-danger btn-sm border-0" onclick="borrarPlaca(<?= $rowPlacas['idPlaca'];?>)"> <i class="bi bi-eraser"></i> </button>
	</td>
</tr>
<?php	
$i++; } ?>