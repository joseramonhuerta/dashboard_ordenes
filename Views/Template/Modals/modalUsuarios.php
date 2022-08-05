<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div id="divLoading" >
              <div>
                <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
              </div>
            </div>
            <form id="formUsuario" name="formUsuario" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtNombre">Nombres</label>
                  <input type="text" class="form-control valid" id="txtNombre" name="txtNombre" required="">
                </div>                
              </div>
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtEmail">Email</label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listRolid">Rol</label>
                    <select class="form-control selectpicker" id="listRolid" name="listRolid" required >
                        <option value="1">Administrador</option>
                        <option value="2">Supervisor</option>
                        <option value="3">Vendedor</option>
                        <option value="4">Técnico</option>
                    </select>
                </div>               
             </div>
              
             <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtUsuario">Usuario</label>
                  <input type="text" class="form-control valid validText" id="txtUsuario" name="txtUsuario" required="">
                </div>                
              </div>
             <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtPassword">Password</label>
                  <input type="password" class="form-control" id="txtPassword" name="txtPassword" >
                </div>
             </div>
             <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStatus">Status</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                    </select>
                </div>
             </div> 

              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
             <tr>
              <td>Usuario:</td>
              <td id="celUsuario">Jacob</td>
            </tr>
            <tr>
            <tr>
              <td>Correo:</td>
              <td id="celCorreo">Jacob</td>
            </tr>
            <tr>
              <td>Rol:</td>
              <td id="celRol">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

