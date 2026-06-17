<?php
if( !isset($_COOKIE['ckPower']) ) {
	header("Location: index.html");
	exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Vencimientos - Transportes y Contratistas JKM SRL</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
</head>
<body>

<?php include 'menu.php';?>
<section>
	<div class="container-fluid row py-2">
		<div class="order-0 order-md-0 col-6 col-md-3 text-center">
			<img src="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/logo-transportes.png" class="img-fluid"></div>
		<div class="order-2 order-md-1 col-12 col-md-6">
			<h3 class="text-center ">Registro de fechas de vencimiento</h3>
			<div class="input-group mb-3 d-print-none">
				<input type="text" class="form-control" placeholder="Buscar por placa" id="txtBuscarPlaca">
				<button class="btn btn-outline-secondary" type="button" onclick="buscarPlaca()" ><i class="bi bi-search"></i></button>
				<button class="btn btn-outline-secondary" type="button" onclick="limbiarBusqueda()" ><i class="bi bi-eraser"></i></button>
			</div>
		</div>
		
	</div>
</section>

<section class="container-fluid">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('soat')">
			<button class="nav-link active" id="soat-tab" data-bs-toggle="tab" data-bs-target="#soat" type="button" role="tab" aria-controls="soat" aria-selected="true">SOAT</button>
		</li>
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('aceite')">
			<button class="nav-link" id="aceite-tab" data-bs-toggle="tab" data-bs-target="#aceite" type="button" role="tab" aria-controls="aceite" aria-selected="false">Aceite y Filtros</button>
		</li>
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('caja')">
			<button class="nav-link" id="caja-tab" data-bs-toggle="tab" data-bs-target="#caja" type="button" role="tab" aria-controls="caja" aria-selected="false">Caja y Corona</button>
		</li>
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('documentos')">
			<button class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab" aria-controls="documentos" aria-selected="false">Documentos</button>
		</li>
	</ul>
</section>

<section class="container-fluid">
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="soat" role="tabpanel" aria-labelledby="soat-tab">
			<div class="resultado"></div>
		</div>
		<div class="tab-pane fade" id="aceite" role="tabpanel" aria-labelledby="aceite-tab">
			<div class="card my-3 d-print-none">
				<div class="card-body">
					<label for=""><i class="bi bi-funnel"></i> Filtros</label>
					<button class="btn btn-sm btn-outline-success btnFiltros my-1" onclick="activarFiltro('operativo')">Operativo</button>
					<button class="btn btn-sm btn-outline-warning btnFiltros my-1" onclick="activarFiltro('programar')">Programar mantenimiento</button>
					<button class="btn btn-sm btn-outline-danger btnFiltros my-1" onclick="activarFiltro('mantenimiento')">Mantenimiento urgente</button>
					<button class="btn btn-sm btn-outline-primary btnFiltros my-1" onclick="activarFiltro('pendiente')">Pendiente Actualizar Km/Hora</button>
					<button class="btn btn-sm btn-outline-secondary btnFiltros my-1" onclick="activarFiltro('limpiar')" title="Limpiar filtro"><i class="bi bi-eraser"></i></button>
				</div>
			</div>
			<div class="resultado"></div>
		</div>
		<div class="tab-pane fade" id="caja" role="tabpanel" aria-labelledby="caja-tab">
		<div class="card my-3 d-print-none">
				<div class="card-body">
					<label for=""><i class="bi bi-funnel"></i> Filtros</label>
					<button class="btn btn-sm btn-outline-success btnFiltros" onclick="activarFiltroFiltro('operativo')">Operativo</button>
					<button class="btn btn-sm btn-outline-warning btnFiltros" onclick="activarFiltroFiltro('programar')">Programar mantenimiento</button>
					<button class="btn btn-sm btn-outline-danger btnFiltros" onclick="activarFiltroFiltro('mantenimiento')">Mantenimiento urgente</button>
					<button class="btn btn-sm btn-outline-secondary btnFiltros" onclick="activarFiltroFiltro('limpiar')" title="Limpiar filtro"><i class="bi bi-eraser"></i></button>
				</div>
			</div>
			<div class="resultado">
				<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> Cargando datos
			</div>
		</div>
		<div class="tab-pane fade" id="documentos" role="tabpanel" aria-labelledby="caja-tab">
			<div class="card my-3 d-print-none">
				<div class="card-body">
					<div class="resultado"></div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal para adjuntar la foto -->
<div class="modal fade" id="modalEditarSoat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="exampleModalLabel">Edición de la placa: <span id="fPlaca"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Puede editar los siguientes campos</p>
				<label for="">Fecha de vencimiento de Soat:</label>
				<input type="date" class="form-control" id="txtSoat">
				<label for="" class="mt-2">Fecha de vencimiento de RT:</label>
				<input type="date" class="form-control" id="txtRT">
				<label for="" class="mt-2">Fecha de vencimiento de RCT:</label>
				<input type="date" class="form-control" id="txtRCT">
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary d-print-none" onclick="updateVencimiento()" data-bs-dismiss="modal">Actualizar vencimientos</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal para: Insertar Hodometro -->
<div class="modal fade" id="modalInsertarHodometro" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Insertar Mantenimiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row mb-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Placa:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltPlacaHoroEdit" title="Placas disponibles" >
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row mb-3 grupoHoro">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaHoroEdit">
					</div>
				</div>
				<div class="form-group row mb-3 grupoHoro">
					<label for="staticEmail" class="col-sm-4 col-form-label">Horómetro / Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtHoroEdit">
					</div>
				</div>
				<div class="form-group row mb-3 grupoActual">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaActualEdit">
					</div>
				</div>
				<div class="form-group row mb-3 grupoActual">
					<label for="staticEmail" class="col-sm-4 col-form-label">Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtOdoAntEdit">
					</div>
				</div>
				<div class="form-group row mb-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Tipo:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltTipo1" title="Tipo" >
						<option value="1" selected>K.m.</option>
						<option value="2">Horas</option>
					</select>
					</div>
				</div>
				<div class="form-group row mb-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Observaciones:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="txtObservacionEdit">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer border-0">
				<div class="grupoHoro">
					<button type="button" class="btn btn-outline-primary d-print-none" onclick="insertarMantenimientoHoro()"><i class="bi bi-save"></i> Insertar actualización</button>
				</div>
				<div class="grupoActual">
					<button type="button" class="btn btn-outline-primary d-print-none" onclick="insertarMantenimientoActual()"><i class="bi bi-save"></i> Insertar mantenimiento</button>
				</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para: Insertar Caja -->
<div class="modal fade" id="modalInsertarCaja" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Insertar Actualización de Caja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row my-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Placa:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltPlacCaja" title="Placas disponibles" >
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row my-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaCaja">
					</div>
				</div>
				<div class="form-group row my-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Horómetro / Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtHoroCaja">
					</div>
				</div>
				<div class="form-group row my-3">
					<label for="staticEmail" class="col-sm-4 col-form-label">Observaciones:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="txtObservacionCaja">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer border-0">
				<div class="">
					<button type="button" class="btn btn-outline-primary d-print-none" onclick="insertarMantenimientoCaja()"><i class="bi bi-save"></i> Insertar actualización</button>
				</div>
      </div>
    </div>
  </div>
</div>


	
<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
if ($.fn && !$.fn.modal) {
    $.fn.modal = function(action) {
        return this.each(function() {
            var instance = bootstrap.Modal.getOrCreateInstance(this);
            if (action === 'show') instance.show();
            else if (action === 'hide') instance.hide();
        });
    };
}
</script>
<script src="js/moment.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
	var idPlaca=-1, queTipo='';
	$(document).ready(function() {
		$('.selectpicker').selectpicker();
		
		$('#txtFechaHoroEdit').val( moment().format('YYYY-MM-DD') );
		cambiarPlantilla('soat');
	})

	function cambiarPlantilla(tipo){
		var datos = new FormData();
		datos.append('tipo', tipo)
		switch (tipo) {
			case 'soat':
				fetch('php/vencimientos/plantilla.php',{
					method:'POST', body:datos
				}).then(resp=>{
					resp.text()
					.then(data=>{ //console.log(data);
						document.querySelector('#soat .resultado').innerHTML=data;
						contarCajas(tipo);
					})
				});
				break;
			case 'aceite':
				fetch('php/vencimientos/plantilla.php',{
					method:'POST', body:datos
				}).then(resp=>{
					resp.text()
					.then(data=>{ //console.log(data);
						document.querySelector('#aceite .resultado').innerHTML=data;
						contarCajas(tipo);
					})
				});
				break;
			case 'caja':
				fetch('php/vencimientos/plantilla.php',{
					method:'POST', body:datos
				}).then(resp=>{
					resp.text()
					.then(data=>{ //console.log(data);
						document.querySelector('#caja .resultado').innerHTML=data;
						contarCajas(tipo);
					})
				});
				break;
			case 'documentos':
				fetch('php/vencimientos/plantilla.php',{
					method:'POST', body:datos
				}).then(resp=>{
					resp.text()
					.then(data=>{ //console.log(data);
						document.querySelector('#documentos .resultado').innerHTML=data;
						contarCajas(tipo);
					})
				});
				break;
			default:
				break;
		}
	}
	function contarCajas( tipo ){
		//console.log('version, 1.03')
		document.querySelectorAll('#' + tipo + ' .alert').forEach(el => el.remove())

		placasAlertas = []
		placasVencidas = []
		const trs = document.querySelectorAll('#'+ tipo +' tr')
		trs.forEach( fila =>{
			/* if( placasAlertas.includes(fila.querySelector('.tdPlaca').dataset.value) ) {
				console.log('ya tiene')
				return;} */
			const celdas = fila.querySelectorAll('td')
			celdas.forEach( columna => {
				if(columna.classList.contains('bg-warning'))
					placasAlertas.push( fila.querySelector('.tdPlaca').dataset.value )
				if(columna.classList.contains('bg-danger'))
					placasVencidas.push( fila.querySelector('.tdPlaca').dataset.value )
			})
		})

		//console.info(placasAlertas)

		if(placasAlertas.length>0){
			const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-warning alert-dismissible fade show mt-2";
      alertDiv.id = "divAlert";
      alertDiv.setAttribute("role", "alert");
      alertDiv.innerHTML = `			
        <i class="bi bi-exclamation-triangle-fill"></i> <strong>¡Alerta!</strong> Existen placas (${placasAlertas.length}) por vencer: ${placasAlertas.join(', ')}` ;
      const caja = document.getElementById(tipo);
      if (caja) {
        caja.insertBefore(alertDiv, caja.firstChild);
      }    
		}
		if(placasVencidas.length>0){
			const alertDivVencida = document.createElement("div");
      alertDivVencida.className = "alert alert-danger alert-dismissible fade show mt-2";
      alertDivVencida.id = "divAlertVencida";
      alertDivVencida.setAttribute("role", "alert");
      alertDivVencida.innerHTML = `			
        <i class="bi bi-x-octagon-fill"></i> <strong>¡Alerta!</strong> Urgente placas (${placasVencidas.length}) vencidas: ${placasVencidas.join(', ')}` ;
      const cajaVencida = document.getElementById(tipo);
      if (cajaVencida) {
        cajaVencida.insertBefore(alertDivVencida, cajaVencida.firstChild);
      }    
		}
	}
	function editarSoat(indice, id){
		idPlaca = id;
		let trs = document.querySelectorAll("#soat tr")
		let fSoat = trs[indice].querySelector('.tdSoat').dataset.value
		let fRT = trs[indice].querySelector('.tdRT').dataset.value
		let fRCT = trs[indice].querySelector('.tdRCT').dataset.value
		document.getElementById('fPlaca').innerText = trs[indice].querySelector('.tdPlaca').dataset.value
		document.getElementById('txtSoat').value = fSoat;
		document.getElementById('txtRT').value = fRT;
		document.getElementById('txtRCT').value = fRCT;

		$('#modalEditarSoat').modal('show');
	}
	function updateVencimiento(){
		if(confirm('¿Es correcto la información ingresada?')){
			let datos = new FormData();
			datos.append('id', idPlaca)
			datos.append('soat', document.getElementById('txtSoat').value )
			datos.append('rt', document.getElementById('txtRT').value )
			datos.append('rct', document.getElementById('txtRCT').value )
			fetch('php/vencimientos/actualizarVencimiento.php', {
				method:'POST', body:datos
			})
			.then(resp =>{
				cambiarPlantilla('soat');
			})
		}
	}
	function abrirModalInsertarMantenimiento(tipo, idPlaca){
		queTipo = tipo;
		if(tipo == 'actualizacion'){
			$('#modalInsertarHodometro .modal-title').text('Actualización de KM')
			$('.grupoHoro').removeClass('d-none')
			$('.grupoActual').addClass('d-none')
		}else{
			$('#modalInsertarHodometro .modal-title').text('Agregar mantenimiento de KM/hora')
			$('.grupoHoro').addClass('d-none')
			$('.grupoActual').removeClass('d-none')
		}
		$('#sltPlacaHoroEdit').selectpicker('val',idPlaca.toString() )
		$('#sltTipo1').selectpicker('val','1')
		
		//$('#sltPlacaHoroEdit').val(idPlaca).selectpicker('refresh')
		// //		$('#sltTipo1').parent().find('.dropdown-menu').remove()
		//$('#sltTipo1').val(1).selectpicker('refresh')
		cambiarValores()
		$('#modalInsertarHodometro').modal('show')
	}
	$('#sltPlacaHoroEdit').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		if(clickedIndex != undefined){
			cambiarValores();
		}
	});
	function abrirModalInsertarCaja(idPlaca){
		$('#sltPlacCaja').val(idPlaca)
		$('#txtFechaCaja').val(moment().format("YYYY-MM-DD"))
		$('#modalInsertarCaja').modal('show')
	}
	function cambiarValores(){
		let idNuevo = $('#sltPlacaHoroEdit').selectpicker('val');
		if(!idNuevo) return;
		var fila = $('#aceite table tbody tr').filter(function(){return this.id==idNuevo;});
		if(!fila.length) fila = $('#caja table tbody tr').filter(function(){return this.id==idNuevo;});
		if(!fila.length) return;
		$('#txtHoroEdit').val(fila.find('.tdHorometro').data('value'))
		$('#txtOdoAntEdit').val(fila.find('.tdActual').data('value'))
		if(queTipo == 'actualizacion'){
			$('#txtFechaActualEdit').val(fila.find('.tdFecha2').data('value'))
		}else{
			$('#txtFechaHoroEdit').val(fila.find('.tdFecha1').data('value'))
		}
	}
	function insertarMantenimientoHoro(){
		if($('#sltPlacaHoroEdit').selectpicker('val')==null){
			$('#modalInsertarHodometro #errorMensaje').text('La placa esta vacía');
			$('#modalInsertarHodometro .pError').removeClass('d-none')
		}else if( $('#txtHoroEdit').val()=='' ){
			$('#modalInsertarHodometro #errorMensaje').text('El valor de Hodómetro no puede estar vacío');
			$('#modalInsertarHodometro .pError').removeClass('d-none')
		}else{
			let datos = new FormData();
			datos.append('tipo', 'horometro');
			datos.append('idPlaca', $('#sltPlacaHoroEdit').selectpicker('val') );
			datos.append('fechaHoro', $('#txtFechaHoroEdit').val() );
			datos.append('horometro', $('#txtHoroEdit').val() );
			datos.append('fechaActual', $('#txtFechaActualEdit').val() );
			datos.append('kilometraje', $('#txtOdoAntEdit').val() );
			datos.append('observacion', $('#txtObservacionEdit').val() );
			datos.append('kmhoras', $('#sltTipo1').val() );
			fetch('php/vencimientos/insertarMantenimientos.php', {
				method:'POST', body:datos
			})
			.then(response => response.text())
			.then(respuesta => {
				if(respuesta=='ok'){
					$('#modalInsertarHodometro').modal('hide');
					cambiarPlantilla('aceite');
				}
			})
		}
	}
	function insertarMantenimientoActual(){
		if($('#sltPlacaHoroEdit').selectpicker('val')==null){
			$('#modalInsertarHodometro #errorMensaje').text('La placa esta vacía');
			$('#modalInsertarHodometro .pError').removeClass('d-none')
		}else if( $('#txtOdoAntEdit').val()=='' ){
			$('#modalInsertarHodometro #errorMensaje').text('El valor de Hodómetro no puede estar vacío');
			$('#modalInsertarHodometro .pError').removeClass('d-none')
		}else{
			let datos = new FormData();
			datos.append('tipo', 'horometro');
			datos.append('idPlaca', $('#sltPlacaHoroEdit').selectpicker('val') );
			datos.append('fechaHoro', $('#txtFechaHoroEdit').val() );
			datos.append('horometro', $('#txtHoroEdit').val() );
			datos.append('fechaActual', $('#txtFechaActualEdit').val() );
			datos.append('kilometraje', $('#txtOdoAntEdit').val() );
			datos.append('observacion', $('#txtObservacionEdit').val() );
			datos.append('kmhoras', $('#sltTipo1').val() );
			fetch('php/vencimientos/insertarMantenimientos.php', {
				method:'POST', body:datos
			})
			.then(response => response.text())
			.then(respuesta => {
				if(respuesta=='ok'){
					$('#modalInsertarHodometro').modal('hide');
					cambiarPlantilla('aceite');
					limpiarCamposInsert()
				}
			})
		}
	}
	function insertarMantenimientoCaja(){
	/* 	sltPlacCaja
txtFechaCaja
txtHoroCaja
txtObservacionCaja */
		if($('#sltPlacCaja').selectpicker('val')==null){
			$('#modalInsertarCaja #errorMensaje').text('La placa esta vacía');
			$('#modalInsertarCaja .pError').removeClass('d-none')
		}else if( $('#txtHoroCaja').val()=='' ){
			$('#modalInsertarCaja #errorMensaje').text('El valor de Hodómetro no puede estar vacío');
			$('#modalInsertarCaja .pError').removeClass('d-none')
		}else{
			console.log('aca');
			let datos = new FormData();
			datos.append('tipo', 'horometro');
			datos.append('idPlaca', $('#sltPlacCaja').selectpicker('val') );
			datos.append('fecha', $('#txtFechaCaja').val() );
			datos.append('horometro', $('#txtHoroCaja').val() );
			datos.append('observacion', $('#txtObservacionCaja').val() );
			fetch('php/vencimientos/insertarCaja.php', {
				method:'POST', body:datos
			})
			.then(response => response.text())
			.then(respuesta => {
				if(respuesta=='ok'){
					$('#modalInsertarCaja').modal('hide');
					cambiarPlantilla('caja');
				}
			})
		}
	}
	function subirDocumento(btn, idPlaca, tipo) {
		const input = document.createElement('input');
		input.type = 'file';
		input.accept = '.pdf,.jpg,.jpeg,.png,.doc,.docx';
		input.onchange = function() {
			const file = this.files[0];
			if (!file) return;
			const formData = new FormData();
			formData.append('idPlaca', idPlaca);
			formData.append('tipo', tipo);
			formData.append('archivo', file);
			btn.disabled = true;
			btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
			fetch('php/vencimientos/subirDocumento.php', {
				method: 'POST', body: formData
			})
			.then(res => res.text())
			.then(respuesta => {
				if (respuesta == 'ok') {
					cambiarPlantilla('documentos');
				} else {
					alert('Error al subir el archivo');
				}
			})
			.catch(() => alert('Error de conexión'))
			.finally(() => {
				btn.disabled = false;
				btn.innerHTML = '<i class="bi bi-upload"></i>';
			});
		};
		input.click();
	}
	function eliminarDocumento(btn, idPlaca, tipo) {
		if(!confirm('¿Eliminar este archivo?')) return;
		const formData = new FormData();
		formData.append('idPlaca', idPlaca);
		formData.append('tipo', tipo);
		btn.disabled = true;
		btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
		fetch('php/vencimientos/eliminarDocumento.php', {
			method: 'POST', body: formData
		})
		.then(res => res.text())
		.then(respuesta => {
			if (respuesta == 'ok') {
				cambiarPlantilla('documentos');
			} else {
				alert('Error al eliminar el archivo');
			}
		})
		.catch(() => alert('Error de conexión'))
		.finally(() => {
			btn.disabled = false;
			btn.innerHTML = '<i class="bi bi-x-lg"></i>';
		});
	}
	function limpiarCamposInsert(){
		$('#sltPlacaHoroEdit').val(-1).selectpicker('render')
		$('#txtFechaHoroEdit').val('')
		$('#fechaActual').val('')
		$('#txtHoroEdit').val('')
		$('#txtOdoAntEdit').val('')
		$('#txtObservacionEdit').val('')
	}
	txtBuscarPlaca = document.getElementById('txtBuscarPlaca')
	document.querySelector('#txtBuscarPlaca').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      buscarPlaca();
    }
	});
	function buscarPlaca(){
		let texto = txtBuscarPlaca.value;
		let arreglo = texto.toLowerCase().replace(' ','').split(',');
		let tablas = document.querySelectorAll('.resultado tbody tr');
		let cards = document.querySelectorAll('.resultado .tarjeta-venc');

		if(texto ==''){
			tablas.forEach(function(r){r.classList.remove('d-none')});
			cards.forEach(function(c){c.classList.remove('d-none')});
			return;
		}

		tablas.forEach(function(campo){
			var filtro = campo.querySelectorAll('td')[1]?.innerText || '';
			if(contains(filtro.toLowerCase(), arreglo)){
				campo.classList.remove('d-none');
			}else{
				campo.classList.add('d-none');
			}
		});

		cards.forEach(function(card){
			var placa = (card.dataset.placa || '').toLowerCase();
			if(contains(placa, arreglo)){
				card.classList.remove('d-none');
			}else{
				card.classList.add('d-none');
			}
		});
	}
	function limbiarBusqueda(){
		txtBuscarPlaca.value='';
		buscarPlaca();
	}
	function contains(target, pattern){
    var value = 0;
    pattern.forEach(function(word){
      value = value + target.includes(word);
    });
    return (value === 1)
	}
	function activarFiltro(tipo){
		$('.btnFiltros').removeClass('active')
		$(event.target).addClass('active')
		let filas = document.querySelectorAll('#aceite .resultado tbody tr');
		let cards = document.querySelectorAll('#aceite .resultado .tarjeta-venc');
		let fecha = null;
		let hoy = moment();
		switch (tipo) {
			case 'operativo': $filtro = 'Operativo'; break;
			case 'programar': $filtro = 'Programar Mantenimiento'; break;
			case 'mantenimiento': $filtro = 'Mantenimiento Urgente'; break;
			case 'pendiente': $filtro = ''; break;
			case 'limpiar': break;
			default:
				break;
		}
		if(tipo!='limpiar' && tipo!='pendiente'){
			filas.forEach(function(campo){
				if(campo.querySelectorAll('td')[2].innerText == $filtro){
					campo.classList.remove('d-none');
				}else{
					campo.classList.add('d-none');
				}
			});
			cards.forEach(function(card){
				if(card.dataset.estado == $filtro){
					card.classList.remove('d-none');
				}else{
					card.classList.add('d-none');
				}
			});
		}else if( tipo=='pendiente'){
			filas.forEach(function(campo){
				fecha = moment(campo.querySelectorAll('td')[3].dataset.value)
				diferencia = hoy.diff(fecha, 'days');
				if(diferencia >= 7){
					campo.classList.remove('d-none')
				}else{
					campo.classList.add('d-none')
				}
			});
		}else{
			filas.forEach(function(r){r.classList.remove('d-none')});
			cards.forEach(function(c){c.classList.remove('d-none')});
		}
	}
	function activarFiltroFiltro(tipo){
		$('.btnFiltros').removeClass('active')
		$(event.target).addClass('active')
		let filas = document.querySelectorAll('#caja .resultado tbody tr');
		let cards = document.querySelectorAll('#caja .resultado .tarjeta-venc');
		let fecha = null;
		let hoy = moment();
		switch (tipo) {
			case 'operativo': $filtro = 'Operativo'; break;
			case 'programar': $filtro = 'Programar Mantenimiento'; break;
			case 'mantenimiento': $filtro = 'Mantenimiento Urgente'; break;
			case 'pendiente': $filtro = ''; break;
			case 'limpiar': break;
			default:
				break;
		}
		if(tipo!='limpiar' && tipo!='pendiente'){
			filas.forEach(function(campo){
				if(campo.querySelectorAll('td')[2].innerText == $filtro){
					campo.classList.remove('d-none');
				}else{
					campo.classList.add('d-none');
				}
			});
			cards.forEach(function(card){
				if(card.dataset.estado == $filtro){
					card.classList.remove('d-none');
				}else{
					card.classList.add('d-none');
				}
			});
		}else{
			filas.forEach(function(r){r.classList.remove('d-none')});
			cards.forEach(function(c){c.classList.remove('d-none')});
		}
	}

</script>
<style>
.bootstrap-select .dropdown-toggle .filter-option,
.bootstrap-select .dropdown-toggle .filter-option-inner-inner{font-family:inherit;}
.bootstrap-select .dropdown-toggle .filter-option {
    border: 1px solid #c5c5c5;
    border-radius: .25rem;
}
.bg-dark{background-color:#0e0e0e!important}
.bootstrap-select .dropdown-toggle .filter-option{
	border: transparent!important;	
}
.tarjeta-venc {border-radius:8px;border:1px solid #dee2e6;}
.td-documento .btn-upload,
.td-documento .btn-eliminar {opacity:0;transition:opacity .4s ease,transform .4s ease;transform:scale(.9);}
.td-documento:hover .btn-upload,
.td-documento:hover .btn-eliminar {opacity:1;transform:scale(1);}
.btn-upload .spinner-border{width:1rem;height:1rem;}
.tarjeta-venc .text-secondary {font-size:.8rem;}
.tarjeta-venc .row > div {word-break:break-word;}
.tarjeta-venc.border-danger,.alert-danger {border-color:#dc3545!important;border-width:2px!important;}
.tarjeta-venc.border-warning,.alert-warning {border-color:#ffc107!important;border-width:2px!important;}
.card-body .badge {font-size:.75rem;}
@media print {
  .tarjeta-venc { break-inside: avoid; }
  .cards-container { break-before: avoid; }
  .badge.bg-success { background-color: transparent !important; color: #198754 !important; }
  .badge.bg-warning { background-color: transparent !important; color: #664d03 !important; }
  .badge.bg-danger { background-color: transparent !important; color: #dc3545 !important; }
  .alert-danger { background-color: transparent !important; color: #dc3545 !important; border-width:1px!important; }
  .alert-warning { background-color: transparent !important; color: #664d03 !important; border-width:1px!important; }
}
tr.bg-danger td,
tr.bg-warning td{
  background-color: inherit !important;
	color:white;
}
.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 70px;
  height: 30px;
}
.lds-ellipsis div {
  position: absolute;
  top: 23px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #1319cf;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}
</style>
</body>
</html>