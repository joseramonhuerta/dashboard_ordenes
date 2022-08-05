<!-- Modal -->
<div class="modal fade" id="modalFormVenta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Venta</h5>
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
        <form id="formVenta" name="formVenta" class="form-horizontal">
          <!-- Info generales -->  
          <div class="card">                            
            <div class="card-body">  
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label for="txtFecha">Fecha</label>
                  <input type="text" class="form-control valid validText" id="txtFecha" name="txtFecha" required="" readonly="">
                </div>
                
              </div>

              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="listCliente">Cliente</label>
                  <select class="form-control" data-live-search="true" id="listCliente" name="listCliente" required="">
                    </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="txtObservaciones">Observaciones</label>
                  <input type="text" class="form-control" id="txtObservaciones" name="txtObservaciones" required="" >
                </div>
              </div>
            </div>
          </div>
        </form>  
        <form id="formDetalle" name="formDetalle" class="form-horizontal">
          <!-- Agregar productos -->  
          <div class="card mt-4">                           
            <div class="card-body">  
              <div class="form-row">
                <div class="form-group col-md-2">
                  <label for="txtCantidad">Cantidad</label>
                  <input type="text" class="form-control" id="txtCantidad" name="txtCantidad" onkeypress="return validarPrecio(event);">
                </div>
                <div class="form-group col-md-5">
                  <label for="listProducto">Descripcion</label>
                  <select class="form-control" data-live-search="true" id="listProducto" name="listProducto" required="">
                    </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="txtPrecio">P.Unitario</label>
                  <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" onkeypress="return validarPrecio(event);">
                </div>
                <div class="form-group col-md-2">
                  <label for="txtSubtotal">Subtotal</label>
                  <input type="text" class="form-control" id="txtSubtotal" name="txtSubtotal" readonly="">
                </div>
                 <div class="orm-group col-md-1">
                <button class="btn btn-primary boton-add-producto" type="submit" id="btnAgregar"><i class="fas fa-plus-circle"></i></button>
              </div>
              </div>                     
            </div>
          </div>
        </form>   
        <!-- Tabla detalles -->
        <table class="table mt-4 text-center">
          <thead>
            <tr>
              <th>Cantidad</th>
              <th>Descripcion</th>
              <th>P. Unitario</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tableDetalles"></tbody>
        </table>            
        <div class="tile-footer mt-5">
          <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
          <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</tton>
        </div>           
      </div>
    </div>
  </div>
</div>




