<?php
include "./../conexion.php";

switch ($_POST['tipo']) {
	case 'soat': reporteSoat($cadena); break;
	case 'aceite': reporteAceite($cadena, $esclavo); break;
	
	default:
		# code...
		break;
}

function reporteSoat($cadena){
	$sql="SELECT *, date_format(vencimientoSoat, '%d/%m/%Y') as vencimientoSoatLatam, date_format(vencimientoRT, '%d/%m/%Y') as vencimientoRTLatam, date_format(vencimientoRCT, '%d/%m/%Y') as vencimientoRCTLatam  FROM placas where placActivo = 1 order by idPlaca;";
	$resultado = $cadena->query($sql); $i=1;
	$hoy = new DateTime(date('Y-m-d'));
	?>
	<table class="table table-hover">
		<thead>
				<th>N°</th>
				<th>Vehículo - Placa</th>
				<th>Año Fab.</th>
				<th>Fecha Vencimiento SOAT</th>
				<th>Alerta SOAT</th>
				<th>Fecha Vencimiento R. Técnica</th>
				<th>Alerta R. Técnica</th>
				<th>Fecha vencimiento Póliza RCT</th>
				<th>Alerta Póliza RCT</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($row = $resultado->fetch_assoc()){
				$venceSoat = new DateTime($row['vencimientoSoat']);
				$venceRT = new DateTime($row['vencimientoRT']);
				$venceRCT = new DateTime($row['vencimientoRCT']);

				$intervaloSoat = $hoy->diff($venceSoat)->format('%R%a');
				$intervaloRT = $hoy->diff($venceRT)->format('%R%a');
				$intervaloRCT = $hoy->diff($venceRCT)->format('%R%a');
			?>
			<tr>
				<td><?= $i;?></td>
				<td class="tdPlaca" data-value="<?= $row['placSerie']?>"><?= $row['placSerie']?></td>
				<td><?= $row['ano']?></td>
				<td class="tdSoat" data-value="<?= $row['vencimientoSoat']?>"><?= $row['vencimientoSoatLatam']?></td>
				<?php if( $row['vencimientoSoat']<>''): ?>
					<?php if( $intervaloSoat >0): ?>
						<td class="bg-success text-light"><?= 'Faltan '. abs($intervaloSoat) . ' días' ?></td>
					<?php else: ?>
						<td class="bg-danger text-light"><?= 'Vencido hace '. abs($intervaloSoat) . ' días' ?></td>
					<?php endif; ?>
				<?php else: ?>
					<td></td>
				<?php endif; ?>
				<td class="tdRT" data-value="<?= $row['vencimientoRT']?>"><?= $row['vencimientoRTLatam']?></td>
				<?php if( $row['vencimientoRT']<>''): ?>
					<?php if( $intervaloRT >0): ?>
						<td class="bg-success text-light"><?= 'Faltan '. abs($intervaloRT) . ' días' ?></td>
					<?php else: ?>
						<td class="bg-danger text-light"><?= 'Vencido hace '. abs($intervaloRT) . ' días' ?></td>
					<?php endif; ?>
				<?php else: ?>
					<td></td>
				<?php endif; ?>
				
				<td class="tdRCT" data-value="<?= $row['vencimientoRCT']?>"><?= $row['vencimientoRCTLatam']?></td>
				<?php if( $row['vencimientoRCT']<>''): ?>
					<?php if( $intervaloRCT >0): ?>
						<td class="bg-success text-light"><?= 'Faltan '. abs($intervaloRCT) . ' días' ?></td>
					<?php else: ?>
						<td class="bg-danger text-light"><?= 'Vencido hace '. abs($intervaloRCT) . ' días' ?></td>
					<?php endif; ?>
				<?php else: ?>
					<td></td>
				<?php endif;
				if($_COOKIE['ckPower']==1):
				?>
				<td><button class="btn btn-outline-secondary border-0" onclick="editarSoat(<?= $i?>, <?= $row['idPlaca']?>)"><i class="bi bi-pencil-square"></i></button></td>
				<?php endif; ?>
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}

function reporteAceite($cadena, $esclavo){
	$sql="SELECT masReciente(idPlaca) as idAceite FROM `placas` where placActivo = 1;";
	$resultado = $cadena->query($sql);
	$placas = '';
	while($row = $resultado->fetch_assoc()){
		if($row['idAceite']<>'0') $placas .= $row['idAceite']. ',';
	}
	$placas = substr($placas, 0, -1);
	
	$sqlAceite = "SELECT a.`id`, a.`idPlaca`, a.`fActualizacion`, a.`horometro`, a.`fMantenimiento`, a.`kilometraje`, a.`observacion`, a.`tipo`, registro, p.rango, p.porcentajeAviso, movilidad, placSerie, case a.tipo when 1 then 'km' when 2 then 'horas' end as queTipo, date_format(fActualizacion, '%d/%m/%Y') as fActualizacionLatam, date_format(fMantenimiento, '%d/%m/%Y') as fMantenimientoLatam
	FROM `aceite` a
	inner join placas p on a.idPlaca = p.idPlaca
	where a.id in ({$placas});";
	
	$resultadoAceite = $esclavo->query($sqlAceite);
	
	$i=1;
	$hoy = new DateTime(date('Y-m-d'));
	?>
	<table class="table table-hover">
		<thead>
				<th>N°</th>
				<th>Vehículo - Placa</th>
				<th>Fecha de Actualización KM</th>
				<th>Horómetro / Odómetro actual</th>
				<th>Fecha Último Mantenimiento</th>
				<th>Km / Horo Último Mantenimiento</th>
				<th>Rango de mantenimiento</th>
				<th>Odómetro prox. Mant.</th>
				<th>Km Restantes</th>
				<th>Porcentaje de aviso</th>
				<th>KM antes aviso</th>
				<th>Estado</th>
				<th>Observación</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($rowAceite = $resultadoAceite->fetch_assoc()){
			?>
			<tr>
				<td><?= $i;?></td>
				<td><?= $rowAceite['movilidad'];?> <?= $rowAceite['placSerie'];?></td>
				<td><?= $rowAceite['fActualizacionLatam'];?></td>
				<td><?= $rowAceite['horometro'];?> <?= $rowAceite['queTipo'];?> </td>
				<td><?= $rowAceite['fMantenimientoLatam'];?></td>
				<td><?= $rowAceite['kilometraje'];?> <?= $rowAceite['queTipo'];?> </td>
				<td><?= $rowAceite['rango'];?></td>
				<?php $proximo = $rowAceite['kilometraje'] +$rowAceite['rango']; ?>
				<td><?= $proximo;?></td>
				<?php $restante = $proximo - $rowAceite['horometro'] ;
					if($restante<0): ?>
					<td class="bg-danger text-light"><?= $restante ?> <?= $rowAceite['queTipo'];?></td>
				<?php else: ?>
					<td class="bg-success text-light"><?= $restante ?> <?= $rowAceite['queTipo'];?></td>
				<?php endif;?>
				<td><?= $rowAceite['porcentajeAviso'];?>%</td>
				<?php $aviso = $rowAceite['rango'] * $rowAceite['porcentajeAviso']/100;?>
				<td><?= $aviso ?></td>
				<?php if(  $restante >= $aviso):?>
					<td class="bg-success text-light">Operativo</td>
				<?php else:
					if( $restante < 0 ): ?>
						<td class="bg-danger text-light">Mantenimiento Urgente</td>
					<?php else: ?>
						<td class="bg-warning ">Programar Mantenimiento</td>
				<?php endif;
					endif?>
				
				<td><?= $rowAceite['observacion'];?></td>
				<td>@</td>
				
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}
?>