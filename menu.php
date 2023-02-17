<?php $nomArchivo = basename($_SERVER["SCRIPT_FILENAME"]);?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5">
  <a class="navbar-brand" href="#">Control de mantenimientos </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav mr-auto">
		<?php if($_COOKIE['ckPower']=='1' && $nomArchivo =='reporte.php' ): ?>
			<li class="nav-item dropdown <?php if($nomArchivo =='reporte.php') echo 'active'; ?>">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="bi bi-gear-wide"></i> Configuraciones
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
    		  <a class="dropdown-item" href="#!" id="btnAgregarSerie"><i class="bi bi-aspect-ratio"></i> Configurar Placas</a>
					<a class="dropdown-item" href="#!" id="btnAgregarManteniminto" ><i class="bi bi-node-plus"></i> Agregar Mantenimiento</a>
					<a class="dropdown-item" href="#!" id="btnModificarUsuarios" ><i class="bi bi-person-plus"></i> Controlar usuarios</a>
				</div>
			</li>
    
		<?php else: ?>
			<li class="nav-item dropdown <?php if($nomArchivo =='reporte.php' ) echo 'active'; ?>">
				<a class="nav-link" href="reporte.php" id="navbarDropdown" role="button" > 
					<i class="bi bi-house"></i> Reportes </a>
			</li>
		<?php endif; ?>
			<li class="nav-item dropdown <?php if($nomArchivo =='vencimientos.php' ) echo 'active'; ?>">
				<a class="nav-link" href="vencimientos.php" id="navbarDropdown" role="button" > 
					<i class="bi bi-bar-chart-steps"></i> Vencimientos </a>
			</li>
			
	</div>
	<?php if($nomArchivo =='reporte.php'):?>
	<div class="form-inline">
		<select class="selectpicker" data-live-search="true" id="sltPlacas" title="&#xed11; Filtro de placas">
			<?php include 'php/optPlacas.php'; ?>
		</select>
	</div>
	<?php endif;?>

	<a class="nav-item nav-link text-light" href="desconectar.php"><i class="bi bi-sign-turn-left"></i> Salir del sistema</a>
  </div>
</nav>