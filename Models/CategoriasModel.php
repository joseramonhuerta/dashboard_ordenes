<?php
class CategoriasModel extends Mysql
{
	private $id_categoria;
	private $nombre_categoria;
	private $status_categoria;
	
	public function __construct()
	{
			//session_start();
			$db = $_SESSION['basedatos'];
			$this->getConexion($db);
	}
	//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super
	public function selectCategorias(){
		$sql = "SELECT id_categoria, nombre_categoria, status_categoria FROM cat_categorias";
		$request = $this->select_all($sql);
		return $request;
	}
	
	public function selectCategoria($id){
		$this->id_categoria = $id;
		$sql = "SELECT id_categoria, nombre_categoria, status_categoria
		FROM cat_categorias WHERE id_categoria = $this->id_categoria";
		$request = $this->select($sql);
		return $request;

	}

	public function insertCategoria(string $nombre, string $status){
		$this->nombre_categoria = $nombre;
		$this->status_categoria = $status;
		
		$return = 0;

		$sql = "SELECT * FROM cat_categorias WHERE 
				nombre_categoria = '{$this->nombre_categoria}'";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO cat_categorias(nombre_categoria, status_categoria) 
							  VALUES(?,?)";
        	$arrData = array($this->nombre_categoria, $this->status_categoria);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}
	
	public function updateCategoria(int $idcategoria, string $nombre, string $status){

		$this->id_categoria = $idcategoria;
		$this->nombre_categoria = $nombre;
		$this->status_categoria = $status;
		
		$sql = "SELECT * FROM cat_categorias WHERE (nombre_categoria = '{$this->nombre_categoria}' AND id_categoria != $this->id_categoria)";
		$request = $this->select_all($sql);

		if(empty($request))
		{
		
			$sql = "UPDATE cat_categorias SET nombre_categoria=?, status_categoria=?
					WHERE id_categoria = $this->id_categoria ";
			$arrData = array($this->nombre_categoria, $this->status_categoria);
			
			$request = $this->update($sql, $arrData);
		}else{
			$request = "exist";
		}
		return $request;
	
	}


	public function deleteCategoria(int $idcategoria)
	{
		$this->id_categoria = $idcategoria;
		$sql = "DELETE FROM cat_categorias where id_categoria = $this->id_categoria";
		$request = $this->delete($sql);
		return $request;
	}	

	
	
}





?>