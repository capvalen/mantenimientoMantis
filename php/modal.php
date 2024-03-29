<div class="modal fade" id="modalGuardadoExitoso" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
			<div class="text-center">
				<img src="images/path4585.png" alt="" class="img-fluid">
			</div>
        <h4 class="pt-2 deep-purple-text text-center">Guardado Exitósamente</h4>
				<h5 class="text-center text-muted" id="h5Detalle"></h5>
      </div>
      <div class="modal-footer border-0">
				<p class="text-danger d-none" id="pError3"></p>
        <button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="bi bi-check"></i> Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFaltaDatos" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
			<div class="text-center">
				<img src="images/sadfolder.png" alt="" class="img-fluid">
			</div>
        <h4 class="pt-2 deep-purple-text text-center">Faltan Datos</h4>
				<h5 class="text-center text-muted" id="h5DetalleFaltan"></h5>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="bi bi-check"></i> Ok</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalListadoPersonal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Listado de personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="table-responsive">
					<button class="btn btn-outline-success mb-2" id="btnAddNewUser"><i class="bi bi-person-plus"></i> Agregar nuevo personal</button>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Apellidos y Nombres</th>
								<th>Nick</th>
								<th>Nivel</th>
								<th>@</th>
							</tr>
						</thead>
						<tbody>
							<?php require 'listarPersonal.php'; ?>
						</tbody>
					</table>
				</div>
      </div>
     
    </div>
  </div>
</div>
<div class="modal fade" id="modalNuevoPersonal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="icofont-plus-circle"></i> Agregar personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>Nick</p>
				<input type="text" class="form-control" id="txtNickPers">
				<p>Nombres</p>
				<input type="text" class="form-control text-capitalize" id="txtNombrePers">
				<p>Apellidos</p>
				<input type="text" class="form-control text-capitalize" id="txtApellidoPers">
				<p>Contraseña</p>
				<input type="text" class="form-control" id="txtPassPers">
				<p>Nivel de acceso</p>
				<select class="selectpicker" data-live-search="false" id="sltFiltroNiveles" title="&#xed12; Filtro de Niveles">
					<option value="1">Administrador</option>
					<option value="2">Colaborador</option>
				</select>
      </div>
      <div class="modal-footer border-0">
				<label for="" class="text-danger d-none" id="lblError"><i class="bi bi-exclamation-circle"></i> <span></span></label>
				<label for="" class="text-success d-none" id="lblExito"><i class="bi bi-gear-wide"></i> <span></span></label>
        <button type="button" class="btn btn-outline-primary" id="btnGuardarPersona"><i class="bi bi-node-plus"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalBorrarPersonal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrar personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>¿Está seguro que desea borrar a: <strong id="strNombre"></strong>?</p>
      </div>
      <div class="modal-footer border-0">				
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal" id="btnCancelarBorrar"><i class="bi bi-x"></i> Cancelar</button>
        <button type="button" class="btn btn-outline-danger" id="btnBorrarPersona"><i class="bi bi-eraser"></i> Borrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalBorrarRegistro" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>¿Está seguro que desea éste registro?</p>
      </div>
      <div class="modal-footer border-0">				
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal" id="btnCancelarBorrar"><i class="bi bi-x"></i> Cancelar</button>
        <button type="button" class="btn btn-outline-danger" id="btnBorrarRegistro"><i class="bi bi-eraser"></i> Borrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalBorrarPlaca" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<p>¿Está seguro que desea ésta placa?</p>
      </div>
      <div class="modal-footer border-0">				
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal" id="btnCancelarBorrar"><i class="bi bi-x"></i> Cancelar</button>
        <button type="button" class="btn btn-outline-danger" id="btnBorrarPlaca"><i class="bi bi-eraser"></i> Borrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para adjuntar la foto -->
<div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="exampleModalLabel">Foto de la placa: <span id="fPlaca"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Puede subir una nueva foto para la unidad</p>
				<input type="file" id="plaFoto" class="form-control" onchange="previsualizarFoto()" accept="image/*">
				<div id="">
					<img id="divPreview" src="#" alt="image" style="width:70%;height:auto; margin:0 auto;display: none;">
				</div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary" onclick="subirFotoPlaca()" data-dismiss="modal">Subir archivo</button>
      </div>
    </div>
  </div>
</div>