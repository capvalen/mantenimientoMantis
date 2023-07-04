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
	<link rel="shortcut icon" href="https://contratistasjkm.com/wp-content/uploads/2023/02/favic.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="shortcut icon" href="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/favicon.png" />
</head>
<body>

<?php include 'menu.php';?>
<section>
	<div class="container-fluid row py-2">
		<div class="order-0 order-md-0 col-6 col-md-3 text-center">
			<img src="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/logo-transportes.png" class="img-fluid"></div>
		<div class="order-2 order-md-1 col-12 col-md-6">
			<h3 class="text-center ">Registro de fechas de vencimiento</h3>
			<div class="input-group mb-3">
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
			<button class="nav-link active" id="soat-tab" data-toggle="tab" data-target="#soat" type="button" role="tab" aria-controls="soat" aria-selected="true">SOAT</button>
		</li>
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('aceite')">
			<button class="nav-link" id="aceite-tab" data-toggle="tab" data-target="#aceite" type="button" role="tab" aria-controls="aceite" aria-selected="false">Aceite y Filtros</button>
		</li>
		<li class="nav-item" role="presentation" onclick="cambiarPlantilla('caja')">
			<button class="nav-link" id="caja-tab" data-toggle="tab" data-target="#caja" type="button" role="tab" aria-controls="caja" aria-selected="false">Caja y Corona</button>
		</li>
	</ul>
</section>

<section class="container-fluid">
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="soat" role="tabpanel" aria-labelledby="soat-tab">
			<div class="resultado table-responsive"></div>
		</div>
		<div class="tab-pane fade" id="aceite" role="tabpanel" aria-labelledby="aceite-tab">
			<div class="card my-3">
				<div class="card-body">
					<label for="">Filtros</label>
					<button class="btn btn-sm btn-outline-success btnFiltros" onclick="activarFiltro('operativo')">Operativo</button>
					<button class="btn btn-sm btn-outline-warning btnFiltros" onclick="activarFiltro('programar')">Programar mantenimiento</button>
					<button class="btn btn-sm btn-outline-danger btnFiltros" onclick="activarFiltro('mantenimiento')">Mantenimiento urgente</button>
					<button class="btn btn-sm btn-outline-primary btnFiltros" onclick="activarFiltro('pendiente')">Pendiente Actualizar Km/Hora</button>
					<button class="btn btn-sm btn-outline-secondary btnFiltros" onclick="activarFiltro('limpiar')">Limpiar filtro</button>
				</div>
			</div>
			<div class="resultado table-responsive"></div>
		</div>
		<div class="tab-pane fade" id="caja" role="tabpanel" aria-labelledby="caja-tab">
		<div class="card my-3">
				<div class="card-body">
					<label for="">Filtros</label>
					<button class="btn btn-sm btn-outline-success btnFiltros" onclick="activarFiltroFiltro('operativo')">Operativo</button>
					<button class="btn btn-sm btn-outline-warning btnFiltros" onclick="activarFiltroFiltro('programar')">Programar mantenimiento</button>
					<button class="btn btn-sm btn-outline-danger btnFiltros" onclick="activarFiltroFiltro('mantenimiento')">Mantenimiento urgente</button>
					<button class="btn btn-sm btn-outline-secondary btnFiltros" onclick="activarFiltroFiltro('limpiar')">Limpiar filtro</button>
				</div>
			</div>
			<div class="resultado table-responsive">
				<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div> Cargando datos
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Puede editar los siguientes campos</p>
				<label for="">Fecha de vencimiento de Soat:</label>
				<input type="date" class="form-control" id="txtSoat">
				<label for="">Fecha de vencimiento de RT:</label>
				<input type="date" class="form-control" id="txtRT">
				<label for="">Fecha de vencimiento de RCT:</label>
				<input type="date" class="form-control" id="txtRCT">
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary" onclick="updateVencimiento()" data-dismiss="modal">Actualizar vencimientos</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal para: Insertar Hodometro -->
<div class="modal fade" id="modalInsertarHodometro" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Insertar Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row ">
					<label for="staticEmail" class="col-sm-4 col-form-label">Placa:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltPlacaHoroEdit" title="&#xed11; Placas disponibles" >
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row grupoHoro">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaHoroEdit">
					</div>
				</div>
				<div class="form-group row grupoHoro">
					<label for="staticEmail" class="col-sm-4 col-form-label">Horómetro / Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtHoroEdit">
					</div>
				</div>
				<div class="form-group row grupoActual">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaActualEdit">
					</div>
				</div>
				<div class="form-group row grupoActual">
					<label for="staticEmail" class="col-sm-4 col-form-label">Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtOdoAntEdit">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Tipo:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltTipo1" title="&#xed11; Tipo" >
						<option value="1">K.m.</option>
						<option value="2">Horas</option>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Observaciones:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="txtObservacionEdit">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer">
				<div class="grupoHoro">
					<button type="button" class="btn btn-outline-primary" onclick="insertarMantenimientoHoro()"><i class="bi bi-save"></i> Insertar actualización</button>
				</div>
				<div class="grupoActual">
					<button type="button" class="btn btn-outline-primary" onclick="insertarMantenimientoActual()"><i class="bi bi-save"></i> Insertar mantenimiento</button>
				</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para: Insertar Caja -->
<div class="modal fade" id="modalInsertarCaja" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Insertar Actualización de Caja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row ">
					<label for="staticEmail" class="col-sm-4 col-form-label">Placa:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltPlacCaja" title="&#xed11; Placas disponibles" >
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row ">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
						<input type="date" class="form-control" id="txtFechaCaja">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Horómetro / Odómetro actual:</label>
					<div class="col-sm-8">
						<input type="number" class="form-control" id="txtHoroCaja">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Observaciones:</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="txtObservacionCaja">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer">
				<div class="">
					<button type="button" class="btn btn-outline-primary" onclick="insertarMantenimientoCaja()"><i class="bi bi-save"></i> Insertar actualización</button>
				</div>
      </div>
    </div>
  </div>
</div>


	
<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script>
	var idPlaca=-1, queTipo='';
	$(document).ready(function() {
		$('.selectpicker').selectpicker('render');
		$('.selectpicker').selectpicker('val', -1);
		$('#sltTipo1').selectpicker('val', 1);
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
					})
				});
				break;
			default:
				break;
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
		$('#sltPlacaHoroEdit').selectpicker('val', idPlaca)
		cambiarValores()
		$('#modalInsertarHodometro').modal('show')
	}
	$('#sltPlacaHoroEdit').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
		if(clickedIndex != undefined){
			cambiarValores();
		}
	});
	function abrirModalInsertarCaja(idPlaca){
		$('#sltPlacCaja').selectpicker('val', idPlaca)
		$('#txtFechaCaja').val(moment().format("YYYY-MM-DD"))
		$('#modalInsertarCaja').modal('show')
	}
	function cambiarValores(){
		let idNuevo = $('#sltPlacaHoroEdit').selectpicker('val');
		//console.log('id', idNuevo);
		$('#txtHoroEdit').val($('#'+idNuevo+' .tdHorometro').data('value'))
		$('#txtOdoAntEdit').val($('#'+idNuevo+' .tdActual').data('value'))
		if(queTipo == 'actualizacion'){
			$('#txtFechaActualEdit').val($('#'+idNuevo+' .tdFecha2').data('value'))
		}else{
			$('#txtFechaHoroEdit').val($('#'+idNuevo+' .tdFecha1').data('value'))
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
	function limpiarCamposInsert(){
		$('#sltPlacaHoroEdit').selectpicker('val', -1)
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
		let todo = document.querySelectorAll('.resultado tbody tr');
		let filtro = ''
		let arreglo = texto.toLowerCase().replace(' ','').split(',');

		todo.forEach( campo=>{
			

			if(texto ==''){
				campo.classList.remove('d-none')
			}
			filtro = campo.querySelectorAll('td')[1].innerText
						
			if(contains(filtro.toLowerCase(), arreglo)){
				campo.classList.remove('d-none')
			}else{
				campo.classList.add('d-none')
			}


			/* if(filtro.toLowerCase().includes(texto.toLowerCase())){
				campo.classList.remove('d-none')
			}else{
				campo.classList.add('d-none')
			} */
		})
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
		let todo = document.querySelectorAll('#aceite .resultado tbody tr');
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
		if(tipo!='limpiar' && tipo!='pendiente')
			todo.forEach(campo =>{
				if( campo.querySelectorAll('td')[2].innerText == $filtro ){
					campo.classList.remove('d-none')
				}else{
					campo.classList.add('d-none')
				}
			})
		else if( tipo=='pendiente')
			todo.forEach(campo =>{
				fecha = moment(campo.querySelectorAll('td')[3].dataset.value)
				diferencia = hoy.diff(fecha, 'days');
				//console.log(fecha.format('YYYY-MM-DD'), diferencia, campo.querySelectorAll('td')[3].dataset.value);
				if( diferencia >= 7 ){
					campo.classList.remove('d-none')
				}else{
					campo.classList.add('d-none')
				}
			})
		else $('.resultado tbody tr').removeClass('d-none')
	}
	function activarFiltroFiltro(tipo){
		$('.btnFiltros').removeClass('active')
		$(event.target).addClass('active')
		let todo = document.querySelectorAll('#caja .resultado tbody tr');
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
		if(tipo!='limpiar' && tipo!='pendiente')
			todo.forEach(campo =>{
				if( campo.querySelectorAll('td')[2].innerText == $filtro ){
					campo.classList.remove('d-none')
				}else{
					campo.classList.add('d-none')
				}
			})
		else $('.resultado tbody tr').removeClass('d-none')
	}

</script>
<style>
.bootstrap-select .dropdown-toggle .filter-option{font-family:'Icofont', 'Segoe UI';}
.bootstrap-select .dropdown-toggle .filter-option {
    border: 1px solid #c5c5c5;
    border-radius: .25rem;
}
.bg-dark{background-color:#0e0e0e!important}
.bootstrap-select .dropdown-toggle .filter-option{
	border: transparent!important;	
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