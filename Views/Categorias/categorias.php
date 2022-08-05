<?php 
    headerAdmin($data); 
    getModal('modalCategorias',$data);
?>
<div id="contentAjax"></div>
  <main class="app-content">    
      <div class="app-title">
        <div>
            <h1><i class="fa fa-code-fork"></i> <?= $data['page_title'] ?>
                
               <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
             
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/categorias"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableCategorias">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre Categoria</th>
                          <th>Estatus</th>
                          <th>Acciones</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Accesorios</td>
                          <td>Estatus</td>
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