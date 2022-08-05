<!-- Modal -->
<div class="modal fade" id="modalFormGasto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Gasto/Ingreso</h5>
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
            <form id="formGasto" name="formGasto" class="form-horizontal">
              <input type="hidden" id="idGasto" name="idGasto" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="txtFecha">Fecha</label>
                    <input type="text"  class="form-control valid validText" id="txtFecha" name="txtFecha" readonly="">
                  </div>                
                </div>
              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtConcepto">Concepto</label>
                  <input type="text" class="form-control valid" id="txtConcepto" name="txtConcepto" required="">
                </div>                
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listTipo">Tipo</label>
                    <select class="form-control selectpicker" id="listTipo" name="listTipo" required >
                        <option value="1">Ingreso</option>
                        <option value="2">Egreso</option>
                    </select>
                </div>
              </div>
              <div id="divOrdenes">
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="listOrdenServicio">Orden de Servicio</label>
                    <select class="form-control" data-live-search="true" id="listOrdenServicio" name="listOrdenServicio" >
                    </select>
                  </div>                
                </div>
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtNombreCliente" id="txtNombreCliente"></label>                  
                  </div>                
                </div>
              </div>  
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="txtImporte">Importe</label>
                  <input type="text" class="form-control" id="txtImporte" name="txtImporte" required="" onkeypress="return validarPrecio(event);">
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
<div class="modal fade" id="modalViewGasto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Gasto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Fecha:</td>
              <td id="celFecha">01/01/2020</td>
            </tr>
            <tr>
              <td>Concepto:</td>
              <td id="celConcepto">Ingreso</td>
            </tr>
            <tr>
              <td>Importe:</td>
              <td id="celImporte">1.00</td>
            </tr>
            <tr>
            <tr>
              <td>Orden Servicio:</td>
              <td id="celOrdenServicio">12345</td>
            </tr>
            <tr>
              <td>Tipo:</td>
              <td id="celTipo">Ingreso</td>
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
