<?php 
include "conexion.php";

if(!isset($_GET['placa'])){
	?>
	<tr>
		<td colspan="8">Seleccione una placa para visualizar el reporte</td>
	</tr>
	<?php
}else{

	$sql="SELECT `idMantenimiento`, date_format(`manFecha`, '%d/%m/%Y') as manFecha, manFecha as manFecha2 , mantDescipcion, `mantKilometraje`, lower(mantLugar) as `mantLugar`, lower(mantResponsable) as `mantResponsable`, `mantMonto`, `mantAdjunto`, `mantActivo`, tpm.tipmDescripcion , pl.placSerie,  pl.idPlaca, m.idTipoMantenimiento, mantFactura
	FROM `mantenimiento` m
	inner join tipoMantenimiento tpm on tpm.idTipoMantenimiento = m.idTipoMantenimiento
	inner join placas pl on pl.idPlaca = m.idPlaca
	where concat(upper(pl.movilidad), ' ',upper(pl.placSerie)) = upper('{$_GET['placa']}') and mantActivo=1 ORDER BY  manFecha2 DESC ;";
	
	$resultado=$cadena->query($sql);
	if($resultado->num_rows>=1){
	$i=0;
		while($row=$resultado->fetch_assoc()){ ?>
			<tr>
				<td style="white-space: nowrap"><?php if($_COOKIE['ckPower']==1){echo "<span class='d-print-none'><button class='btn btn-outline-danger btn-sm border-0' onclick='borrarDescipcion({$row['idMantenimiento']})'><i class='bi bi-x'></i></button> <button class='btn btn-outline-primary btn-sm border-0' onclick='updateDescipcion({$row['idMantenimiento']}, {$row['idPlaca']}, {$i})'> <i class='bi bi-pencil-square'></i> </button></span>";} ?> <?= $i+1; ?></td>
				<td class="tdFecha">
					<span><?= $row['manFecha']; ?></span>
					<span class="d-print-flex d-none"><?= $row['tipmDescripcion']; ?></span>
				</td>
				<td class="tdTipoMant d-print-none" data-id="<?= $row['idTipoMantenimiento'];?>"><?= $row['tipmDescripcion']; ?></td>
				<td class="tdDescipcion"><?= $row['mantDescipcion']; ?></td>
				<td class="tdKilo"><?= $row['mantKilometraje']; ?></td>
				<td class="text-capitalize tdLugar">
					<span><?= $row['mantLugar']; ?></span>
					<span class="d-print-flex d-none"><?= $row['mantResponsable']; ?></span>
				</td>
				<td class="text-capitalize d-print-none tdResponsable"><?= $row['mantResponsable']; ?></td>
				<td class="tdMonto"><?= $row['mantMonto']; ?></td>
				<td class="d-print-none tdArchivo"><?php if(strlen($row['mantAdjunto'])>0){ ?>
					<a href="./files/<?= $row['mantAdjunto'];?>" download><i class="bi bi-file-arrow-down"></i></a> <?php }  ?>
				</td>
				<td class="d-print-none tdFactura"><?php if(strlen($row['mantFactura'])>0){ ?>
					<a href="./facturas/<?= $row['mantFactura'];?>" download><i class="bi bi-file-arrow-down"></i></a> <?php }  ?>
				</td>
				
			</tr>
			<?php $i++;
		}
	}else{
		?>
		<tr>
			<td colspan="8">No se encuentran resultados con esa placa</td>
		</tr>
		<?php
	}
}

$cadena = null;

 ?>