<?php
	class Roles extends Controllers{
		public function __construct()
		{
			parent::__construct();	
		}

		public function Roles()
		{
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles usuario";
			$data['page_name'] = "rol_usuario";
			$data['page_title'] = "Roles Usuario <small>Mensajeria App</small>";
			$data['page_functions_js'] = "functions_roles.js";
			$this->views->getView($this,"roles",$data);
		}

		public function getRoles()
		{
			$arrData = $this->model->selectRoles();

			for($i=0; $i < count($arrData); $i++){
				if($arrData[$i]['status'] == 1){
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';	
				}else{
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';		
				}

				$arrData[$i]['options'] = '<div class="text-center">
				<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key" aria-hidden="true"></i></button>
				<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button>
				<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['id_rol'].')" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>						

											</div>';

			}

			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getRol(int $idrol){
			$intIdrol = intval(strClean($idrol));
			if($intIdrol > 0)
			{
				$arrData = $this->model->selectRol($intIdrol);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();			
		}


		public function setRol(){
			$intIdRol = intval($_POST['idRol']);
			$strRol = strClean($_POST['txtNombre']);
			$strDescripcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listEstatus']);
			

			if($intIdRol ==0 )
			{
				$request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
				$option = 1;
			}else{

				$request_rol = $this->model->updateRol($intIdRol,$strRol, $strDescripcion, $intStatus);
				$option = 2;
			}

			if((int)$request_rol > 0){
				if($option == 1){
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');		
				}else{
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');	
				}					
			}else if($request_rol == 'exist'){
				//if($option == 1)
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');			
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();	

		}

		public function delRol()
		{
			if($_POST){
				$intIdrol = intval($_POST['id_rol']);
				$requestDelete = $this->model->deleteRol($intIdrol);
				if($requestDelete == 'ok'){
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rol.');
				}else if($requestDelete == 'exist'){
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un rol asociado a un usuario.');	
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}	
			
	}
?>