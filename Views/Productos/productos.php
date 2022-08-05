<?php 
    headerAdmin($data); 
    getModal('modalProductos',$data);
?>
<div id="contentAjax"></div>
  <main class="app-content">    
      <div class="app-title">
        <div>
            <h1><i class="fa fa-product-hunt"></i> <?= $data['page_title'] ?>
                
               <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
             
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/productos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableProductos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre Producto</th>
                          <th>Codigo</th>
                          <th>Descripcion</th>
                          <th>Categoria</th>
                          <th>Precio</th>
                          <th>Precio Mayoreo</th>
                          <th>Estatus</th>
                          <th>Acciones</th> 
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Producto 1</td>
                          <td>P00001</td>
                          <td>Descripcion del Producto</td>
                          <td>Accesorios</td>
                          <td>2.00</td>
                          <td>1.00</td>
                          <td>Activo</td>
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