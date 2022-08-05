<!-- Modal -->
<div class="modal fade" id="modalFormSolicitud" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Servicio</h5>
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
            <form id="formSolicitud" name="formSolicitud" class="form-horizontal">
              <input type="hidden" id="idOrdenServicio" name="idOrdenServicio" value="">
              <!--<p class="text-primary">Todos los campos son obligatorios.</p>-->
                 
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#Generales" role="tab" data-toggle="tab">Datos Generales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#Tecnicos" role="tab" data-toggle="tab">Datos Técnicos</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#Administrativos" role="tab" data-toggle="tab">Datos Administrativos</a>
                </li>
                
              </ul>
              <!-- nav tabs-->  
              <div class="tab-content">
              <!-- tab generales-->
              <div role="tabpanel" class="tab-pane active" id="Generales">
                <!-- Rows-->
                 <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtFolio">Folio</label>
                    <input type="text"  class="form-control valid validText" id="txtFolio" name="txtFolio" required="" disabled="true" value="0">
                  </div>                
                </div>        
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="txtFecha">Fecha</label>
                    <input type="text"  class="form-control valid validText" id="txtFecha" name="txtFecha" readonly="">
                  </div>                
                </div>        

                


                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="listCliente">Cliente</label>
                    <select class="form-control" data-live-search="true" id="listCliente" name="listCliente" required="">
                    </select>
                  </div>                
                </div>
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtCelular">Celular</label>
                    <input type="text" class="form-control valid validNumber" id="txtCelular" name="txtCelular" disabled="true">
                  </div>
                </div>
                        
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtNombreEquipo">Nombre Equipo</label>
                    <input type="text"  class="form-control valid" id="txtNombreEquipo" name="txtNombreEquipo" required="">
                  </div>                
                </div>  
                
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtModeloEquipo">Modelo Equipo</label>
                    <input type="text"  class="form-control" id="txtModeloEquipo" name="txtModeloEquipo">
                  </div>                
                </div>  

                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtSerieEquipo">Serie Equipo</label>
                    <input type="text"  class="form-control" id="txtSerieEquipo" name="txtSerieEquipo">
                  </div>                
                </div>     
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtDescripcionFalla">Descripcion Falla</label>
                    
                    <textarea class="form-control valid validText" id="txtDescripcionFalla" name="txtDescripcionFalla" required="" rows="3"></textarea>
                  </div>                
                </div>  

                  
                <!-- fin Rows-->                
                </div>
                <!-- fin tab generales-->
                <!-- tab tecnicos-->  
                <div role="tabpanel" class="tab-pane" id="Tecnicos">
                  <div class="form-row">
                    <div class="form-group col-md-10">
                      <label for="listTecnico">Tecnico</label>
                      <select class="form-control" data-live-search="true" id="listTecnico" name="listTecnico" required=""></select>
                    </div>
                    
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-10">
                      <label for="txtDescripcionDiagnostico">Descripcion Diagnostico</label>
                    
                      <textarea class="form-control valid validText" id="txtDescripcionDiagnostico" name="txtDescripcionDiagnostico" rows="3"></textarea>
                      </div>                
                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtDescripcionReparacion">Descripcion Reparacion</label>
                    
                    <textarea class="form-control" id="txtDescripcionReparacion" name="txtDescripcionReparacion"  rows="3"></textarea>
                  </div>                
                </div>


                </div>
                <!-- fin tab tecnicos-->
                <!-- tab administrativos-->
                <div role="tabpanel" class="tab-pane" id="Administrativos">
                  <div class="form-row">
                  <div class="form-group col-md-10">
                    <label for="txtPresupuesto">Presupuesto</label>
                    <input type="text"  class="form-control" id="txtPresupuesto" name="txtPresupuesto" onkeypress="return validarPrecio(event);">
                  </div>                
                </div>  
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="listStatus">Estatus</label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
                        <option value="1">Recibido</option>
                        <option value="2">Revisión</option>
                        <option value="3">Cotización</option>
                        <option value="4">Reparación</option>
                        <option value="5">Reparado</option>
                        <option value="6">Entregado</option>
                        <option value="7">Devolución</option>
                    </select>
                </div>               
             </div>  

                </div> 
                <!-- fin tab administrativos-->
              </div>    
              <!-- fin nav tabs-->   

              
              
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
<div class="modal fade" id="modalViewSolicitud" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Fecha:</td>
              <td id="celFecha">Jacob</td>
            </tr>
            <tr>
              <td>Nombre Cliente:</td>
              <td id="celNombreCliente">Jacob</td>
            </tr>
             <tr>
              <td>Celular:</td>
              <td id="celCelular">Jacob</td>
            </tr>
            <tr>
            <tr>
              <td>Nombre Equipo:</td>
              <td id="celNombreEquipo">Jacob</td>
            </tr>
            <tr>
              <td>Modelo Equipo:</td>
              <td id="celModeloEquipo">Jacob</td>
            </tr>
            <tr>
              <td>Serie Equipo:</td>
              <td id="celSerieEquipo">Jacob</td>
            </tr>
            <tr>
              <td>Descripcion Falla:</td>
              <td id="celDescripcionFalla">Jacob</td>
            </tr>
            <tr>
              <td>Nombre Tecnico:</td>
              <td id="celNombreTecnico">Jacob</td>
            </tr>
            <tr>
              <td>Descripcion Diagnostico:</td>
              <td id="celDescripcionDiagnostico">Jacob</td>
            </tr>
            <tr>
              <td>Descripcion Reparacion:</td>
              <td id="celDescripcionReparacion">Jacob</td>
            </tr>
            <tr>
              <td>Importe Presupuesto:</td>
              <td id="celImportePresupuesto">Jacob</td>
            </tr>
            <tr>
              <td>Estatus:</td>
              <td id="celEstatus">Jacob</td>
            </tr>
            <tr>            

              
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


