<?php
class ProductosModel extends Mysql
{
	private $id_producto;
	private $nombre_producto;
	private $descripcion;
	private $codigo;
	private $precio;
	private $precio_mayoreo;
	private $categoria;
	private $status_producto;

	public function __construct()
	{
			//session_start();
			$db = $_SESSION['basedatos'];
			$this->getConexion($db);
	}
	//1=Administrador,2=Supervisor,3=Vendedor,4=Tecnico,5=Super
	public function selectProductos(){
		$sql = "SELECT p.id_producto, p.nombre_producto, p.codigo, p.descripcion, p.precio, p.precio_mayoreo,p.id_categoria,c.nombre_categoria,p.status_producto 
				FROM cat_productos p
				LEFT JOIN cat_categorias c on c.id_categoria = p.id_categoria";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectProducto($id){
		$this->id_producto = $id;
		$sql = "SELECT p.id_producto, p.nombre_producto, p.descripcion, p.codigo, p.precio, p.precio_mayoreo,p.id_categoria,c.nombre_categoria,p.status_producto
		FROM cat_productos p
		LEFT JOIN cat_categorias c on c.id_categoria = p.id_categoria
		WHERE id_producto = $this->id_producto";
		$request = $this->select($sql);
		return $request;

	}
	//$strNombre, $strCodigo, $strDescripcion, $dbPrecio, $dbPrecioMayoreo, $intCategoria, $strStatus
	public function insertProducto(string $nombre,  string $codigo, string $descripcion, float $precio, float $precio_mayoreo, int $categoria, string $status){
		$this->nombre_producto = $nombre;
		$this->descripcion = $descripcion;
		$this->codigo = $codigo;
		$this->precio = $precio;
		$this->precio_mayoreo = $precio_mayoreo;
		$this->categoria = $categoria;
		$this->status_producto = $status;


		$return = 0;

		$sql = "SELECT * FROM cat_productos WHERE 
				nombre_producto = '{$this->nombre_producto}' OR codigo = '{$this->codigo}' ";
		$request = $this->select_all($sql);

		if(empty($request))
		{
			$query_insert  = "INSERT INTO cat_productos(nombre_producto, descripcion, codigo, precio, precio_mayoreo, id_categoria, status_producto) 
							  VALUES(?,?,?,?,?,?,?)";
        	$arrData = array($this->nombre_producto,
    						$this->descripcion,
    						$this->codigo,
    						$this->precio,
    						$this->precio_mayoreo,
    						$this->categoria,
    						$this->status_producto);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;
		}else{
			$return = "exist";
		}
        return $return;
	}

	public function updateProducto(int $idproducto, string $nombre,  string $codigo, string $descripcion, float $precio, float $precio_mayoreo, int $categoria, string $status){

		$this->id_producto = $idproducto;
		$this->nombre_producto = $nombre;
		$this->descripcion = $descripcion;
		$this->codigo = $codigo;
		$this->precio = $precio;
		$this->precio_mayoreo = $precio_mayoreo;
		$this->categoria = $categoria;
		$this->status_producto = $status;


		$sql = "SELECT * FROM cat_productos WHERE ((nombre_producto = '{$this->nombre_producto}' OR codigo = '{$this->codigo}') AND id_producto != $this->id_producto)";

		$request = $this->select_all($sql);

		if(empty($request))
		{
				
			$sql = "UPDATE cat_productos SET nombre_producto = ?, descripcion = ?, codigo = ?, precio = ?, precio_mayoreo = ?, id_categoria = ?, status_producto = ?
					WHERE id_producto = $this->id_producto ";
			$arrData = array($this->nombre_producto,
							$this->descripcion,
							$this->codigo,
							$this->precio,
							$this->precio_mayoreo,
							$this->categoria,
							$this->status_producto);
				
			$request = $this->update($sql,$arrData);
		}else{
			$request = "exist";
		}
		return $request;
	
	}


	public function deleteProducto(int $idproducto)
	{
		$this->id_producto = $idproducto;
		$sql = "DELETE FROM cat_productos where id_producto = $this->id_producto";
		$request = $this->delete($sql);
		return $request;
	}

	public function selectCategorias(){
		$sql = "SELECT id_categoria, nombre_categoria FROM cat_categorias";
		$request = $this->select_all($sql);
		return $request;
	}	

	

}





?>