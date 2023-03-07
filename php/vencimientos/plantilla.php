<?php
include "./../conexion.php";

switch ($_POST['tipo']) {
	case 'soat': reporteSoat($cadena); break;
	case 'aceite': reporteAceite($cadena); break;
	case 'caja': reporteCaja($cadena, $esclavo); break;
	
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
					<?php if( $intervaloSoat >5): ?>
						<td class="bg-success text-light"><?= 'Faltan '. abs($intervaloSoat) . ' días' ?></td>
					<?php elseif($intervaloSoat>0): ?>
						<td class="bg-warning text-light"><?= 'Faltan '. abs($intervaloSoat) . ' días' ?></td>
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

function reporteAceite($cadena){
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
	where a.id in ({$placas}) and p.placActivo=1;";
	
	$resultadoAceite = $cadena->query($sqlAceite);
	
	$i=1;
	?>
	<!-- <div class="row d-none">
		<div class="col">
			<button class="btn btn-secondary" onclick="abrirModalInsertarMantenimiento('actualizacion')">Agregar Actualización KM</button>
			<button class="btn btn-secondary" onclick="abrirModalInsertarMantenimiento('mantenimiento')">Agregar Mantenimiento KM/Hora</button>
		</div>
	</div> -->
	<table class="table table-hover">
		<thead>
				<th>N°</th>
				<th>Vehículo - Placa</th>
				<th>Estado</th>
				<th>Fecha de Actualización KM</th>
				<th>Horómetro / Odómetro actual</th>
				<th>Fecha Último Mantenimiento</th>
				<th>Km / Horo Último Mantenimiento</th>
				<th>Rango de mantenimiento</th>
				<th>Odómetro prox. Mant.</th>
				<th>Km Restantes</th>
				<th>Porcentaje de aviso</th>
				<th>KM antes aviso</th>
				<th>Observación</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($rowAceite = $resultadoAceite->fetch_assoc()){
				$proximo = $rowAceite['kilometraje'] +$rowAceite['rango'];
				$restante = $proximo - $rowAceite['horometro'] ;
				$aviso = $rowAceite['rango'] * $rowAceite['porcentajeAviso']/100;
				$color='';
				if ( $restante >= $aviso ){
					$color='';
				}else{
					if($restante<0){
						$color='bg-danger text-light';
					}else{
						$color='bg-warning';
					}
				}
			?>
			<tr class="<?= $color;?>" id="<?= $rowAceite['idPlaca'] ?>">
				<td><?= $i;?></td>
				<td style="white-space:nowrap"> <?= $rowAceite['placSerie'];?></td>
				<?php if(  $restante >= $aviso):?>
					<td class="bg-success text-light">Operativo</td>
				<?php else:
					if( $restante < 0 ): ?>
						<td class="bg-danger text-light" style="white-space:nowrap">Mantenimiento Urgente</td>
					<?php else: ?>
						<td class="bg-warning " style="white-space:nowrap">Programar Mantenimiento</td>
				<?php endif;
					endif?>
				<td class="tdFecha1" data-value="<?= $rowAceite['fActualizacion'];?>"><?= $rowAceite['fActualizacionLatam'];?></td>
				<td class="tdHorometro" data-value="<?= $rowAceite['horometro'];?>"><?= number_format($rowAceite['horometro']);?> <?= $rowAceite['queTipo'];?> </td>
				<td class="tdFecha2" data-value="<?= $rowAceite['fMantenimiento'];?>"><?= $rowAceite['fMantenimientoLatam'];?></td>
				<td class="tdActual" data-value="<?= $rowAceite['kilometraje'];?>"><?= number_format($rowAceite['kilometraje']);?> <?= $rowAceite['queTipo'];?> </td>
				<td><?= $rowAceite['rango'];?></td>
				<td><?= number_format($proximo);?></td>
				<?php 
					if($color<>''):?>
						<td class=""><?= number_format($restante) ?> <?= $rowAceite['queTipo'];?></td>
					<?php
					elseif($restante<0): ?>
					<td class="bg-danger text-light"><?= number_format($restante) ?> <?= $rowAceite['queTipo'];?></td>
				<?php else: ?>
					<td class="bg-success text-light"><?= number_format($restante) ?> <?= $rowAceite['queTipo'];?></td>
				<?php endif;?>
				<td><?= $rowAceite['porcentajeAviso'];?>%</td>
				<td><?= $aviso ?></td>
				<td style="white-space:nowrap"><?= $rowAceite['observacion'];?></td>
				<td style="white-space:nowrap">
				<?php if($_COOKIE['ckPower']==1): ?>
					<button class="btn btn-outline-primary mx-1" onclick="abrirModalInsertarMantenimiento('actualizacion', <?= $rowAceite['idPlaca']?>)"><i class="bi bi-plus"></i> Actualización</button>
					<button class="btn btn-outline-success mx-1" onclick="abrirModalInsertarMantenimiento('mantenimiento', <?= $rowAceite['idPlaca']?>)"><i class="bi bi-plus"></i> Mantenimiento</button>
					<?php endif; ?>
				</td>
				
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}
function reporteCaja($cadena, $esclavo){
	$sql="SELECT a.idPlaca from  `aceite` a
	inner join placas p on p.idPlaca = a.idPlaca
	where p.placActivo = 1
	group by idPlaca";
	$resultado = $cadena->query($sql);
	$placas = '';
	while($row = $resultado->fetch_assoc()){
		if($row['idPlaca']<>'0') $placas .= $row['idPlaca']. ',';
	}
	$placas = substr($placas, 0, -1);
	//echo $placas; die();


	/* $sqlCaja="SELECT masRecienteCaja(idPlaca) as idCaja FROM `placas` where placActivo = 1;";
	$resultadoCaja = $esclavo->query($sqlCaja);
	$placasCaja = '';
	while($rowCaja = $resultadoCaja->fetch_assoc()){
		if($rowCaja['idCaja']<>'0') $placasCaja .= $rowCaja['idCaja']. ',';
	}
	$placasCaja = substr($placasCaja, 0, -1);
	echo $placasCaja; */
	
	// fechaRecienteCaja(c.idPlaca) as fechaRecienteCaja, horometroRecienteCaja(c.idPlaca) as horometroRecienteCaja
	
	/*SELECT c.`id`, c.`idPlaca`, c.`observacion`,  c.registro, c.fActualizacion as fechaRecienteCaja, c.horometro as horometroRecienteCaja,
	subQuery.fActualizacion, subQuery.horometro, rango2, fActualizacionLatam, placSerie
	from caja c, 
	( 
		SELECT  a.`fActualizacion`, a.`horometro`,p.rango2, p.porcentajeAviso2, movilidad, placSerie, case a.tipo when 1 then 'km' when 2 then 'horas' end as queTipo, date_format(a.fActualizacion, '%d/%m/%Y') as fActualizacionLatam, a.`tipo`
		FROM placas p
		join aceite a on a.idPlaca = p.idPlaca where a.idPlaca in ($placas) order by a.registro desc limit 1
	) as subQuery
	order by c.registro desc limit 1;*/
	$sqlCaja = "SELECT a.idPlaca, a.`fActualizacion`, horometroAnterior(a.idPlaca) as horometroAnterior,p.rango2, p.porcentajeAviso2, movilidad, placSerie, case queKilo(a.idPlaca) when 1 then 'km' when 2 then 'horas' end as queTipo, fechaAnterior(a.idPlaca) as fechaAnterior, queKilo(a.idPlaca) as `tipo`, horometroRecienteCaja(a.idPlaca) as horometroReciente, fechaRecienteCaja(a.idPlaca) as fechaReciente, observacionRecienteCaja(a.idPlaca) as observacionReciente FROM placas p join aceite a on a.idPlaca = p.idPlaca where a.idPlaca in ({$placas}) group by a.idPlaca;";
	//echo $sqlCaja;die();
	
	$resultadoAceite = $cadena->query($sqlCaja);
	
	$i=1;
	?>
	<div class="row d-none">
		<div class="col">
			<button class="btn btn-secondary" onclick="abrirModalInsertarMantenimiento('actualizacion')">Agregar Actualización KM</button>
			<button class="btn btn-secondary" onclick="abrirModalInsertarMantenimiento('mantenimiento')">Agregar Mantenimiento KM/Hora</button>
		</div>
	</div>
	<table class="table table-hover">
		<thead>
				<th>N°</th>
				<th>Vehículo - Placa</th>
				<th>Estado</th>
				<th>Fecha de Actualización KM</th>
				<th>Horómetro / Odómetro actual</th>
				<th>Fecha Último Aceite Caja y Corona</th>
				<th>Km / Horo Último Mantenimiento</th>
				<th>Rango de mantenimiento</th>
				<th>Odómetro prox. Mant.</th>
				<th>Km Restantes</th>
				<th>Porcentaje de aviso</th>
				<th>KM antes aviso</th>
				<th>Observación</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($rowCaja = $resultadoAceite->fetch_assoc()){
				$fUltimaCaja =new DateTime($rowCaja['fechaReciente']);
				$fAnterior =new DateTime($rowCaja['fechaAnterior']);
				$proximo = $rowCaja['horometroReciente'] +$rowCaja['rango2'];
				$restante = $proximo - $rowCaja['horometroAnterior'] ;
				$aviso = $rowCaja['rango2'] * $rowCaja['porcentajeAviso2']/100;
				$color='';
				if ( $restante >= $aviso ){
					$color='';
				}else{
					if($restante<0){
						$color='bg-danger text-light';
					}else{
						$color='bg-warning';
					}
				}
			?>
			<tr class="<?= $color;?>" id="<?= $rowCaja['idPlaca'] ?>">
				<td><?= $i;?></td>
				<td style="white-space:nowrap"> <?= $rowCaja['placSerie'];?></td>
				<?php if(  $restante >= $aviso):?>
					<td class="bg-success text-light">Operativo</td>
				<?php else:
					if( $restante < 0 ): ?>
						<td class="bg-danger text-light" style="white-space:nowrap">Mantenimiento Urgente</td>
					<?php else: ?>
						<td class="bg-warning " style="white-space:nowrap">Programar Mantenimiento</td>
				<?php endif;
					endif?>
				<td ><?= $fAnterior->format('d/m/Y');?></td>
				<td ><?= number_format($rowCaja['horometroAnterior']);?> <?= $rowCaja['queTipo'];?></td>
				<td ><?= $fUltimaCaja->format('d/m/Y');?></td>
				<td ><?= number_format($rowCaja['horometroReciente']);?> <?= $rowCaja['queTipo'];?></td>
				<td ><?= $rowCaja['rango2'];?></td>
				<td style="white-space:nowrap"><?= number_format($proximo);?> <?= $rowCaja['queTipo'];?></td>
				<?php 
					if($restante<0): ?>
					<td class="bg-danger text-light" style="white-space:nowrap"><?= number_format($restante) ?> <?= $rowCaja['queTipo'];?></td>
				<?php else: ?>
					<td class="bg-success text-light" style="white-space:nowrap"><?= number_format($restante) ?> <?= $rowCaja['queTipo'];?></td>
				<?php endif;?>
				<td ><?= $rowCaja['porcentajeAviso2'];?></td>
				<td ><?= $aviso;?></td>

				<td style="white-space:nowrap"><?= $rowCaja['observacionReciente'];?></td>
				<td style="white-space:nowrap">
				<?php if($_COOKIE['ckPower']==1): ?>
					<button class="btn btn-outline-primary mx-1" onclick="abrirModalInsertarCaja(<?= $rowCaja['idPlaca']?>)"><i class="bi bi-plus"></i> Actualización</button>
				<?php endif; ?>
				</td>
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	<?php
}
?>