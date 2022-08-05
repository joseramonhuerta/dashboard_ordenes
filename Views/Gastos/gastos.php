<?php 
    headerAdmin($data); 
    getModal('modalGastos',$data);
?>
<div id="contentAjax"></div>
  <main class="app-content">    
      <div class="app-title">
        <div>
            <h1><i class="fa fa-credit-card"></i> <?= $data['page_title'] ?>
                
               <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
             
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Gastos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableGastos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Fecha</th>
                          <th>Concepto</th>
                          <th>Importe</th>
                          <th>Tipo</th>
                          <th>Orden Servicio</th>
                          <th>Acciones</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>04/05/2021 09:00:00</td>
                          <td>Concepto</td>
                          <td>100.00</td>
                          <td>Ingreso</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </main>
<?php footerAdmin($data); ?>