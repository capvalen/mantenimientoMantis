<?php
include "./../conexion.php";

switch ($_POST['tipo']) {
	case 'soat': reporteSoat($cadena); break;
	case 'aceite': reporteAceite($cadena); break;
	
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
				<th>Fecha Vencimiento RT</th>
				<th>Alerta RT</th>
				<th>Fecha vencimiento RT</th>
				<th>AlertaRCT</th>
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
				<?php endif; ?>
				<td><button class="btn btn-outline-secondary border-0" onclick="editarSoat(<?= $i?>, <?= $row['idPlaca']?>)"><i class="bi bi-pencil-square"></i></button></td>
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}

function reporteAceite($cadena){
	$sql="";
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
				<th>Fecha Vencimiento RT</th>
				<th>Alerta RT</th>
				<th>Fecha vencimiento RT</th>
				<th>AlertaRCT</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($row = $resultado->fetch_assoc()){
				
			?>
			<tr>
				<td><?= $i;?></td>
				
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}
?>