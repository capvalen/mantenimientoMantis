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
    		  <a class="dropdown-item" href="#!" id="btnAgregarSerie"><i class="icofont-id"></i> Agregar Placa</a>
					<a class="dropdown-item" href="#!" ><i class="icofont-tools-alt-2"></i> Agregar Mantenimiento</a>
					<a class="dropdown-item" href="#!" ><i class="icofont-users-alt-1"></i> Controlar usuarios</a>
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
	<h3 class="text-center pt-3 ">Transportes y Contratistas JKM EIRL</h3>
	<h3 class="text-center ">Control de mantenimiento</h3>
		<?php if(isset($_GET['placa'])){?> <h4 class="text-center pb-5">Placa: <?= $_GET['placa'];?></h4> 

	<table class="table table-hover">
		<thead>
			<tr>
				<th>N°</th>
				<th>Fecha</th>
				<th>Tipo de Mantenimiento</th>
				<th>Descripción</th>
				<th>Kilometraje</th>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" id="btnGuardarPlacaNew"><i class="icofont-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/bootstrap-select.min.js"></script>
<script>
$('.selectpicker').selectpicker('render');
$('.selectpicker').selectpicker('val', -1);
$('#sltPlacas').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
	var placa=$(this).parent().parent().find('.selected a').text();
	console.log( placa )
	window.location.href = 'reporte.php?placa='+placa; //$('#sltPlacas').val()
});
<?php if( $_COOKIE['ckPower']==1){ ?>
$('#btnAgregarSerie').click(function() {
	$('#modalAddPlaca').modal('show');
});
$('#btnGuardarPlacaNew').click(function() {
	if( $('#txtPlacaNueva').val()==''){
		$('#modalAddPlaca').removeClass('d-none');
		$('#errorMensaje').val('Debe rellenar un valor en la placa');
	}else{
		$.ajax({url: 'php/insertarPlaca.php', type: 'POST', data: { placa: $('#txtPlacaNueva').val() }}).done(function(resp) {
//			console.log(resp)
			$('#modalAddPlaca').modal('hide');
			if(resp=='ok'){
				$('#modalGuardadoExitoso').modal('show');
			}else{
				$('#h5DetalleFaltan').val('Ocurrió un error al momento de guardar, inténtelo de nuevo porfavor');
				$('#modalFaltaDatos').modal('show');
			}
		});
	}
});
<?php } ?>
</script>
