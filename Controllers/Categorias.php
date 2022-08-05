<?php
class Categorias extends Controllers{
	public function __construct(){
		
			
			 session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				//die();
			}
			parent::__construct();
	}

	public function Categorias(){
		$data['page_tag'] = "Categorias";
		$data['page_title'] = "Categorias <small>Ordenes Servicio</small>";
		$data['page_name'] = "categorias";
		$data['page_functions_js'] = "functions_categorias.js";		
		$this->views->getView($this, "categorias",$data);
	}

	public function setCategoria(){
		if($_POST){			
			if(empty($_POST['txtNombreCategoria']) || empty($_POST['listStatus']))
			{
				$arrResponse = array("success" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idCategoria = intval($_POST['idCategoria']);
				$strNombre = ucwords(strClean($_POST['txtNombreCategoria']));
				$strStatus = ucwords(strClean($_POST['listStatus']));
				

				$request_categoria = "";
				if($idCategoria == 0)
				{
					$option = 1;					
					$request_categoria = $this->model->insertCategoria($strNombre, $strStatus);
					
				}else{
					$option = 2;			
					$request_categoria = $this->model->updateCategoria($idCategoria, $strNombre, $strStatus);		
				}

				if(intval($request_categoria) > 0 )
				{
					if($option == 1){
						$arrResponse = array('success' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('success' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_categoria == 'exist'){
					$arrResponse = array('success' => false, 'msg' => '¡Atención! Categoria ya existe, ingrese otra.');		
				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getCategorias(){
		$arrData = $this->model->selectCategorias();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			if($arrData[$i]['status_categoria'] == 'A')
			{
				$arrData[$i]['status_categoria'] = '<span class="badge badge-success">Activo</span>';	
			}else{
				$arrData[$i]['status_categoria'] = '<span class="badge badge-danger">Inactivo</span>';	
			}


			$btnView = '<button class="btn btn-info btn-sm btnViewCategoria" onClick="fntViewCategoria('.$arrData[$i]['id_categoria'].')" title="Ver categoria"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditCategoria" onClick="fntEditCategoria(this,'.$arrData[$i]['id_categoria'].')" title="Editar categoria"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelCategoria" onClick="fntDelCategoria('.$arrData[$i]['id_categoria'].')" title="Eliminar categoria"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getCategoria($id){
		$id_categoria = $id;
		if($id_categoria > 0){
			$arrData = $this->model->selectCategoria($id_categoria);
			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delCategoria(){
		if($_POST){
			$id_categoria = intval($_POST['idCategoria']);
			$requestDelete = $this->model->deleteCategoria($id_categoria);
			if($requestDelete)
			{
				$arrResponse = array('success' => true, 'msg' => 'Categoria eliminada correctamente.');
			}else{
				$arrResponse = array('success' => false , 'msg' => 'Error al eliminar la categoria.');
			}
			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
		}
		die();
	}

}

?>