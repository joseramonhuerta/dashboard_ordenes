<!-- Modal -->
<div class="modal fade" id="modalFormProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
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
            <form id="formProducto" name="formProducto" class="form-horizontal">
              <input type="hidden" id="idProducto" name="idProducto" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="txtNombre">Nombre Producto</label>
                  <input type="text" class="form-control valid" id="txtNombre" name="txtNombre" required="">
                </div>                
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtCodigo">Codigo</label>
                  <input type="text" class="form-control valid" id="txtCodigo" name="txtCodigo" required="">
                </div>                
              </div>
              <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtDescripcionProducto">Descripcion</label>
                    
                    <textarea class="form-control valid" id="txtDescripcionProducto" name="txtDescripcionProducto" rows="3"></textarea>
                  </div>                
                </div>  
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="txtPrecio">Precio</label>
                  <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" required="" onkeypress="return validarPrecio(event);">
                </div>
                <div class="form-group col-md-5">
                  <label for="txtPrecioMayoreo">Precio Mayoreo</label>
                  <input type="text" class="form-control" id="txtPrecioMayoreo" name="txtPrecioMayoreo" required="" onkeypress="return validarPrecio(event);">
                </div>
              </div>
              <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="listCategoria">Categoria</label>
                    <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria" required="">
                    </select>
                  </div>                
                </div>
              
             
             <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStatus">Estatus</label>
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
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Nombre Producto:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Codigo:</td>
              <td id="celCodigo">Jacob</td>
            </tr>
            <tr>
              <td>Descripcion:</td>
              <td id="celDescripcion">Jacob</td>
            </tr>
            <tr>
            <tr>
              <td>Precio:</td>
              <td id="celPrecio">100.00</td>
            </tr>
            <tr>
              <td>Precio Mayoreo:</td>
              <td id="celPrecioMayoreo">85.00</td>
            </tr>
            <tr>
              <td>Categoria:</td>
              <td id="celCategoria">Larry</td>
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

