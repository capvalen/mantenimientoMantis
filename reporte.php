<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reportes - Transportes y Contratistas JKM EIRL</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	
</head>
<body>
<style>
.bootstrap-select .dropdown-toggle .filter-option{font-family:'Icofont', 'Segoe UI';}
.bootstrap-select .dropdown-toggle .filter-option {
    border: 1px solid #c5c5c5;
    border-radius: .25rem;
}

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5">
  <a class="navbar-brand" href="#">Control de mantenimientos </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav mr-auto">
		<?php if($_COOKIE['ckPower']=='1'): ?>
			<li class="nav-item dropdown <?php if($nomArchivo =='productos.php' || $nomArchivo =='compras.php') echo 'active'; ?>">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="icofont-newspaper"></i> Configuraciones
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    		  <a class="dropdown-item" href="#!" id="btnAgregarSerie"><i class="icofont-id"></i> Configurar Placas</a>
					<a class="dropdown-item" href="#!" id="btnAgregarManteniminto" ><i class="icofont-tools-alt-2"></i> Agregar Mantenimiento</a>
					<a class="dropdown-item" href="#!" id="btnModificarUsuarios" ><i class="icofont-users-alt-1"></i> Controlar usuarios</a>
				</div>
			</li>
    
		<?php endif; ?>
	</div>
	<div class="form-inline">
		<select class="selectpicker" data-live-search="true" id="sltPlacas" title="&#xed11; Filtro de placas">
			<?php include 'php/optPlacas.php'; ?>
		</select>
	</div>
	<a class="nav-item nav-link text-light" href="desconectar.php"><i class="icofont-addons"></i> Salir del sistema</a>
  </div>
</nav>
<div class="container-fluid">
<section>
<div class="row">
<div class="col-4 col-sm-3 col-lg-2  text-center">
<img src="images/64649944_384295198856923_3228315122975899648_n.jpg" class="img-fluid"></div>
<div class="col-8 col-sm-9">
	<h3 class="text-center pt-3 ">Transportes y Contratistas JKM EIRL</h3>
	<h3 class="text-center ">Control de mantenimiento</h3>
</div>
</div>
	
		<?php if(isset($_GET['placa'])){?> <h4 class="text-center pb-5">Placa: <?= $_GET['placa'];?></h4> 

	<table class="table table-hover">
		<thead>
			<tr>
				<th>N°</th>
				<th>Fecha</th>
				<th>Tipo de Mantenimiento</th>
				<th>Descripción</th>
				<th>Kilometraje</th>
				<th>Lugar</th>
				<th>Responsable</th>
				<th>Monto</th>
				<th>Adjunto</th>
			</tr>
		</thead>
		<tbody>
			<?php include "php/listarReportePlacas.php";?>
		</tbody>
	</table>
	<?php }else{ ?>
	<p>Empieze seleccionando una placa en la esquina superior derecha.</p>
	<?php } ?>
</section>
</div>

<?php if( $_COOKIE['ckPower']==1){ ?>
<!-- Modal para: agregar una placa -->
<div class="modal fade" id="modalAddPlaca" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Placa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Rellene la serie de la placa:</p>
				<input type="text" class="form-control text-uppercase" id="txtPlacaNueva">
				<p class="pError text-danger d-none"><i class="icofont-cat-alt-3"></i> <span id="errorMensaje"></span></p>
				<button type="button" class="btn btn-outline-primary" id="btnGuardarPlacaNew"><i class="icofont-save"></i> Guardar</button>
				
				<table class="table table-hover">
				<thead>
				<tr><th>N°</th>
				<th>Placa</th>
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
				<p>Rellene os campos básicos:</p>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Placa:</label>
					<div class="col-sm-9">
					<select class="selectpicker" data-live-search="true" id="sltPlacasMant" title="&#xed11; Placas disponibles">
						<?php include 'php/optPlacas.php'; ?>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Fecha:</label>
					<div class="col-sm-9">
					<input type="date" class="form-control" id="txtFechaMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Tipo mantenimiento:</label>
					<div class="col-sm-9">
					<select class="selectpicker" data-live-search="true" id="sltTipoMant" title="&#xed11; Tipo de mantenimiento">
						<option value="1">Preventivo</option>
						<option value="2">Correctivo</option>
					</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Descripción:</label>
					<div class="col-sm-9">
					<textarea class="form-control" id="txtDescipcionMant"  rows="3"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Kilometraje:</label>
					<div class="col-sm-9">
					<input type="number" class="form-control" id="txtKilometrajeMant" value="0" min="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Lugar:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtLugarMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Responsable:</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="txtResponsableMant">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Monto:</label>
					<div class="col-sm-9">
					<input type="number" class="form-control" id="txtMontoMant" value="0">
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-3 col-form-label">Archivo adjunto:</label>
					<div class="col-sm-9">
					<input type="file" class="form-control" id="txtAdjuntoMant" accept=".png, .jpg, .jpeg, .doc,.docx, .pdf, .xls, xlsx">
					</div>
				</div>
				
				<p class="pError text-danger d-none"><i class="icofont-cat-alt-3"></i> <span id="errorMensaje"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" id="btnGuardarMantenimientoNew"><i class="icofont-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function() {
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	$('#txtFechaMant').val( moment().format('YYYY-MM-DD') );
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
	if( $('#txtPlacaNueva').val()==''){
		$('#modalAddPlaca .pError').removeClass('d-none');
		$('#errorMensaje').text('Debe rellenar un valor en la placa');
	}else{
		$.ajax({url: 'php/insertarPlaca.php', type: 'POST', data: { placa: $('#txtPlacaNueva').val() }}).done(function(resp) {
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

				if( $('#txtAdjuntoMant')[0].files[0]!=null ){
				var formData= new FormData();
				var archivo = $('#txtAdjuntoMant')[0].files[0];
				formData.append("archivo", archivo );
				formData.append("placa", $('#sltPlacasMant').selectpicker('val') );
				formData.append("idReg", resp );
				$.ajax({url: 'php/subirArchivo.php', type: 'POST', data: formData, contentType: false, processData: false,
					cache:false
						}).done(function(resp2) { console.log(resp2)
						$('#modalAddMantenimiento').modal('hide');
						if(resp2=='ok'){
							$('#modalGuardadoExitoso').modal('show');
							//$.post('php/updateNombreFile.php', {idPlaca: $('#sltPlacasMant').selectpicker('val'), subida: encodeURIComponent(archivo.name)} ).done(function(respuesta){console.log(respuesta)})
						}else{
							$('#h5DetalleFaltan').text('Ocurrió subiendo su archivo, pero los registros se realizaron correctamente');
							$('#modalFaltaDatos').modal('show');
						}
					});
				}else{
					$('#modalGuardadoExitoso').modal('show');
				}
			
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


<?php } ?>
function pantallaOver(tipo) {
	if(tipo){$('#overlay').css('display', 'initial');}
	else{ $('#overlay').css('display', 'none'); }
}
</script>
