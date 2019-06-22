<?php 
include "conexion.php";

if(!isset($_GET['placa'])){
	?>
	<tr>
		<td colspan="8">Seleccione una placa para visualizar el reporte</td>
	</tr>
	<?php
}else{

	$sql="SELECT `idMantenimiento`, date_format(`manFecha`, '%d/%m/%Y') as manFecha, manFecha as manFecha2 , lower(mantDescipcion) as `mantDescipcion`, `mantKilometraje`, lower(mantLugar) as `mantLugar`, lower(mantResponsable) as `mantResponsable`, `mantMonto`, `mantAdjunto`, `mantActivo`, tpm.tipmDescripcion , pl.placSerie,  pl.idPlaca, m.idTipoMantenimiento
	FROM `mantenimiento` m
	inner join tipoMantenimiento tpm on tpm.idTipoMantenimiento = m.idTipoMantenimiento
	inner join placas pl on pl.idPlaca = m.idPlaca
	where upper(pl.placSerie) = upper('{$_GET['placa']}') and mantActivo=1 ORDER BY  manFecha2 DESC ;";
	
	$resultado=$cadena->query($sql);
	if($resultado->num_rows>=1){
	$i=0;
		while($row=$resultado->fetch_assoc()){ ?>
			<tr>
				<td><?php if($_COOKIE['ckPower']==1){echo "<button class='btn btn-outline-danger btn-sm border-0' onclick='borrarDescipcion({$row['idMantenimiento']})'><i class='icofont-close'></i></button> <button class='btn btn-outline-primary btn-sm border-0' onclick='updateDescipcion({$row['idMantenimiento']}, {$row['idPlaca']}, {$i})'><i class='icofont-edit'></i></button>";} ?> <?= $i+1; ?></td>
				<td class="tdFecha"><?= $row['manFecha']; ?></td>
				<td class="tdTipoMant" data-id="<?= $row['idTipoMantenimiento'];?>"><?= $row['tipmDescripcion']; ?></td>
				<td class="text-capitalize tdDescipcion"><?= $row['mantDescipcion']; ?></td>
				<td class="tdKilo"><?= $row['mantKilometraje']; ?></td>
				<td class="text-capitalize tdLugar"><?= $row['mantLugar']; ?></td>
				<td class="text-capitalize tdResponsable"><?= $row['mantResponsable']; ?></td>
				<td class="tdMonto"><?= $row['mantMonto']; ?></td>
				<td class="tdArchivo"><?php if(strlen($row['mantAdjunto'])>0){ ?>
				<a href="./files/<?= $row['mantAdjunto'];?>" download><i class="icofont-download-alt"></i></a>
				<?php }  ?></td>
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


 ?>