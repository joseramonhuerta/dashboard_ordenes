<?php
class Productos extends Controllers{
	public function __construct(){
		
			
			 session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				//die();
			}
			parent::__construct();
	}

	public function Productos(){
		$data['page_tag'] = "Productos";
		$data['page_title'] = "Productos <small>Ordenes Servicio</small>";
		$data['page_name'] = "productos";
		$data['page_functions_js'] = "functions_productos.js";		
		$this->views->getView($this, "productos",$data);
	}

	public function getProductos(){
		$arrData = $this->model->selectProductos();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			if($arrData[$i]['status_producto'] == 'A')
			{
				$arrData[$i]['status_producto'] = '<span class="badge badge-success">Activo</span>';	
			}else{
				$arrData[$i]['status_producto'] = '<span class="badge badge-danger">Inactivo</span>';	
			}


			$btnView = '<button class="btn btn-info btn-sm btnViewProducto" onClick="fntViewProducto('.$arrData[$i]['id_producto'].')" title="Ver producto"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditProducto" onClick="fntEditProducto(this,'.$arrData[$i]['id_producto'].')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelProducto" onClick="fntDelProducto('.$arrData[$i]['id_producto'].')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function setProducto(){
		if($_POST){			
			if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['txtPrecio']) || empty($_POST['txtPrecioMayoreo']) || empty($_POST['listCategoria']) || empty($_POST['listStatus']) )
			{
				$arrResponse = array("success" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idProducto = intval($_POST['idProducto']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strCodigo = ucwords(strClean($_POST['txtCodigo']));
				$strDescripcion = ucwords(strClean($_POST['txtDescripcionProducto']));
				$dbPrecio = doubleval(strClean($_POST['txtPrecio']));
				$dbPrecioMayoreo = doubleval(strClean($_POST['txtPrecioMayoreo']));
				$intCategoria = intval(strClean($_POST['listCategoria']));
				$strStatus = ucwords(strClean($_POST['listStatus']));
				

				$request_producto = "";
				if($idProducto == 0)
				{
					$option = 1;					
					$request_producto = $this->model->insertProducto($strNombre, $strCodigo, $strDescripcion, $dbPrecio, $dbPrecioMayoreo, $intCategoria, $strStatus);
					
				}else{
					$option = 2;			
					$request_producto = $this->model->updateProducto($idProducto, $strNombre, $strCodigo, $strDescripcion, $dbPrecio, $dbPrecioMayoreo, $intCategoria, $strStatus);		
				}

				if(intval($request_producto) > 0)
				{
					if($option == 1){
						$arrResponse = array('success' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('success' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_producto == 'exist'){
					$arrResponse = array('success' => false, 'msg' => '¡Atención! El Producto ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}	

	public function getProducto($id){
		$id_producto = $id;
		if($id_producto > 0){
			$arrData = $this->model->selectProducto($id_producto);
			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delProducto(){
		if($_POST){
			$id_producto = intval($_POST['idProducto']);
			$requestDelete = $this->model->deleteProducto($id_producto);
			if($requestDelete)
			{
				$arrResponse = array('success' => true, 'msg' => 'Producto eliminado correctamente.');
			}else{
				$arrResponse = array('success' => false , 'msg' => 'Error al eliminar el producto.');
			}
			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
		}
		die();
	}

	public function getSelectCategorias(){
		$htmlOptions = "";
		$arrData = $this->model->selectCategorias();
		//$htmlOptions .= '<option value="0" >Seleccione un cliente...</option>';
		if(count($arrData) > 0){
			for($i=0; $i < count($arrData); $i++)
			{
				
					$htmlOptions .= '<option value="'.$arrData[$i]['id_categoria'].'">'.$arrData[$i]['nombre_categoria'].'</option>';
				
			}
		}
		echo $htmlOptions;
		die();  
	}


}

?>