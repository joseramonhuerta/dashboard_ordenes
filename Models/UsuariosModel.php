<?php
class UsuariosModel extends Mysql
{
	private $id_usuario;
	private $id_usuario_master;
	private $nombre_usuario;
	private $correo;
	private $usuario;
	private $pass;
	private $rol;
	private $status;
	private $db;
	private $id_empresa;
	private $id_usuario_empresa;

	public function __construct()
	{
			//session_start();
			$this->db = $_SESSION['basedatos'];
			$this->getConexion($this->db);
	}
	//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super
	public function selectUsuarios(){
		$sql = "SELECT id_usuario, nombre_usuario, usuario, correo, status AS status_usuario, CASE rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Técnico' END AS rol_descripcion FROM cat_usuarios WHERE rol != 5";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectUsuario($id){
		$this->id_usuario = $id;
		$sql = "SELECT id_usuario, nombre_usuario, usuario, correo, status,CASE status WHEN 'A' THEN 'ACTIVO' ELSE 'INACTIVO' END AS status_usuario, rol, CASE rol WHEN 1 THEN 'Administrador' WHEN 2 THEN 'Supervisor' WHEN 3 THEN 'Vendedor' WHEN 4 THEN 'Técnico' END AS rol_descripcion, from_base64(pass)  as pass
		FROM cat_usuarios WHERE id_usuario = $this->id_usuario";
		$request = $this->select($sql);
		return $request;

	}

	public function insertUsuario(string $nombre, string $usuario, string $email, string $password, int $rol, string $status){
		$this->nombre_usuario = $nombre;
		$this->usuario = $usuario;
		$this->correo = $email;
		$this->pass = $password;
		$this->rol = $rol;
		$this->status = $status;
		$this->id_empresa = $_SESSION['id_empresa'];

		$return = 0;
		$return_master = 0;

		$sql = "SELECT * FROM cat_usuarios WHERE 
				usuario = '{$this->usuario}' AND pass = to_base64('{$this->pass}') ";
		$request = $this->select_all($sql);

		//insertar el usuario en la bd del usuario
		if(empty($request))
		{
			$query_insert  = "INSERT INTO cat_usuarios(nombre_usuario,usuario,correo,pass,rol,status) 
							  VALUES(?,?,?,to_base64(?),?,?)";
        	$arrData = array($this->nombre_usuario,
    						$this->usuario,
    						$this->correo,
    						$this->pass,
    						$this->rol,
    						$this->status);
        	$request_insert = $this->insert($query_insert,$arrData);
        	
        	$sql = "SELECT LAST_INSERT_ID() AS id_usuario";
			$response = $this->select($sql);
			$this->id_usuario = $response['id_usuario'];
        	$return = $request_insert;
		}else{
			$return = "exist";
		}

		//verificar si el usuario existe en la bd master
		
		if(intval($return) > 0 ){
			$this->getConexionMaster();
			$sql = "SELECT * FROM cat_usuarios_empresas WHERE 
					usuario = '{$this->usuario}' AND pass = to_base64('{$this->pass}') ";
			$request_masdter = $this->select_all($sql);

			if(empty($request_masdter))
			{
				
								
				$query_insert  = "INSERT INTO cat_usuarios(id_usuario,nombre_usuario,usuario, rol,estatus) 
								  VALUES(?,?,?,?,?)";
	        	$arrData = array($this->id_usuario,
	        					$this->nombre_usuario,
	    						$this->usuario,	    						
	    						$this->rol,
	    						$this->status
	    						);
	        	$request_insert = $this->insert($query_insert,$arrData);

	        	$sql = "SELECT LAST_INSERT_ID() AS id_usuario_master";
				$response = $this->select($sql);
				$this->id_usuario_master = $response['id_usuario_master'];

				$query_insert  = "INSERT INTO cat_usuarios_empresas(id_usuario_master,id_usuario,id_empresa,usuario,pass) 
								  VALUES(?,?,?,?,to_base64(?))";
	        	$arrData = array($this->id_usuario_master,
	        					$this->id_usuario,
	    						$this->id_empresa,	    						
	    						$this->usuario,
	    						$this->pass
	    						);
	        	$request_insert = $this->insert($query_insert,$arrData);	        	

	        	$return_master = $request_insert;
			}else{
				$return_master = "exist";
			}

			$return = $return_master;

		}

        return $return;
	}

	public function updateUsuario(int $idusuario, string $nombre, string $usuario, string $email, string $password, int $rol, string $status){

		$this->id_usuario = $idusuario;
		$this->nombre_usuario = $nombre;
		$this->usuario = $usuario;
		$this->correo = $email;
		$this->pass = $password;
		$this->rol = $rol;
		$this->status = $status;
		$this->id_empresa = $_SESSION['id_empresa'];

		$return = 0;
		$return_master = 0;

		$sql = "SELECT * FROM cat_usuarios WHERE (usuario = '{$this->usuario}' AND id_usuario != $this->id_usuario)";
		$request = $this->select_all($sql);

		if(empty($request))
		{
		
			$sql = "UPDATE cat_usuarios SET nombre_usuario=?, usuario=?, correo=?, pass=to_base64(?), rol=?, status=?
					WHERE id_usuario = $this->id_usuario ";
			$arrData = array($this->nombre_usuario,
    						$this->usuario,
    						$this->correo,
    						$this->pass,
    						$this->rol,
    						$this->status);
			
			$return = $this->update($sql,$arrData);
			//dep($return);
			//die();
		}else{
			$return = "exist";
		}


		if(intval($return) > 0 ){
			$this->getConexionMaster();

			$sql = "SELECT * FROM cat_usuarios_empresas WHERE 
					usuario = '{$this->usuario}' AND pass = to_base64('{$this->pass}') AND id_usuario <> $this->id_usuario";
			$request_master = $this->select_all($sql);

			if(empty($request_master))
			{
					
				//Para editar buscar el id_usuario_master 

				$sql = "SELECT * FROM cat_usuarios_empresas WHERE 
					id_usuario = '{$this->id_usuario}' AND id_empresa = $this->id_empresa";

				$response = $this->select($sql);

				//dep($response);
				//die();
				
				$this->id_usuario_empresa = $response['id_usuario_empresa'];
				$this->id_usuario_master = $response['id_usuario_master'];

				$sql = "UPDATE cat_usuarios SET nombre_usuario=?, usuario=?, rol=?, estatus=?
					WHERE id_usuario_master = $this->id_usuario_master ";
				$arrData = array($this->nombre_usuario,
	    						$this->usuario,
	    						$this->rol,
	    						$this->status);
				
				$request_update = $this->update($sql,$arrData);

				//dep($request_update);
				//die();

				if(intval($request_update) > 0){
					$sql = "UPDATE cat_usuarios_empresas SET usuario=?, pass=to_base64(?)
					WHERE id_usuario_empresa = $this->id_usuario_empresa ";
					$arrData = array($this->usuario,
	    						$this->pass
	    						);	

					$request_update = $this->update($sql,$arrData);

					if(intval($request_update) > 0){

					}else{
						$request_update = "Error en Update cat_usuarios_empresas";	

					}

				}else{
					$request_update = "Error en Update cat_usuarios";	
				}

				
				
						        	 	

	        	$return_master = $request_update;
			}else{
				$return_master = "exist";
			}

			$return = $return_master;

		}

		return $return;
	
	}


	public function deleteUsuario(int $idusuario)
	{
		$this->id_usuario = $idusuario;
		$this->id_empresa = $_SESSION['id_empresa'];

		$sql = "DELETE FROM cat_usuarios where id_usuario = $this->id_usuario";
		$request = $this->delete($sql);		
		

		$this->getConexionMaster();

		$sql = "SELECT * FROM cat_usuarios_empresas WHERE 
					id_usuario = '{$this->id_usuario}' AND id_empresa = $this->id_empresa";

		$response = $this->select($sql);

		$this->id_usuario_empresa = $response['id_usuario_empresa'];
		$this->id_usuario_master = $response['id_usuario_master'];

		$sql = "DELETE FROM cat_usuarios where id_usuario_master = $this->id_usuario_master";
		$request = $this->delete($sql);


		$sql = "DELETE FROM cat_usuarios_empresas where id_usuario_empresa = $this->id_usuario_empresa";
		$request = $this->delete($sql);

		return $request;
	}	

	

}





?>