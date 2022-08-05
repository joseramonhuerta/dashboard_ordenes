<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
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
            <form id="formCliente" name="formCliente" class="form-horizontal">
              <input type="hidden" id="idCliente" name="idCliente" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtNombre">Nombres</label>
                  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>                
              </div>
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtCelular">Celular</label>
                  <input type="text" class="form-control valid validNumber" id="txtCelular" name="txtCelular" required="" onkeypress="return controlTag(event);">
                </div>
              </div>
                            
             <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtDireccion">Dirección</label>
                  
                  <textarea class="form-control valid validText" id="txtDireccion" name="txtDireccion" required="" rows="3"></textarea>
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
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
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
              <td>Celular:</td>
              <td id="celCelular">Jacob</td>
            </tr>
            <tr>
            <tr>
              <td>Dirección:</td>
              <td id="celDireccion">Jacob</td>
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
