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
<section>
	<div class="row py-2">
		<div class="order-0 order-md-0 col-6 col-md-3 text-center">
			<img src="https://contratistasjkm.com/portal/wp-content/uploads/2019/07/logo-transportes.png" class="img-fluid"></div>
		<div class="order-2 order-md-1 col-12 col-md-6">
			<h3 class="text-center pt-3 ">Transportes & Contratistas JKM S.R.L.</h3>
			<h3 class="text-center ">Registro de fechas de vencimiento</h3>
			
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
			<div class="resultado table-responsive"></div>
		</div>
		<div class="tab-pane fade" id="caja" role="tabpanel" aria-labelledby="caja-tab">
			<div class="resultado table-responsive"></div>
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
	
<?php include 'php/modal.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script>
	var idPlaca=-1;
	function cambiarPlantilla(tipo){
		var datos = new FormData();
		datos.append('tipo', tipo)
		switch (tipo) {
			case 'soat':
				fetch('php/vencimientos/plantilla.php',{
					method:'POST', body:datos
				}).then(resp=>{
					resp.text()
					.then(data=>{
						//console.log(data);
						document.querySelector('#soat .resultado').innerHTML=data;
					})
				})
				
				break;
			case 'aceite':
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
</script>
</body>
</html>