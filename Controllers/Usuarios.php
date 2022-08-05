<?php
class Usuarios extends Controllers{
	public function __construct(){
		
			
			 session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				//die();
			}
			parent::__construct();
	}

	public function Usuarios(){
		$data['page_tag'] = "Usuarios";
		$data['page_title'] = "Usuarios <small>Ordenes Servicio</small>";
		$data['page_name'] = "usuarios";
		$data['page_functions_js'] = "functions_usuarios.js";		
		$this->views->getView($this, "usuarios",$data);
	}

	public function setUsuario(){
		if($_POST){			
			if(empty($_POST['txtNombre']) || empty($_POST['txtUsuario']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) || empty($_POST['txtPassword']))
			{
				$arrResponse = array("success" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strUsuario = strClean($_POST['txtUsuario']);
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$intRol = intval(strClean($_POST['listRolid']));
				$strStatus = strClean($_POST['listStatus']);
				$strPassword =  $_POST['txtPassword'];

				$request_user = "";
				if($idUsuario == 0)
				{
					$option = 1;					
					$request_user = $this->model->insertUsuario($strNombre, $strUsuario, $strEmail, $strPassword, $intRol, $strStatus);
					
				}else{
					$option = 2;			
					$request_user = $this->model->updateUsuario($idUsuario, $strNombre, $strUsuario, $strEmail, $strPassword, $intRol, $strStatus);		
				}

				if(intval($request_user) > 0 )
				{
					if($option == 1){
						$arrResponse = array('success' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('success' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'exist'){
					$arrResponse = array('success' => false, 'msg' => '¡Atención! Usuario ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("success" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getUsuarios(){
		$arrData = $this->model->selectUsuarios();
		
		for($i=0; $i < count($arrData); $i++){
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';

			if($arrData[$i]['status_usuario'] == 'A')
			{
				$arrData[$i]['status_usuario'] = '<span class="badge badge-success">Activo</span>';	
			}else{
				$arrData[$i]['status_usuario'] = '<span class="badge badge-danger">Inactivo</span>';	
			}


			$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['id_usuario'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
			
			
			$btnEdit = '<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['id_usuario'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
				
			
			$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_usuario'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
				
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';	


		}
		
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getUsuario($id){
		$id_usuario = $id;
		if($id_usuario > 0){
			$arrData = $this->model->selectUsuario($id_usuario);
			if(empty($arrData)){
				$arrResponse = array('success' => false, 'msg' => 'Datos no encontrados');
			}else{
				$arrResponse = array('success' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delUsuario(){
		if($_POST){
			$id_usuario = intval($_POST['idUsuario']);
			$requestDelete = $this->model->deleteUsuario($id_usuario);
			if($requestDelete)
			{
				$arrResponse = array('success' => true, 'msg' => 'Usuario eliminado correctamente.');
			}else{
				$arrResponse = array('success' => false , 'msg' => 'Error al eliminar al usuario.');
			}
			
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
		}
		die();
	}

}

?>