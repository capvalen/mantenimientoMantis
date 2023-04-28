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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reportes - Transportes y Contratistas JKM SRL</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="shortcut icon" href="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/favicon.png" />
	
</head>
<body>
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
</style>
<?php include 'menu.php';?>
<div class="container-fluid">
<section>
	<div class="row py-2">
		<div class="order-0 order-md-0 col-6 col-md-3 text-center">
			<img src="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/logo-transportes.png" class="img-fluid"></div>
		<div class="order-2 order-md-1 col-12 col-md-6">
			<h3 class="text-center ">Reporte de Mantenimiento Preventivo y Correctivo</h3>
			<?php if(isset($_GET['placa'])){?> <h4 class="text-center pb-3">Placa: <?= $_GET['placa'];?></h4> 
		</div>
		<div class="order-1 order-md-2 col-6 col-md-2 text-center">
			<img src="" id="imgFoto" class="img-fluid w-75" onclick="modalFoto()" style="cursor:pointer;">
		</div>
	</div>
	<?php if( $_COOKIE['ckPower']==1){ ?>
		<div class="row">
			<div class="col-sm-4">
				<button class="btn btn-outline-primary mb-3" onclick="abrirMantenimientoAutomatico()"><i class="bi bi-node-plus"></i>  Agregar mantenimiento</button>
			</div>
			<div class="col-sm-8">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Buscar por placa" id="txtBuscarPlaca">
					<button class="btn btn-outline-secondary" type="button" onclick="buscarPlaca()" ><i class="bi bi-search"></i></button>
					<button class="btn btn-outline-secondary" type="button" onclick="limbiarBusqueda()" ><i class="bi bi-eraser"></i></button>
				</div>
			</div>
		</div>
	<?php } ?>
		

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="white-space: nowrap">N°</th>
					<th>Fecha</th>
					<th class="d-print-none">Tipo de Mantenimiento</th>
					<th>Descripción</th>
					<th>Kilometraje</th>
					<th>Lugar</th>
					<th class="d-print-none">Responsable</th>
					<th>Monto</th>
					<th class="d-print-none">Informe</th>
					<th class="d-print-none">Factura</th>
				</tr>
			</thead>
			<tbody>
				<?php include "php/listarReportePlacas.php";?>
			</tbody>
		</table>
	</div>
	<?php }else{ ?>
	<p>Empieze seleccionando una placa en la esquina superior derecha.</p>
	<?php } ?>
</section>
</div>

<?php if( $_COOKIE['ckPower']==1){ ?>
<!-- Modal para: agregar una placa -->
<div class="modal fade" id="modalAddPlaca" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Placa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="row">
					<div class="col-8">
						<p class="mb-0">Rellene la serie de la placa:</p>
						<input type="text" class="form-control text-uppercase" id="txtMovilidadNueva">
						<input type="text" class="form-control text-uppercase" id="txtPlacaNueva">
						<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
					</div>
					<div class="col-4 d-flex align-items-center">
						<div><button type="button" class="btn btn-outline-primary " id="btnGuardarPlacaNew"><i class="bi bi-shield-plus"></i> Guardar</button></div>
					</div>
				</div>
				<p class="mb-0 mt-3"><strong>Placas registradas:</strong></p>
				
				<table class=" table table-hover">
				<thead>
					<tr><th>N°</th>
					<th>Movilidad</th>
					<th>Placa</th>
					<th>Año</th>
					<th>Rango (Aceite)</th>
					<th>Porcentaje de aviso (Aceite)</th>
					<th>Rango (Caja)</th>
					<th>Porcentaje de aviso (Caja)</th>
					<th>@</th></tr>
				</thead>
					<tbody>
						<?php include "php/listarPlacas.php"; ?>
					</tbody>
				</table>
      </div>
    </div>
  </div>
</div>
<!-- Modal para: agregar una mantenimiento -->
<div class="modal fade" id="modalAddMantenimiento" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Placa:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltPlacasMant" title="&#xed11; Placas disponibles">
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Fecha:</label>
					<div class="col-sm-8">
					<input type="date" class="form-control" id="txtFechaMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Tipo mantenimiento:</label>
					<div class="col-sm-8">
					<select class="selectpicker" data-live-search="true" id="sltTipoMant" title="&#xed11; Tipo de mantenimiento">
						<option value="1">Preventivo</option>
						<option value="2">Correctivo</option>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Descripción:</label>
					<div class="col-sm-8">
					<textarea class="form-control" id="txtDescipcionMant"  rows="3"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Kilometraje:</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="txtKilometrajeMant" value="0" min="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Lugar:</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="txtLugarMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Responsable:</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="txtResponsableMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Monto:</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="txtMontoMant" value="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtAdjuntoMant" class="col-sm-4 col-form-label">Informe:</label>
					<div class="col-sm-8">
					<input type="file" class="form-control" id="txtAdjuntoMant" accept=".png, .jpg, .jpeg, .doc,.docx, .pdf, .xls, xlsx">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtAdjuntoFactura" class="col-sm-4 col-form-label">Factura:</label>
					<div class="col-sm-8">
					<input type="file" class="form-control" id="txtAdjuntoFactura" accept=".png, .jpg, .jpeg, .doc,.docx, .pdf, .xls, xlsx">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" id="btnGuardarMantenimientoNew"><i class="bi bi-shield-plus"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para: editar una mantenimiento -->
<div class="modal fade" id="modalEditMantenimiento" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Mantenimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Rellene los campos básicos:</p>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Placa:</label>
					<div class="col-sm-9">
					<select class="selectpicker" data-live-search="true" id="sltPlacasMantEdit" title="&#xed11; Placas disponibles" disabled>
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Fecha:</label>
					<div class="col-sm-9">
					<input type="date" class="form-control" id="txtFechaMantEdit">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Tipo mantenimiento:</label>
					<div class="col-sm-9">
					<select class="selectpicker" data-live-search="true" id="sltTipoMantEdit" title="&#xed11; Tipo de mantenimiento">
						<option value="1">Preventivo</option>
						<option value="2">Correctivo</option>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Descripción:</label>
					<div class="col-sm-9">
					<textarea class="form-control" id="txtDescipcionMantEdit"  rows="3"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Kilometraje:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtKilometrajeMantEdit" value="0" min="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Lugar:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtLugarMantEdit">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Responsable:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtResponsableMantEdit">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Monto:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtMontoMantEdit" value="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtAdjuntoMantEdit" class="col-sm-3 col-form-label">Informe:</label>
					<div class="col-sm-9">
					<div  class="hidden">
						<span id="spanArchiAdjunto"></span> <button class="btn btn-outline-danger border-0" id="btnBorrarArchivo"> <i class="bi bi-eraser"></i> </button>
					</div>
					<input type="file" class="form-control" id="txtAdjuntoMantEdit" accept=".png, .jpg, .jpeg, .doc,.docx, .pdf, .xls, xlsx">
					</div>
				</div>
				<div class="form-group row">
					<label for="txtFacturaEdit" class="col-sm-3 col-form-label">Factura:</label>
					<div class="col-sm-9">
					<div  class="hidden">
						<span id="spanFacturaEdit"></span> <button class="btn btn-outline-danger border-0" id="btnBorrarFacturaEdit"> <i class="bi bi-eraser"></i> </button>
					</div>
					<input type="file" class="form-control" id="txtFacturaEdit" accept=".png, .jpg, .jpeg, .doc,.docx, .pdf, .xls, xlsx">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="bi bi-exclamation-circle"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" id="btnGuardarMantenimientoEdit"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script>
var idGlobal='';
$(document).ready(function() {
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	$('#txtFechaMant').val( moment().format('YYYY-MM-DD') );
	datosIniciales();
})
$('#sltPlacas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
	if( $('#sltPlacas').val()!=null ){	
		var placa=$(this).parent().parent().find('.selected a').text();
		console.log( placa )
		window.location.href = 'reporte.php?placa='+placa; //$('#sltPlacas').val()
	}
});
<?php if( $_COOKIE['ckPower']==1){ ?>
$('#btnAgregarSerie').click(function() {
	$('#modalAddPlaca').modal('show');
});
$('#btnGuardarPlacaNew').click(function() {
	if( $('#txtPlacaNueva').val()=='' || $('#txtMovilidadNueva').val()==''){
		$('#modalAddPlaca .pError').removeClass('d-none');
		$('#errorMensaje').text('Debe rellenar un valor en la placa');
	}else{
		$.ajax({url: 'php/insertarPlaca.php', type: 'POST', data: {
			movilidad: $('#txtMovilidadNueva').val(),
			placa: $('#txtPlacaNueva').val()
		}}).done(function(resp) {
//			console.log(resp)
			$('#modalAddPlaca').modal('hide');
			if(resp=='ok'){
				$('#modalGuardadoExitoso').modal('show');
			}else{
				$('#h5DetalleFaltan').text('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
				$('#modalFaltaDatos').modal('show');
			}
		});
	}
});
$('#btnAgregarManteniminto').click(function() {
	$('#modalAddMantenimiento').modal('show');
});
$('#btnGuardarMantenimientoNew').click(function() {
	if($('#sltPlacasMant').selectpicker('val')==null){
		$('#modalAddMantenimiento .pError').removeClass('d-none');
		$('#modalAddMantenimiento #errorMensaje').text('Falta seleccionar una placa');
	}else if( $('#txtFechaMant').val()=="" ){
		$('#modalAddMantenimiento .pError').removeClass('d-none');
		$('#modalAddMantenimiento #errorMensaje').text('Fecha incorrecta');
	}else if($('#sltTipoMant').selectpicker('val')==null){
		$('#modalAddMantenimiento .pError').removeClass('d-none');
		$('#modalAddMantenimiento #errorMensaje').text('Falta seleccionar un tipo de mantenimiento');
	}else if( $('#txtDescipcionMant').val()=="" ){
		$('#modalAddMantenimiento .pError').removeClass('d-none');
		$('#modalAddMantenimiento #errorMensaje').text('La descripción no puede estar vacía');
	}else if( $('#txtLugarMant').val()=="" ){
		$('#modalAddMantenimiento .pError').removeClass('d-none');
		$('#modalAddMantenimiento #errorMensaje').text('El lugar no puede estar vacío');
	}else{
		var kilome=0, monto=0;
		if( $('#txtKilometrajeMant').val()!="" ){ kilome = $('#txtKilometrajeMant').val(); }
		if( $('#txtMontoMant').val()!="" ){ monto = $('#txtMontoMant').val(); }

	$.ajax({url: 'php/insertarMantenimiento.php', type: 'POST',
		data: {
			placa: $('#sltPlacasMant').selectpicker('val'),
			fecha: $('#txtFechaMant').val(),
			tipo: $('#sltTipoMant').selectpicker('val'),
			descripcion: $('#txtDescipcionMant').val(),
			kilome: kilome,
			lugar: $('#txtLugarMant').val(),
			responsable: $('#txtResponsableMant').val(),
			monto: monto,
		} }).done(function(resp) { console.log(resp)
			$('#modalAddMantenimiento').modal('hide');
			if($.isNumeric(resp)){
				//$('#modalGuardadoExitoso').modal('show');
				
				subirAdjunto(resp)
				.then(que=>{
					console.log('respuesta 1' , que);
					subirFactura(resp)
					.then(que2=>{
						console.log('respuesta 2' , que2);
						if(que && que2){
							$('#modalGuardadoExitoso').modal('show');
						}else{
							$('#h5DetalleFaltan').text('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
							$('#modalFaltaDatos').modal('show');
						}
					})
				})
				
			}else{
				$('#h5DetalleFaltan').text('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
				$('#modalFaltaDatos').modal('show');
			}
			
		});
		$('#modalGuardadoExitoso').on('hidden.bs.modal', function () { 
			location.reload();
		});
	}
});
function subirAdjunto (resp){
	return new Promise((resolve, reject)=>{
		if( $('#txtAdjuntoMant')[0].files[0]!=null ){
			var formData= new FormData();
			var archivo = $('#txtAdjuntoMant')[0].files[0];
			formData.append("archivo", archivo );
			formData.append("placa", $('#sltPlacasMant').selectpicker('val') );
			formData.append("idReg", resp );
			$.ajax({url: 'php/subirArchivo.php', type: 'POST', data: formData, contentType: false, processData: false, cache:false
				}).done(function(resp3) { console.log(resp3)
				$('#modalAddMantenimiento').modal('hide');
				if(resp3=='ok'){
					resolve(true);
					//$.post('php/updateNombreFile.php', {idPlaca: $('#sltPlacasMant').selectpicker('val'), subida: encodeURIComponent(archivo.name)} ).done(function(respuesta){console.log(respuesta)})
				}else{
					resolve(false);
				
				}
			});
		}else{
			resolve(true);
		}
	});
}
function subirFactura(resp){
	return new Promise((resolve, reject)=>{
		if( $('#txtAdjuntoFactura')[0].files[0]!=null ){
			var formData= new FormData();
			var archivo = $('#txtAdjuntoFactura')[0].files[0];
			formData.append("archivo", archivo );
			formData.append("placa", $('#sltPlacasMant').selectpicker('val') );
			formData.append("idReg", resp );
			$.ajax({url: 'php/subirArchivo_fact.php', type: 'POST', data: formData, contentType: false, processData: false,cache:false
				}).done(function(resp2) { console.log(resp2)
				$('#modalAddMantenimiento').modal('hide');
				if(resp2=='ok'){
					resolve(true);
					//$.post('php/updateNombreFile.php', {idPlaca: $('#sltPlacasMant').selectpicker('val'), subida: encodeURIComponent(archivo.name)} ).done(function(respuesta){console.log(respuesta)})
				}else{
					resolve(false);
				
				}
			});
			}else{
				resolve(true);
			}

	})
}
function subirAdjuntoE (resp){
	return new Promise((resolve, reject)=>{
		if( $('#txtAdjuntoMantEdit')[0].files[0]!=null ){
			var formData= new FormData();
			var archivo = $('#txtAdjuntoMantEdit')[0].files[0];
			formData.append("archivo", archivo );
			formData.append("placa", $('#sltPlacasMant').selectpicker('val') );
			formData.append("idReg", resp );
			$.ajax({url: 'php/subirArchivo.php', type: 'POST', data: formData, contentType: false, processData: false, cache:false
				}).done(function(resp3) { console.log(resp3)
				if(resp3=='ok'){
					resolve(true);
					//$.post('php/updateNombreFile.php', {idPlaca: $('#sltPlacasMant').selectpicker('val'), subida: encodeURIComponent(archivo.name)} ).done(function(respuesta){console.log(respuesta)})
				}else{
					resolve(false);
				}
			});
		}else{
			resolve(true);
		}
	});
}
function subirFacturaE (resp){
	return new Promise((resolve, reject)=>{
		if( $('#txtFacturaEdit')[0].files[0]!=null ){
			var formData= new FormData();
			var archivo = $('#txtFacturaEdit')[0].files[0];
			formData.append("archivo", archivo );
			formData.append("placa", $('#sltPlacasMant').selectpicker('val') );
			formData.append("idReg", resp );
			$.ajax({url: 'php/subirArchivo_fact.php', type: 'POST', data: formData, contentType: false, processData: false,cache:false
				}).done(function(resp2) { console.log(resp2)
				if(resp2=='ok'){
					resolve(true);
					//$.post('php/updateNombreFile.php', {idPlaca: $('#sltPlacasMant').selectpicker('val'), subida: encodeURIComponent(archivo.name)} ).done(function(respuesta){console.log(respuesta)})
				}else{
					resolve(false);
				}
			});
			}else{
				resolve(true);
			}
	})
}
$('#btnAddNewUser').click(function() {
	$('#modalListadoPersonal').modal('hide');
	$('#modalNuevoPersonal').modal('show');
});
function removerPersonal(idEmple){
	$.idEmple = idEmple;
	var nombre = $(`td[data-id="${idEmple}"]`).text();
	$('#strNombre').text(nombre);
	$('#modalListadoPersonal').modal('hide');
	$('#modalBorrarPersonal').modal('show');
}
$('#btnBorrarPersona').click(function() { 
	$.ajax({url: 'php/borrarPersonal.php', type: 'POST', data: { idUser: $.idEmple }}).done(function(resp) { //console.log( resp=='todo ok' );
		if($.trim(resp)=='todo ok'){
			location.reload();
		}
	});
});
function borrarDescipcion(idDescripc){
	$.idDescripc = idDescripc;
	$('#modalBorrarRegistro').modal('show');
}
$('#btnBorrarRegistro').click(function() { 
	$.ajax({url: 'php/borrarRegistro.php', type: 'POST', data: { idDescripc: $.idDescripc }}).done(function(resp) { //console.log( resp=='todo ok' );
		if($.trim(resp)=='todo ok'){
			location.reload();
		}
	});
});
function borrarPlaca(idPlaca){
	$.idPlaca = idPlaca;
	$('#strPlacaBorrar').text( $(this).parent().prev().text());
	$('#modalAddPlaca').modal('hide');
	$('#modalBorrarPlaca').modal('show');
}
$('#btnBorrarPlaca').click(function() { 
	$.ajax({url: 'php/borrarPlaca.php', type: 'POST', data: { idPlaca: $.idPlaca }}).done(function(resp) { //console.log( resp=='todo ok' );
		if($.trim(resp)=='todo ok'){
			location.reload();
		}
	});
});
$('#btnGuardarPersona').click(function() {
	$('#lblExito').addClass('d-none');
	$('#lblError').addClass('d-none');
	if( $('#txtDniPers').val()=='' || $('#txtNombrePers').val()=='' || $('#txtApellidoPers').val()=='' ){
		$('#lblError').removeClass('d-none').find('span').text('Debe rellenar todos los campos obligatorio');
	}else if( $('#sltFiltroNiveles').selectpicker('val') == null ){
		$('#lblError').removeClass('d-none').find('span').text('Debe rellenar un nivel');
	} else{
		$('#lblExito').addClass('d-none');
		$('#lblError').addClass('d-none');
		$.ajax({url: 'php/crearPersonal.php', type: 'POST', data: {nick: $('#txtNickPers').val(), apellido: $('#txtApellidoPers').val(), nombre: $('#txtNombrePers').val(), passw: $('#txtPassPers').val(), poder: $('#sltFiltroNiveles').selectpicker('val') }}).done(function(resp) {
			console.log(resp)
			if($.trim(resp)=='todo ok'){
				//$('#modalNuevoPersonal').modal('hide');
				$('#modalNuevoPersonal input').val('');
				$('#lblExito').removeClass('d-none').find('span').text('Registro guardado con éxito');
			}else{
				$('#lblError').removeClass('d-none').find('span').text('Hubo un error interno, comunícalo a soporte informático');
			}
			$('#modalNuevoPersonal').on('hidden.bs.modal', function () { 
				location.reload();
			});
		});
	}
});
$('#btnModificarUsuarios').click(function() {
	$('#modalListadoPersonal').modal('show');
});
function updateDescipcion(idMantenimiento, idPlaca, posicion){
	var padre= $('tbody tr').eq(posicion); //console.log(padre.html())
	$.idMantenimiento = idMantenimiento;
	$.idPlaca = idPlaca;
	$('#sltPlacasMantEdit').val(idPlaca ).selectpicker('render');
	$('#txtFechaMantEdit').val(moment(padre.find('.tdFecha').text() , 'DD/MM/YYYY').format('YYYY-MM-DD'));
	$('#sltTipoMantEdit').val(padre.find('.tdTipoMant').attr('data-id') ).selectpicker('render');
	$('#txtDescipcionMantEdit').val(padre.find('.tdDescipcion').text());
	$('#txtKilometrajeMantEdit').val(padre.find('.tdKilo').text());
	$('#txtLugarMantEdit').val(padre.find('.tdLugar').text());
	$('#txtResponsableMantEdit').val(padre.find('.tdResponsable').text());
	$('#txtMontoMantEdit').val(padre.find('.tdMonto').text());
	if( padre.find('.tdArchivo').html().length>5 ){
		//console.log('hayArchi')
		$('#spanArchiAdjunto').text(padre.find('.tdArchivo a').attr('href').replace('./files/','') ).parent().removeClass('d-none');
		$('#txtAdjuntoMantEdit').addClass('d-none');
	}else{
		//console.log('no hayArchi')
		$('#spanArchiAdjunto').parent().addClass('d-none');
		$('#txtAdjuntoMantEdit').removeClass('d-none');
	}
	if( padre.find('.tdFactura').html().length>5 ){
		//console.log('hayArchi')
		$('#spanFacturaEdit').text(padre.find('.tdFactura a').attr('href').replace('./facturas/','') ).parent().removeClass('d-none');
		$('#txtFacturaEdit').addClass('d-none');
	}else{
		//console.log('no hayArchi')
		$('#spanFacturaEdit').parent().addClass('d-none');
		$('#txtFacturaEdit').removeClass('d-none');
	}
	$('#modalEditMantenimiento').modal('show');
}
$('#btnBorrarArchivo').click(function() {
	$.post("php/borrarArchivo.php", {idMantenimiento: $.idMantenimiento, archivo: $('#spanArchiAdjunto').text() }).done(function (resp) {
		if(resp=='todo ok'){
			location.reload();
		}
	});
});
$('#btnBorrarFacturaEdit').click(function() {
	$.post("php/borrarFactura.php", {idMantenimiento: $.idMantenimiento, archivo: $('#spanFacturaEdit').text() }).done(function (resp) {
		if(resp=='todo ok'){
			location.reload();
		}
	});
});
$('#btnGuardarMantenimientoEdit').click(function() {
	if( $('#txtFechaEdit').val()=="" ){
		$('#modalEditMantenimiento .pError').removeClass('d-none');
		$('#modalEditMantenimiento #errorMensaje').text('Fecha incorrecta');
	//}else if( $(`#sltTipoMantEdit option:contains('${$('#sltTipoMantEdit').parent().find('.selected a').text()}')`).attr('value') ==null){ 
	}else if( $('#sltTipoMantEdit').selectpicker('val') ==null){ 
		$('#modalEditMantenimiento .pError').removeClass('d-none');
		$('#modalEditMantenimiento #errorMensaje').text('Falta seleccionar un tipo de mantenimiento');
	}else if( $('#txtDescipcionMantEdit').val()=="" ){
		$('#modalEditMantenimiento .pError').removeClass('d-none');
		$('#modalEditMantenimiento #errorMensaje').text('La descripción no puede estar vacía');
	}else if( $('#txtLugarEdit').val()=="" ){
		$('#modalEditMantenimiento .pError').removeClass('d-none');
		$('#modalEditMantenimiento #errorMensaje').text('El lugar no puede estar vacío');
	}else{
		var kilome=0, monto=0;
		if( $('#txtKilometrajeMantEdit').val()!="" ){ kilome = $('#txtKilometrajeMantEdit').val(); }
		if( $('#txtMontoMantEdit').val()!="" ){ monto = $('#txtMontoMantEdit').val(); }

	$.ajax({url: 'php/actualizarMantenimiento.php', type: 'POST',
		data: {
			//placa: $(`#sltPlacasMantEdit option:contains(${$('#sltPlacasMantEdit').parent().find('.selected a').text()})`).attr('value'),
			fecha: $('#txtFechaMantEdit').val(),
			tipo: $('#sltTipoMantEdit').selectpicker('val'),
			descripcion: $('#txtDescipcionMantEdit').val(),
			kilome: kilome,
			lugar: $('#txtLugarMantEdit').val(),
			responsable: $('#txtResponsableMantEdit').val(),
			monto: monto,
			idMantenimientoReg: $.idMantenimiento
		} }).done(function(resp) { console.log(resp)
			$('#modalEditMantenimiento').modal('hide');
			if($.isNumeric(resp)){
				//$('#modalGuardadoExitoso').modal('show');

				subirAdjuntoE(resp)
				.then(que=>{
					console.log('respuesta 1' , que);
					subirFacturaE(resp)
					.then(que2=>{
						console.log('respuesta 2' , que2);
						$('#modalEditMantenimiento').modal('hide');
						if(que && que2){
							$('#modalGuardadoExitoso').modal('show');
						}else{
							$('#h5DetalleFaltan').text('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
							$('#modalFaltaDatos').modal('show');
						}
					})
				})
			
			}else{
				$('#h5DetalleFaltan').text('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
				$('#modalFaltaDatos').modal('show');
			}
			
		});
		$('#modalGuardadoExitoso').on('hidden.bs.modal', function () { 
			location.reload();
		});
	}
});


function modalFoto(){
	$('#modalFoto').modal('show');
}
<?php } ?>
function pantallaOver(tipo) {
	if(tipo){$('#overlay').css('display', 'initial');}
	else{ $('#overlay').css('display', 'none'); }
}

function datosIniciales(){
	<?php if( isset($_GET['placa']) ):?>
		document.getElementById('fPlaca').innerText = "<?= $_GET['placa']; ?>";
		let datos = new FormData();
		datos.append('placa', "<?= $_GET['placa']; ?>");
		fetch('php/pedirDatosPorPlaca.php',{
			method:'POST', body:datos
		}).then(promesa=>{
			promesa.json()
			.then(resp=>{
				console.log(resp);
				idGlobal = resp.id;
				if(resp.foto ==''){
					document.getElementById('imgFoto').src="./images/bosquejo.png";
				}else{
					document.getElementById('imgFoto').src="./images/"+resp.foto;
				}
			})
		
		})
	<?php endif;?>
}
function previsualizarFoto(){
	const input = document.getElementById('plaFoto');
	if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#divPreview')
        .attr('src', e.target.result)
        .width(150)
        .height('auto')
				.css('display', 'block')
				;
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function subirFotoPlaca(){
	if( $('#plaFoto')[0].files[0]!=null ){
		var formData= new FormData();
		var archivo = $('#plaFoto')[0].files[0];
		formData.append("archivo", archivo );
		formData.append("idPlaca", idGlobal );
		$.ajax({url: 'php/subirArchivo_foto.php', type: 'POST', data: formData, contentType: false, processData: false, cache:false
			}).done(function(resp) { console.log(resp)
			$('#modalFoto').modal('hide');
			location.reload();
		});
	}
}
function abrirMantenimientoAutomatico(){
	$('#sltPlacasMant').val( idGlobal ).selectpicker('render');
	$('#modalAddMantenimiento').modal('show');
}
idIndex = -1; idPlacaAct = -1;
function activarActualizacionBasicos(index, placa){
	let fila = $('#modalAddPlaca tr').eq(index);
	fila.find('.btnActualizar').removeClass('d-none')
	idIndex = index;
	idPlacaAct = placa;
}
function actualizarPlaca(){
	let fila = $('#modalAddPlaca tr').eq(idIndex);
	
	let data = new FormData();
	data.append('idPlaca', idPlacaAct )
	data.append('ano', fila.find('.ano').val() )
	data.append('rangoAceite', fila.find('.rangoAceite').val() )
	data.append('porcentajeAceite', fila.find('.porcentajeAceite').val() )
	data.append('rangoCaja', fila.find('.rangoCaja').val() )
	data.append('porcentajeCaja', fila.find('.porcentajeCaja').val() )
	fetch('php/actualizarPlacas.php',{
		method:'POST', body:data
	})
	.then(response => response.text() )
	.then(respuesta => fila.find('.btnActualizar').addClass('d-none') )
}
txtBuscarPlaca = document.getElementById('txtBuscarPlaca')
document.querySelector('#txtBuscarPlaca').addEventListener('keypress', function (e) {
	if (e.key === 'Enter') {
		buscarPlaca();
	}
});
function buscarPlaca(){
	
	let texto = txtBuscarPlaca.value;
	let todo = document.querySelectorAll('table tbody tr');
	let filtro = ''
	let arreglo = texto.toLowerCase().replace(' ','').split(',');

	todo.forEach( campo=>{
		

		if(texto ==''){
			campo.classList.remove('d-none')
		}
		filtro = campo.querySelectorAll('td')[3].innerText
					
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
</script>
