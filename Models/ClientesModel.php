<?php
class ClientesModel extends Mysql
{
	private $id_cliente;
	private $nombre_cliente;
	private $celular;
	private $direccion;
	
	public function __construct()
	{
			//session_start();
			$db = $_SESSION['basedatos'];
			$this->getConexion($db);
	}
	//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super
	public function selectClientes(){
		$sql = "SELECT id_cliente, nombre_cliente, celular, direccion FROM cat_clientes";
		$request = $this->select_all($sql);
		return $request;
	}
	
	public function selectCliente($id){
		$this->id_cliente = $id;
		$sql = "SELECT id_cliente, nombre_cliente, celular, direccion
		FROM cat_clientes WHERE id_cliente = $this->id_cliente";
		$request = $this->select($sql);
		return $request;

	}

	public function insertCliente(string $nombre, int $telefono, string $direccion){
		$this->nombre_cliente = $nombre;
		$this->celular = $telefono;
		$this->direccion = $direccion;
		
		$return = 0;

		$sql = "SELECT * FROM cat_clientes WHERE 
				nombre_cliente = '{$this->nombre_cliente}' AND celular = '{$this->celular}' ";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO cat_clientes(nombre_cliente, celular, direccion) 
							  VALUES(?,?,?)";
        	$arrData = array($this->nombre_cliente, $this->celular, $this->direccion);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}
	
	public function updateCliente(int $idcliente, string $nombre, int $telefono, string $direccion){

		$this->id_cliente = $idcliente;
		$this->nombre_cliente = $nombre;
		$this->celular = $telefono;
		$this->direccion = $direccion;
		
		$sql = "SELECT * FROM cat_clientes WHERE (nombre_cliente = '{$this->nombre_cliente}' AND id_cliente != $this->id_cliente)";
		$request = $this->select_all($sql);

		if(empty($request))
		{
		
			$sql = "UPDATE cat_clientes SET nombre_cliente=?, celular=?, direccion=?
					WHERE id_cliente = $this->id_cliente ";
			$arrData = array($this->nombre_cliente, $this->celular, $this->direccion);
			
			$request = $this->update($sql, $arrData);
		}else{
			$request = "exist";
		}
		return $request;
	
	}


	public function deleteCliente(int $idcliente)
	{
		$this->id_cliente = $idcliente;
		$sql = "DELETE FROM cat_clientes where id_cliente = $this->id_cliente";
		$request = $this->delete($sql);
		return $request;
	}	

	
	
}





?>