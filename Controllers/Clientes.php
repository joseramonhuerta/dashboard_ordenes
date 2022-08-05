<?php
class Clientes extends Controllers{
	public function __construct(){
		
			
			 session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				//die();
			}
			parent::__construct();
	}

	public function Clientes(){
		$data['page_tag'] = "Clientes";
		$data['page_title'] = "Clientes <small>Ordenes Servicio</small>";
		$data['page_name'] = "clientes";
		$data['page_functions_js'] = "functions_clientes.js";		
		$this->views->getView($this, "clientes",$data);
	}

	public function getClientes(){
		$arrData = $this->model->selectClientes();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			/*if($arrData[$i]['status_usuario'] == 'A')
			{
				$arrData[$i]['status_usuario'] = '<span class="badge badge-success">Activo</span>';	
			}else{
				$arrData[$i]['status_usuario'] = '<span class="badge badge-danger">Inactivo</span>';	
			}*/


			$btnView = '<button class="btn btn-info btn-sm btnViewCliente" onClick="fntViewCliente('.$arrData[$i]['id_cliente'].')" title="Ver cliente"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditCliente" onClick="fntEditCliente(this,'.$arrData[$i]['id_cliente'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelCliente('.$arrData[$i]['id_cliente'].')" title="Eliminar cliente"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function setCliente(){
		if($_POST)
		{
			if(empty($_POST['txtNombre']) || empty($_POST['txtCelular']) || empty($_POST['txtDireccion']))
			{
				$arrResponse = array("success" => false, "msg" => 'Datos incorrectos.');				
			}else{
				$idCliente = intval($_POST['idCliente']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$intTelefono = intval(strClean($_POST['txtCelular']));	
				$strDireccion = ucwords(strClean($_POST['txtDireccion']));

				if($idCliente == 0){
					$option = 1;
					$request_cliente = $this->model->insertCliente($strNombre, $intTelefono, $strDireccion);	

				}else{
					$option = 2;
					$request_cliente = $this->model->updateCliente($idCliente,$strNombre, $intTelefono, $strDireccion);

				}

				if(intval($request_cliente) > 0){
					if($option == 1){
						$arrResponse = array("success" => true, "msg" => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array("success" => true, "msg" => 'Datos modificados correctamente.');	
					}

				}else if($request_cliente == 'exist'){
					$arrResponse = array("success" => false, "msg" => 'El cliente ya existe.');
				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}

			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getCliente($idcliente){
			
		$id_cliente = intval($idcliente);
		if($id_cliente > 0)
		{
			$arrData = $this->model->selectCliente($id_cliente);
			if(empty($arrData))
			{
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		
		die();
	}	

	public function delCliente()
		{
			if($_POST){
			
				$intIdcliente = intval($_POST['idCliente']);
				$requestDelete = $this->model->deleteCliente($intIdcliente);
				if($requestDelete)
				{
					$arrResponse = array('success' => true, 'msg' => 'Se ha eliminado el cliente.');
				}else{
					$arrResponse = array('success' => false, 'msg' => 'Error al eliminar el cliente.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
			}
			die();
		}

}

?>