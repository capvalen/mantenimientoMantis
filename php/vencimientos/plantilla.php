<?php
include "./../conexion.php";

switch ($_POST['tipo']) {
	case 'soat': reporteSoat($cadena); break;
	case 'aceite': reporteAceite($cadena); break;
	case 'caja': reporteCaja($cadena, $esclavo); break;
	case 'documentos': reporteDocumentos($cadena, $esclavo); break;
	default:
		break;
}

function reporteSoat($cadena){
	$sql="SELECT *, date_format(vencimientoSoat, '%d/%m/%Y') as vencimientoSoatLatam, date_format(vencimientoRT, '%d/%m/%Y') as vencimientoRTLatam, date_format(vencimientoRCT, '%d/%m/%Y') as vencimientoRCTLatam  FROM placas where placActivo = 1 order by idPlaca;";
	$resultado = $cadena->query($sql); $i=1;
	$hoy = new DateTime(date('Y-m-d'));
	?>
	<div class="table-responsive d-none d-md-block d-print-block">
	<table class="table table-hover">
		<thead class="text-center">
				<th>N°</th>
				<th class="tdPlaca" data-value="-1">Vehículo - Placa</th>
				<th>Año Fab.</th>
				<th>SOAT</th>
				<th>Alerta SOAT</th>
				<th>R. Técnica</th>
				<th>Alerta R. Técnica</th>
				<th>Póliza RCT</th>
				<th>Alerta Póliza RCT</th>
				<th>@</th>
		</thead>
		<tbody>
			<?php
			while($row = $resultado->fetch_assoc()){
				$venceSoat = new DateTime($row['vencimientoSoat'] ?? '' );
				$venceRT = new DateTime($row['vencimientoRT'] ?? '' );
				$venceRCT = new DateTime($row['vencimientoRCT'] ?? '' );

				$intervaloSoat = $hoy->diff($venceSoat)->format('%R%a');
				$intervaloRT = $hoy->diff($venceRT)->format('%R%a');
				$intervaloRCT = $hoy->diff($venceRCT)->format('%R%a');

				$soatColor = '';
				if($row['vencimientoSoat']<>''){
					if($intervaloSoat > 10) $soatColor = 'bg-success text-light';
					elseif($intervaloSoat > 0) $soatColor = 'bg-warning text-light';
					else $soatColor = 'bg-danger text-light';
				}
				$rtColor = '';
				if($row['vencimientoRT']<>''){
					if($intervaloRT > 10) $rtColor = 'bg-success text-light';
					elseif($intervaloRT > 0) $rtColor = 'bg-warning text-light';
					else $rtColor = 'bg-danger text-light';
				}
				$rctColor = '';
				if($row['vencimientoRCT']<>''){
					if($intervaloRCT > 10) $rctColor = 'bg-success text-light';
					elseif($intervaloRCT > 0) $rctColor = 'bg-warning text-light';
					else $rctColor = 'bg-danger text-light';
				}
			?>
			<tr>
				<td><?= $i;?></td>
				<td class="tdPlaca" data-value="<?= $row['placSerie']?>"><?= $row['placSerie']?></td>
				<td><?= $row['ano']?></td>
				<td class="tdSoat text-right" data-value="<?= $row['vencimientoSoat']?>"><?= $row['vencimientoSoatLatam']?></td>
				<?php if( $row['vencimientoSoat']<>''): ?>
					<td class="<?= $soatColor ?>"><?= $intervaloSoat > 0 ? 'Faltan '. abs($intervaloSoat) . ' días' : 'Vencido hace '. abs($intervaloSoat) . ' días' ?></td>
				<?php else: ?>
					<td></td>
				<?php endif; ?>
				<td class="tdRT text-right" data-value="<?= $row['vencimientoRT']?>"><?= $row['vencimientoRTLatam']?></td>
				<?php if( $row['vencimientoRT']<>''): ?>
					<td class="<?= $rtColor ?>"><?= $intervaloRT > 0 ? 'Faltan '. abs($intervaloRT) . ' días' : 'Vencido hace '. abs($intervaloRT) . ' días' ?></td>
				<?php else: ?>
					<td></td>
				<?php endif; ?>
				<td class="tdRCT text-right" data-value="<?= $row['vencimientoRCT']?>"><?= $row['vencimientoRCTLatam']?></td>
				<?php if( $row['vencimientoRCT']<>''): ?>
					<td class="<?= $rctColor ?>"><?= $intervaloRCT > 0 ? 'Faltan '. abs($intervaloRCT) . ' días' : 'Vencido hace '. abs($intervaloRCT) . ' días' ?></td>
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
	</div>
	<div class="row d-md-none cards-container">
		<?php
		$i=1; $resultado = $cadena->query($sql);
		while($row = $resultado->fetch_assoc()){
			$venceSoat = new DateTime($row['vencimientoSoat'] ?? '' );
			$venceRT = new DateTime($row['vencimientoRT'] ?? '' );
			$venceRCT = new DateTime($row['vencimientoRCT'] ?? '' );
			$intervaloSoat = $hoy->diff($venceSoat)->format('%R%a');
			$intervaloRT = $hoy->diff($venceRT)->format('%R%a');
			$intervaloRCT = $hoy->diff($venceRCT)->format('%R%a');

			$soatColor = '';
			$soatTxt = '';
			if($row['vencimientoSoat']<>''){
				if($intervaloSoat > 10){ $soatColor = 'bg-success'; $soatTxt = 'Faltan '.abs($intervaloSoat).' días'; }
				elseif($intervaloSoat > 0){ $soatColor = 'bg-warning'; $soatTxt = 'Faltan '.abs($intervaloSoat).' días'; }
				else{ $soatColor = 'bg-danger'; $soatTxt = 'Vencido hace '.abs($intervaloSoat).' días'; }
			}
			$rtColor = ''; $rtTxt = '';
			if($row['vencimientoRT']<>''){
				if($intervaloRT > 10){ $rtColor = 'bg-success'; $rtTxt = 'Faltan '.abs($intervaloRT).' días'; }
				elseif($intervaloRT > 0){ $rtColor = 'bg-warning'; $rtTxt = 'Faltan '.abs($intervaloRT).' días'; }
				else{ $rtColor = 'bg-danger'; $rtTxt = 'Vencido hace '.abs($intervaloRT).' días'; }
			}
			$rctColor = ''; $rctTxt = '';
			if($row['vencimientoRCT']<>''){
				if($intervaloRCT > 10){ $rctColor = 'bg-success'; $rctTxt = 'Faltan '.abs($intervaloRCT).' días'; }
				elseif($intervaloRCT > 0){ $rctColor = 'bg-warning'; $rctTxt = 'Faltan '.abs($intervaloRCT).' días'; }
				else{ $rctColor = 'bg-danger'; $rctTxt = 'Vencido hace '.abs($intervaloRCT).' días'; }
			}
		?>
		<div class="col-12 col-sm-6 mb-3">
			<div class="card tarjeta-venc h-100" data-placa="<?= $row['placSerie']?>">
				<div class="card-body p-3">
					<div class="d-flex justify-content-between align-items-start">
						<h6 class="card-title mb-0 fw-bold"><?= $row['placSerie']?></h6>
						<small class="text-muted"><?= $row['ano']?></small>
					</div>
					<hr class="my-2">
					<div class="row g-1">
						<div class="col-6">
							<small class="text-secondary">SOAT:</small><br>
							<span><?= $row['vencimientoSoatLatam']?: '-'?></span>
							<?php if($soatTxt): ?>
							<br><span class="badge <?= $soatColor ?> text-light mt-1"><?= $soatTxt ?></span>
							<?php endif; ?>
						</div>
						<div class="col-6">
							<small class="text-secondary">R. Técnica:</small><br>
							<span><?= $row['vencimientoRTLatam']?: '-'?></span>
							<?php if($rtTxt): ?>
							<br><span class="badge <?= $rtColor ?> text-light mt-1"><?= $rtTxt ?></span>
							<?php endif; ?>
						</div>
						<div class="col-12 mt-1">
							<small class="text-secondary">Póliza RCT:</small><br>
							<span><?= $row['vencimientoRCTLatam']?: '-'?></span>
							<?php if($rctTxt): ?>
							<br><span class="badge <?= $rctColor ?> text-light mt-1"><?= $rctTxt ?></span>
							<?php endif; ?>
						</div>
					</div>
					<?php if($_COOKIE['ckPower']==1): ?>
					<hr class="my-2">
					<button class="btn btn-outline-secondary btn-sm w-100" onclick="editarSoat(<?= $i?>, <?= $row['idPlaca']?>)"><i class="bi bi-pencil-square"></i> Editar vencimientos</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php $i++; } ?>
	</div>
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
	where a.id in ({$placas}) and p.placActivo=1
	order by p.idPlaca asc;";

	$resultadoAceite = $cadena->query($sqlAceite);

	$i=1;
	?>
	<div class="table-responsive d-none d-md-block d-print-block">
	<table class="table table-hover">
		<thead class="text-center">
				<th>N°</th>
				<th class="tdPlaca" data-value="-1">Vehículo - Placa</th>
				<th>Estado</th>
				<th>Fecha de Actualización KM</th>
				<th>Horómetro/ Odómetro actual</th>
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
				$estadoTxt = 'Operativo';
				if ( $restante >= $aviso ){
					$color='';
				}else{
					if($restante<10){
						$color='bg-danger text-light';
						$estadoTxt = 'Mantenimiento Urgente';
					}
					else{
						$color='bg-warning';
						$estadoTxt = 'Programar Mantenimiento';
					}
				}
			?>
			<tr class="<?= $color;?>" id="<?= $rowAceite['idPlaca'] ?>">
				<td><?= $i;?></td>
				<td class="tdPlaca" data-value="<?= $rowAceite['placSerie']?>" style="white-space:nowrap"> <?= $rowAceite['placSerie'];?></td>
				<?php if(  $restante >= $aviso):?>
					<td class="bg-success text-light">Operativo</td>
				<?php else:
					if( $restante < 10 ): ?>
						<td class="bg-danger text-light" style="white-space:nowrap">Mantenimiento Urgente</td>
					<?php else: ?>
						<td class="bg-warning " style="white-space:nowrap">Programar Mantenimiento</td>
				<?php endif;
					endif?>
				<td class="tdFecha1" data-value="<?= $rowAceite['fActualizacion'];?>"><?= $rowAceite['fActualizacionLatam'];?></td>
				<td class="tdHorometro" data-value="<?= $rowAceite['horometro'];?>"><?= number_format($rowAceite['horometro']);?> <?= $rowAceite['queTipo'];?> </td>
				<td class="tdFecha2" data-value="<?= $rowAceite['fMantenimiento'];?>"><?= $rowAceite['fMantenimientoLatam'];?></td>
				<td class="tdActual" data-value="<?= $rowAceite['kilometraje'];?>" style="white-space:nowrap"><?= number_format($rowAceite['kilometraje']);?> <?= $rowAceite['queTipo'];?> </td>
				<td style="white-space:nowrap"><?= number_format($rowAceite['rango']);?> <?= $rowAceite['queTipo'];?></td>
				<td style="white-space:nowrap"><?= number_format($proximo);?> <?= $rowAceite['queTipo'];?></td>
				<td class="<?= $color==''? 'bg-success': '';?>" ><?= number_format($restante) ?> <?= $rowAceite['queTipo'];?></td>
				<td><?= $rowAceite['porcentajeAviso'];?>%</td>
				<td><?= number_format($aviso) ?></td>
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
	</div>
	<div class="row d-md-none cards-container">
		<?php
		$resultadoAceite = $cadena->query($sqlAceite);
		while($rowAceite = $resultadoAceite->fetch_assoc()){
			$proximo = $rowAceite['kilometraje'] +$rowAceite['rango'];
			$restante = $proximo - $rowAceite['horometro'] ;
			$aviso = $rowAceite['rango'] * $rowAceite['porcentajeAviso']/100;
			$estadoColor = 'bg-success';
			$estadoTxt = 'Operativo';
			$cardColor = '';
			if ( $restante >= $aviso ){
				$estadoColor = 'bg-success';
			}else{
				if($restante<10){
					$estadoColor = 'bg-danger';
					$estadoTxt = 'Mantenimiento Urgente';
					$cardColor = 'border-danger';
				}else{
					$estadoColor = 'bg-warning';
					$estadoTxt = 'Programar Mantenimiento';
					$cardColor = 'border-warning';
				}
			}
		?>
		<div class="col-12 col-sm-6 mb-3">
			<div class="card tarjeta-venc h-100 <?= $cardColor ?>" data-placa="<?= $rowAceite['placSerie']?>" data-estado="<?= $estadoTxt ?>">
				<div class="card-body p-3">
					<div class="d-flex justify-content-between align-items-start">
						<h6 class="card-title mb-0 fw-bold"><?= $rowAceite['placSerie']?></h6>
						<span class="badge <?= $estadoColor ?> text-light"><?= $estadoTxt ?></span>
					</div>
					<hr class="my-2">
					<div class="row g-1">
						<div class="col-6"><small class="text-secondary">Fecha Actualización:</small><br><?= $rowAceite['fActualizacionLatam']?></div>
						<div class="col-6"><small class="text-secondary">Horómetro actual:</small><br><?= number_format($rowAceite['horometro'])?> <?= $rowAceite['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Último Mant.:</small><br><?= $rowAceite['fMantenimientoLatam']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Km Último Mant.:</small><br><?= number_format($rowAceite['kilometraje'])?> <?= $rowAceite['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Rango:</small><br><?= number_format($rowAceite['rango'])?> <?= $rowAceite['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Próx. Mant.:</small><br><?= number_format($proximo)?> <?= $rowAceite['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Km Restantes:</small><br><span class="fw-bold <?= $cardColor ? 'text-'.($cardColor=='border-danger'?'danger':'warning') : 'text-success' ?>"><?= number_format($restante)?> <?= $rowAceite['queTipo']?></span></div>
						<div class="col-6 mt-1"><small class="text-secondary">Aviso:</small><br><?= $rowAceite['porcentajeAviso']?>% (<?= number_format($aviso)?>)</div>
						<?php if($rowAceite['observacion']): ?>
						<div class="col-12 mt-1"><small class="text-secondary">Observación:</small><br><?= $rowAceite['observacion']?></div>
						<?php endif; ?>
					</div>
					<?php if( isset($_COOKIE['ckPower']) && $_COOKIE['ckPower']==1): ?>
					<hr class="my-2">
					<div class="row g-1">
						<div class="col-6"><button class="btn btn-outline-primary btn-sm w-100" onclick="abrirModalInsertarMantenimiento('actualizacion', <?= $rowAceite['idPlaca']?>)"><i class="bi bi-plus"></i> Actualización</button></div>
						<div class="col-6"><button class="btn btn-outline-success btn-sm w-100" onclick="abrirModalInsertarMantenimiento('mantenimiento', <?= $rowAceite['idPlaca']?>)"><i class="bi bi-plus"></i> Mantenimiento</button></div>
					</div>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php
}

function reporteCaja($cadena, $esclavo){
	$sql="SELECT a.idPlaca from  `aceite` a
	inner join placas p on p.idPlaca = a.idPlaca
	where p.placActivo = 1
	group by idPlaca
	order by p.idPlaca asc;";
	$resultado = $cadena->query($sql);
	$placas = '';
	$jPlacas = [];
	$resultados = [];
	$fila = [];
	while($row = $resultado->fetch_assoc()){
		if($row['idPlaca']<>'0'){
			$placas .= $row['idPlaca']. ',';
			$jPlacas[] = [
				'idPlaca' => $row['idPlaca'],
				'resultados' => []
			];
		}
	}
	$placas = substr($placas, 0, -1);

	foreach($jPlacas as $key=> $placa){
		$sqlCaja = "SELECT a.idPlaca, a.`fActualizacion`, horometroAnterior(a.idPlaca) as horometroAnterior,p.rango2, p.porcentajeAviso2, movilidad, placSerie, case queKilo(a.idPlaca) when 1 then 'km' when 2 then 'horas' end as queTipo, fechaAnterior(a.idPlaca) as fechaAnterior, queKilo(a.idPlaca) as `tipo`, horometroRecienteCaja(a.idPlaca) as horometroReciente, fechaRecienteCaja(a.idPlaca) as fechaReciente, observacionRecienteCaja(a.idPlaca) as observacionReciente FROM placas p join aceite a on a.idPlaca = p.idPlaca where a.idPlaca in ({$placa['idPlaca']}) group by a.idPlaca order by p.idPlaca asc;";
		if($resultadoAceite = $esclavo->query($sqlCaja)){
			while ($fila = $resultadoAceite->fetch_assoc()) {
				$resultados [] = $fila;
			}
		}
	}

	$i=1;
	?>
	<div class="table-responsive d-none d-md-block d-print-block">
	<table class="table table-hover">
		<thead class="text-center">
				<th>N°</th>
				<th class="tdPlaca" data-value="-1">Vehículo - Placa</th>
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
			foreach( $resultados as $rowCaja ){
				$fUltimaCaja =new DateTime($rowCaja['fechaReciente']);
				$fAnterior =new DateTime($rowCaja['fechaAnterior']);
				$proximo = $rowCaja['horometroReciente'] +$rowCaja['rango2'];
				$restante = $proximo - $rowCaja['horometroAnterior'] ;
				$aviso = $rowCaja['rango2'] * $rowCaja['porcentajeAviso2']/100;
				$color='';
				$estadoTxt = 'Operativo';
				if ( $restante >= $aviso ){
					$color='';
				}else{
					if($restante<0){
						$color='bg-danger text-light';
						$estadoTxt = 'Mantenimiento Urgente';
					}else{
						$color='bg-warning';
						$estadoTxt = 'Programar Mantenimiento';
					}
				}
			?>
			<tr class="<?= $color;?>" id="<?= $rowCaja['idPlaca'] ?>">
				<td><?= $i;?></td>
				<td class="tdPlaca" data-value="<?= $rowCaja['placSerie']?>" style="white-space:nowrap"> <?= $rowCaja['placSerie'];?></td>
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
				<td style="white-space:nowrap"><?= number_format($rowCaja['rango2']);?> <?= $rowCaja['queTipo'];?></td>
				<td style="white-space:nowrap"><?= number_format($proximo);?> <?= $rowCaja['queTipo'];?></td>
				<td class="<?= $color==''? 'bg-success': '';?>" style="white-space:nowrap"><?= number_format($restante) ?> <?= $rowCaja['queTipo'];?></td>
				<td ><?= $rowCaja['porcentajeAviso2'];?>%</td>
				<td ><?= number_format($aviso);?></td>
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
	</div>
	<div class="row d-md-none cards-container">
		<?php
		foreach( $resultados as $rowCaja ){
			$fUltimaCaja =new DateTime($rowCaja['fechaReciente']);
			$fAnterior =new DateTime($rowCaja['fechaAnterior']);
			$proximo = $rowCaja['horometroReciente'] +$rowCaja['rango2'];
			$restante = $proximo - $rowCaja['horometroAnterior'] ;
			$aviso = $rowCaja['rango2'] * $rowCaja['porcentajeAviso2']/100;
			$estadoColor = 'bg-success';
			$estadoTxt = 'Operativo';
			$cardColor = '';
			if ( $restante >= $aviso ){
				$estadoColor = 'bg-success';
			}else{
				if($restante<0){
					$estadoColor = 'bg-danger';
					$estadoTxt = 'Mantenimiento Urgente';
					$cardColor = 'border-danger';
				}else{
					$estadoColor = 'bg-warning';
					$estadoTxt = 'Programar Mantenimiento';
					$cardColor = 'border-warning';
				}
			}
		?>
		<div class="col-12 col-sm-6 mb-3">
			<div class="card tarjeta-venc h-100 <?= $cardColor ?>" data-placa="<?= $rowCaja['placSerie']?>" data-estado="<?= $estadoTxt ?>">
				<div class="card-body p-3">
					<div class="d-flex justify-content-between align-items-start">
						<h6 class="card-title mb-0 fw-bold"><?= $rowCaja['placSerie']?></h6>
						<span class="badge <?= $estadoColor ?> text-light"><?= $estadoTxt ?></span>
					</div>
					<hr class="my-2">
					<div class="row g-1">
						<div class="col-6"><small class="text-secondary">Fecha Actualización:</small><br><?= $fAnterior->format('d/m/Y')?></div>
						<div class="col-6"><small class="text-secondary">Horómetro actual:</small><br><?= number_format($rowCaja['horometroAnterior'])?> <?= $rowCaja['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Último Cambio:</small><br><?= $fUltimaCaja->format('d/m/Y')?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Km Último Cambio:</small><br><?= number_format($rowCaja['horometroReciente'])?> <?= $rowCaja['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Rango:</small><br><?= number_format($rowCaja['rango2'])?> <?= $rowCaja['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Próx. Mant.:</small><br><?= number_format($proximo)?> <?= $rowCaja['queTipo']?></div>
						<div class="col-6 mt-1"><small class="text-secondary">Km Restantes:</small><br><span class="fw-bold <?= $cardColor ? 'text-'.($cardColor=='border-danger'?'danger':'warning') : 'text-success' ?>"><?= number_format($restante)?> <?= $rowCaja['queTipo']?></span></div>
						<div class="col-6 mt-1"><small class="text-secondary">Aviso:</small><br><?= $rowCaja['porcentajeAviso2']?>% (<?= number_format($aviso)?>)</div>
						<?php if($rowCaja['observacionReciente']): ?>
						<div class="col-12 mt-1"><small class="text-secondary">Observación:</small><br><?= $rowCaja['observacionReciente']?></div>
						<?php endif; ?>
					</div>
					<?php if($_COOKIE['ckPower']==1): ?>
					<hr class="my-2">
					<button class="btn btn-outline-primary btn-sm w-100" onclick="abrirModalInsertarCaja(<?= $rowCaja['idPlaca']?>)"><i class="bi bi-plus"></i> Actualización</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php
}

function reporteDocumentos($cadena, $esclavo){
	$sql = "SELECT p.idPlaca, p.movilidad, p.placSerie
		FROM `placas` p where p.placActivo = 1
		order by p.idPlaca asc;";
	$resultado = $cadena->query($sql); $i=1;
	$tiposDB = ['SOAT', 'Revisión', 'Póliza', 'Tarjeta'];
	?>
	<div class="table-responsive d-none d-md-block d-print-block">
	<table class="table table-hover table-bordered">
		<thead class="text-center">
				<th>N°</th>
				<th class="tdPlaca" data-value="-1">Vehículo - Placa</th>
				<th>SOAT</th>
				<th>Revisión técnica</th>
				<th>Póliza</th>
				<th>Tarjeta de propiedad</th>
		</thead>
		<tbody>
			<?php
			while($row = $resultado->fetch_assoc()){
				$archivos = $esclavo->query("SELECT
						idPlaca,
						MAX(CASE WHEN tipo = 'SOAT' THEN ruta ELSE NULL END) AS 'SOAT',
						MAX(CASE WHEN tipo = 'Revisión' THEN ruta ELSE NULL END) AS 'Revisión',
						MAX(CASE WHEN tipo = 'Póliza' THEN ruta ELSE NULL END) AS 'Póliza',
						MAX(CASE WHEN tipo = 'Tarjeta' THEN ruta ELSE NULL END) AS 'Tarjeta'
				FROM (
						SELECT
								a.*,
								ROW_NUMBER() OVER (PARTITION BY tipo ORDER BY id DESC) AS row_num
						FROM archivos a
						WHERE idPlaca = {$row['idPlaca']} AND activo = 1
				) AS RankedArchivos
				WHERE row_num = 1
				GROUP BY idPlaca;");

				$rowArch = $archivos->fetch_assoc();
			?>
			<tr>
				<td><?= $i;?></td>
				<td class="tdPlaca" data-value="<?= $row['placSerie']?>"><?= $row['placSerie']?></td>
				<?php foreach($tiposDB as $tipo):
					$ruta = $rowArch ? $rowArch[$tipo] : null;
				?>
					<td class="text-center td-documento">
						<div class="d-flex gap-1 align-items-center justify-content-center td-documento-wrap">
							<?php if($ruta): ?>
							<a class="btn btn-sm btn-outline-secondary" href="archivos/<?= $ruta ?>" download title="Descargar">
								<i class="bi bi-box-arrow-in-down"></i> Descargar
							</a>
							<?php if($_COOKIE['ckPower']==1): ?>
							<button class="btn btn-sm btn-outline-danger btn-eliminar" onclick="eliminarDocumento(this, <?= $row['idPlaca'] ?>, '<?= $tipo ?>')" title="Eliminar archivo">
								<i class="bi bi-x-lg"></i>
							</button>
							<?php endif; ?>
							<?php endif; ?>
							<?php if($_COOKIE['ckPower']==1): ?>
							<button class="btn btn-sm btn-outline-primary btn-upload" onclick="subirDocumento(this, <?= $row['idPlaca'] ?>, '<?= $tipo ?>')" title="Subir archivo">
								<i class="bi bi-upload"></i> Adjuntar
							</button>
							<?php endif; ?>
						</div>
					</td>
				<?php endforeach; ?>
			</tr>
			<?php
			$i++; }
			?>
		</tbody>
	</table>
	</div>
	<div class="row d-md-none cards-container">
		<?php
		$resultado = $cadena->query($sql); $i=1;
		$tiposLabel = ['SOAT'=>'SOAT', 'Revisión'=>'Revisión Técnica', 'Póliza'=>'Póliza', 'Tarjeta'=>'Tarjeta Propiedad'];
		while($row = $resultado->fetch_assoc()){
			$archivos = $esclavo->query("SELECT
					idPlaca,
					MAX(CASE WHEN tipo = 'SOAT' THEN ruta ELSE NULL END) AS 'SOAT',
					MAX(CASE WHEN tipo = 'Revisión' THEN ruta ELSE NULL END) AS 'Revisión',
					MAX(CASE WHEN tipo = 'Póliza' THEN ruta ELSE NULL END) AS 'Póliza',
					MAX(CASE WHEN tipo = 'Tarjeta' THEN ruta ELSE NULL END) AS 'Tarjeta'
			FROM (
					SELECT
							a.*,
							ROW_NUMBER() OVER (PARTITION BY tipo ORDER BY id DESC) AS row_num
					FROM archivos a
					WHERE idPlaca = {$row['idPlaca']} AND activo = 1
			) AS RankedArchivos
			WHERE row_num = 1
			GROUP BY idPlaca;");

			$rowArch = $archivos->fetch_assoc();
		?>
		<div class="col-12 col-sm-6 mb-3">
			<div class="card tarjeta-venc h-100" data-placa="<?= $row['placSerie']?>">
				<div class="card-body p-3">
					<h6 class="card-title fw-bold"><?= $row['placSerie']?></h6>
					<hr class="my-2">
					<div class="row g-1">
						<?php
						foreach($tiposLabel as $key=>$label):
							$ruta = $rowArch ? $rowArch[$key] : null;
						?>
							<div class="col-6 mt-1">
								<small class="text-secondary"><?= $label ?>:</small><br>
								<div class="d-flex gap-1">
									<?php if($ruta): ?>
									<a class="btn btn-outline-secondary btn-sm flex-grow-1" href="archivos/<?= $ruta ?>" download>
										<i class="bi bi-box-arrow-in-down"></i> Descargar
									</a>
									<?php if($_COOKIE['ckPower']==1): ?>
									<button class="btn btn-outline-danger btn-sm btn-eliminar" onclick="eliminarDocumento(this, <?= $row['idPlaca'] ?>, '<?= $key ?>')" title="Eliminar archivo">
										<i class="bi bi-x-lg"></i>
									</button>
									<?php endif; ?>
									<?php endif; ?>
									<?php if($_COOKIE['ckPower']==1): ?>
									<button class="btn btn-outline-primary btn-sm btn-upload" onclick="subirDocumento(this, <?= $row['idPlaca'] ?>, '<?= $key ?>')" title="Subir archivo">
										<i class="bi bi-upload"></i> Adjuntar
									</button>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php
}
?>
