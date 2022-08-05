<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			$this->getConexionMaster();
		}	

		public function loginUser(string $usuario, string $password)
		{
			
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT u.id_usuario_master,ue.id_usuario, u.nombre_usuario, u.usuario, u.rol,e.id_empresa, e.basedatos, e.nombre_empresa, CASE u.rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Tecnico' WHEN 5 THEN 'Super Admin' END AS rol_descripcion			
				FROM cat_usuarios_empresas ue 
				INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
				INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
				WHERE ue.usuario = '$this->strUsuario' AND ue.pass = to_base64('$this->strPassword') AND u.estatus = 'A' AND e.estatus = 'A'
			";
			$request = $this->select($sql);
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT ue.id_usuario, u.nombre_usuario, u.usuario, u.rol,e.id_empresa, e.basedatos, e.nombre_empresa, CASE u.rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Tecnico' WHEN 5 THEN 'Super Admin' END AS rol_descripcion  
				FROM cat_usuarios_empresas ue 
				INNER JOIN cat_usuarios u on u.id_usuario_master = ue.id_usuario_master
				INNER JOIN cat_empresas e on e.id_empresa = ue.id_empresa 	
				WHERE u.id_usuario_master = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}


		
		/*
		public function getUserEmail(string $strEmail){
			$this->strUsuario = $strEmail;
			$sql = "SELECT idpersona,nombres,apellidos,status FROM persona WHERE 
					email_user = '$this->strUsuario' and  
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}
		
		public function setTokenUser(int $idpersona, string $token){
			$this->intIdUsuario = $idpersona;
			$this->strToken = $token;
			$sql = "UPDATE persona SET token = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function getUsuario(string $email, string $token){
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT idpersona FROM persona WHERE 
					email_user = '$this->strUsuario' and 
					token = '$this->strToken' and 					
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}

		public function insertPassword(int $idPersona, string $password){
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}*/
	}
 ?>