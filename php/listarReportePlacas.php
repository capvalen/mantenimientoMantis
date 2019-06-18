<?php 
include "conexion.php";

if(!isset($_GET['placa'])){
	?>
	<tr>
		<td colspan="8">Seleccione una placa para visualizar el reporte</td>
	</tr>
	<?php
}else{

	$sql="SELECT `idMantenimiento`, date_format(`manFecha`, '%d/%m/%Y') as manFecha, `mantDescipcion`, `mantKilometraje`, `mantLugar`, `mantResponsable`, `mantMonto`, `mantAdjunto`, `mantActivo`, tpm.tipmDescripcion , pl.placSerie
	FROM `mantenimiento` m
	inner join tipoMantenimiento tpm on tpm.idTipoMantenimiento = m.idTipoMantenimiento
	inner join placas pl on pl.idPlaca = m.idPlaca
	where upper(pl.placSerie) = upper('{$_GET['placa']}') ;";
	
	$resultado=$cadena->query($sql);
	if($resultado->num_rows>=1){
	$i=1;
		while($row=$resultado->fetch_assoc()){ ?>
			<tr>
				<td><?= $i; ?></td>
				<td><?= $row['manFecha']; ?></td>
				<td class="text-capitalize"><?= $row['mantDescipcion']; ?></td>
				<td><?= $row['mantKilometraje']; ?></td>
				<td><?= $row['mantLugar']; ?></td>
				<td><?= $row['mantResponsable']; ?></td>
				<td><?= $row['mantMonto']; ?></td>
				<td><?php if(strlen($row['mantAdjunto'])>0){ ?>
				<a href="./files/<?= $row['mantAdjunto'];?>"><i class="icofont-download-alt"></i></a>
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